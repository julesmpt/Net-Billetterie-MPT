 <?php
 function pagination($url,$parpage,$nblignes,$nbpages)
 {
 // On crée le code html pour la pagination
 $initial=isset($_GET['initial'])?$_GET['initial']:"";
 $ordre=isset($_GET['ordre'])?$_GET['ordre']:"";
 $par_page=isset($_GET['parpage'])?$_GET['parpage']:"";
 
 $html = precedent($url,$parpage,$nblignes,$initial); // On crée le lien precedent
 // On vérifie que l'on a plus d'une page à afficher
 if ($nbpages > 1) {
 // On boucle sur les numéros de pages à afficher
 for ($i = 0 ; $i < $nbpages ; ++$i) {
 $limit = $i * $parpage; // On calcule le début de la valeur 'limit'
 $limit = $limit.",".$parpage; // On fait une concaténation avec $parpage
  // On affiche les liens des numéros de pages
 $html .= "<a href=".$url.$limit."&initial=".$initial."&ordre=".$ordre."&parpage=".$par_page.">".($i + 1)."</a> | " ;
 }
      $page=position($parpage);
      //si y pas de limit c est que cest la première page
      if(empty($page)){$page =1;}
      echo "<h1>PageN°$page/$nbpages</h1>";
      


 }
 // Si l'on a qu'une page on affiche rien

 else {
 $html .= "";
 }
 $html .= suivant($url,$parpage,$nblignes); // On crée le lien suivant
 // On retourne le code html
 return $html;
 }
 function validlimit($nblignes,$parpage,$sql)
 {
 // On vérifie l'existence de la variable $_GET['limit']
 // $limit correspond à la clause LIMIT que l'on ajoute à la requête $sql
 if (isset($_GET['limit'])) {
 $pointer = split('[,]', $_GET['limit']); // On scinde $_GET['limit'] en 2
 $debut = $pointer[0];
 $fin = $pointer[1];
 // On vérifie la conformité de la variable $_GET['limit']
 if (($debut >= 0) && ($debut < $nblignes) && ($fin == $parpage)) {
 // Si $_GET['limit'] est valide on lance la requête pour afficher la page
 $limit = $_GET['limit']; // On récupère la valeur 'limit' passée par url
 $sql .= " LIMIT ".$limit.";"; // On ajoute $limit à la requête $sql
 $result = mysql_query($sql); // Nouveau résultat de la requête
 }
 // Sinon on affiche la première page
 else {
 $sql .= " LIMIT 0,".$parpage.";"; // On ajoute la valeur LIMIT à la requête
 $result = mysql_query($sql); // Nouveau résultat de la requête
 }
 }
 // Si la valeur 'limit' n'est pas connue, on affiche la première page
 else {
 $sql .= " LIMIT 0,".$parpage.";"; // On ajoute la valeur LIMIT à la requête
 $result = mysql_query($sql); // Nouveau résultat de la requête
 }
 // On retourne le résultat de la requête
 return $result;
 }
 function precedent($url,$parpage,$nblignes,$initial,$ordre)
 {
 // On vérifie qu'il y a au moins 2 pages à afficher
 if ($nblignes > $parpage) {
 // On vérifie l'existence de la variable $_GET['limit']
 if (isset($_GET['limit'])) {
 // On scinde la variable 'limit' en utilisant la virgule comme séparateur
 $pointer = split('[,]', $_GET['limit']);
 // On récupère le nombre avant la virgule et on soustrait la valeur $parpage
 $pointer = $pointer[0]-$parpage;
 // Si on atteint la première page, pas besoin de lien 'Précédent'
 if ($pointer < 0) {
 $precedent = "";
 }
 // Sinon on affiche le lien avec l'url de la page précédente
 else {
 $limit = "$pointer,$parpage";
  $ordre= $_GET['ordre'];
  $par_page= $_GET['parpage'];
 $precedent = "<a href='".$url.$limit."&initial=".$initial."&ordre=".$ordre."&parpage=".$par_page."'>Précédent</a> | ";
 }
 }
 else {
 $precedent = ""; // On est à la première page, pas besoin de lien 'Précédent'
 }
 }
 else {
 $precedent = ""; // On a qu'une page, pas besoin de lien 'Précédent'
 }
 return $precedent;
 }
 
 function suivant($url,$parpage,$nblignes,$initial,$ordre)
 {
 // On vérifie qu'il y a au moins 2 pages à afficher
 if ($nblignes > $parpage) {
 // On vérifie l'existence de la variable $_GET['limit']
 if (isset($_GET['limit']['initial'])) {
 // On scinde la variable 'limit' en utilisant la virgule comme séparateur
 $pointer = split('[,]', $_GET['limit']);
 // On récupère le nombre avant la virgule auquel on ajoute la valeur $parpage
 $pointer = $pointer[0] + $parpage;
 // Si on atteint la dernière page, pas besoin de lien 'Suivant'
 if ($pointer >= $nblignes) {
 $suivant = "";
 }
 // Sinon on affiche le lien avec l'url de la page suivante
 else  {
 $limit = "$pointer,$parpage";
 $initial= $_GET['initial'];
 $ordre= $_GET['ordre'];
 $par_page= $_GET['parpage'];
 $suivant = "<a class='pagination' href=".$url.$limit."&initial=".$initial."&ordre=".$ordre."&parpage=".$par_page.">Suivant</a>";
 }
 }
 // Si pas de valeur 'limit' on affiche le lien de la deuxième page
 if (@$_GET['limit']== false) {
	 
$initial= $_GET['initial'];
$ordre= $_GET['ordre'];
$par_page= $_GET['parpage'];
 $suivant = "<a href=".$url.$parpage."&initial=".$initial.",".$parpage."&initial=".$initial."&ordre=".$ordre."&parpage=".$par_page."></a>";
 }
 }
 else {
 $suivant = ""; // On a qu'une page, pas besoin de lien 'Suivant'
 }
 return $suivant;
 }
 

 ?>
