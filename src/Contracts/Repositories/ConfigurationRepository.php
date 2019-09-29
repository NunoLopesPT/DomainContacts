<?php
namespace NunoLopes\DomainContacts\Contracts\Repositories;

use NunoLopes\DomainContacts\Datatypes\DatabaseConfiguration;

/**
 * ConfigurationRepository Contract.
 *
 * This classs will be responsible to get the configurations.
 *
 * All Configurations Repositories should implement this class.
 *
 * @package NunoLopes\DomainContacts
 */
interface ConfigurationRepository
{
    /**
     * Get the DatabaseConfiguration.
     *
     * @return DatabaseConfiguration
     */
    public function getDatabase(): DatabaseConfiguration;
}
