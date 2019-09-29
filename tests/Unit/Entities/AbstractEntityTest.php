<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Entities;

use NunoLopes\DomainContacts\Entities\AbstractEntity;
use NunoLopes\Tests\DomainContacts\AbstractTest;

/**
 * Class AbstractTest.
 *
 * This class will add extra functionality to all tests.
 * This should be extended by all tests instead of TestCase.
 *
 * @package NunoLopes\DomainContacts
 */
abstract class AbstractEntityTest extends AbstractTest
{
    /**
     * @inheritdoc
     *
     * @return void
     */
    public function validateEntityAttributes(AbstractEntity $entity, array $attributes): void
    {
        // Assert finally the getAttributes.
        $entityAttributes = $entity->getAttributes();
        foreach ($attributes as $attribute => $value) {
            $this->assertEquals(
                $entityAttributes[$attribute],
                $value,
                "The $attribute is not the same."
            );
        }
    }
}
