<?php
/** @var \NunoLopes\DomainContacts\Entities\User $user */

\json_encode([
    'name' => $user->name()
]);
