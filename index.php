<?php
/**
 * Created by PhpStorm.
 * User: david blanchard
 * Date: 26/05/16
 * Time: 12:07
 */

try {
    include_once __DIR__ . '/config/config.php';
    include_once __DIR__ . '/view/layout/layout.php';
} catch(\Exception $e) { ?>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="page-not-fount">
                    <h3 class="page-not-found">
<!--                        Une erreur s'est produite, merci de réessayer ultérieurement.-->
                        <?php  echo $e->getMessage(); ?>
                    </h3>
                </div>
                <a href="" class="btn btn-danger btn-retour" style="float: right;">Retour</a>
            </div>
        </div>
    </div>

    <?php
    exit;
}
?>

