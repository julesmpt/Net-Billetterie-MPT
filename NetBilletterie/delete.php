<?
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

if (file_exists($path."dbinfo.php")) {
   $dir=opendir($path."dump/"); 
   $fl = readdir($dir);
   while ($fl = readdir ($dir)) { 
       if ($fl != "." && $fl != ".." &&  (eregi("\.sql",$fl) || eregi("\.gz",$fl))){ 
         unlink($path."dump/".$fl); // del all sql and gz
       }
   } 
   closedir($dir); 
   unlink($path."dbinfo.php"); 
}
 
?>
<html>
<head>


</head>

<center>

  <TABLE WIDTH="80%" border="0" cellspacing="0" >
    <TR> 
      <TD  valign="top"> <h4><?php echo "$lang_back_utili" ?></h4>
        <b><font color="#990000"><?php echo "$lang_back_effac" ?></font></b><font size="2"> 
        <br>
        <?php echo "$lang_back_upl" ?><br>
        <br>
        </font></TD>
    </TR>
    <TR> 
      <TD height="40" valign="top"><b><br>
        <a href="form_backup.php"><font size="1"><?php echo "$lang_back_ret" ?></font></a> 
        </b></TD>
    </TR>
    <TR>
      <TD height="15" valign="top" bgcolor="#FFFFFF"><div align="right"><font color="#9999CC" face="Arial, Helvetica, sans-serif" style="font-size:6Pt">MySql 
          Php Backup &copy; 2003 by <a href="http://www.absoft-my.com" target="_blank">AB 
          Webservices</a></font> </div></TD>
    </TR>
  </TABLE>

<br><br>
  <br>
  <br>
  <br>
  <br>
  <br>

</center>
</body>
</html>
