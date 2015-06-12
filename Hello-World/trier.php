

<?php
$a = $a.'<style>
#conteneur {
  /* Rien de spécial ici. */
}
#conteneur:after {
  content: ""; 
  display: table;
  clear: both;
}
</style>';

//ini_set('display_errors', 1); error_reporting(E_ALL); 

$dir = ".";
$dh  = opendir($dir);
while (false !== ($filename = readdir($dh))) {
	$explode = explode('.',$filename);
	$chaine = $explode[count($explode)-1];
	if(stripos($chaine, 'js') !== false || stripos($chaine, 'php') !== false)
    $files[] = $filename;

}

foreach ($files as $key => $value) {
	$contenu = file_get_contents($value);


while (stripos($contenu, 'function') !== false)
{

$contenu = preg_replace('`(.+)function(.+)\)`isU', '$2)QWERTssY', $contenu);

}

$fonctions = explode('QWERTssY', $contenu);
$n = count($fonctions);

foreach ($fonctions as $key2 => $value2) {
	if($n > 1 && $value2 != '()' && $value2 != '' && $value2 != ' ()'&& $value2 != '() '&& $value2 != ' () ')
	{
$fonctions_list[$n]['name'] = $value2;
$fonctions_list[$n]['file'] = $value;
$fonctions_list_2[$value][] = $value2;
$n = $n -1;
	}
	else
	{
	$n = $n -1;	
	}
	sort($fonctions_list);
	array_multisort($fonctions_list_2[$value]);
}







}
$e = 0;
foreach ($fonctions_list as $key => $value) {
$e++;
if($e > 19)
{
	$e = 0;
	$tableau =  $tableau.'<tr><td><a href="'.$value['file'].'">'.$value['name'].'</a></td><td> '.$value['file'].'</td></tr></table>';
}elseif($e == 1)
{
$tableau =  $tableau.'<table style="margin-left:20px;margin-top:20px;border:1px solid black;width:400px; float:left;"><tr><td><a href="'.$value['file'].'">'.$value['name'].'</a></td><td> '.$value['file'].'</td></tr>';
}
else
{
$tableau =  $tableau.'<tr><td><a href="'.$value['file'].'">'.$value['name'].'</a></td><td> '.$value['file'].'</td></tr>';
}

}
if($e <= 19)
{
	
	$tableau =  $tableau.'</table>';
}
$a = $a.'<div id="conteneur"><h1>TRI ALPHABETIQUE</h1>';
$a = $a.$tableau;

$a = $a.'</div><div id="conteneur">';
$a = $a.'<h1 >TRI PAR FICHIERS</h1></div>';

foreach ($fonctions_list_2 as $key2 => $value2) {
	$tableau2  = NULL;
	$e = 0;
	foreach ($fonctions_list_2[$key2] as $key => $value) {
	$e++;
	if($e > 20)
	{
		$e = 0;
		$tableau2 =  $tableau2.'<tr><td><a href="'.$key2.'">'.$value.'</a></td></tr></table>';
	}elseif($e == 1)
	{
	$tableau2 =  $tableau2.'<table style="margin-left:20px;margin-top:20px;border:1px solid black;width:400px; float:left;"><tr><td><a href="'.$key2.'">'.$value.'</a></td></tr>';
	}
	else
	{
	$tableau2 =  $tableau2.'<tr><tr><td><a href="'.$key2.'">'.$value.'</a></td></tr>';
	}
	}
	if($e <= 19)
	{
		
		$tableau2 =  $tableau2.'</table>';
	}
$a = $a.'<div id="conteneur">';
$a = $a.'<h3>'.$key2.'</h3>';
$a = $a.'<h3>'.$tableau2.'</h3>';
$a = $a.'</div>';
}

?>
<form action="#" method="POST">

<input type="submit" name="save" value="sauvegarder ces informations dans un fichier html" />
</form>


<?php
if($_POST['save'] != NULL)
{
	//function creeFichier trouvée sur http://blog.studiovitamine.com/actualite,107,fr/creer-fichier-php,304,fr.html?id=256 le 12.06.15 19h57
	function creerFichier($fichierChemin, $fichierNom, $fichierExtension, $fichierContenu, $droit=""){
	$fichierCheminComplet = $_SERVER["DOCUMENT_ROOT"].$fichierChemin."/".$fichierNom;
	if($fichierExtension!=""){
	$fichierCheminComplet = $fichierCheminComplet.".".$fichierExtension;
	}
	 
	// création du fichier sur le serveur
	$leFichier = fopen($fichierCheminComplet, "wb");
	fwrite($leFichier,$fichierContenu);
	fclose($leFichier);
	 
	// la permission
	if($droit==""){
	$droit="0777";
	}
	 
	// on vérifie que le fichier a bien été créé
	$t_infoCreation['fichierCreer'] = false;
	if(file_exists($fichierCheminComplet)==true){
	$t_infoCreation['fichierCreer'] = true;
	}
	 
	// on applique les permission au fichier créé
	$retour = chmod($fichierCheminComplet,intval($droit,8));
	$t_infoCreation['permissionAppliquer'] = $retour;
	 
	return $t_infoCreation;
	}

	$fichierChemin = ".";
	$fichierNom = "trier";
	$fichierExtension = "html";
	$fichierContenu = '<h1>Sauvegarde</h1><a href="trier.php">retour</a>'.$a;
	$droit = "0777";
	$t_infoCreation = creerFichier($fichierChemin, $fichierNom, $fichierExtension, $fichierContenu, $droit);
	echo "<pre>";
	print_r($t_infoCreation);
	echo "</pre>";
	if($t_infoCreation['fichierCreer'] == 1)
		echo '<h1>Sauvegarde effectuée</h1>Accéder au fichier en cliquant sur <a href="trier.html">trier.html</a>';
	else
		echo '<h1>Impossible de créer le fichier</h1>Faites le manuellement, désolé.<a href="trier.php">retour</a>';
}
else
echo $a;
?>