<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 26/05/16
 * Time: 14:36
 */

if (array_key_exists('isAuthentified', $_SESSION) && $_SESSION['isAuthentified']) { ?>

    <div class="row">
        <div class="col-md-offset-6">
            <form class="form-inline" action="/authentification/disconnect" method="post" role="form" id="login-form">

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Se deconnecter</button>
                </div>

            </form>
        </div>
    </div>

<?php } else { ?>

    <div class="row">
        <div class="col-md-6 col-md-offset-4">
            <form class="form-inline" action="/authentification" method="post" role="form" id="login-form">
                <fieldset>
                    <div class="form-group">
                        <input type="text" name="username" required="required" placeholder="Identifiant"
                               class="form-control">
                        <input type="password" required="required" name="password" placeholder="Mot de passe"
                               class="form-control">
                        <button type="submit" class="btn btn-primary">Se connecter</button>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="col-md-2">
            <a href="/authentification/registration" class="btn btn-primary">S'inscrire</a>
        </div>
    </div>

<?php } ?>

<hr>

