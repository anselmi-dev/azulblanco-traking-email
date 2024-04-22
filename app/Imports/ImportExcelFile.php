<?php

namespace App\Imports;

use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\ImportFailed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

use App\Models\ExcelEmail;
use App\Models\ExcelFile;

class ImportExcelFile implements ToModel, WithHeadingRow, WithEvents, WithBatchInserts, WithChunkReading
{
    public function  __construct(
        public ExcelFile $excelFile,
        protected bool $only_private = true
    ) {

    }

    public function model(array $row)
    {
        if ($this->validationRow($row)) {

            $num_obra = $row['num_obra'];

            $email_promo = optional($row)['email_promo'];

            $email_arqui = optional($row)['email_arqui'];

            $email_const = optional($row)['email_const'];

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

        return;
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
        if (!(!$this->only_private || strtoupper($row['tipo_promo']) == 'PRIVADO'))
            return false;

        if (!Str::contains(strtoupper($row['obra']), ['VIVIENDA', 'RESIDENCIA', 'UNIFAMILIAR', 'HOTEL']))
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
            'num_obra' => $row['num_obra'],
            'obra' => $row['obra'],
            'dir_obra' => $row['dir_obra'],
            'pobla_obra' => $row['pobla_obra'],
            'provi_obra' => $row['provi_obra'],
            'type' => $row['tipo_promo'] == 'Privado' ? 'private' : 'public',
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
        return settings()->get('heading_row', 1);
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
