<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 31/05/16
 * Time: 11:56
 */
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<h2>Bienvenue <?= $this->isAuthentified ? $this->oUser->getUsername() : ''; ?></h2>

<hr>
