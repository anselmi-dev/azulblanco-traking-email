<?php

namespace App\Imports;

use App\Models\ExcelEmail;
use App\Models\ExcelFile;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportExcelFile implements ToModel, WithHeadingRow, WithValidation
{

    protected $skips_rows = 0;

    public function  __construct(
        public ExcelFile $excelFile,
        protected bool $only_private = true
    ) { }

    public function model(array $row)
    {
        if ($this->validation($row)) {
            return $this->excelFile->excel_emails()->create([
                'email_arqui' => trim($row['email_arqui']),
                'num_obra' => optional($row)['num_obra'],
                'obra' => optional($row)['obra'],
                'dir_obra' => optional($row)['dir_obra'],
                'pobla_obra' => optional($row)['pobla_obra'],
                'provi_obra' => optional($row)['provi_obra'],
                'type' => optional($row)['tipo_promo'] == 'Privado' ? 'private' : 'public',
                'data' => $row,
            ]);
        }

        $this->skips_rows++;
    }

    public function validation ($row)
    {
        if (is_null(optional($row)['email_arqui']))
            return false;

        if (!(!$this->only_private || (isset($row['tipo_promo']) && $row['tipo_promo'] == 'Privado')))
            return false;

        return !ExcelEmail::where('email_arqui', trim($row['email_arqui']))->exists();
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
