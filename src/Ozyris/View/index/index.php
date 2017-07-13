<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 31/05/16
 * Time: 11:56
 */

if ($this->isAuth) {
?>
    <p>Bonjour <?php echo ucfirst($this->user->getUsername()); ?>,</p>

    <?php
        if ($this->user->isAdmin()) {
            echo 'is Admin';
        } else {
            echo'<pre>';var_dump($this->user->isAdmin());die;
        }
    ?>

<?php } else {

    echo 'Bonjour,';

}