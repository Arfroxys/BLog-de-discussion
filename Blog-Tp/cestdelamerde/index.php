<?php 
    session_start();
    $pdo = new PDO('mysql:host=database;dbname=data', 'root', 'motdepasse'); 
    #$query = $pdo->query("SHOW TABLES");
    #var_dump($query->fetchAll());   
    if(isset($_POST['Inscription'])){
        if(!empty($_POST['pseudo']) AND !empty($_POST['Password'])){
            $pseudo = htmlspecialchars($_POST['pseudo']);
            $Password = sha1($_POST['Password']);
            $insertUser = $pdo->prepare('INSERT INTO users(Name_User, Pwd_User) Values(?, ?)');
            $insertUser->execute(array($pseudo, $Password));

            $recupUser = $pdo->prepare('SELECT * FROM users WHERE Name_User = ? And Pwd_User = ?');
            $recupUser->execute(array($pseudo, $Password));
            if($recupUser->rowCount() > 0){
                $_SESSION['Name_User'] = $pseudo;
                $_SESSION['Pwd_User'] = $Password;
                $_SESSION['Id'] = $recupUser->fetch()['Id'];
                echo "Vous vous êtes inscrits.";
            }
        }
        else{
            echo "Veuillez compléter tous les champs...";
        }
    }
    if(isset($_POST['Connexcion'])){
        if(!empty($_POST['pseudo']) AND !empty($_POST['Password'])){
            $pseudo = htmlspecialchars($_POST['pseudo']);
            $Password = sha1($_POST['Password']);

            $recupUser = $pdo->prepare('SELECT * FROM users WHERE Name_User = ? And Pwd_User = ?');
            $recupUser->execute(array($pseudo, $Password));
            if($recupUser->rowCount() > 0){
                $_SESSION['Name_User'] = $pseudo;
                $_SESSION['Pwd_User'] = $Password;
                $_SESSION['Id'] = $recupUser->fetch()['Id'];
                header('Location: Post.php');
            }else{
                echo "Votre mot de passe ou votre pseudo est incorrect.";
            }
        }
        else{
            echo "Veuillez compléter tous les champs...";
        }
    }
?>
<!doctype   html>
<html lang="fr">
    <head>
        <meta charset="utf8">
        <title>La carte de kiwi</title>
        <link rel="stylesheet" href="Utile.css">
    </head>
    <body>
    <h1 class="H1">Bienvenue A la Carte de Kiwi</h1>
        <form method="POST" action="" align="center">
            <h2>Inscription</h2>
            <input type="text" name="pseudo" placeholder="Your Name" autocomplete="off">
            <br/>
            <input type="password" name="Password" placeholder="password" autocomplete="off">
            <br><br>
            <input type="submit" name="Inscription" value="Inscription">
            <br><br>
        </form>
        <form method="POST" action="" align="center">
            <h2>Connexcion</h2>
            <input type="text" name="pseudo" placeholder="Your Name" autocomplete="off">
            <br/>
            <input type="password" name="Password" placeholder="password" autocomplete="off">
            <br><br>
            <input type="submit" name="Connexcion" value="Connexcion">
            <br><br>
        </form>
    </body>
</html>