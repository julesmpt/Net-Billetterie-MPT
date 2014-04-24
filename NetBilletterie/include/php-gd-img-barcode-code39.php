<?php
// ############## GENERER UN CODE BARRE CODE 39 AVEC PHP/GD ################# //
// Date de création : 11/11/2007                                              //
// Auteur : Thierry Godin                                                     //
// http://thierry-godin.developpez.com/                                       //
//                                                                            //
// Remerciements à Guillaume Rossolini pour les corrections et les conseils   //
// http://g-rossolini.developpez.com/                                         //
// ########################################################################## //

//Vérification des paramètres passés par l'URL =================================
if(isset($_GET['string']))
{
    $TheString = preg_replace('¤[^0-9A-Z. $/+%*-]¤', '', strtoupper($_GET['string']));
}
else
{
    $TheString = 'ERREUR';
}

if(isset($_GET['control']) and $_GET['control'] == "1")
{
    $AddControl = TRUE;
}
else{
    $AddControl = FALSE;
}

//------------------------------------------------------------------------------

//création de l'image temporaire ===============================================
$thumb = imagecreatetruecolor(500, 45);
$fond = imagecolorallocate($thumb, 255, 0, 255); // fond
imagefill($thumb, 0, 0, $fond);

//------------------------------------------------------------------------------

// tableau Char -> Code ========================================================
$TabCode = array(
   '0' =>  '101000111011101',
   '1' =>  '111010001010111',
   '2' =>  '101110001010111',
   '3' =>  '111011100010101',
   '4' =>  '101000111010111',
   '5' =>  '111010001110101',
   '6' =>  '101110001110101',
   '7' =>  '101000101110111',
   '8' =>  '111010001011101',
   '9' =>  '101110001011101',
   
   'A' =>  '111010100010111',
   'B' =>  '101110100010111',
   'C' =>  '111011101000101',
   'D' =>  '101011100010111',
   'E' =>  '111010111000101',
   'F' =>  '101110111000101',
   'G' =>  '101010001110111',
   'H' =>  '111010100011101',
   'I' =>  '101110100011101',
   'J' =>  '101011100011101',
   'K' =>  '111010101000111',
   'L' =>  '101110101000111',
   'M' =>  '111011101010001',
   'N' =>  '101011101000111',
   'O' =>  '111010111010001',
   'P' =>  '101110111010001',
   'Q' =>  '101010111000111',
   'R' =>  '111010101110001',
   'S' =>  '101110101110001',
   'T' =>  '101011101110001',
   'U' =>  '111000101010111',
   'V' =>  '100011101010111',
   'W' =>  '111000111010101',
   'X' =>  '100010111010111',
   'Y' =>  '111000101110101',
   'Z' =>  '100011101110101',
   
   '-' =>  '100010101110111',
   '.' =>  '111000101011101',
   ' ' =>  '100011101011101',
   '$' =>  '100010001000101',
   '/' =>  '100010001010001',
   '+' =>  '100010100010001',
   '%' =>  '101000100010001',
   '*' =>  '100010111011101'
);

//------------------------------------------------------------------------------

// convertir la chaine en code =================================================
$CodeBar = '';

// tableau des caractères seuls
$TabKeys = array_keys($TabCode);

$TotalChar = 0;
for($i = 0; $i < strlen($TheString); $i++)
{
    $CodeBar .= "0" . $TabCode[$TheString[$i]] . "<br>";
    
    //récupération de l'index du caractère
    foreach($TabKeys as $key => $value) {
        if($value === $TheString[$i]){ $TotalChar += $key;}
    }
}
//------------------------------------------------------------------------------

//calculer le caractère de controle ============================================
$IndexControl = bcmod($TotalChar, 43);
//------------------------------------------------------------------------------

//ajouter le caratère de controle ==============================================
if($AddControl)
{
    $CodeBar.= "0" . $TabCode[$TabKeys[$IndexControl]];
}
//------------------------------------------------------------------------------

//on rajoute * en début et en fin de code ======================================
$xCodeBar = $TabCode["*"] . $CodeBar . "0" . $TabCode["*"];

//------------------------------------------------------------------------------

// dessiner le code barre ======================================================
$c_w = imagecolorallocate($thumb, 255, 255, 255); // blanc
$c_b = imagecolorallocate($thumb, 0, 0, 0); // noir
$x_ref = 0;
for($x=0; $x < strlen($xCodeBar); $x++)
{
    if($xCodeBar[$x] == "1")
    {
        imageline($thumb, $x_ref, 0, $x_ref, 45, $c_b);
    }
    else
    {
        imageline($thumb, $x_ref, 0, $x_ref, 45, $c_w);
    }
    $x_ref++;
}

//------------------------------------------------------------------------------

// Création de l'image définitive ==============================================
$IMG = imagecreatetruecolor($x_ref, 45);
imagefill($IMG, 0, 0, $fond);
imagecopymerge ($IMG, $thumb, 0, 0, 0, 0, 500, 65, 100 );

//------------------------------------------------------------------------------

header("Content-type: image/png");
imagepng($IMG);
?>
