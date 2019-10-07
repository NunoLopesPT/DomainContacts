<?php
namespace NunoLopes\DomainContacts\Repositories\Filesystem;

use NunoLopes\DomainContacts\Contracts\Repositories\ConfigurationRepository;
use NunoLopes\DomainContacts\Datatypes\AsymmetricCryptography;
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
        // Get the path of the  configuration file of the Server's Database.
        $path = self::config . 'database.php';

        // Get the configurations.
        $config = include($path);

        // Return the datatype.
        return new DatabaseConfiguration(
            $config['host'],
            $config['user'],
            $config['pass'],
            $config['name'],
            $config['driver']
        );
    }

    /**
     * @inheritdoc
     *
     * @see ConfigurationRepository::getDatabase()
     */
    public function getRsa(): AsymmetricCryptography
    {
        // Get the path of the configuration file of the Server's RSA Key.
        $path = self::config . 'rsa.php';

        // Get the configurations.
        $config = include($path);

        // Get the private and the public key.
        $privKey = \openssl_pkey_get_private('file://' . $config['private_key']);
        $pubKey  = \openssl_pkey_get_public('file://' . $config['public_key']);

        // Return the datatype.
        return new AsymmetricCryptography($pubKey, $privKey);
    }
}
