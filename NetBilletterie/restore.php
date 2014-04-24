<?php
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/headers.php");
include_once("include/head.php");
include_once("include/finhead.php");

extract ($_REQUEST);
?>


<table class="page">
	<tr>
		<td>
			<center>
				<TABLE class="action" >
					<TR> 
					  <td class="texte0">
						  <h1><?php echo "$lang_back_ti_re" ?></h1>
					  </TD>
					</TR>  
							<?php
							if (!isset($file)) {
								echo '
								<TR> 
								  <TD valign="top">
									 </TD>
								</TR> ';
							} ?>    
					<TR> 
						<td class="texte0"> 
									<?
							$x=  $_SERVER[SERVER_SOFTWARE];
							if (strpos($x,"Win32")!=0) {
							   $path = $path . "dump\\";
							} else {
							   $path = $path . "dump/";
							}

							// IF WINDOWS GIVES PROBLEMS
							// FOR WINDOWS change to ==> $path = $path . "dump\\";
							if ($file!="") {
								  if (eregi("gz",$file)) { //zip file decompress first than show only
									 @unlink($path."backup.sql");
									 $fp2 = @fopen("dump/backup.sql","w");
									 fwrite ($fp2,"");
								 fclose ($fp2);
									 chmod($path."backup.sql", 0777);
									 $fp = @fopen("dump/backup.sql","w");
									 $zp = @gzopen("dump/$file", "rb");
									 if(!$fp) {
										  die("No sql file can be created"); 
									 }    
									 if(!$zp) {
										  die("Cannot read zip file");
									 }    
									 while(!gzeof($zp)){
									  $data=gzgets($zp, 8192);// buffer php
									  fwrite($fp,$data);
									 }
									 fclose($fp);
									 gzclose($zp);
									 $file="backup.sql";
									 echo " <br>$lang_back_ext <br>";
									 $file='';
								  } // end of unzip
							}
							if ($file!=""){  
									 
								  flush();
								  $conn = mysql_connect($dbhost,$dbuser,$password) or die(mysql_error());
								$filename = $file;
								set_time_limit(1000);
								$file=fread(fopen($path.$file, "r"), filesize($path.$file));
								$query=explode(";#%%\n",$file);
								for ($i=0;$i < count($query)-1;$i++) {
									mysql_db_query($dbname,$query[$i],$conn) or die(mysql_error());
								}
								echo "<table width=\"90%\"><tr><td class='texte0'>$lang_back_resto 
							.</b> $lang_back_restO2 
							.<br><br></td></tr></table>";
							} 
							?>
							</TD>
					</TR>
					<TR> 
						<td class='texte0'><table width="625" cellspacing="0">
								<tr> 
									<td class="texte0"width="125" align="center"><font size="2"><u><i><?php echo "$lang_fichier" ?></i></u></font></td>
									<td class="texte0" width="125" align="center"><font size="2"><u><i><?php echo "$lang_tai" ?></i></u></font></td>
									<td class="texte0" width="125" align="center"><font size="2"><u><i><?php echo "$lang_date" ?></i></u></font></td>
									<td class="texte0" width="125"><font size="2">&nbsp;</font></td>
									<td class="texte0" width="125"><font size="2">&nbsp;</font></td>
								</tr>
							  <?php
								$dir=opendir($path); 
								$file = readdir($dir);
								while ($file = readdir ($dir)) { 
									if ($file != "." && $file != ".." &&  (eregi("\.sql",$file) || eregi("\.gz",$file))){ 
										if (eregi("\.sql",$file) ) {
										   echo "<tr><td class='texte0'>$file</td>
											 <td class='texte0'>".round(filesize($path.$file) / 1024, 2)." KB</td>
											 <td class='texte0'>".date("d-m-Y",filemtime($path.$file))."</td>
											 <td class='texte0'><a href=\"restore.php?file=$file\">$lang_rest</a></td>
											 <td class='texte0'><a href=\"dump/$file\">$lang_voir</a></td></tr>"; 
										} else {
										   echo "<tr><td nowrap bgcolor=\"#dddddd\" align=\"center\">$file</td>
											 <td class='texte0'>".round(filesize($path.$file) / 1024, 2)." KB</td>
											 <td class='texte0'>".date("d-m-Y",filemtime($path.$file))."</td>
											 <td class='texte0'><a href=\"restore.php?file=$file\">Unzip</a></td>
											 <td></td></tr>"; 
										   }
									} 
								}
								closedir($dir);
								?>
						</td>
					</tr>
				</table>
			</center>
		</TD>
	</TR>
	<TR> 
		<td class='texte0' height="20" valign="top"><p><br>
					  <b><a href="main.php"><?php echo "$lang_back_ret" ?></a></b></p>
		</TD>
	</TR>
			  </TABLE>
			</center>
		</td>
	</tr>
</table>
<?php 
include_once("include/bas.php");
 ?> 

