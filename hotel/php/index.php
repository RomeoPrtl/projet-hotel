<?php
include_once('../php/client.php');
include_once('../php/booking.php');
include_once('../php/connexion.php');
//ici on va récupérer nos données, puis créer des instances à partir de ces données, puis les enregistrer en bdd
$date = date("Y-m-d");
if (isset($_GET['submit'])){
    $nom = $_GET["nom"];
    $email = $_GET["email"];
    $date_deb_reservation = $_GET["date-deb"];
    $date_fin_reservation = $_GET["date-fin"];
    $hotel = $_GET["hotel"];
    echo $nom;
    echo $email;
    echo $date_deb_reservation;
    echo $date_fin_reservation;
    echo $hotel;
}else{
    echo("Une erreur est survenue");
}

//on créer un nouvel objet client
$client = new Client();
$client -> nom = $nom;
$client -> email = $email;
$client->SePresenter();

//on créer un nouvel objet booking
$booking = new Booking();
$booking -> date_deb_reservation = $date_deb_reservation;
$booking -> date_fin_reservation = $date_fin_reservation;
$booking -> date_reservation = $date;

//on ajoute a la bdd
try {
    $requete_client = $co->prepare("INSERT INTO clients(nom_client, email_client) VALUES (:nom , :email)");
    $requete_client->bindParam(':nom', $client->nom);
    $requete_client->bindParam(':email', $client->email);
    $requete_client->execute();
    echo "Données insérées avec succès !";
    $idClient = $co -> lastInsertId();
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
//requete SQL pour récupérer l'id de l'hotel
$requete_id_hotel = $co -> prepare("SELECT id_hotel FROM hotels WHERE nom_hotel = :nom_hotel");
$requete_id_hotel-> execute([':nom_hotel' => $hotel]);
$resultat = $requete_id_hotel->fetch();
$idHotel = $resultat['id_hotel'];
// Requête chambre
$requeteChambreDisponible = $co->prepare("
    SELECT chambres.id_chambre
    FROM chambres
    LEFT JOIN bookings ON chambres.id_chambre = bookings.id_chambre
    LEFT JOIN hotels_chambres ON chambres.id_chambre = hotels_chambres.id_chambre
    LEFT JOIN hotels ON hotels_chambres.id_hotel = hotels.id_hotel
    WHERE (bookings.id_chambre IS NULL OR bookings.date_fin_reservation < ? OR bookings.date_deb_reservation > ?)
      AND hotels.nom_hotel = ?
    ORDER BY chambres.id_chambre
    LIMIT 1
");

$requeteChambreDisponible->execute([$date_deb_reservation, $date_fin_reservation, $hotel]);

$resultat = $requeteChambreDisponible->fetch();
$idChambre = $resultat['id_chambre'];




try {
    $requete_booking = $co->prepare("INSERT INTO bookings(date_deb_reservation, date_fin_reservation, date_creation_reservation, id_hotel, id_client, id_chambre) VALUES (:date_deb_reservation , :date_fin_reservation , :date_creation_reservation , :id_hotel , :id_client , :id_chambre)");
    $requete_booking->bindParam(':date_deb_reservation', $booking->date_deb_reservation);
    $requete_booking->bindParam(':date_fin_reservation', $booking->date_fin_reservation);
    $requete_booking->bindParam(':date_creation_reservation', $booking->date_reservation);
    $requete_booking->bindParam(':id_hotel', $idHotel);
    $requete_booking->bindParam(':id_client', $idClient);
    $requete_booking->bindParam(':id_chambre', $idChambre);
    $requete_booking->execute();
    echo "Données insérées avec succès !";
    header("Location: ../php/recap_reservation.php?nom=$nom&email=$email&date_deb_reservation=$date_deb_reservation&date_fin_reservation=$date_fin_reservation&hotel=$hotel&chambre=$idChambre");
    exit();
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
