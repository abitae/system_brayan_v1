<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SqlFileSeeder extends Seeder
{
    public function run()
    {
        $sqlFiles = File::files(database_path('data'));

        foreach ($sqlFiles as $file) {
            if ($file->getExtension() === 'sql') {
                $sql = File::get($file->getRealPath());
                DB::unprepared($sql);
            }
        }
    }
}