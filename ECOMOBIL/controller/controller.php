<?php
/* Fichier controller  pour TP_SIO2_1 */
require ('Model/modele.php');

function AddClient($Prenom, $Nom, $Email, $Mdp){
    if (CheckEmailExists($Email)) {
        $_SESSION["insertClient"] = 0;
        $_SESSION["Email"] = $Email; // Set the email for error message
        $_SESSION["errorMessage"] = "Error: Email already exists!";
        require('View/AddClient.php');
    } else {
        $mdpHash = password_hash($Mdp, PASSWORD_DEFAULT);
        $AddClient_result = InsertClient($Prenom, $Nom, $Email, $mdpHash);

        if ($AddClient_result) {
            $_SESSION["insertClient"] = 1;
        } else {
            $_SESSION["insertClient"] = 0;
            $_SESSION["errorMessage"] = "Error: Failed to add client.";
        }

        require('View/AddClient.php');
    }
}

function LoginUser($Email, $Mdp)
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $maxAttempts = 4;
    $lockoutPeriod = 20;

    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
    }
    if (!isset($_SESSION['last_login_attempt'])) {
        $_SESSION['last_login_attempt'] = 0;
    }

    if ($_SESSION['last_login_attempt'] + $lockoutPeriod < time()) {
        $_SESSION['login_attempts'] = 0;
    }

    if ($_SESSION['login_attempts'] >= $maxAttempts) {
        echo "Too many failed login attempts. Please try again later.";
        require('View/Login.php');
        exit();
    }

    $row = RecupClient($Email);

    if ($row && $row->rowCount() > 0) {
        $row = $row->fetch(PDO::FETCH_ASSOC);

        if ($row['MDP'] !== null) {
            $hashedPassword = $row['MDP'];

            if (password_verify($Mdp, $hashedPassword)) {
                // Reset login attempts on successful login
                $_SESSION['login_attempts'] = 0;
                $_SESSION['last_login_attempt'] = 0;

                $_SESSION["email"] = $Email;
                $_SESSION["Nom"] = $row['Nom'];
                $_SESSION["Prenom"] = $row['Prenom'];
                header("Location: /ECOMOBIL/index.php");
                echo "Bienvenue " . $_SESSION["Prenom"] . " " . $_SESSION["Nom"];
                exit();
            } else {
                $_SESSION['last_login_attempt'] = time();

                $_SESSION['login_attempts']++;

                echo "Mot de passe incorrect";
                require('View/Login.php');
            }
        } else {
            echo "Le mot de passe n'est pas défini pour cet utilisateur.";
        }
    } else {
        $_SESSION['last_login_attempt'] = time();

        $_SESSION['login_attempts']++;

        echo "L'email rentrée est inexistant";
    }
}





function ListAgence($agence) {
    $results = GetListAgence($agence);
    require('View/Reserver.php');
}

function ListVehiclesByAgency($agencyId) {
    $vehicles = GetVehiclesByAgency($agencyId);
    require('View/ChoixV.php');
}

function calculateMultiplier($tarifType) {
    $numericPart = substr($tarifType, -1);

    if (is_numeric($numericPart) && $numericPart >= 1 && $numericPart <= 3) {
        return (int)$numericPart;
    } else {
        return 1;
    }
}


?>