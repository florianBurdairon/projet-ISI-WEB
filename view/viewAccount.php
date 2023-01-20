<div class="d-sm-inline-flex d-flex w-100">
    <div class="container-fluid">
        <h1 class="mt-4 mb-3 ml-5"><i class="fa fa-user"></i> Mon compte</h1>
        <div class="d-flex flex-column align-items-center justify-content-center w-100">
            
            <div class="d-flex flex-column col-4">
                <p class="account-category border-top border-right border-left rounded-top w-100 pt-1"><b>Nom :</b></p>
                <p class="account-info border-bottom border-right border-left w-100 pb-1"><?=(($user != null) ? $user->get_surname() : "");?></p>
                <p class="account-category border-top border-right border-left w-100 pt-1"><b>Prénom :</b></p>
                <p class="account-info border-bottom border-right border-left w-100 pb-1"><?=(($user != null) ? $user->get_forname() : "");?></p>
                <p class="account-category border-top border-right border-left w-100 pt-1"><b>Nom d'utilisateur :</b></p>
                <p class="account-info border-bottom border-right border-left w-100 pb-1"><?=(($user != null) ? $login->get_username() : "");?></p>
                <p class="account-category border-top border-right border-left w-100 pt-1"><b>Email :</b></p>
                <p class="account-info border-bottom border-right border-left w-100 pb-1"><?=(($user != null) ? $user->get_email() : "");?></p>
                <p class="account-category border-top border-right border-left w-100 pt-1"><b>Téléphone :</b></p>
                <p class="account-info border-bottom border-right border-left w-100 pb-1"><?=(($user != null) ? $user->get_phone() : "");?></p>
                <p class="account-category border-top border-right border-left w-100 pt-1"><b>Adresse :</b></p>
                <p class="account-info border-bottom border-right border-left w-100 pb-1"><?=(($user != null) ? $user->get_add1() : "");?></p>
                <p class="account-category border-top border-right border-left w-100 pt-1"><b>Complément d'adresse :</b></p>
                <p class="account-info border-bottom border-right border-left w-100 pb-1"><?=(($user != null) ? $user->get_add2() : "");?></p>
                <p class="account-category border-top border-right border-left w-100 pt-1"><b>Ville :</b></p>
                <p class="account-info border-bottom border-right border-left w-100 pb-1"><?=(($user != null) ? $user->get_add3() : "");?></p>
                <p class="account-category border-top border-right border-left w-100 pt-1"><b>Code postal :</b></p>
                <p class="account-info border-bottom border-right border-left rounded-bottom w-100 pb-1 mb-4"><?=(($user != null) ? $user->get_postcode() : "");?></p>
            </div>
        </div>
    </div>
</div>