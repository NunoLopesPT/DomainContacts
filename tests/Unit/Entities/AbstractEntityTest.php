<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Entities;

use NunoLopes\DomainContacts\Entities\AbstractEntity;
use NunoLopes\Tests\DomainContacts\AbstractTest;

/**
 * Class Entity.
 *
 * This class will be used to test the AbstractEntity more easily.
 *
 * @package NunoLopes\DomainContacts
 */
class Entity extends AbstractEntity
{
}

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
     * @var AbstractEntity $abstractEntity - Abstract Entity instance.
     */
    protected $abstractEntity;

    /**
     * @inheritdoc
     */
    public function setUp(): void
    {
        // Calls parent function.
        parent::setUp();

        // Create a new instance from the Abstract Class
        $this->abstractEntity = new Entity(['id' => 1]);
    }

    /**
     * Test that an Entity can be JsonSerialized.
     *
     * @return void
     */
    public function testCanJsonSerializeEntity(): void
    {
        // Performs test.
        $result = $this->abstractEntity->jsonSerialize();

        // Performs assertions.
        $this->assertIsArray(
            $result
        );
        $this->assertEquals(
            1,
            $result['id']
        );
    }

    /**
     * Test that setting an attribute that doesn't exists fails.
     *
     * @return void
     */
    public function testSettingAttributeThatDoesntExistsFails(): void
    {
        // Creates expectation.
        $this->expectException(\InvalidArgumentException::class);

        // Performs test.
        $this->abstractEntity->setAttributes(['dummyAttribute' => 0]);
    }

    /**
     * Validates all Entity Attributes
     *
     * @param AbstractEntity $entity     - The entity that we will test all attributes.
     * @param array          $attributes - The attributes of the entity in an array that we will compare.
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
