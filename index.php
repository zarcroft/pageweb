<?php

require "config/config.php";

if(isset($_POST['submit'])) {
    // récupération des informations d'identification
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];

    // vérification des informations d'identification
     $query = "SELECT users.*, permission.permission FROM users
              JOIN permission ON users.id_permission = permission.id_permission
              WHERE pseudo = ? AND password = ?";
    $stmt = $dbh->prepare($query);
    $stmt->execute([$pseudo, $password]);

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $user_role = $row['permission'];
        
        // démarrage de la session et stockage des informations d'utilisateur
        session_start();
        $_SESSION['pseudo'] = $pseudo;
        $_SESSION['permission'] = $user_role;
        $_SESSION['name'] = $name;
        $_SESSION['firstname'] = $firstname;
        setcookie('pseudo', urlencode($pseudo), time() + 3600, '/');
       setcookie('pseudo', urlencode($pseudo), time() + 3600, '/');
        setcookie('permission', urlencode($user_role), time() + 3600, '/');

        if ($user_role == 'admin') { 
            header("Location: http://localhost:3000/index.js");
            exit;
        }
      else if ($user_role == 'user'){
        header("Location: http://localhost:3000/index.js");
        exit;
      }
      else {
        echo "nom d'utilisateur ou mot de passe incorrect";
      }
    }
      else {
        echo "nom d'utilisateur ou mot de passe incorrect";
      }
?>

<html>
<LINK href="style.css" rel="stylesheet" type="text/css">

<body>

<form class = "form" method="post">

Connexion

    <input type="text" name="pseudo" placeholder="Nom d'utilisateur" required>

    <input type="password" name="password" placeholder="Mot de passe" required>

        <br>

    <button type="submit" name="submit">se connecter</button>

</div>

</form>

</body>

</html>
