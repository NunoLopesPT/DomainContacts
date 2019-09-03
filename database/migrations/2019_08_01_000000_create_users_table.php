<?php

use Illuminate\Database\Schema\Blueprint;
use NunoLopes\DomainContacts\Utilities\Database\Migrations\AbstractMigration;

/**
 * Class CreateUsersTable.
 *
 * This class will create the Users table.
 *
 * @package NunoLopes\DomainContacts
 */
class CreateUsersTable extends AbstractMigration
{
    /**
     * @var string TABLE_NAME - The name of the table that is going to be created.
     */
    const TABLE_NAME = 'users';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only create table if it doesn't exist.
        if (!$this->schema->hasTable(self::TABLE_NAME)) {

            // Create table.
            $this->schema->create(self::TABLE_NAME, function (Blueprint $table) {

                // Add table columns.
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('email')
                    ->unique();
                $table->string('password');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->dropIfExists(self::TABLE_NAME);
    }
}
