<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Requests;

use NunoLopes\DomainContacts\Requests\AbstractValidationRequest;
use NunoLopes\Tests\DomainContacts\AbstractTest;

/**
 * Class Request.
 *
 * This class will be used to test more easily the
 * Abstract Validation Request.
 *
 * @package NunoLopes\DomainContacts
 */
class Request extends AbstractValidationRequest
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
        ];
    }
};

/**
 * Class AbstractValidationRequestTest.
 *
 * @package NunoLopes\DomainContacts
 */
class AbstractValidationRequestTest extends AbstractTest
{
    /**
     * @inheritdoc
     */
    public function setUp(): void
    {
        // Calls parent.
        parent::setUp();

        $_POST = [
            'name' => $this->faker->name,
        ];
    }

    /**
     * Test that a request without the set rules will fail.
     *
     * @return void
     */
    public function testRequestWithoutRequiredRulesFails(): void
    {
        unset($_POST['name']);

        $request = new Request();

        $this->assertTrue(
            $request->fails()
        );
        $this->assertEmpty(
            $request->validated()
        );
        $this->assertEquals(
            \array_keys($request->errors()),
            ['name']
        );

    }
}
