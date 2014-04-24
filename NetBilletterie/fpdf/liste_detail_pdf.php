<?php
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/
require('mysql_table.php');
include("../include/config/common.php");
include("../include/config/var.php");
include("../include/language/fr.php");
include_once("../include/configav.php");



define('FPDF_FONTPATH','font/');


	
//on compte le nombre de ligne 
$sql = "SELECT * FROM " . $tblpref ."cont_bon";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
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
    //Ajoute du JavaScript pour lancer la bo�te d'impression ou imprimer immediatement
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
$sql2="SELECT * FROM " . $tblpref ."cont_bon ORDER BY num ASC LIMIT $nb, 40";
$pdf->AddPage();
$file="liste_detail_commandes.pdf";



//la date
$date_print= date("d M Y");
$pdf->SetFillColor(255,238,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetY(8);
$pdf->SetX(135);
$pdf->MultiCell(50,6,"Liste imprimée le: \n  $date_print",1,C,1);


//les infos du spectacle
$pdf->SetFont('Arial','B',10);
$pdf->SetY(12);
$pdf->SetX(10);
$pdf->MultiCell(100,6,"Liste détaillée des commandes de billets",1,C,1);


//Le tableau : on d�finit les colonnes
$pdf->SetFont('Arial','',8);
$pdf->SetY(32);
$pdf->SetX(10);
$pdf->AddCol('num',30,"N)",'C');
$pdf->AddCol('article_num',30,"N� spectacle",'C');
$pdf->AddCol('quanti',9,"Nombre",'C');
$pdf->AddCol('prix_tarif',13,"prix du spectacle",'C');
$pdf->AddCol('id_tarif',20,"identifiant du tarif",'C');
$pdf->AddCol('to_tva_art',8,"total",'C');
$prop=array('HeaderColor'=>array(255,150,100),
'color1'=>array(255,255,210),
'color2'=>array(255,238,204),
'padding'=>2);
$pdf->Table("$sql2",$prop);

//le nombre de page 
$pdf->SetFont('Arial','B',10);
$pdf->SetY(260);
$pdf->SetX(30);
$pdf->MultiCell(160,4,"$lang_page $num_pa2 $lang_de $nb_pa\n",0,C,0);
}


$pdf->AutoPrint(false, $nbr_impr);

//Sauvegarde du PDF dans le fichier
$pdf->Output($file);

echo "<HTML><SCRIPT>document.location='$file';</SCRIPT></HTML>";


?>
