<?php

namespace App\Imports;

use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\ImportFailed;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use App\Models\ExcelEmail;
use App\Models\ExcelFile;

class ImportExcelFile implements ToModel, WithEvents, WithBatchInserts, WithChunkReading
{
    CONST HEAD_NUM_OBRA = 0;

    CONST HEAD_OBRA = 4;

    CONST HEAD_DIR_OBRA = 6;

    CONST HEAD_POBLA_OBRA = 8;

    CONST HEAD_PROVI_OBRA = 9;

    CONST HEAD_TIPO_PROMO = 15;

    CONST HEAD_EMAIL_PROMO = 24;

    CONST HEAD_EMAIL_ARQUI = 34;

    CONST HEAD_EMAIL_CONST = 44;

    public function  __construct(
        public ExcelFile $excelFile,
        protected bool $only_private = true
    ) {
        // Nothing to do.
    }

    public function model(array $row)
    {
        if (!$this->validationRow($row))
            return null;

        $num_obra = $row[self::HEAD_NUM_OBRA];

        $email_promo = optional($row)[self::HEAD_EMAIL_PROMO];

        $email_arqui = optional($row)[self::HEAD_EMAIL_ARQUI];

        $email_const = optional($row)[self::HEAD_EMAIL_CONST];

        $excel_email = ExcelEmail::select('promotor.id as promotor_id', 'arquitecto.id as arquitecto_id', 'constructor.id as constructor_id')
            ->leftJoin('excel_emails as promotor', function ($join) use ($num_obra, $email_promo) {
                $join->where('promotor.num_obra', $num_obra)
                    ->where('promotor.email', $email_promo);
            })
            ->leftJoin('excel_emails as arquitecto', function ($join) use ($num_obra, $email_arqui) {
                $join->where('arquitecto.num_obra', $num_obra)
                    ->where('arquitecto.email', $email_arqui);
            })
            ->leftJoin('excel_emails as constructor', function ($join) use ($num_obra, $email_const) {
                $join->where('constructor.num_obra', $num_obra)
                    ->where('constructor.email', $email_const);
            })
            ->first();

        // REGISTRO:PROMOTOR
        if ($email_promo && is_null(optional($excel_email)->promotor_id))
            $this->createExcelEmail($row, $email_promo, 'PROMOTOR');

        // REGISTRO:ARQUITECTO
        if ($email_arqui && is_null(optional($excel_email)->arquitecto_id))
            $this->createExcelEmail($row, $email_arqui, 'ARQUITECTO');

        // REGISTRO:CONSTRUCTOR
        if ($email_const && is_null(optional($excel_email)->constructor_id))
            $this->createExcelEmail($row, $email_const, 'CONSTRUCTOR');
    }

    /**
     * Validar que la linew del excel sea PRIVADO y que posee por lo menos esto string:
     * 'VIVIENDA', 'RESIDENCIA', 'UNIFAMILIAR', 'HOTEL'
     *
     * @param array $row
     * @return boolean
     */
    protected function validationRow ($row) : bool
    {
        $HEAD_TIPO_PROMO = $row[self::HEAD_TIPO_PROMO];

        if (is_null($HEAD_TIPO_PROMO) || $HEAD_TIPO_PROMO == '' || $HEAD_TIPO_PROMO == " ")
            return false;

        if (!(!$this->only_private || strtoupper($HEAD_TIPO_PROMO) == 'PRIVADO'))
            return false;

        if (!Str::contains(strtoupper($row[self::HEAD_OBRA]), ['VIVIENDA', 'RESIDENCIA', 'UNIFAMILIAR', 'HOTEL']))
            return false;

        return true;
    }

    /**
     * Crear registro del email, pero no envia el correo.
     *
     * @param array $sender
     * @param array $row
     * @return void
     */
    protected function createExcelEmail (array $row, string $name_email, string $role)
    {
        $this->excelFile->excel_emails()->create([
            'email' => trim($name_email),
            'role' => $role,
            'num_obra' => $row[self::HEAD_NUM_OBRA],
            'obra' => $row[self::HEAD_OBRA],
            'dir_obra' => $row[self::HEAD_DIR_OBRA],
            'pobla_obra' => $row[self::HEAD_POBLA_OBRA],
            'provi_obra' => $row[self::HEAD_PROVI_OBRA],
            'type' => $row[self::HEAD_TIPO_PROMO] == 'Privado' ? 'private' : 'public',
            'data' => $row,
        ]);
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function(BeforeSheet $event) {
                $this->excelFile->update([
                    'status' => 'starting'
                ]);
            },
            AfterImport::class => function(AfterImport $event) {
                $this->excelFile->update([
                    'status' => 'sending'
                ]);
            },
            ImportFailed::class => function(ImportFailed $event) {
                $this->excelFile->update([
                    'status' => 'error'
                ]);
            },
        ];
    }

    public function headingRow(): int
    {
        return settings()->get('heading_row', 0);
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
