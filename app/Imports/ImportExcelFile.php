<?php

namespace App\Imports;

use App\Models\ExcelEmail;
use App\Models\ExcelFile;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportExcelFile implements ToModel, WithHeadingRow
{
    public function  __construct(
        public ExcelFile $excelFile,
        protected bool $only_private = true
    ) { }

    public function model(array $row)
    {
        if ($this->validation($row)) {
            if ($row['email_promo'])
                $this->createExcelEmail($row['email_promo'], 'PROMOTOR', $row);

            if ($row['email_arqui'])
                $this->createExcelEmail($row['email_arqui'], 'ARQUITECTO', $row);

            if ($row['email_const'])
                $this->createExcelEmail($row['email_const'], 'CONSTRUCTOR', $row);
        }

        return;
    }

    protected function validation ($row) : bool
    {
        if (!(!$this->only_private || (isset($row['tipo_promo']) && $row['tipo_promo'] == 'Privado')))
            return false;

        if (!Str::contains(strtoupper($row['obra']), ['VIVIENDA', 'RESIDENCIA', 'UNIFAMILIAR', 'HOTEL']))
            return false;

        return !ExcelEmail::where([
            'num_obra' => trim($row['num_obra']),
        ])->exists();
    }

    protected function createExcelEmail ($email, $rol, $row)
    {
        $this->excelFile->excel_emails()->create([
            'email' => trim($email),
            'role' => $rol,
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

    public function rules(): array
    {
        return [
            // 'email_arqui' => 'required',
        ];
    }
}
