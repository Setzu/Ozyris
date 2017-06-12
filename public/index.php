<?php
/**
 * Created by PhpStorm.
 * User: david blanchard
 * Date: 26/05/16
 * Time: 12:07
 */

/**
 * On inclue le fichier de configuration du projet dans un bloc try catch pour récupérer toutes les exceptions
 */
try {
    include_once __DIR__ . '/../config/config.php';
    include_once __DIR__ . '/../src/Ozyris/View/layout/layout.php';
} catch(\Exception $e) { ?>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="page-not-found">
                    <h3 class="page-not-found">
                        <!-- @TODO : à décommenter sur environnement de prod : -->
<!--                        Une erreur s'est produite, merci de réessayer ultérieurement.-->
                        <!-- @TODO : à commenter sur environnement de dev : -->
                        <?php echo $e->getMessage(); ?>
                    </h3>
                </div>
                <a href="" class="btn btn-danger btn-retour" style="float: right;">Retour</a>
            </div>
        </div>
    </div>

<?php } ?>
