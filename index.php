<?php 

/*connexion*/
$destinataire= 'mysql:host=localhost;dbname=bdd_temperaturevilles;port=3306';
$utilisateur= 'root';
$motPasse= '';
/*on se connecte avec nos identifiants*/
$connexion=new PDO($destinataire,$utilisateur,$motPasse);
$connexion->query("SET lc_time_names = 'fr_FR'");


$sql_requette="SELECT ville FROM temperaturevilles"; 
$reponse =  $connexion->prepare($sql_requette);
$reponse->execute(array($sql_requette));
?>

<!--mon formulaire qui selectionne toute les villes -->
<div>

<form method="post" action="affichage_temperature.php">  
 Sélectionnez une ville <br />
    <select name="Ville">
    	<option selected="selected"></option>
  		<?php /*tant qu'il y a des reponses*/
			while ($colonne = $reponse->fetch(PDO::FETCH_ASSOC))
    		{?>
    	 		<option value=<?= $colonne['ville']?>><?php echo ucfirst($colonne['ville']);?></option>  
   			<?php } ?> <!-- fin du while -->
			<?php $reponse->closeCursor(); /*-termine le traitement de la requête*/?>
  	</select>
  	<input type="submit" value="valider" />
</form>
</div>


<?php 
include "affichage_temperature.php"
?>