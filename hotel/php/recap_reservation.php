<?php
if (isset($_GET['nom'])){
    $nom = $_GET["nom"];
    $email = $_GET["email"];
    $date_deb_reservation = $_GET["date_deb_reservation"];
    $date_fin_reservation = $_GET["date_fin_reservation"];
    $hotel = $_GET["hotel"];
    $chambre = $_GET["chambre"];
}else{
    echo("Une erreur est survenue");
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel.io / Récapitulatif</title>
    <link rel="stylesheet" href="../css/recap_reservation.css">
</head>
<body>
    <header>
        <h1>Hôtel.io</h1>
        <nav>
            <ul>
                <li><a href="../index.html">Accueil</a></li>
                <li><a href="../html/hotels.html">Nos Hôtels</a></li>
                <li><a href="../html/reservation.html">Réserver une chambre</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Votre réservation a bien été enregistrée.</h1>
        <table>
            <tr>
                <th>Nom de la réservation</th>
                <th>Contact</th>
                <th>Date arrivée</th>
                <th>Date départ</th>
                <th>Nom de l'hôtel</th>
                <th>Numéro de chambre</th>
            </tr>
            <tr>
                <td><?php echo $nom; ?></td>
                <td><?php echo $email; ?></td>
                <td><?php echo $date_deb_reservation; ?></td>
                <td><?php echo $date_fin_reservation; ?></td>
                <td><?php echo $hotel; ?></td>
                <td><?php echo $chambre; ?></td>
            </tr>
        </table>
    </main>
    
</body>
</html>