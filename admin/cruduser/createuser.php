<?php 
session_start(); 
if ($_SESSION['permission'] !== "admin") {
    header("Location: ../../index.php"); 
}

require "../../config/config.php";
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id_permissions = $dbh->query('SELECT * FROM permission');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $surname = $_POST['firstname'];
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];
    $id_permission = $_POST['id_permission'];
    
    $stmt = $dbh->prepare("INSERT INTO users (name, firstname, pseudo, password, id_permission) VALUES (:name, :firstname, :pseudo, :password, :id_permission)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':firstname', $surname);
    $stmt->bindParam(':pseudo', $pseudo);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':id_permission', $id_permission);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Données utilisateur insérées avec succès";
        header("Location: ../cruduser/createuser.php");
        exit();
    } else {
        $_SESSION['error'] = "Erreur";
    }
}
?>

<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <LINK href="../../style.css" rel="stylesheet" type="text/css">
    <title>création d'utilisateur</title>
  </head>
     <body>
        <h1>Création d'utilisateurs</h1>
        
        <?php if(isset($_SESSION['error'])): ?>
            <div class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form method="post" class="button">
            <input type="text" id="name" name="name" required placeholder='Nom'>     
            <input type="text" id="firstname" name="firstname" required placeholder="Prénom" > 
            <input type="text" id="pseudo" name="pseudo" required placeholder="Pseudo" >     
            <input type="password" id="password" name="password" required placeholder="Mot de passe"  minlength="8" maxlength="16" >    
        <div class ="box">
            <select aria-label="Default select example" name="id_permission" required>
                <?php foreach ($id_permissions as $id_permission): ?>
                    <option value="<?= $id_permission['id_permission']?>">fonction : <?= $id_permission['permission']?></option>
                <?php endforeach; ?>  
            </select>
        </div>
            <br>   
            <button value="envoyer">envoyer</button>
        </form>
    </body>
    <div class = deco>
        <button onclick="window.location.href = '../admin.php';">retour</button>
    </div>
</html>
