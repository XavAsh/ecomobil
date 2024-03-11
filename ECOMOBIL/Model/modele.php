<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
function dbconnect()
{
    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=ecomobil', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        return $bdd;
    }
    catch (Exception $e)
    {
        die('Erreur de connection à la base : ' . $e->getMessage());
    }
}

function InsertClient($Prenom, $Nom, $Email, $Mdp) {
    $bdd = dbconnect();
    $insert_query = $bdd->prepare("INSERT INTO client (Prenom, Nom, Email, MDP) VALUES (:Prenom, :Nom, :Email, :Mdp)");
    if ($insert_query->execute(array(
        'Prenom' => $Prenom,
        'Nom' => $Nom,
        'Email' => $Email,
        'Mdp' => $Mdp,
    ))) {
        return true; // Insertion successful
    } else {
        return false; // Insertion failed
    }
}

function RecupClient($Email) {
    $bdd = dbconnect();
    $select_query = $bdd->prepare("SELECT * FROM client WHERE Email = :Email");
    $select_query->execute(array('Email' => $Email));
    return $select_query;
}

function CheckEmailExists($Email) {
    $bdd = dbconnect();
    $select_query = $bdd->prepare("SELECT COUNT(*) FROM client WHERE Email = :Email");
    $select_query->execute(array('Email' => $Email));
    $result = $select_query->fetchColumn();

    return $result;
}

function GetListAgence()
{
    $bdd = dbconnect();
    $sql = "SELECT NomAgence, IdAgence FROM agence";
    $result = $bdd->query($sql);

    $agences = $result->fetchAll(PDO::FETCH_ASSOC);
    return $agences;
}

function GetListTarifs()
{
    $bdd = dbconnect();
    $sql = "SHOW COLUMNS FROM Tarifs";
    $result = $bdd->query($sql);

    $columns = $result->fetchAll(PDO::FETCH_COLUMN);
    $filteredColumns = array_filter($columns, function ($column) {
        return $column !== 'IdTarifs';
    });
    return $filteredColumns;
}


function StoreReservationInSession($reservationData) {
    $_SESSION['reservation'] = $reservationData;
}
function StoreVehicleInSession($vehicleId, $selectedTarif){
    $_SESSION['IdTypeVehicule'] = $vehicleId;
    $_SESSION['selectedTarif'] = $selectedTarif;
}

function StoreVehicleParticipantInSession($vehicleId, $selectedTarif){
    $_SESSION['IdTypeVehicule'] = $vehicleId;
    $_SESSION['selectedTarif'] = $selectedTarif;
}

function GetVehiclesByAgency($agencyId)
{
    try {
        $bdd = dbconnect();
        $query = "SELECT V.IdVehicule, V.Disponibilite, TV.IdTypeVehicule, TV.Libelle, TV.Image AS TypeLabel FROM Vehicule V
                  JOIN TypeVehicule TV ON V.IdTypeVehicule = TV.IdTypeVehicule
                  WHERE V.IdAgence = :agencyId";
        $stmt = $bdd->prepare($query);
        $stmt->bindParam(':agencyId', $agencyId, PDO::PARAM_INT);
        $stmt->execute();
        $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $vehicles;
    } catch (PDOException $e) {
        die('Database Error: ' . $e->getMessage());
    }
}


function GetPrixVehicules($typeVehiculeId)
{
    $bdd = dbconnect();
    $sql = "SELECT T.* FROM Tarifs T
            JOIN TypeVehicule TV ON T.IdTarifs = TV.IdTarifs
            WHERE TV.IdTypeVehicule = :typeVehiculeId";
    $stmt = $bdd->prepare($sql);
    $stmt->bindParam(':typeVehiculeId', $typeVehiculeId, PDO::PARAM_INT);
    $stmt->execute();

    $prices = $stmt->fetch(PDO::FETCH_ASSOC);

    return $prices;
}

function Insertion($sessionData) {
    $bdd = dbconnect();

    $reservationData = $sessionData['reservation'];
    $participantData = $sessionData['participant'];

    $bdd->beginTransaction();

    try {
        // Insert into reservation table
        $stmtReservation = $bdd->prepare("INSERT INTO reservation (DateReservation, HeureReservation, TypeReservation, NbPersonne, IdParticipant, IdClient) VALUES (:dateReservation, :heureReservation, :typeReservation, :nbPersonne, :idParticipant, :idClient)");

        $stmtReservation->bindParam(':dateReservation', $reservationData['date']);
        $stmtReservation->bindParam(':heureReservation', $reservationData['heure']);
        $stmtReservation->bindParam(':typeReservation', $reservationData['tarifType']);
        $stmtReservation->bindParam(':nbPersonne', $reservationData['nbParticipants']);
        $stmtReservation->bindParam(':idParticipant', $participantData['idParticipant']);
        $stmtReservation->bindParam(':idClient', $reservationData['idClient']);

        $stmtReservation->execute();

        // Get the last inserted reservation ID
        $reservationId = $bdd->lastInsertId();

        // Insert into participant table
        $stmtParticipant = $bdd->prepare("INSERT INTO Participant (Nom, Prenom, IdReservation, IdVéhicule) VALUES (:nom, :prenom, :idReservation, :idVehicule)");

        $stmtParticipant->bindParam(':nom', $participantData['name']);
        $stmtParticipant->bindParam(':prenom', $participantData['surname']);
        $stmtParticipant->bindParam(':idReservation', $reservationId);
        $stmtParticipant->bindParam(':idVehicule', $participantData['idVehicule']);

        $stmtParticipant->execute();

        // Commit the transaction
        $bdd->commit();

        // For illustration purposes, you can print a success message
        echo "Reservation and Participant information have been inserted successfully!";
    } catch (PDOException $e) {
        // Rollback the transaction in case of an error
        $bdd->rollBack();

        // Handle any errors that occurred during the insertion
        echo "Error: " . $e->getMessage();
    }
}





?>
