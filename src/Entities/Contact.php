<?php
namespace NunoLopes\DomainContacts\Entities;

/**
 * Class Contact.
 *
 * @package NunoLopes\DomainContacts\Entities
 */
class Contact extends AbstractEntity implements \JsonSerializable
{
    /**
     * @var string $first_name - First name of the Contact.
     */
    protected $first_name = null;

    /**
     * @var string|null $last_name - Last name of the Contact.
     */
    protected $last_name = null;

    /**
     * @var string|null $email - Email of the Contact.
     */
    protected $email = null;

    /**
     * @var string|null $phone_number - Phone Number of the Contact.
     */
    protected $phone_number = null;

    /**
     * @var int $user_id - Contact owner's ID.
     */
    protected $user_id = null;

    /**
     * Get the first name of the Contact.
     *
     * @return string
     */
    public function firstName(): string
    {
        return $this->first_name;
    }

    /**
     * Set the first name of the Contact.
     *
     * @param string|null $first_name - Sets the first name of the Contact.
     */
    public function setFirstName(string $first_name): void
    {
        if (\strlen(\trim($first_name)) === 0) {
            $first_name = null;
        }

        $this->first_name = $first_name;
    }

    /**
     * Get the last name of the Contact.
     *
     * @return string|null
     */
    public function lastName(): ?string
    {
        return $this->last_name;
    }

    /**
     * Set the last name of the Contact.
     *
     * @param string|null $last_name - Sets the last name of the Contact.
     */
    public function setLastName($last_name): void
    {
        if (\strlen(\trim($last_name)) === 0) {
            $last_name = null;
        }

        $this->last_name = $last_name;
    }

    /**
     * Get the email of the Contact.
     *
     * @return string|null
     */
    public function email(): ?string
    {
        return $this->email;
    }

    /**
     * Set the email of the Contact.
     *
     * @param string|null $email - Sets the email of the Contact.
     */
    public function setEmail(string $email = null): void
    {
        if ($email !== null && \strlen(\trim($email)) === 0) {
            $email = null;
        }

        $this->email = $email;
    }

    /**
     * Get the phone number of the Contact.
     *
     * @return string|null
     */
    public function phoneNumber()
    {
        return $this->phone_number;
    }

    /**
     * Set the phone number of the Contact.
     *
     * @param string|null $phone_number - Sets the phone number of the Contact.
     */
    public function setPhoneNumber(string $phone_number = null): void
    {
        if ($phone_number !== null && \strlen(\trim($phone_number)) === 0) {
            $phone_number = null;
        }

        $this->phone_number = $phone_number;
    }

    /**
     * Returns the Contact's User.
     *
     * @return User
     */
    public function user(): User
    {
        // @todo Create singleton factories
    }

    /**
     * Returns the Contact's User ID.
     *
     * @return int
     */
    public function userId()
    {
        return $this->user_id;
    }

    /**
     * Sets the Contact User ID.
     *
     * @param int $id - User's ID of the contact.
     *
     * @throws \InvalidArgumentException - If the id is not a positive integer.
     */
    protected function setUserId(int $id): void
    {
        if ($id < 0) {
            throw new \InvalidArgumentException('User ID Should be a positive integer.');
        }

        $this->user_id = $id;
    }
}
