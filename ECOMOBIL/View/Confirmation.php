<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['email'])) {
    header("Location: Login.php");
    exit();
}

if (!isset($_SESSION['reservation'])) {
    header("Location: /ECOMOBIL/View/Reserver.php");
    exit();
}


$reservationData = $_SESSION['reservation'];
$participantData = $_SESSION['participant'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation Page</title>
    <link rel="stylesheet" type="text/css" href="/ECOMOBIL/assets/style.css">
</head>

<body>

    <div class="navbar">
        <span><?php echo ucfirst($_SESSION["Prenom"]); ?></span>
        <a href="/ECOMOBIL/main.php">Accueil</a>
    </div>




    <h2>Confirmation Page</h2>

    <div id="grid">

        <div>
            <h3>Reservation Details for <?php echo ucfirst($_SESSION["Prenom"]); ?></h3>
        <table>
            <tr>
                <td><strong>Prenom :</strong></td>
                <td><?php echo ucfirst($_SESSION["Prenom"]); ?></td>
            </tr>
            <tr>
                <td><strong>Nom :</strong></td>
                <td><?php echo ucfirst($_SESSION["Nom"]); ?></td>
            </tr>
            <tr>
                <td><strong>Agence :</strong></td>
                <td><?php echo $reservationData['agence']; ?></td>
            </tr>
            <tr>
                <td><strong>Date :</strong></td>
                <td><?php echo $reservationData['date']; ?></td>
            </tr>
            <tr>
                <td><strong>Heure :</strong></td>
                <td><?php echo $reservationData['heure']; ?></td>
            </tr>
            <tr>
                <td><strong>Nombre de participants :</strong></td>
                <td><?php echo $reservationData['nbParticipants']; ?></td>
            </tr>
            <tr>
                <td><strong>Tarif Type :</strong></td>
                <td><?php echo $reservationData['tarifType']; ?></td>
            </tr>
            <tr>
                <td><strong>veicule id :</strong></td>
                <td><?php echo $_SESSION['IdTypeVehicule']; ?></td>
            </tr>
            <tr>
                <td><strong>veicule tarif :</strong></td>
                <td><?php echo $_SESSION['selectedTarif']; ?> €</td>
            </tr>
        </table>
    </div>
    <div id="table2">
        <h3>Participant Information</h3>
        <table>
            <tr>
                <td><strong>Nom :</strong></td>
                <td><?php echo ucfirst($participantData["name"]); ?></td>
            </tr>
            <tr>
                <td><strong>Prenom :</strong></td>
                <td><?php echo ucfirst($participantData["surname"]); ?></td>
            </tr>
            <tr>
                <td><strong>Véhicule :</strong></td>
                <td><?php echo ($participantData['selectedVehicleLibelle']); ?></td>
            </tr>
            <tr>
                <td><strong>Prix :</strong></td>
                <td><?php echo ($participantData['selectedTarif']); ?> €</td>
            </tr>
        </table>
    </div>
        <form action="/ECOMOBIL/index.php?action=inserer" method="post">
            <input type="hidden" name="confirmationAction" value="confirmer">
            <input type="submit" value="Confirmer">
        </form>
    </div>


</body>

</html>
