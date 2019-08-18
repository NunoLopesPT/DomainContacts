<?=
/** @var \NunoLopes\DomainContacts\Entities\Contact $contact */

\json_encode([
    'id'           => $contact->id(),
    'first_name'   => $contact->firstName(),
    'last_name'    => $contact->lastName(),
    'email'        => $contact->email(),
    'phone_number' => $contact->phoneNumber(),
]);
