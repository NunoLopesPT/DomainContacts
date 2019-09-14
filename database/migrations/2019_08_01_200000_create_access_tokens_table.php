<?php

use Illuminate\Database\Schema\Blueprint;
use NunoLopes\DomainContacts\Utilities\Database\Migrations\AbstractMigration;

/**
 * Class CreateAccessTokensTable.
 *
 * This class will create the AccessTokens table.
 *
 * @package NunoLopes\DomainContacts
 */
class CreateAccessTokensTable extends AbstractMigration
{
    /**
     * @var string TABLE_NAME - The name of the table that is going to be created.
     */
    const TABLE_NAME = 'access_tokens';

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
                $table->string('token_id', 100)
                      ->comment('Access Token Unique ID');
                $table->unsignedBigInteger('user_id')
                      ->comment('Owner of the Access Token.');
                $table->boolean('revoked')
                      ->default(false)
                      ->comment('If the Access Token is still valid');
                $table->date('expires_at')
                      ->comment('When the Access Token will expire');
                $table->timestamps();

                // Add table foreign keys.
                $table->foreign('user_id', self::TABLE_NAME . '_user_foreign')
                      ->references('id')
                      ->on('users')
                      ->onDelete('cascade')
                      ->onUpdate('cascade');

                // Add table unique keys.
                $table->unique('token_id', self::TABLE_NAME . '_token_id_unique');
            });
        }

        echo "Access Tokens table created with success\n";
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

            echo "Access Tokens table dropped with success\n";
        }
    }
}
