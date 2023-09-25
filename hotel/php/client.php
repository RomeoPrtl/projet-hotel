<?php 
//ici on va créer notre classe client avec les différentes méthodes
class Client {
    public $nom;
    public $email;

    public function SePresenter(){
        echo "Bonjour " . $this->nom . ' ' . "voici mon email " . $this->email;
    }
}