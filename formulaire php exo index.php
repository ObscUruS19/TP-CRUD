<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $mdp = $_POST["mdp"];
}

echo 'Bonjour '. $_POST['nom'];
