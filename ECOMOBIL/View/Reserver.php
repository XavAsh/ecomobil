<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
ob_start();

require_once __DIR__ . '/../Model/modele.php';

$previousReservationData = isset($_SESSION['reservation']) ? $_SESSION['reservation'] : [];

if (!isset($_SESSION['email'])) {
    header("Location: Login.php");
    exit();
}

$agences = GetListAgence();
$tarifColumns  = GetListTarifs();
$selectedAgencyId = isset($_POST['agencyId']) ? $_POST['agencyId'] : null;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Page</title>
    <link rel="stylesheet" type="text/css" href="/ECOMOBIL/assets/style.css">
</head>

<body>
<div class="navbar">
    <span><?php echo ucfirst($_SESSION["Prenom"]); ?></span>
    <a href="/ECOMOBIL/index.php">Acceuil</a>
</div>

<p><a href="/ECOMOBIL/index.php"><img src="/ECOMOBIL/assets/IMG/back.png" alt="fleche arriere" style="width: 70px; height: 70px;"></a></p> <br/>

<form action="/ECOMOBIL/index.php?action=GetListAgence" method="POST">

    <h2>Reservation</h2>

    <label for="agence">Nom de l'agence :</label>
    <select id="agence" name="agencyId" required>
        <option value="">Sélectionnez une agence</option>
        <?php
        foreach ($agences as $agence) {
            $nomAgence = $agence['NomAgence'];
            $idAgence = $agence['IdAgence'];
            $selected = ($nomAgence == $previousReservationData['agence']) ? 'selected' : '';
            echo "<option value='$idAgence' $selected>$nomAgence</option>";
        }
        ?>
    </select>

    <label for="Date">Date</label>
    <input type="date" id="Date" name="Date" required
           min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>"
           value="<?php echo $previousReservationData['date'] ?? ''; ?>">

    <label for="Heure">Heure</label>
    <input type="time" id="Heure" name="Heure" required value="<?php echo $previousReservationData['heure'] ?? ''; ?>">

    <label for="NbParticipants">Nombre de participants</label>
    <input type="number" id="NbParticipants" name="NbParticipants" required min="1" max="5"  value="<?php echo $previousReservationData['nbParticipants'] ?? ''; ?>">

    <label for="tarifType">Tarif Type :</label>
<select id="tarifType" name="tarifType" required>
    <option value="">Sélectionnez une Durée</option>
    <?php foreach ($tarifColumns as $column): ?>
        <option value="<?php echo $column; ?>" <?php echo (isset($previousReservationData['idTarifs']) && $column == $previousReservationData['idTarifs'] ? 'selected' : ''); ?>><?php echo $column; ?></option>
        ob_end_clean();
    <?php endforeach; ?>
</select>


    <input type="submit" value="Choix du véhicule pour <?php echo ucfirst($_SESSION["Prenom"]); ?>"><br/><br/>

</form>
</body>

</html>
