<?php

namespace Database\Seeders;

use App\Models\Source;
use Illuminate\Database\Seeder;

class SourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Source::count() == 0) {
            Source::factory()
                ->count(3)
                ->create();
        }
    }
}
