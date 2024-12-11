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

$bdd = new PDO('mysql:host=localhost;dbname=miavoudila', 'root', '');

echo 'Bonjour '. $nom . ', vous venez de vous connecter. Bienvenue dans notre site';

echo '<a href="http://localhost/MIAVOUDILA%20Ivann/formulaire%20php%20exo/formulaire%20php%20exo%20inscription.html">Allez vous inscrire ;)</a>';

