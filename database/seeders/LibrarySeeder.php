<?php

namespace Database\Seeders;

use App\Models\Library;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibrarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $total = 100000;
        $chunkSize = 5000;

        for ($i = 0; $i < $total; $i += $chunkSize) {
            $data = Library::factory()->count($chunkSize)->make()->toArray();
            Library::insert($data);
        }
    }
}
