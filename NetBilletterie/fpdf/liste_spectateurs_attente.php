<?php
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:José Das Neves pitu69@hotmail.fr*/
require('mysql_table.php');
include("../include/config/common.php");
include("../include/config/var.php");
include("../include/language/fr.php");
include_once("../include/configav.php");

define('FPDF_FONTPATH','font/');

//on GET le numero du spectacle
$article_numero=isset($_GET['article'])?$_GET['article']:"";

//on recupère les infos du spectacle
$sql2="SELECT DATE_FORMAT(date_spectacle,'%d/%m/%Y') AS date_spectacle, article, stock, num, lieu, horaire FROM ".$tblpref."article WHERE num=$article_numero";
$req2 = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$data = mysql_fetch_array($req2);

    $article = $data['article'];
    $article_numero= $data['num'];
    $date = $data['date_spectacle'];
    $stock = $data['stock'];


//on compte le nombre de ligne de la liste des spectateurs
$sql = " SELECT *
FROM ".$tblpref."client C, ".$tblpref."cont_bon CB, ".$tblpref."bon_comm BC , ".$tblpref."tarif T,".$tblpref."article A
WHERE CB.bon_num=BC.num_bon
AND BC.client_num=C.num_client
AND CB.article_num = $article_numero
AND A.num = $article_numero
AND CB.id_tarif = T.id_tarif
AND BC.attente=1
 ";


$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
$nb_li = mysql_num_rows($req);
$nb_pa1 = $nb_li /40 ;
$nb_pa = ceil($nb_pa1);
$nb_li =$nb_pa * 40 ;


class PDF extends PDF_MySQL_Table
{

function Header()
{		}
//debut Js
var $javascript;
    var $n_js;

    function IncludeJS($script) {
        $this->javascript=$script;
    }

    function _putjavascript() {
        $this->_newobj();
        $this->n_js=$this->n;
        $this->_out('<<');
        $this->_out('/Names [(EmbeddedJS) '.($this->n+1).' 0 R ]');
        $this->_out('>>');
        $this->_out('endobj');
        $this->_newobj();
        $this->_out('<<');
        $this->_out('/S /JavaScript');
        $this->_out('/JS '.$this->_textstring($this->javascript));
        $this->_out('>>');
        $this->_out('endobj');
    }

    function _putresources() {
        parent::_putresources();
        if (!empty($this->javascript)) {
            $this->_putjavascript();
        }
    }

    function _putcatalog() {
        parent::_putcatalog();
        if (isset($this->javascript)) {
            $this->_out('/Names <</JavaScript '.($this->n_js).' 0 R>>');
        }
    }
		function AutoPrint($dialog=false, $nb_impr)
{
    //Ajoute du JavaScript pour lancer la boîte d'impression ou imprimer immediatement
    $param=($dialog ? 'true' : 'false');
    $script=str_repeat("print($param);",$nb_impr);

    $this->IncludeJS($script);
}
//fin js

}
$pdf=new PDF('p','mm','a4');
$pdf->Open();

for ($i=0;$i<$nb_pa;$i++)
{
$nb = $i *40;
$num_pa = $i;
$num_pa2 = $num_pa +1;

$pdf->AddPage();
$file="liste_attente_$article_numero.pdf";


//la date
$date_print= date("d M Y");
$pdf->SetFillColor(255,238,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetY(8);
$pdf->SetX(135);
$pdf->MultiCell(50,6,"Liste imprimée le: \n  $date_print",1,C,1);

//le slogan en haut à gauche

$pdf->SetFont('Arial','B',10);
$pdf->SetY(8);
$pdf->SetX(5);
$pdf->MultiCell(71,4,"$slogan",0,C,0);

//deuxieme cellule les infos du spectacle
$pdf->SetFont('Arial','B',10);
$pdf->SetY(12);
$pdf->SetX(10);
$pdf->MultiCell(100,6,"Liste d'atttente des spectateurs pour :  \n - $article -  le $date. \n Le nombre est de $stock places",1,C,1);

//Le tableau : on définit les colonnes
$pdf->SetFont('Arial','',8);
$pdf->SetY(32);
$pdf->SetX(10);
$pdf->AddCol('num_bon',10,"Num.",'C');
$pdf->AddCol('nom',30,"Nom Prenom",'C');
$pdf->AddCol('cp',9,"CP",'C');
$pdf->AddCol('rue',30,"Adresse",'C');
$pdf->AddCol('ville',36,"Ville",'C');
$pdf->AddCol('tel',20,"Telephone",'C');
$pdf->AddCol('quanti',8,"Nbr",'C');
$pdf->AddCol('nom_tarif',28,"Type de tarif",'C');
$pdf->AddCol('coment',70,"Commentaire",'C');
$prop=array('HeaderColor'=>array(255,150,100),
		  'color1'=>array(255,255,210),
			'color2'=>array(255,238,204),
			'padding'=>2);

$pdf->Table("SELECT *
FROM ".$tblpref."client C, ".$tblpref."cont_bon CB, ".$tblpref."bon_comm BC , ".$tblpref."tarif T
WHERE CB.bon_num=BC.num_bon
AND BC.client_num=C.num_client
AND CB.article_num = $article_numero
AND BC.attente=1
AND CB.id_tarif = T.id_tarif
ORDER BY BC.num_bon ASC
LIMIT $nb, 40",$prop);


//le nombre de page

$pdf->SetFont('Arial','B',10);
$pdf->SetY(260);
$pdf->SetX(30);
$pdf->MultiCell(160,4,"Page $num_pa2 sur $nb_pa\n",0,C,0);
}
$pdf->Output($file);
echo "<HTML><SCRIPT>document.location='$file';</SCRIPT></HTML>";
?>
