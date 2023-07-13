<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cinéma</title>
  <link rel="stylesheet" type="text/css" href="styles.css" />
  <?php include 'tab.php'; ?>
</head>

<body>
  <div class="card-container">
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

    <form method="POST" enctype="multipart/form-data">
      <label>Ajouter une valeur : </label>
      <input type="file" name="image">
      <input type="text" name="nom">
      <input type="date" name="date">
      <input type="text" name="réalisateur">
      <input type="number" name="durée">
      <input type="text" name="genre">
      <input type="text" name="synopsis">
      <input type="url" name="bandeannonce">
      <input type="submit" name="submitCreate" value="Ajouter">
      <br><br>
      <label>Modifier les valeurs : </label>
      <input type="number" name="updateId">
      <input type="file" name="updateImage">
      <input type="text" name="updateName">
      <input type="date" name="updateDate">
      <input type="text" name="updateReal">
      <input type="number" name="updateTime">
      <input type="text" name="updateGenre">
      <input type="text" name="updateSynopsis">
      <input type="url" name="updateURL">
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

    // Connexion à la BDD - Nouvelle instance de PDO

    $host = "localhost";
    $dbname = "cinema";
    $username = "root";
    $password = "";

    $dbConnect = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);


    // CRUD - CREATE READ UPDATE DELETE

    // CREATE


    if (isset($_POST['submit'])) {
      $nom = $dbConnect->quote($_POST['nom']);
      $realisateur = $dbConnect->quote($_POST['réalisateur']);
      $duree = $dbConnect->quote($_POST['durée']);
      $genre = $dbConnect->quote($_POST['genre']);
      $synopsis = $dbConnect->quote($_POST['synopsis']);
      $dateDeSortie = $dbConnect->quote($_POST['dateDeSortie']);
    }


    if (isset($_POST['submitCreate'])) {
      $image = $_FILES['image']['tmp_name'];
      $nom = $_POST['nom'];
      $date = $_POST['date'];
      $réalisateur = $_POST['réalisateur'];
      $durée = $_POST['durée'];
      $genre = $_POST['genre'];
      $synopsis = $_POST['synopsis'];
      $bandeannonce = $_POST['bandeannonce'];

      $sql = "INSERT INTO `films` (`image`, `nom`, `date`, `réalisateur`, `durée`, `genre`, `synopsis`, `bandeannonce`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = $dbConnect->prepare($sql);
      $stmt->execute([$image, $nom, $date, $réalisateur, $durée, $genre, $synopsis, $bandeannonce]);
    }


    // READ

    $sql = "SELECT * FROM `films`";
    $stmt = $dbConnect->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $value) {
      echo '<div class="card">
        <h3>' . $value['nom'] . '</h3>
        <img src="' . $value['image'] . '" alt="Affiche du film">
        <p><strong>Date:</strong> ' . $value['date'] . '</p>
        <p><strong>Réalisateur:</strong> ' . $value['réalisateur'] . '</p>
        <p><strong>Durée:</strong> ' . $value['durée'] . ' minutes</p>
        <p><strong>Genre:</strong> ' . $value['genre'] . '</p>
        <p>' . $value['synopsis'] . '</p>
        <div class="video-container"> ' . $value['bandeannonce'] . '</div>
        </div>';
    }
    ?>
  </div>

  <?php

  // UPDATE

  if (isset($_POST['updateSubmit'])) {
    $id = $_POST['updateId'];
    $nom = $_POST['updateName'];
    $date = $_POST['updateDate'];
    $réalisateur = $_POST['updateReal'];
    $durée = $_POST['updateTime'];
    $genre = $_POST['updateGenre'];
    $synopsis = $_POST['updateSynopsis'];

    $sql = "UPDATE `films` SET ";
    $updateColumns = array();

    if (!empty($nom)) {
      $updateColumns[] = "`nom`='$nom'";
    }
    if (!empty($date)) {
      $updateColumns[] = "`date`='$date'";
    }
    if (!empty($réalisateur)) {
      $updateColumns[] = "`réalisateur`='$réalisateur'";
    }
    if (!empty($durée)) {
      $updateColumns[] = "`durée`='$durée'";
    }
    if (!empty($genre)) {
      $updateColumns[] = "`genre`='$genre'";
    }
    if (!empty($synopsis)) {
      $updateColumns[] = "`synopsis`='$synopsis'";
    }

    $updateColumnsString = implode(", ", $updateColumns);
    $sql .= $updateColumnsString . " WHERE id = '$id';";

    $stmt = $dbConnect->prepare($sql);
    $stmt->execute();
  }


  // DELETE

  if (isset($_POST['deleteSubmit'])) {
    $id = $_POST['deleteId'];

    $sql = "DELETE FROM `films` WHERE id = ?";
    $stmt = $dbConnect->prepare($sql);
    $stmt->execute([$id]);
  }


  ?>
</body>

</html>