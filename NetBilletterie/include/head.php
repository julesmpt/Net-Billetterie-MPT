<?php
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:José Das Neves pitu69@hotmail.fr*/

//Administrateur plein pouvoir
if ($user_menu=='1'){
include_once("include/menu1.php");
}
//saisie abonnement
if ($user_menu=='2'){
include_once("include/menu2.php");
}
//saisie billetterie
if ($user_menu=='3'){
include_once("include/menu3.php");
}
//saisie attente
if ($user_menu=='6'){
include_once("include/menu6.php");
}
//Charger de communication
if ($user_menu=='4'){
include_once("include/menu4.php");
}
//comptable
if ($user_menu=='5'){
include_once("include/menu5.php");
}
?>
<br>
