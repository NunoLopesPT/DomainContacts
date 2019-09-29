<?php
namespace NunoLopes\DomainContacts\Services\Database;

use Illuminate\Database\Seeder;

/**
 * Class MigrationsService.
 *
 * This class will be the responsible for all migrations.
 *
 * @package NunoLopes\DomainContacts\Services
 */
class SeedsService extends Seeder
{
    /**
     * Populate the database with random records.
     *
     * @return void
     */
    public function seedDatabase(): void
    {
        echo "Running seeds";

        // Folder where all the seeds are.
        $folder = __DIR__ . '/../../../database/seeds/';

        // Scan all files/folders inside database.
        $files = \scandir($folder);

        $seeders = [];
        foreach ($files as $key => $file) {

            // All files that don't start with a dot.
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
