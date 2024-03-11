<!DOCTYPE html>
<html>

<head>
    <title>index</title>
    <link rel="stylesheet" type="text/css" href="/ECOMOBIL/assets/style.css">
</head>

<body>
<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require('Controller/controller.php');



if (isset($_GET['action'])) {
    if ($_GET['action'] == 'login') {
        LoginUser($_POST['email'], $_POST['password']);
    } else if ($_GET['action'] == 'AddClient') {
        if (isset($_POST['Prenom'], $_POST['Nom'], $_POST['Email'], $_POST['Mdp'])) {
            AddClient($_POST['Prenom'], $_POST['Nom'], $_POST['Email'], $_POST['Mdp']);
        } else {
            echo "Manque un champ du formulaire";
        }
    } else if ($_GET['action'] == 'Deconnexion') {
        session_unset();
        session_destroy();
        header("Location: /ECOMOBIL/index.php");
        exit();
    } else if ($_GET['action'] == 'GetListAgence') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $selectedAgencyId = isset($_POST['agencyId']) ? $_POST['agencyId'] : NULL;
            ListAgence($selectedAgencyId);

            $reservationData = [
                'agence' => $_POST['agencyId'],
                'date' => $_POST['Date'],
                'heure' => $_POST['Heure'],
                'nbParticipants' => $_POST['NbParticipants'],
                'tarifType' => $_POST['tarifType'] ?? '',
            ];
            StoreReservationInSession($reservationData);

            header("Location: /ECOMOBIL/View/ChoixNP.php");
            exit();
        }
    }else if ($_GET['action'] == 'SelectVehicle') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $selectedVehicleId = isset($_POST['selectedVehicleId']) ? $_POST['selectedVehicleId'] : NULL;
            $selectedTarif = isset($_POST['selectedTarif']) ? $_POST['selectedTarif'] : NULL;

            StoreVehicleInSession($selectedVehicleId, $selectedTarif);

            header("Location: /ECOMOBIL/View/ChoixVParticipant.php");
            exit();
        }
    }else if ($_GET['action'] == 'SelectVehicleParticipant') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $selectedVehicleId = isset($_POST['selectedVehicleId']) ? $_POST['selectedVehicleId'] : NULL;
        $selectedTarif = isset($_POST['selectedTarif']) ? $_POST['selectedTarif'] : NULL;

        $participantData = isset($_SESSION['participant']) ? $_SESSION['participant'] : [];

        $participantData['selectedVehicleId'] = $selectedVehicleId;
        $participantData['selectedTarif'] = $selectedTarif;

        $selectedVehicleLibelle = isset($_POST['selectedVehicleLibelle']) ? $_POST['selectedVehicleLibelle'] : NULL;
        $participantData['selectedVehicleLibelle'] = $selectedVehicleLibelle;

        $_SESSION['participant'] = $participantData;

        header("Location: /ECOMOBIL/View/Confirmation.php");
        exit();
        }
    }else if  ($_GET['action'] == 'inserer') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Insertion($_SESSION);
        }
    }
    
    else {
        ListAgence(NULL);
    }


} else {
    if (isset($_SESSION['email'])) {
        $welcomeMessage = "Welcome, " . $_SESSION["Prenom"] . " " . $_SESSION["Nom"] . "!";

        require('View/main.php');
    } else {
        require('Menuprincipal.php');
    }
}







?>
</body>

</html>
