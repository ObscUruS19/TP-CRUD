<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $mdp = $_POST["mdp"];
}


$formulaire = array(
    'Nom' => $nom,
    'Password' => $mdp,
);

foreach ($formulaire as $key => $element) {
    echo $key . " : " . $element . '<br>';
}

$bdd = new PDO('mysql:host=localhost;dbname=crud', 'root', '');

echo 'Bonjour '. $nom . ', vous venez de vous connecter. Bienvenue dans notre site';

echo '<a href="formulaire%20php%20exo%20inscription.html"><br>Allez vous inscrire ;)</a>';

