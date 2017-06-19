<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 30/05/16
 * Time: 15:32
 */

namespace Ozyris\Form\Validator;

class PasswordValidator extends StandardValidator
{
    const IS_EMPTY = 'Vous devez saisir un mot de passe et le confirmer.';
    const INVALID = 'Le mot de passe et la confirmation du mot de passe doivent contenir au moins 8 caractères,
    ils ne doivent pas dépasser 50 caractères et doivent comporter uniquement des caractères alphanumériques.';
    const DO_NOT_MATCH = 'Les mots de passe que vous avez saisis ne correspondent pas.';

    public $errorMessage = '';

    /**
     * @param string $value
     * @param string $confirm
     * @return bool
     */
    public function isValid($value = '', $confirm = '')
    {
        $sPasswordPattern = '/^[a-zA-Z0-9]{8,255}$/';
        
        if (empty((string) $value) || empty((string) $confirm)) {
            $this->errorMessage = self::IS_EMPTY;

            return false;
        } elseif (!preg_match($sPasswordPattern, (string) $value)) {
            $this->errorMessage = self::INVALID;

            return false;
        } elseif ((string) $value !== (string) $confirm) {
            $this->errorMessage = self::DO_NOT_MATCH;

            return false;
        }

        return true;
    }
}