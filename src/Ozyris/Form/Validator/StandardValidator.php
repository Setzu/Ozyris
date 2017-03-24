<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 31/05/16
 * Time: 14:32
 */

namespace Ozyris\Validator;

use Ozyris\Stdlib\ValidatorInterface;

class StandardValidator // implements ValidatorInterface
{
    const IS_EMPTY = "ChampVide";
    const TOO_LONG = "ChampTropLong";
    const TOO_SMALL = "ChampTropCourt";

    public $errorMessage = '';

    private $messagesTemplate = array(
        self::IS_EMPTY => 'Veuillez remplir ce champ.',
        self::TOO_LONG => 'La valeur de ce champ ne doit pas dépasser %value% caractères.',
        self::TOO_SMALL => 'La valeur de ce champ doit comporter au moins %value% caractères.',
    );

    /**
     * @param string $value
     * @param int $min
     * @param int $max
     * @return bool
     */
    public function stringLenght($value = '', $min = 0, $max = 255)
    {
        if (strlen((string) $value) < (int) $min) {
            $this->errorMessage = $this->setMessageTemplate($this->messagesTemplate[self::TOO_SMALL], $min);

            return false;
        } elseif (strlen((string) $value) > (int) $max) {
            $this->errorMessage = $this->setMessageTemplate($this->messagesTemplate[self::TOO_LONG], $max);

            return false;
        }

        return true;
    }

    /**
     * @param string $pattern
     * @param $value
     * @return bool
     * @throws \Exception
     */
    public function pregMatch($pattern = '', $value)
    {
        $regex = '/^' . (string) $pattern . '$/';

        if (is_array($value)) {
            foreach ($value as $k => $v) {
                if (!preg_match($regex, (string) $v)) {
                    return false;
                }
            }
        } elseif (!preg_match($regex, (string) $value)) {
            return false;
        }

        return true;
    }

    /**
     * @param string $message
     * @param string $value
     * @return string
     */
    private function setMessageTemplate($message, $value)
    {
        $errorMessage = str_replace(
            '%value%',
            (string) $value,
            (string) $message
        );

        return $errorMessage;
    }

    /**
     * @param $value
     */
    public function isValid($value)
    {
        // @TODO : méthode à définir
    }
}