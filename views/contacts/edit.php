<?=
/** @var \NunoLopes\LaravelContactsAPI\Entities\Contact $contact */

\json_encode([
    'first_name'   => $contact->firstName(),
    'last_name'    => $contact->lastName(),
    'email'        => $contact->email(),
    'phone_number' => $contact->phoneNumber(),
]);
