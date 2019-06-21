<?php
namespace NunoLopes\LaravelContactsAPI\Requests;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Validator;

/**
 * This class will initialize the Validatior from Illuminate.
 * @todo Encapsulate it
 *
 * @package NunoLopes\LaravelContactsAPI
 */
abstract class AbstractValidationRequest {
    public $validator = null;

    public function __construct()
    {
        // Initializes Validator's dependencies.
        $fileSystem = new Filesystem();
        $fileLoader = new FileLoader($fileSystem, 'lang');
        $translator = new Translator($fileLoader, 'en');

        // Returns initialized instance.
        $this->validator = new Validator(
            $translator,
            \array_merge(
                $_GET,
                $_POST,
                $_FILES
            ),
            $this->rules(),
            []
        );
    }

    public abstract function rules(): array;
}