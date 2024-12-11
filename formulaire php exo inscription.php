<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $mdp = $_POST["mdp"];
    $age = $_POST["age"];
    $pays = $_POST["pays"];
    $metier = $_POST["metier"];
}

$formulaire = array(
    'Nom' => $nom,
    'Prenom' => $prenom,
    'Email' => $email,
    'Password' => $mdp,
    'Age' => $age,
    'Pays' => $pays,
    'Metier' => $metier
);

foreach ($formulaire as $key => $element) {
    echo $key . " : " . $element . '<br>';
}

$bdd = new PDO('mysql:host=localhost;dbname=CRUD', 'root', '');

$req = $bdd->prepare('INSERT INTO personne(nom,prenom,email,Passord,Age,Pays,Metier) VALUES(:nom,:prenom)');
$req->execute(array(
    'Nom' => $nom,'Prenom' => $prenom,'Email' => $email, 'Password' => $mdp, 'Age' => $age,'Pays' => $pays, 'Metier' => $metier
));

echo 'Bonjour '. $nom . ', vous venez de vous inscrire. Bienvenue dans notre site';

echo '<a href="http://localhost/MIAVOUDILA%20Ivann/formulaire%20php%20exo/formulaire%20php%20exo%20connexion.html">Allez vous connecter ;)</a>';
