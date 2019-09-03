<?php

use Illuminate\Database\Schema\Blueprint;
use NunoLopes\DomainContacts\Utilities\Database\Migrations\AbstractMigration;

/**
 * Class CreateContactsTable.
 *
 * This class will create the contacts table.
 *
 * @package NunoLopes\DomainContacts
 */
class CreateContactsTable extends AbstractMigration
{
    /**
     * @var string TABLE_NAME - The name of the table that is going to be created.
     */
    const TABLE_NAME = 'contacts';

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
                $table->unsignedBigInteger('user_id');
                $table->string('first_name');
                $table->string('last_name')
                    ->nullable();
                $table->string('phone_number')
                    ->nullable();
                $table->string('email')
                    ->nullable();
                $table->timestamps();

                // Add table foreign keys.
                $table->foreign('user_id', self::TABLE_NAME . '_user_foreign')
                      ->references('id')
                      ->on('users')
                      ->onDelete('cascade')
                      ->onUpdate('cascade');
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
