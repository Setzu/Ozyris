<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 26/05/16
 * Time: 13:54
 */

use Ozyris\Controller\IndexController;
?>

<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo __DIR__ . '/../../../../public/css/layout.css';?>">
    <link rel="stylesheet" type="text/css" href="<?php echo __DIR__ . '/../../../../public/css/header.css';?>">
    <link rel="stylesheet" type="text/css" href="<?php echo __DIR__ . '/../../../../public/css/form.css';?>">
    <link rel="stylesheet" type="text/css" href="<?php echo __DIR__ . '/../../../../public/css/element.css';?>">
</head>

<body>

<header>
    <div class="container">
        <?php include_once (__DIR__ . '/header.php'); ?>
    </div>
</header>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <?php
                $oIndexController = new IndexController();
                $oIndexController->flashMessages();
            ?>
        </div>
    </div>
    <div class="row">
        <?php \Ozyris\Service\Dispatch::dispatch(); ?>
    </div>
</div>

<footer>
    <?php include_once (__DIR__ . '/footer.php'); ?>
</footer>

</body>

</html>
