<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 29/05/16
 * Time: 03:19
 */
?>

<div class="row">
    <div class="col-md-4 col-md-offset-4">

        <form action="/authentification/registration" method="post" role="form" class="form-style">
            <h2>Inscription : </h2>
            <div class="form-group">
                <label for="email">Adresse email :
                <input type="text" name="email" required="required" placeholder="Adresse email" class="form-control"
                       value="<?= isset($_SESSION['email']) ? $_SESSION['email'] : null; ?>">
                </label>
                <label for="username">Nom d'utilisateur :
                <input type="text" name="username" required="required" placeholder="Nom d'utilisateur"
                       class="form-control" value="<?= isset($_SESSION['username']) ? $_SESSION['username'] : null; ?>">
                </label>
                <label for="password">Mot de passe :
                    <input type="password" required="required" name="password" class="form-control">
                </label>
                <label for="confirm-password">Confirmer le mot de passe :
                    <input type="password" required="required" name="confirm-password" class="form-control">
                </label>
            </div>

            <button type="submit" class="btn btn-primary">Valider</button>
        </form>

    </div>
</div>
