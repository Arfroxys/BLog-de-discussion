<?php
$pdo = new PDO('mysql:host=database;dbname=data', 'root', 'motdepasse');
if(isset($_POST['valider'])){
    if(!empty($_POST['pseudo']) AND !empty($_POST['message'])){
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $message = nl2br(htmlspecialchars($_POST['message']));
        $id_use = $pdo->prepare('SELECT Id FROM users WHERE Name_User = ?');
        $id_use->execute(array($pseudo));

        $insererMessage = $pdo->prepare('INSERT INTO post(Id_User, Contenu) VALUES(?, ?)');
        $insererMessage->execute(array($id_use, $message));
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
        <H1>Le Kiwi, Le Kiwi, C'est trop génial!</H1>
        <form method="Post" action="" align="center">
            <input type="text" name="pseudo">
            <br>
            <textarea name="message"></textarea>
            <br><br>
            <input type="submit" name="valider">
        </form>
        <section id="messages">
            <h2>Please Reload to see messages</h2>
            <?php 
            $pdo = new PDO('mysql:host=database;dbname=data', 'root', 'motdepasse');
            $recuppost = $pdo->query('SELECT * FROM post');
            while($posts = $recuppost->fetch()){
                ?>
                <div class="message">
                    <h4><?= $posts['pseudo']; ?></4>
                    <p><?= $posts['Contenu']; ?></p>
                </div>
                <?php
            }
            ?>
        </section>
        <script></script>
    </body>
</html>