<?php
namespace NunoLopes\DomainContacts\Utilities\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Builder;
use NunoLopes\DomainContacts\Factories\Database\Eloquent\CapsuleFactory;

/**
 * Class AbstractMigration.
 *
 * This class will provide a schema for the migrations to run, all of them
 * should extend this class.
 *
 * @package NunoLopes\DomainContacts
 */
abstract class AbstractMigration extends Migration
{
    /**
     * @var Builder $schema - Database schema instance.
     */
    protected $schema = null;

    /**
     * AbstractMigration constructor.
     */
    public function __construct()
    {
        $this->schema = CapsuleFactory::get()->schema();
    }
}
