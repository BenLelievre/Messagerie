<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="Style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>MESSAGERIE</title>
</head>
<body>
    <div id="conteneur">
        <header>
        <form action="index.php" method="post">
            <center> 
                ENVOYEUR:
                <input type = "text" name = "envoyeur"style="width:200px"/>
                DESTINATAIRE:
                <input type = "text" name = "receveur"style="width:200px"/>
                MESSAGE:
                <input type = "text" name = "texte" size="50" style="height:50px;"/>
                <input type = "submit" value= "ENVOYER"/>
      
           </center>   </form>
        </header>
        <div class="gauche">
            <center>
            MESSAGE ENVOYE
            </center>
            <p>
                <ul>
                <?php
                base();
                ?>
                </ul>
		    </p>
        </div>
        <div class="milieu">
            <center>
            MESSAGE RECU
            </center>
            <?php
                reception();
            ?>
        </div>
        <div class="clear"></div>
    </div>
</body>
</html>



<?php

function base()
 {
 $dbhost = "localhost";
 $dbuser = "root";
 $dbpass = "rtlry";
 $db = "messages";
 $mail="";
	try
	{
		$bdd = new PDO('mysql:host=localhost;dbname='.$db.';charset=utf8', $dbuser, $dbpass);
	}
	catch (Exception $e)
	{
			die('Erreur : ' . $e->getMessage());
	}
	if (isset($_GET["id"])){
		$bdd->query("DELETE FROM boiteenvoi WHERE id=".$_GET["id"]."");
	}
	
	if (isset($_POST["texte"])&&isset($_POST["receveur"])&&isset($_POST["envoyeur"])){
        $message = $_POST['texte'];
        $mail = $_POST['receveur'];
        $envoi = $_POST['envoyeur'];
		$bdd->query("INSERT INTO boiteenvoi (envoyeur,receveur,texte) VALUES ('".$envoi."','".$mail."','".$message."')");
	}
	
	$reponse = $bdd->query("SELECT * FROM boiteenvoi WHERE receveur='".$mail."'");
	
	while ($donnees = $reponse->fetch())
	{
		echo "<li><a id=\"croix\" href=\"index.php?id=".$donnees['id']."\">x</a> 'Message envoyé à: '".$donnees['receveur']."<br> ".$donnees['texte']."</br></li><br/>";
	}
}


function reception()
 {
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "rtlry";
    $db = "messages";
    $envoi = $_POST['envoyeur'];
    $envoi = "";
    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname='.$db.';charset=utf8', $dbuser, $dbpass);
    }
    catch (Exception $e)
    {
       die('Erreur : ' . $e->getMessage());
    }

	$reponse = $bdd->query("SELECT * FROM boiteenvoi WHERE receveur='".$envoi."'");
	
	while ($donnees = $reponse->fetch())
	{
		echo "<li><a id=\"croix\" href=\"index.php?id=".$donnees['id']."\">x</a> 'Message recu de: '".$donnees['envoyeur']."<br> ".$donnees['texte']."</br></li><br/>";
	}
}
?>

