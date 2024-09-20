<?php

namespace App\Imports;

use App\Models\Santri;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class SantrisImport implements ToModel, WithHeadingRow
{
    /**
     * Transform the date serial from Excel to a Carbon instance.
     * Adjust the format according to your needs.
     *
     * @param mixed $date
     * @return string|null
     */
    private function transformDate($date): ?string
    {
        if (is_numeric($date)) {
            try {
                // Convert Excel serial date to Carbon date
                return Carbon::createFromFormat('Y-m-d', Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($date - 2)->format('Y-m-d'))->format('Y-m-d');
            } catch (\Exception $e) {
                // Handle date conversion exception if needed
                return null;
            }
        } elseif (is_string($date)) {
            try {
                // If the date is a string, try parsing it directly
                return Carbon::parse($date)->format('Y-m-d');
            } catch (\Exception $e) {
                // Handle parsing exception if needed
                return null;
            }
        }

        return null;
    }

    /**
     * Map the array data to the Santri model.
     *
     * @param array $row
     * @return Santri
     */
    public function model(array $row): Santri
    {
        return new Santri([
            'name' => $row['name'] ?? null,
            'nisn' => $row['nisn'] ?? null,
            'no_kk' => $row['no_kk'] ?? null,
            'nik' => $row['nik'] ?? null,
            'tempat_lahir' => $row['tempat_lahir'] ?? null,
            'tanggal_lahir' => $this->transformDate($row['tanggal_lahir']),
            'jenis_kelamin' => $row['jenis_kelamin'] ?? null,
            'anak_ke' => $row['anak_ke'] ?? null,
            'hobi' => $row['hobi'] ?? null,
            'nomor_kip' => $row['nomor_kip'] ?? null,
        ]);
    }
}
