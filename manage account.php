<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer Mon Compte</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #007bff;
            color: #fff;
        }
        .btn {
            padding: 10px 15px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #a71d2a;
        }
        form {
            display: inline;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Gérer Mon Compte</h1>

    <?php
    session_start();
    require 'db.php';

    // Vérifie si l'utilisateur est connecté
    if (!isset($_SESSION['user'])) {
        echo "<p>Veuillez vous connecter pour accéder à cette page.</p>";
        echo "<a href='formulaire%20php%20exo%20connexion.html' class='btn'>Connexion</a>";
        exit();
    }

    // Récupérer les informations de l'utilisateur connecté
    $user_id = $_SESSION['user']['id'];
    $stmt = $pdo->prepare("SELECT membres.*, metiers.nom_metier FROM membres JOIN metiers ON membres.metier_id = metiers.id WHERE membres.id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    if (!$user) {
        echo "<p>Utilisateur introuvable.</p>";
        exit();
    }

    ?>

    <!-- Affichage des informations sous forme de tableau -->
    <table>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Âge</th>
            <th>Métier</th>
            <th>Actions</th>
        </tr>
        <tr>
            <td><?php echo htmlspecialchars($user['nom']); ?></td>
            <td><?php echo htmlspecialchars($user['prenom']); ?></td>
            <td><?php echo htmlspecialchars($user['email']); ?></td>
            <td><?php echo htmlspecialchars($user['age']); ?></td>
            <td><?php echo htmlspecialchars($user['nom_metier']); ?></td>
            <td>
                <form action="manage_account.php" method="post" style="display:inline;">
                    <input type="hidden" name="action" value="edit">
                    <button type="submit" class="btn">Modifier</button>
                </form>
                <form action="manage_account.php" method="post" style="display:inline;">
                    <input type="hidden" name="action" value="delete">
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </td>
        </tr>
    </table>

    <?php
    // Gestion des actions Modifier et Supprimer
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'];

        if ($action === 'edit') {
            // Formulaire de modification
            echo "<h2>Modifier Mes Informations</h2>";
            echo "<form action='manage_account.php' method='post'>";
            echo "<label>Nom: <input type='text' name='nom' value='" . htmlspecialchars($user['nom']) . "'></label><br><br>";
            echo "<label>Prénom: <input type='text' name='prenom' value='" . htmlspecialchars($user['prenom']) . "'></label><br><br>";
            echo "<label>Email: <input type='email' name='email' value='" . htmlspecialchars($user['email']) . "'></label><br><br>";
            echo "<label>Âge: <input type='number' name='age' value='" . htmlspecialchars($user['age']) . "'></label><br><br>";

            // Liste déroulante pour métiers
            $stmt = $pdo->query("SELECT * FROM metiers");
            $metiers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "<label>Métier: <select name='metier'>";
            foreach ($metiers as $metier) {
                $selected = ($user['metier_id'] == $metier['id']) ? 'selected' : '';
                echo "<option value='" . $metier['id'] . "' $selected>" . htmlspecialchars($metier['nom_metier']) . "</option>";
            }
            echo "</select></label><br><br>";

            echo "<input type='hidden' name='action' value='save'>";
            echo "<button type='submit' class='btn'>Enregistrer</button>";
            echo "</form>";

        } elseif ($action === 'delete') {
            // Supprimer l'utilisateur
            $stmt = $pdo->prepare("DELETE FROM membres WHERE id = ?");
            $stmt->execute([$user_id]);
            session_destroy();
            echo "<p>Compte supprimé avec succès.</p>";
            echo "<a href='formulaire%20php%20exo%20inscription.html' class='btn'>Retour à l'inscription</a>";
            exit();

        } elseif ($action === 'save') {
            // Sauvegarder les modifications
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $age = $_POST['age'];
            $metier_id = $_POST['metier'];

            $stmt = $pdo->prepare("UPDATE membres SET nom = ?, prenom = ?, email = ?, age = ?, metier_id = ? WHERE id = ?");
            $stmt->execute([$nom, $prenom, $email, $age, $metier_id, $user_id]);
            echo "<p>Informations mises à jour avec succès.</p>";
            header("Refresh:0"); // Recharge la page
        }
    }
    ?>

</div>
</body>
</html>