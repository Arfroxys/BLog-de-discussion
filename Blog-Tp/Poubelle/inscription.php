<?php 
    session_start();
    $pdo = new PDO('mysql:host=database;dbname=data', 'root', 'motdepasse'); 
    #$query = $pdo->query("SHOW TABLES");
    #var_dump($query->fetchAll());   
    if(isset($_POST['envoie'])){
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
                header('Location: Connexion.php')
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
        <h1 class="H1">Inscription</h1>
        <form method="POST" action="" align="center">
            <input type="text" name="pseudo" autocomplete="off">
            <br/>
            <input type="password" name="Password" autocomplete="off">
            
            <br/><br/>

            <input type="submit" name="envoie">
        </form>
    </body>
</html>