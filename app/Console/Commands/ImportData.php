<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ImportData extends Command
{
    protected $signature = 'import:data';
    protected $description = 'Import data from JSON file to PostgreSQL';

    public function handle()
    {
        $filePath = storage_path('storage/worksData.json');
        $jsonContent = json_decode(Storage::get('worksData.json'), true);

        foreach ($jsonContent as $item) {
            DB::table('works')->insert($item);
        }

        $this->info('Data imported successfully!');
    }
}
