<div class="d-sm-inline-flex d-flex" id="wrapper">
    <div><!-- class="col-lg-8 col-md-7 col-sm-6 col-xs-5" id="page-content-wrapper">-->
        <div class="container-fluid">
            <h1 class="mt-4">Mon compte</h1>
            <table>
                <thead>
                    <tr>
                        <th>Nom</td>
                        <th>Prénom</th>
                        <th>Pseudo</th>
                        <th>Email</td>
                        <th>Téléphone</td>
                        <th>Ville</th>
                        <th>Code postal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?=$_SESSION["user"]["surname"]?></td>
                        <td><?=$_SESSION["user"]["forname"]?></td>
                        <td><?=$_SESSION["user"]["username"]?></td>
                        <td><?=$_SESSION["user"]["email"]?></td>
                        <td><?=$_SESSION["user"]["phone"]?></td>
                        <td><?=$_SESSION["user"]["add3"]?></td>
                        <td><?=$_SESSION["user"]["postcode"]?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>