<?php
/* Net Billetterie Copyright(C)2012 Jos� Das Neves
 Logiciel de billetterie libre. 
D�velopp� depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : Jos� Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/headers.php");
include_once("include/head.php");
include_once("include/finhead.php");
extract($_POST);
flush();
$conn = @mysql_connect($dbhost,$dbuser,$dbpass);
if ($conn==false)  die("password / user or database name wrong");
   $x=$_SERVER[SERVER_SOFTWARE];
   if (strpos($x,"Win32")!=0) {
      $path = $path . "dump\\";
   } else {
      $path = $path . "dump/";
   }

   // If windows gives problems
   // FOR WINDOWS change to ==> $path = $path . "dump\\";
   
   if (!is_dir($path)) mkdir($path, 0766);
//   chmod($path, 0777);

	$fp2 = fopen ($path."backup.sql","w");
        $copyr="#Backup de Factux\n".
               "# Table backup from MySql PHP Backup\n".
               "# AB Webservices 1999-2004\n".
               "# www.absoft-my.com/pondok\n".
               "# Creation date: ".date("m-d-Y h:s",time())."\n\n";

	fwrite ($fp2,$copyr);
	fclose ($fp2);
//        chmod($path . "backup." . date('m-d-Y ') . ".sql", 0777);

   if(file_exists($path . "backup.gz"))
   { 
       unlink($path."backup.gz");
   } 
   $recreate = 0;

function get_def($dbname, $table) {
    global $conn;
    $def = "";
    $def .= "DROP TABLE IF EXISTS $table;#%%\n";
    $def .= "CREATE TABLE $table (\n";
    $result = mysql_db_query($dbname, "SHOW FIELDS FROM $table",$conn) or die("Table $table not existing in database");
    while($row = mysql_fetch_array($result)) {
        $def .= "    $row[Field] $row[Type]";
        if ($row["Default"] != "") $def .= " DEFAULT '$row[Default]'";
        if ($row["Null"] != "YES") $def .= " NOT NULL";
       	if ($row[Extra] != "") $def .= " $row[Extra]";
        	$def .= ",\n";
     }
     $def = ereg_replace(",\n$","", $def);
     $result = mysql_db_query($dbname, "SHOW KEYS FROM $table",$conn);
     while($row = mysql_fetch_array($result)) {
          $kname=$row[Key_name];
          if(($kname != "PRIMARY") && ($row[Non_unique] == 0)) $kname="UNIQUE|$kname";
          if(!isset($index[$kname])) $index[$kname] = array();
          $index[$kname][] = $row[Column_name];
     }
     while(list($x, $columns) = @each($index)) {
          $def .= ",\n";
          if($x == "PRIMARY") $def .= "   PRIMARY KEY (" . implode($columns, ", ") . ")";
          else if (substr($x,0,6) == "UNIQUE") $def .= "   UNIQUE ".substr($x,7)." (" . implode($columns, ", ") . ")";
          else $def .= "   KEY $x (" . implode($columns, ", ") . ")";
     }

     $def .= "\n);#%%";
     return (stripslashes($def));
}

function get_content($dbname, $table) {
     global $conn;
     $content="";
     $result = mysql_db_query($dbname, "SELECT * FROM $table",$conn);
     while($row = mysql_fetch_row($result)) {
         $insert = "INSERT INTO $table VALUES (";
         for($j=0; $j<mysql_num_fields($result);$j++) {
            if(!isset($row[$j])) $insert .= "NULL,";
            else if($row[$j] != "") $insert .= "'".addslashes($row[$j])."',";
            else $insert .= "'',";
         }
         $insert = ereg_replace(",$","",$insert);
         $insert .= ");#%%\n";
         $content .= $insert;
     }
     return $content;
}

$filetype = "sql";

if (!eregi("/restore\.",$PHP_SELF)) {
	
	$cur_time=date("Y-m-d H:i");
	if ($table_names == "*" ) {
	   $tables = mysql_list_tables($dbname,$conn);
	   $num_tables = @mysql_num_rows($tables);
	   $i = 0;
	   while($i < $num_tables) { 
	      $table = mysql_tablename($tables, $i);
	      $table = ltrim($table);
	      $newfile .= get_def($dbname,$table);
	      $newfile .= "\n\n";
	      $newfile .= get_content($dbname,$table);
	      $newfile .= "\n\n";
	      $i++;
	   }	
	} else {
	   $i=0;
	   $tables=explode(";",$table_names);
	   if (count($tables) != 0) {
	      while($i < count($tables)) {
	         $newfile .= get_def($dbname,ltrim($tables[$i]));
	         $newfile .= "\n\n";
	         $newfile .= get_content($dbname,ltrim($tables[$i]));
	         $newfile .= "\n\n";
	         $i++;
	      }
	   }       
	}
	$fp = fopen ($path."backup.$filetype","a");
	fwrite ($fp,$newfile);
	fwrite ($fp,"# Valid end of backup from MySql PHP Backup\n");
	fclose ($fp);
}
?>

<table class="page">
	<tr>
		<td>
			<CENTER>
				<table class="action">
					<h1>Sauvegarde de la base de donn�e</h1>
					<TR> 
						<td class="texte0" height="215" valign="top"> 
							<b><font color="#990000"><?php echo "$lang_back_ok" ?></font></b> 
							<br>Si vous n'avez re�u aucune erreur sur cette page, vous trouverer le backup dans le r�pertoire 'dump' (sans les guillemets) dans le r�pertoire d'installation? 
							<br>Ce fichier s'apelle 'backup.sql'.
							<br>Il contient les tables suivantes:
							<br>
							<br>
							<? 
							if ($_POST[table_names] == "*") {
							   $count = $num_tables;
							} else {
							   $count = count($tables);
							}      

							if ($count != 0 ) {
							   $i=0;
							   while ($i < $count) {
									if ($_POST[table_names] == "*") {
									   echo " ++ <b>".mysql_tablename($tables, $i)."</b><br>";
									} else {
									   echo " ++ <b>".$tables[$i]."</b><br>";
									}
									$i++;
							   }
							} else {
							   echo "<font color='red'>No tables have been backed-up </font><br>";
							}   ?>
										 
									
							<br>Ce fichier ne peut �tre restaur� que gr�ce � l'utilitaire de restauration du logiciel.
							<br>La base de donn�e doit avoir le meme nom.
							<br>N'oubliez pas d'effacer ce backup apres l'avoir t�l�charg�. Laisser un backup sur le serveur est un risque potentiel pour la s�curit�.
							<br>
							</font> 
						</TD>
					</TR>
					<TR> 
						<td class="texte0" height="27" ><B><A HREF="main.php"><font size="1"><br>
						<?php echo "$lang_back_ret" ?></font></A></B></TD>
					</TR>
				</table>
			</center>
		</td>
	</tr>
</table>
<?php include_once("include/bas.php"); ?> 

