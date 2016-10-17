<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 17/10/16
 * Time: 14:30
 */

namespace Ozyris\Stdlib;


interface DispatchInterface
{
    /**
     * dispatch
     *
     * @return mixed
     */
    public function dispatch();

    /**
     * getControllerName
     *
     * @return mixed
     */
    public function getControllerName();

    /**
     * setControllerName
     *
     * @param string $controllerName
     * @return mixed
     */
    public function setControllerName($controllerName);

    /**
     * getActionName
     *
     * @return mixed
     */
    public function getActionName();

    /**
     * setActionName
     *
     * @param string $actionName
     * @return mixed
     */
    public function setActionName($actionName);
}