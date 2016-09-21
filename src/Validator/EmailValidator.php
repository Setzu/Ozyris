<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 30/05/16
 * Time: 15:19
 */

namespace Ozyris\Validator;

use Ozyris\Service\ValidatorInterface;

class EmailValidator implements ValidatorInterface
{
    const IS_EMPTY = "Vous devez saisir une adresse email.";
    const TOO_LONG = "L'adresse email ne doit pas dépasser 255 caractères.";
    const INVALID = "L'adresse email saisie n'est pas valide.";

    public $errorMessage = '';

    /**
     * @param string $value
     * @return bool
     */
    public function isValid($value)
    {
        $sEmail = (string) htmlspecialchars(trim($value));
        $sEmailPattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9-.]+[.][a-zA-Z0-9-]+$/";

        if (empty($sEmail)) {
            $this->errorMessage = self::IS_EMPTY;

            return false;
        } elseif(strlen($sEmail) > 255) {
            $this->errorMessage = self::TOO_LONG;

            return false;
        } elseif (!preg_match($sEmailPattern, $sEmail)) {
            $this->errorMessage = self::INVALID;

            return false;
        }

        return true;
    }

}