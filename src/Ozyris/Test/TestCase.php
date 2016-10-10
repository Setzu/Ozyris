<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 03/10/16
 * Time: 13:29
 */

namespace Ozyris\Test;


use PHPUnit_Framework_TestCase;

class TestCase extends PHPUnit_Framework_TestCase
{
    protected $instance;

    /**
     * Récupère une propriété protégée / privée
     *
     * @param string $sPropertyName
     * @return mixed
     */
    public function getInaccessibleProperty($sPropertyName)
    {
        $oReflectionProperty = new \ReflectionProperty($this->instance, $sPropertyName);
        $oReflectionProperty->setAccessible(true);

        return $oReflectionProperty->getValue($this->instance);
    }

    /**
     * Set une propriété protégée / privée
     *
     * @param string $sPropertyName
     * @return mixed
     */
    public function setInaccessibleProperty($sPropertyName, $value)
    {
        $oReflectionProperty = new \ReflectionProperty($this->instance, $sPropertyName);
        $oReflectionProperty->setAccessible(true);
        $oReflectionProperty->setValue($this->instance, $value);

        return $this;
    }

    /**
     * Appelle une méthode protégée / privée
     *
     * @param string $sMethodName
     * @param array $aParameters
     * @return mixed
     */
    public function callInaccessibleMethod($sMethodName, array $aParameters = [])
    {
        $oReflectionMethod = new \ReflectionMethod($this->instance, $sMethodName);
        $oReflectionMethod->setAccessible(true);

        return $oReflectionMethod->invokeArgs($this->instance, $aParameters);
    }
}