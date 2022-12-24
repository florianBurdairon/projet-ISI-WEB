<?php
    require "components/head.php";
    require "components/header.php";
?>
<div class="d-sm-inline-flex d-flex" id="wrapper">
    <div><!-- class="col-lg-8 col-md-7 col-sm-6 col-xs-5" id="page-content-wrapper">-->
        <div class="container-fluid">
            <h1 class="mt-4">Connexion</h1>
            <form method="post" action="login.php">
                <input type="hidden" name="action" value="login_check">
                <label for="email">email</label>
                <input type="email" name="email">
                <br>
                <label for="password">password</label>
                <input type="password" name="password">
                <br>
                <button type="submit">Envoyer</button>
            </form>
        </div>
    </div>
</div>
<?php include "components/footer.php"; ?>