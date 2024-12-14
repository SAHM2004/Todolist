
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo list Application</title>
</head>
<body>
<div class="h1">
    <h1>Todo list Application</h1>
</div>
<form action="" method="POST">
    <div class="label">
        <input type="text" name="tafe" class="input">
        <button type="submit" class="btn">Ajouter</button>
    </div>
</form>

<style>
    .h1 {
        border: 2px solid;
        text-align: center;
        background-color: beige;
        width: 45%;
        border-radius: 12px;
        margin: 30px auto;
    }

    .label {
        border: 2px solid;
        margin: 30px auto;
        width: 50%;
        padding: 10px;
        border-radius: 5px;
        background-color: beige;
    }

    .btn {
        width: 11%;
        min-height: 5vh;
        margin-left: 2em;
        cursor: pointer;
    }

    .input {
        width: 81%;
        min-height: 5vh;
    }

    table {
        margin: 30px auto;
        width: 50%;
        padding: 10px;
        font-size: 1.5em;
    }

    td {
        margin-left: 2em;
    }

    a {
        text-decoration: none;
        color: red;
        margin-left: 2em;
        margin-right: 2em;
    }
</style>

<?php
$serveur = "localhost";
$login = "root";
$pass = "";

try {
    $connexion = new PDO("mysql:host=$serveur;dbname=todolist", $login, $pass);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Assainir la tâche entrée par l'utilisateur
    if (isset($_POST["tafe"]) && !empty($_POST["tafe"])) {
        $tache = htmlspecialchars(trim($_POST["tafe"]));

        // Insertion dans la base de données
        $requete = $connexion->prepare("INSERT INTO tâche (task) VALUES (:tache)");
        $requete->bindParam(':tache', $tache);
        $requete->execute();
    }

    // Sélectionner les tâches existantes
    $requete = $connexion->prepare("SELECT * FROM tâche");
    $requete->execute();
    $users = $requete->fetchAll(PDO::FETCH_ASSOC);

    // Suppression d'une tâche
    if (isset($_GET['del_task'])) {
        $id = $_GET['del_task'];
        $requete = $connexion->prepare("DELETE FROM tâche WHERE id = :id");
        $requete->bindParam(':id', $id, PDO::PARAM_INT);
        $requete->execute();
    }

} catch (PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}
?>

<table border="1">
    <tr>
        <th>N°</th>
        <th>Tâche</th>
        <th>Supprimer</th>
    </tr>
    <?php $i = 1; foreach ($users as $t): ?>
    <tr>
        <td><?php echo $i; ?> </td>
        <td><?php echo htmlspecialchars($t['task']); ?> </td>
        <td>
            <a href="todolist1.php?del_task=<?php echo $t['id']; ?>">X</a>
        </td>
    </tr>
    <?php $i++; ?>
    <?php endforeach; ?>
</table>
</body>
</html>
