<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 13/07/17
 * Time: 14:58
 */

/**
 * Add controller name and role, like in this example :
 * 'Controller1' => 'role1, role2, role3',
 * 'Controller2' => 'role2, role3',
 * 'Controller3' => 'all'
 */
return [
    'role' => [
        'guest',
        'member',
        'admin'
    ],
    'controller' => [
        'index' => 'all',
        'authentification' => 'guest',
        'password' => 'all',
    ]
];