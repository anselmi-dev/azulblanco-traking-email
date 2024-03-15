<?php

namespace App\Imports;

use App\Models\ExcelEmail;
use App\Models\ExcelFile;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\ImportFailed;
use App\Jobs\ProcessExcelEmailsByFile;

class ImportExcelFile implements ToModel, WithHeadingRow, WithEvents
{
    public function  __construct(
        public ExcelFile $excelFile,
        protected bool $only_private = true
    ) { }

    public function model(array $row)
    {
        if ($this->validation($row)) {
            if ($row['email_promo'])
                $this->createExcelEmail([
                    'email' => $row['email_promo'],
                    'role' => 'PROMOTOR',
                ], $row);

            if ($row['email_arqui'])
                $this->createExcelEmail([
                    'email' => $row['email_arqui'],
                    'role' => 'ARQUITECTO',
                ], $row);

            if ($row['email_const'])
                $this->createExcelEmail([
                    'email' => $row['email_const'],
                    'role' => 'CONSTRUCTOR',
                ], $row);
        }

        return;
    }

    protected function validation ($row) : bool
    {
        if (!(!$this->only_private || strtoupper($row['tipo_promo']) == 'PRIVADO'))
            return false;

        if (!Str::contains(strtoupper($row['obra']), ['VIVIENDA', 'RESIDENCIA', 'UNIFAMILIAR', 'HOTEL']))
            return false;

        return !ExcelEmail::where([
            'num_obra' => trim($row['num_obra']),
        ])->exists();
    }

    protected function createExcelEmail (
        array $sender,
        array $row
    )
    {
        $this->excelFile->excel_emails()->create([
            'email' => trim($sender['email']),
            'role' => $sender['role'],
            'num_obra' => $row['num_obra'],
            'obra' => $row['obra'],
            'dir_obra' => $row['dir_obra'],
            'pobla_obra' => $row['pobla_obra'],
            'provi_obra' => $row['provi_obra'],
            'type' => $row['tipo_promo'] == 'Privado' ? 'private' : 'public',
            'data' => $row,
        ]);
    }

    public function headingRow(): int
    {
        return 3;
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterImport::class => function(AfterImport $event) {
                $this->excelFile->update([
                    'status' => 'done'
                ]);
            },
            ImportFailed::class => function(ImportFailed $event) {
                $this->excelFile->update([
                    'status' => 'error'
                ]);
            },
        ];
    }
}
