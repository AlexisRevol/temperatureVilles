

<?php 

/*connexion*/
$destinataire= 'mysql:host=localhost;dbname=bdd_temperaturevilles;port=3306';
$utilisateur= 'root';
$motPasse= '';
/*on se connecte avec nos identifiants*/
$connexion=new PDO($destinataire,$utilisateur,$motPasse);
$connexion->query("SET lc_time_names = 'fr_FR'");
?>


<?php
if(!empty($_POST['Ville']))
{
	$ville=htmlspecialchars($_POST['Ville']);
	try
{

	/*on créer une requête récuperant tout par ordre décroissant en fonction de la date*/ 
	$sql_requette="SELECT temperature,pression, ville, DATE_FORMAT(last_update,'Le %d %M %Y à %H h %i') as last_update FROM temperaturevilles WHERE ville='$ville'"; 
	/*DAY(last_update) as jour, MONTH(last_update) as mois, YEAR(last_update) as annee, HOUR(last_update) as heure, MINUTE(last_update) as minutes*/
	/*on prépare la requête*/
	$reponse =  $connexion->prepare($sql_requette);
	$reponse->execute(array($sql_requette));


	/*tant qu'il y a des reponses*/
	while ($colonne = $reponse->fetch(PDO::FETCH_ASSOC))
    {?>
      	<!--affichage-->
    	 <p>
    	 	<span> <?= $colonne['last_update']?> </span>
     		<span > <?php echo " à ".ucfirst($colonne['ville']). " il faisait actuellement";?> </span>
        	<span > <?php echo $colonne['temperature']. "°C";?> </span> </br></br>
        	<span > <?php echo "La pression était de " .$colonne['pression']. " hpa";?> </span>
      	</p>
    
   	<?php } ?> <!-- fin du while -->


		<?php $reponse->closeCursor(); /*-termine le traitement de la requête*/
	}

/*pour renvoyer les erreurs*/
catch (Exception $e)
{
    die('Aïe une erreur : '.$e->getMessage());
}



}
?>

