<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../Model/modele.php';
$previousReservationData = isset($_SESSION['reservation']) ? $_SESSION['reservation'] : [];

if (!isset($_SESSION['email'])) {
    header("Location: Login.php");
    exit();
}



$agencyId = isset($_SESSION['reservation']['agence']) ? $_SESSION['reservation']['agence'] : null;
$vehicles = GetVehiclesByAgency($agencyId);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Selection</title>
    <link rel="stylesheet" type="text/css" href="/ECOMOBIL/assets/style.css">
</head>

<body>
    <div class="navbar">
        <span><?php echo ucfirst($_SESSION["Prenom"]); ?></span>
        <a href="/ECOMOBIL/index.php">Acceuil</a>
    </div>

    <p><a href="/ECOMOBIL/View/Reserver.php"><img src="/ECOMOBIL/assets/IMG/back.png" alt="fleche arriere" style="width: 70px; height: 70px;"></a></p> <br/>

    <h2>Sélection véhicule pour <?php echo ucfirst($_SESSION["Prenom"]); ?></h2>
    <ul>
        <div class="grid-container">
            <?php foreach ($vehicles as $vehicle): ?>
                <?php
                $typeVehiculeId = $vehicle['IdTypeVehicule'];
                $tarifType = $_SESSION['reservation']['tarifType'];
                $vehiclePrices = GetPrixVehicules($typeVehiculeId, $tarifType);
                ?>

                <form action="/ECOMOBIL/index.php?action=SelectVehicle" method="POST" class="vehicle-selection-form">
                    <input type="hidden" name="selectedVehicleId" value="<?php echo $vehicle['IdVehicule']; ?>">
                    <div class="vehicle-box">
                        <img src="<?php echo $vehicle['TypeLabel']; ?>" alt="<?php echo $vehicle['Libelle']; ?>" class="vehicle-img">
                        <p><?php echo $vehicle['Libelle']; ?></p>
                        <p><?php echo $vehicle['Disponibilite']; ?></p>

                        <?php
                        $selectedTariffType = $_SESSION['reservation']['tarifType'];
                        $typeVehiculeId = $vehicle['IdTypeVehicule'];
                        $vehiclePrices = GetPrixVehicules($typeVehiculeId);
                        
                        echo "<p>{$selectedTariffType}: {$vehiclePrices[$selectedTariffType]} €</p>";
                        echo "<input type=\"hidden\" name=\"selectedTarif\" value=\"{$vehiclePrices[$selectedTariffType]}\">";

                        ?>
                        
                        <input type="submit" name="selectVehicle" value="Select" id="selectVehicleBtn">
                    </div>
                </form>
            <?php endforeach; ?>
        </div>
    </ul>
</body>

</html>
