<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\DownloadsIranDivisionData;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    use DownloadsIranDivisionData;

    public function run(): void
    {
        $now = now();

//        $provinces = DB::table('provinces')
//            ->pluck('id', 'name');
        $rows = collect($this->iranDivisionData('cities.json'))
            ->map(function (array $city) use ( $now) {

                $provinceId = $city['province_id'] ?? 1;



                return [
                    'province_id' => $provinceId ,
                    'name' => $city['name'],
                    // Fill this later with the matching ERP code.
                    'erp_code' => null,
                    'is_active' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            })
            ->filter()
            ->values();

        $rows->each(function (array $row) {
            DB::table('cities')->updateOrInsert(
                [
                    'province_id' => $row['province_id'],
                    'name' => $row['name'],
                ],
                $row
            );
        });

        $this->command?->info("Seeded {$rows->count()} cities.");
    }
}
