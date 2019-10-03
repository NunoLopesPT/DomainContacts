<?php
namespace NunoLopes\DomainContacts\Repositories\Filesystem;

use NunoLopes\DomainContacts\Contracts\Repositories\ConfigurationRepository;
use NunoLopes\DomainContacts\Datatypes\DatabaseConfiguration;

/**
 * Class FilesystemConfigurationRepository.
 *
 * @package NunoLopes\DomainContacts
 */
class FilesystemConfigurationRepository implements ConfigurationRepository
{
    /**
     * @var string $config - Path to the configuration folder.
     */
    private const config = __DIR__ . '/../../../config/';

    /**
     * @inheritdoc
     *
     * @see ConfigurationRepository::getDatabase()
     */
    public function getDatabase(): DatabaseConfiguration
    {
        $path   = self::config . 'database.php';

        $config = include($path);

        return new DatabaseConfiguration(
            $config['host'],
            $config['user'],
            $config['pass'],
            $config['name'],
            $config['driver']
        );
    }
}
