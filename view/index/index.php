<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 31/05/16
 * Time: 11:56
 */
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="../../public/css/example.css">

<h2>Bienvenue <?= ($this->isAuthentified) ? $this->oUser->getUsername() : ''; ?></h2>

<hr>

<div class="col-md-2">
    <label for="search-by-types">Rechercher par types</label>
    <input name="search-by-types" type="text" id="search-by-types">
</div>

<div class="col-md-10">
    <table id="example" class="table display" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>Name</th>
            <th>Position</th>
            <th>Office</th>
            <th>Salary</th>
        </tr>
    </table>
</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.0.min.js"
        integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s=" crossorigin="anonymous">
</script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../../public/js/plugins/jquery.dataTables.columnFilter.js"></script>
<script type="text/javascript" src="../../public/js/example.js"></script>
