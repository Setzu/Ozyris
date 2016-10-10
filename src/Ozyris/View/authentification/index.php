<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 29/05/16
 * Time: 03:18
 */
?>

<div class="col-md-4 col-md-offset-4">
    <form action="" method="post" role="form" id="register-form" class="form-style">
        <h2>Connexion : </h2>

        <div class="form-group">
            <label for="username">Nom d'utilisateur :
                <input type="text" name="username" required="required" placeholder="Nom d'utilisateur"
                       class="form-control">
            </label>
            <label for="password">Mot de passe :
                <input type="password" name="password" required="required" class="form-control">
            </label>
        </div>
        <div class="row">
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </div>
        <div style="margin: 10px 0 0 0;">
            <a href="/password">Mot de passe perdu ?</a>
        </div>
    </form>
</div>
