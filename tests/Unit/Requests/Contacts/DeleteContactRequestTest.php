<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Requests\Authentication;

use NunoLopes\DomainContacts\Requests\Contacts\DeleteContactRequest;
use NunoLopes\Tests\DomainContacts\AbstractTest;

/**
 * Class DeleteContactRequestTest.
 *
 * @package NunoLopes\DomainContacts
 */
class DeleteContactRequestTest extends AbstractTest
{
    /**
     * @inheritdoc
     */
    public function setUp(): void
    {
        // Calls parent class.
        parent::setUp();

        // Fills POST variable so the Request catches it.
        $_POST = [
            'id' => 1,
        ];
    }

    /**
     * Test DeleteContactRequest fails if there is no ID.
     *
     * @return void
     */
    public function testDeleteContactRequestFailsIfNoIdIsPresent(): void
    {
        // Unsets required variable to test request.
        unset($_POST['id']);

        // Performs test.
        $request = new DeleteContactRequest();

        // Performs assertion.
        $this->assertTrue($request->fails());
    }

    /**
     * Test DeleteContactRequest fails if ID is zero.
     *
     * @return void
     */
    public function testDeleteContactRequestFailsIfIdIsZero(): void
    {
        // Unsets required variable to test request.
        $_POST['id'] = 0;

        // Performs test.
        $request = new DeleteContactRequest();

        // Performs assertion.
        $this->assertTrue($request->fails());
    }

    /**
     * Test DeleteContactRequest fails if ID is negative.
     *
     * @return void
     */
    public function testDeleteContactRequestFailsIfIdIsNegative(): void
    {
        // Unsets required variable to test request.
        $_POST['id'] = -1;

        // Performs test.
        $request = new DeleteContactRequest();

        // Performs assertion.
        $this->assertTrue($request->fails());
    }

    /**
     * Test DeleteContactRequest succeeds.
     *
     * @return void
     */
    public function testDeleteContactRequestSucceeds(): void
    {
        // Performs test.
        $request = new DeleteContactRequest();

        // Performs assertion.
        $this->assertFalse($request->fails());
    }
}
