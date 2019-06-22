<?php
namespace NunoLopes\LaravelContactsAPI\Entities;

/**
 * Class Contact.
 *
 * @package NunoLopes\LaravelContactsAPI\Entities
 */
class Contact
{
    /**
     * @var string $first_name - First name of the Contact.
     */
    private $first_name = null;

    /**
     * @var string|null $last_name - Last name of the Contact.
     */
    private $last_name = null;

    /**
     * @var string|null $email - Email of the Contact.
     */
    private $email = null;

    /**
     * @var string|null $phone_number - Phone Number of the Contact.
     */
    private $phone_number = null;

    /**
     * Contact constructor.
     *
     * @param $attributes
     */
    public function __construct($attributes)
    {
        foreach ($attributes as $key => $value) {

            $setter = 'set' . str_replace('_', '', \ucwords($key, '_'));

            if (\method_exists($this, $setter)) {
                $this->{$setter}($value);
            }
        }
    }

    /**
     * Get the first name of the Contact.
     *
     * @return string
     */
    public function getFirstName(): string
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
    public function getLastName(): ?string
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
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set the email of the Contact.
     *
     * @param string|null $email - Sets the email of the Contact.
     */
    public function setEmail(string $email): void
    {
        if (\strlen(\trim($email)) === 0) {
            $email = null;
        }

        $this->email = $email;
    }

    /**
     * Get the phone number of the Contact.
     *
     * @return string|null
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    /**
     * Set the phone number of the Contact.
     *
     * @param string|null $phone_number - Sets the phone number of the Contact.
     */
    public function setPhoneNumber(string $phone_number): void
    {
        if (\strlen(\trim($phone_number)) === 0) {
            $phone_number = null;
        }
        $this->phone_number = $phone_number;
    }
}