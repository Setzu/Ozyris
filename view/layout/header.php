<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 26/05/16
 * Time: 14:36
 */

if ($oIndexController->isAuthentified) { ?>

    <div class="container">
        <div class="row">
            <div class="col-md-offset-6">
                <form class="form-inline" action="/authentification/disconect" method="post" role="form" id="login-form">

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Se deconnecter</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

<?php } else { ?>

    <div class="container">
        <div class="row">
            <div class="col-md-offset-5">
                <form class="form-inline" action="/authentification" method="post" role="form" id="login-form">

                    <div class="form-group">
                        <input type="text" name="username" required="required" placeholder="Identifiant"
                               class="form-control">
                        <input type="password" required="required" name="password" placeholder="Mot de passe"
                               class="form-control">
                        <button type="submit" class="btn btn-primary">Se connecter</button>
                    </div>

                </form>
                <a href="/authentification/registration" class="btn btn-primary">Inscription</a>

            </div>
        </div>
    </div>

<?php } ?>
