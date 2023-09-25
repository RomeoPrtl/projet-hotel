<?php 
//on va créer notre classe booking et les méthodes
class Booking {
    public $date_deb_reservation;
    public $date_fin_reservation;
    public $date_reservation;

    public function RecupererDateReservation() {
        $this -> date_reservation = date("Y-m-d");
    }
}