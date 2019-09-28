<?php
namespace NunoLopes\DomainContacts\Traits\Entities;

/**
 * Trait AuditTimestampsTrait
 *
 * Implementation of the Audit Timestamps to use in Entities that use them.
 *
 * @package NunoLopes\DomainContacts
 */
trait AuditTimestampsTrait
{
    /**
     * @var string $created_at - When the record was created.
     */
    protected $created_at = null;

    /**
     * @var string|null $updated_at - When the record was updated.
     */
    protected $updated_at = null;

    /**
     * Returns an Unix timestamp when the record was created.
     *
     * @todo Return Datatype.
     *
     * @return int
     */
    public function createdAt(): int
    {
        return \strtotime($this->created_at);
    }

    /**
     * Sets when the record was created.
     *
     * @param string $createdAt - Date timestamp.
     */
    protected function setCreatedAt(string $createdAt)
    {
        $this->created_at = $createdAt;
    }

    /**
     * Returns an Unix timestamp when the record was updated.
     *
     * @todo Return Datatype.
     *
     * @return int
     */
    public function updatedAt(): int
    {
        return \strtotime($this->updated_at);
    }

    /**
     * Sets when the record was updated.
     *
     * @param string|null $updatedAt - Date timestamp.
     */
    protected function setUpdatedAt(string $updatedAt = null)
    {
        $this->updated_at = $updatedAt;
    }
}
