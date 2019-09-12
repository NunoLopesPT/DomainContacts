<?php
namespace NunoLopes\DomainContacts\Entities;

/**
 * Class User.
 *
 * @package NunoLopes\DomainContacts
 */
class User extends AbstractEntityState
{
    /**
     * @inheritdoc
     */
    protected static $required = ['name', 'email', 'password'];

    /**
     * @var string $name - Name of the User.
     */
    protected $name = null;

    /**
     * @var string $email - Email of the User.
     */
    protected $email = null;

    /**
     * @var string $password - Password of the User.
     */
    protected $password = null;

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
        // Remove any white character from the beginning and end of the string.
        $name = \trim($name);

        if (\strlen($name) === 0) {
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
        // Remove any white character from the beginning and end of the string.
        $email = \trim($email);

        if (\strlen($email) === 0) {
            throw new \InvalidArgumentException('The email for the user is empty.');
        }

        $this->email = $email;
    }

    /**
     * Returns the password hash of the user.
     *
     * @return string
     */
    public function password(): string
    {
        return $this->password;
    }

    /**
     * Set the password of the User.
     *
     * @param string $password - Sets the password of the User.
     *
     * @throws \InvalidArgumentException - If the password is empty.
     *
     * @return void
     */
    protected function setPassword(string $password): void
    {
        if (\strlen(\trim($password)) === 0) {
            throw new \InvalidArgumentException('The password for the user is empty.');
        }

        $this->password = $password;
    }
}