<?php
// app/Imports/SantrisImport.php

namespace App\Imports;

use App\Models\Santri;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class SantrisImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    private $successCount = 0;

    public function model(array $row)
    {
        $this->successCount++;

        return new Santri([
            'name' => $row[0],
            'nisn' => $row[1],
            'no_kk' => $row[2],
            'nik' => $row[3],
            'tempat_lahir' => $row[4],
            'tanggal_lahir' => $row[5],
            'jenis_kelamin' => $row[6],
            'anak_ke' => $row[7],
            'hobi' => $row[8],
            'nomor_kip' => $row[9],
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string', // Ensure 'name' is required and a string
            'nisn' => 'nullable|numeric|unique:santris,nisn',
            // Add other validation rules as needed
        ];
    }
    

    public function getSuccessCount(): int
    {
        return $this->successCount;
    }
}
