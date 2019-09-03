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
        // Create table.
        $this->schema->create(self::TABLE_NAME, function (Blueprint $table) {

            // Add table columns.
            $table->bigIncrements('id');
            $table->string('token_id', 100);
            $table->unsignedBigInteger('user_id');
            $table->boolean('revoked');
            $table->date('expires_at');
            $table->timestamps();

            // Add table foreign keys.
            $table->foreign('user_id', self::TABLE_NAME . '_user_foreign');

            // Add table unique keys.
            $table->unique('token_id', self::TABLE_NAME . '_token_id_unique');
         });
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
