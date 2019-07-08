<?php
namespace NunoLopes\LaravelContactsAPI\Entities;

/**
 * Class User.
 *
 * @package NunoLopes\LaravelContactsAPI\Entities
 */
class User extends AbstractEntity
{
    /**
     * @var string $name - Name of the User.
     */
    private $name = null;

    /**
     * @var string $email - Email of the User.
     */
    private $email = null;

    /**
     * Returns the name of the User.
     *
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Set the name of the User.
     *
     * @param string $name - Name of the Contact.
     *
     * @throws \InvalidArgumentException - If the name is empty.
     *
     * @return void
     */
    protected function setName(string $name): void
    {
        if (\strlen(\trim($name)) === 0) {
            throw new \InvalidArgumentException('The name for the user is empty.');
        }

        $this->name = $name;
    }

    /**
     * Returns the email of the User.
     *
     * @return string
     */
    public function email(): ?string
    {
        return $this->email;
    }

    /**
     * Set the email of the User.
     *
     * @param string $email - Sets the email of the Contact.
     *
     * @throws \InvalidArgumentException - If the email is empty.
     *
     * @return void
     */
    protected function setEmail(string $email): void
    {
        if (\strlen(\trim($email)) === 0) {
            throw new \InvalidArgumentException('The email for the user is empty.');
        }

        $this->email = $email;
    }
}