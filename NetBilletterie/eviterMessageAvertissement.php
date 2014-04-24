<?php
 
session_start();
$num_bon=isset($_POST['bon_num'])?$_POST['bon_num']:"";
$num_client=isset($_POST['num_client'])?$_POST['num_client']:"";
$id_tarif=isset($_POST['id_tarif'])?$_POST['id_tarif']:"";
//print_r($num_bon);
 
if(!empty($_POST) OR !empty($_FILES))
{
    $_SESSION['sauvegarde'] = $_POST ;
    $_SESSION['sauvegardeFILES'] = $_FILES ;
     
    $fichierActuel = $_SERVER['PHP_SELF'] ;
    if(!empty($_SERVER['QUERY_STRING']))
    {
        $fichierActuel .= '?' . $_SERVER['QUERY_STRING'] ;
    }
     //echo "coucou";
    header('Location: ' . $fichierActuel);
    exit;
}
 
if(isset($_SESSION['sauvegarde']))
{
    $_POST = $_SESSION['sauvegarde'] ;
    $_FILES = $_SESSION['sauvegardeFILES'] ;
    //echo "debut";
    // print_r($_SESSION['sauvegarde']);
    unset($_SESSION['sauvegarde'], $_SESSION['sauvegardeFILES']);
    //echo"<br>";
   //echo"fin";
    print_r($_SESSION['sauvegarde']);
    // echo "OK";
}
//var_dump($num_bon);
 //var_dump($_SESSION['sauvegarde'], $_SESSION['sauvegardeFILES']);

?>
