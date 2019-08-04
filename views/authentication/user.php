<?php
/** @var \NunoLopes\LaravelContactsAPI\Entities\User $user */

\json_encode([
    'name' => $user->name()
]);
