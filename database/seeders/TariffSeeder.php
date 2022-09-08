<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TariffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dates = [];
        $faker = Faker::create();

        foreach (range(1, 5) as $index) {
            foreach (range(1, 10) as $index) {
                $dates[] = Carbon::createFromDate(
                    Carbon::now()->year,
                    Carbon::now()->month,
                    $faker->numberBetween(1, 28)
                )->format('Y-m-d');
            }

            DB::table('tariffs')->insert([
                'name' => $faker->name(),
                'price' => $faker->numberBetween(100, 9999),
                'dates' => json_encode($dates),
                'deleted_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
