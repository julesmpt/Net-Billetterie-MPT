<?php
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx*/
 function calendrier_local_mois ()
{
  global $code_langue;
  $an = strftime ( "%G", time ());
  setlocale(LC_TIME, $code_langue);
  for ($i=1;$i<=12;$i++)
  {
    $premier = mktime(0, 0, 0, $i, 1, $an);
    $calendrier [$i] = strftime ( "%B", $premier);
  }
  return  $calendrier;
}
function calendrier_local_mois2 ()
{
  global $code_langue;
  $an = strftime ( "%G", time ());
  setlocale(LC_TIME, $code_langue);
  for ($i=12;$i<=12;$i++)
  {
    $premier = mktime(0, 0, 0, $i, 1, $an);
    $calendrier [$i] = strftime ( "%B", $premier);
  }
  return  $calendrier;
}
function calendrier_local_mois3 ()
{
  global $code_langue;
  $an = strftime ( "%G", time ());
  setlocale(LC_TIME, $code_langue);
  for ($i=1;$i<=11;$i++)
  {
    $premier = mktime(0, 0, 0, $i, 1, $an);
    $calendrier [$i] = strftime ( "%B", $premier);
  }
  return  $calendrier;
}
function calendrier_local_jour ()
{
  global $code_langue;
  $jour = strftime ( "%A", time ());
  setlocale(LC_TIME, $code_langue);
  for ($i=5;$i<=10;$i++)
	
  {
    $premier = mktime(0, 0, 0, 0, $i, $jour);
    $calendrier [$i] = strftime ( "%A", $premier);
  }
  return  $calendrier;
}
function calendrier_local_jour2 ()
{
  global $code_langue;
  $jour = strftime ( "%A", time ());
  setlocale(LC_TIME, $code_langue);
  for ($i=11;$i<=11;$i++)
	
  {
    $premier = mktime(0, 0, 0, 0, $i, $jour);
    $calendrier [$i] = strftime ( "%A", $premier);
  }
  return  $calendrier;
}
?>
