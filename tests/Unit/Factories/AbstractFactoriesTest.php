<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Factories;

use NunoLopes\Tests\DomainContacts\AbstractTest;

/**
 * Class AbstractFactoriesTest
 * @package NunoLopes\Tests\DomainContacts\Unit\Factories
 */
abstract class AbstractFactoriesTest extends AbstractTest
{
    /**
     * Clears the singleton of a class.
     *
     * @param string $class
     *
     * @throws \ReflectionException
     */
    protected function clearSingleton(string $class): void
    {
        $reflectionClass = new \ReflectionClass($class);

        // Clear all properties of the given class.
        foreach (\array_keys($reflectionClass->getDefaultProperties()) as $property) {

            // Clear the property.
            $reflectionProperty = $reflectionClass->getProperty($property);
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue(null);
            $reflectionProperty->setAccessible(false);
        }
    }
}