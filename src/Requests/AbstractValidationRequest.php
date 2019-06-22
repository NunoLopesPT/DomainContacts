<?php
namespace NunoLopes\LaravelContactsAPI\Requests;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Validator;
use Symfony\Component\HttpFoundation\Request;

/**
 * This class will initialize the Validatior from Illuminate.
 *
 * @package NunoLopes\LaravelContactsAPI
 */
abstract class AbstractValidationRequest {

    /**
     * @var Validator $validator - Class to validate form data.
     */
    protected $validator = null;

    /**
     * @var Request $request - Class to retrieve form data.
     */
    protected $request = null;

    /**
     * AbstractValidationRequest constructor.
     *
     * @throws \LogicException
     */
    public function __construct()
    {
        // Initializes the request class.
        $this->request = Request::createFromGlobals();

        // Initializes Validator's dependencies.
        $fileSystem = new Filesystem();
        $fileLoader = new FileLoader($fileSystem, 'lang');
        $translator = new Translator($fileLoader, 'en');

        // Returns initialized instance.
        $this->validator = new Validator(
            $translator,
            \json_decode($this->request->getContent(), true),
            $this->rules(),
            []
        );
    }

    /**
     * Returns all validated fields.
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return array
     */
    public function validated(): array
    {
        return $this->validator->validated();
    }

    /**
     * All extending classes should have rules.
     *
     * @return array
     */
    public abstract function rules(): array;
}
