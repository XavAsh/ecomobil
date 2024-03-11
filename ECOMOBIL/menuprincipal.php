<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Accueil ECOMOBIL</title>
      <link rel="stylesheet" type="text/css" href="/ECOMOBIL/assets/style.css">
  </head>

  <body>

  <div class="navbar">
      <a href="View/AddClient.php">Créer compte</a>
      <a href="View/Login.php">Login</a>
      <a href="<?php echo isset($_SESSION['email']) ? 'View/Reserver.php' : 'View/Login.php'; ?>">Réserver</a>
  </div>
  <h1>Bienvenu chez ECOMOBIL</h1>
  <h2>Votre plateforme de reservation de vehicule</h2>
</body>
</html>