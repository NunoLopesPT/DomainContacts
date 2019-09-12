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
                $table->string('first_name')
                      ->comment('First name of the contact.');
                $table->string('last_name')
                      ->nullable()
                      ->comment('Last name of the contact.');;
                $table->string('phone_number')
                      ->nullable()
                      ->comment('Phone Number of the contact.');;
                $table->string('email')
                      ->nullable()
                      ->comment('Email of the contact.');;
                $table->timestamps();

                // Add table foreign keys.
                $table->foreign('user_id', self::TABLE_NAME . '_user_foreign')
                      ->references('id')
                      ->on('users')
                      ->onDelete('cascade')
                      ->onUpdate('cascade');
            });
        }

        echo "Contacts table created with success\n";
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if ($this->schema->hasTable(self::TABLE_NAME)) {
            $this->schema->drop(self::TABLE_NAME);

            echo "Contacts table dropped with success\n";
        }
    }
}
