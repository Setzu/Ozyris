<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 30/05/16
 * Time: 15:45
 */

namespace Ozyris\Service;

interface ValidatorInterface
{

    /**
     * @param mixed $value
     * @return mixed
     */
    public function isValid($value);

}