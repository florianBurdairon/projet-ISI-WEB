<div class="d-sm-inline-flex d-flex" id="wrapper">
    <div><!-- class="col-lg-8 col-md-7 col-sm-6 col-xs-5" id="page-content-wrapper">-->
        <div class="container-fluid">
            <h1 class="mt-4">Mon compte</h1>
            <table>
                <thead>
                    <tr>
                        <th>Nom</td>
                        <th>Prénom</th>
                        <th>Nom d'utilisateur</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Adresse</th>
                        <th>Complément d'adresse</th>
                        <th>Ville</th>
                        <th>Code postal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?=(($user != null) ? $user->get_surname() : "");?></td>
                        <td><?=(($user != null) ? $user->get_forname() : "");?></td>
                        <td><?=(($user != null) ? $login->get_username() : "");?></td>
                        <td><?=(($user != null) ? $user->get_email() : "");?></td>
                        <td><?=(($user != null) ? $user->get_phone() : "");?></td>
                        <td><?=(($user != null) ? $user->get_add1() : "");?></td>
                        <td><?=(($user != null) ? $user->get_add2() : "");?></td>
                        <td><?=(($user != null) ? $user->get_add3() : "");?></td>
                        <td><?=(($user != null) ? $user->get_postcode() : "");?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>