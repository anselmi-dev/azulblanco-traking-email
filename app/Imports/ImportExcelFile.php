<?php

namespace App\Imports;

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
        if (optional($row)['email_arqui'] && (!$this->only_private || optional($row)['tipo_promo'] == 'Privado')) {
            return $this->excelFile->excel_emails()->create([
                'email_arqui' => optional($row)['email_arqui'],
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
