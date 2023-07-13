<!-- 
1 créer un lien / une connexion entre le code PHP et la BDD
    Avoir une BDD
    Avoir une Table
    Utiliser PDO

2 faire la requete SQL 
    Ecrire la requete SQL -> on peut s'aider du panneau PHPMyAdmin

3 préparer la requete

4 executer la requete 
-->

<form method="POST">
    <label>Ajouter une valeur : </label>
    <input type="text" name="nom">
    <input type="date" name="date">
    <input type="text" name="réalisateur">
    <input type="number" name="durée">
    <input type="text" name="genre">
    <input type="text" name="synopsis">
    <input type="submit" name="submitCreate" value="Ajouter">
    <br><br>
    <label>Modifier les valeurs : </label>
    <input type="number" name="updateId">
    <input type="text" name="updateName">
    <input type="date" name="updateDate">
    <input type="text" name="updateReal">
    <input type="number" name="updateTime">
    <input type="text" name="updateGenre">
    <input type="text" name="updateSynopsis">
    <input type="submit" name="updateSubmit" value="UPDATE">
    <br><br>
    <label>Supprimer des valeurs</label>
    <input type="number" name="deleteId">
    <input type="submit" name="deleteSubmit" value="Supprimer">
</form>

<!-- 
    Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum voluptatum neque molestiae voluptate tempore! Quae quasi recusandae dicta minus, voluptate maxime animi tenetur, sapiente odio debitis earum, ipsum pariatur eos. 
-->

<?php

// Connexion à la BDD - Nouvel instance de PDO

$host = "localhost";
$dbname = "cinema";
$username = "root";
$password = "";

$dbConnect = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);


// CRUD - CREATE READ UPDATE DELETE

// CREATE

if (isset($_POST['submitCreate'])) {
    $nom = $_POST['nom'];
    $date = $_POST['date'];
    $réalisateur = $_POST['réalisateur'];
    $durée = $_POST['durée'];
    $genre = $_POST['genre'];
    $synopsis = $_POST['synopsis'];


    $sql = "INSERT INTO `films`(`nom`, `date`, `réalisateur`, `durée`, `genre`, `synopsis`) VALUES ('$nom','$date','$réalisateur','$durée','$genre','$synopsis')";
    $stmt = $dbConnect->prepare($sql);
    $stmt->execute();
}


// READ

$sql = "SELECT * FROM `films`";
$stmt = $dbConnect->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($result as $key) {
    foreach ($key as $value) {
        echo $value . '<br>';
    }
    echo '<br>';
}


// UPDATE

if (isset($_POST['updateSubmit'])) {
    $id = $_POST['updateId'];
    $nom = $_POST['updateName'];
    $date = $_POST['updateDate'];
    $réalisateur = $_POST['updateReal'];
    $durée = $_POST['updateTime'];
    $genre = $_POST['updateGenre'];
    $synopsis = $_POST['updateSynopsis'];

    $sql = "UPDATE `films` SET `nom`='$nom',`date`='$date',`réalisateur`='$réalisateur',`durée`='$durée',`genre`='$genre',`synopsis`='$synopsis' WHERE id = '$id';";
    $stmt = $dbConnect->prepare($sql);
    $stmt->execute();
}


// DELETE

if (isset($_POST['deleteSubmit'])) {
    $id = $_POST['deleteId'];

    $sql = "DELETE FROM `films` WHERE id = $id";
    $stmt = $dbConnect->prepare($sql);
    $stmt->execute();
}
