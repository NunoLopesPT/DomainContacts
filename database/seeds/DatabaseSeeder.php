<?php

use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder.
 *
 * This class will be responsible to run all Database seeds.
 *
 * @package NunoLopes\DomainContacts
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Folder where all the seeds are.
        $folder = __DIR__ . '/database/';

        // Scan all files/folders inside database.
        $files = \scandir($folder);

        $seeders = [];
        foreach ($files as $key => $file) {

            // All files that don't start with a dot (.).
            if ($file[0] !== '.') {

                // Load the file.
                require_once $folder . $file;

                // We have to call the migrations after because
                // some seeds are dependant from other seeds.
                $seeders[] = explode('.', $file)[0];
            }
        }

        // Run all seeds.
        foreach ($seeders as $seeder) {
            $this->call($seeder);
        }
    }
}
