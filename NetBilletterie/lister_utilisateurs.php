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
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/head.php"); 
include_once("include/finhead.php");
?>
<SCRIPT language="JavaScript" type="text/javascript">
        function confirmDelete2()
        {
        var agree=confirm('<?php echo "$lang_con_effa_utils"; ?>');
        if (agree)
         return true ;
        else
         return false ;
        }
        </script>
<SCRIPT language="JavaScript" type="text/javascript">
        function confirmDelete()
        {
        var agree=confirm('<?php echo "$lang_cli_effa"; ?>');
        if (agree)
         return true ;
        else
         return false ;
        }
        </script>
<table class="page">
    <tr>
        <td><?php echo "$message"; ?>
        </td>
    </tr>
    <tr>
        <td  class="page" align="center">
        <?php 
        if ($user_admin != 'y') { 
        echo "<h1>$lang_admin_droit";
        exit;
        }
         ?> 
        <?php 
        $sql = " SELECT * FROM " . $tblpref ."user WHERE 1 ORDER BY `nom` ASC";
        $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        ?>
            <center><table class="boiteaction">
              <caption><?php echo "Les utilisateurs"; ?></caption>
             <tr><th><?php echo $lang_nom; ?></th>
            <th><?php echo prenom; ?></th>
            <th><?php echo login; ?></th>
            <th><?php echo "Est admin"; ?></th>
            <th><?php echo "G�rer pointages"; ?></th>
            <th><?php echo "G�rer commandes"; ?></th>
            <th><?php echo "G�rer billetterie"; ?></th>
            <th><?php echo "G�rer mailings"; ?></th>
            <th><?php echo "Voir stat"; ?></th>
            <th><?php echo "G�rer spectacles"; ?></th>
            <th><?php echo "G�rer spectateurs"; ?></th>
            <th><?php echo "Peut imprimer"; ?></th>
            <th><?php echo "Menu"; ?></th>
            <th colspan="2"><?php echo "$lang_action"; ?></th>
            </tr>
                <?php
                $nombre =1;
                while($data = mysql_fetch_array($req))
                    {
                        $nom = $data['nom'];
                        $prenom = $data['prenom'];
                        $login = $data['login'];
                        $dev = $data['dev'];
                            if ($dev == y) { $dev = $lang_oui ;}
                            if ($dev == n) { $dev = $lang_non ; }
                            if ($dev == r) { $dev = $lang_restrint ; }
                        $com = $data['com'];
                            if ($com == y) { $com = $lang_oui ; }
                            if ($com == n) { $com = $lang_non ; }
                            if ($com == r) { $com = $lang_restrint ; }
                        $fact = $data['fact'];
                                if ($fact == y) { $fact = $lang_oui ; }
                            if ($fact == n) { $fact = $lang_non ; }
                            if ($fact == r) { $fact = $lang_restrint ; }
                        $mail =$data['mail'];
                        $dep = $data['dep'];
                            if ($dep == y) { $dep = $lang_oui ; }
                            if ($dep == n) { $dep = $lang_non ; }
                        $stat = $data['stat'];
                            if ($stat == y) { $stat = $lang_oui ; }
                            if ($stat == n) { $stat = $lang_non ; }
                        $art = $data['art'];
                            if ($art == y) { $art = $lang_oui ; }
                            if ($art == n) { $art = $lang_non ; }
                        $cli = $data['cli'];
                            if ($cli == y) { $cli = $lang_oui ; }
                            if ($cli == n) { $cli = $lang_non ; }
                            if ($dev == r) { $dev = $lang_restrint ; }
                        $admin = $data['admin'];
                            if ($admin == y) { $admin = $lang_oui ; }
                            if ($admin == n) { $admin = $lang_non ; }
                        $print_user = $data['print_user'];
                            if ($print_user == y) { $print_user = $lang_oui ; }
                            if ($print_user == n) { $print_user = $lang_non ; }
                        $menu = $data['menu'];
                            if ($menu ==1) { $menu = 'Administrateur' ; }
                            if ($menu ==2) { $menu = 'saisie abonnement' ; }
                            if ($menu ==3) { $menu = 'saisie billetterie' ; }
                            if ($menu ==4) { $menu = 'Charger de comm' ; }
                            if ($menu ==5) { $menu = 'comptable' ; }
                            if ($menu ==6) { $menu = 'liste d\'attente' ; }
                        
                        
                        $num_user = $data['num'];
                        $nombre = $nombre +1;
                        if($nombre & 1){
                            $line="0";
                        }else{
                            $line="1"; 
                        }
                        ?>
        <tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
            <td class="highlight"><b><?php echo $nom; ?></b></td>
            <td class="highlight"><b><?php echo $prenom; ?></b></td>
            <td class="highlight"><b><?php echo $login; ?></b></td>
            <td class="highlight"><?php echo $admin; ?></td>
            <td class="highlight"><?php echo $dev; ?></td>
            <td class="highlight"><?php echo $com; ?></td>
            <td class="highlight"><?php echo $fact; ?></td>
            <td class="highlight"><?php echo $dep; ?></td>
            <td class="highlight"><?php echo $stat; ?></td>
            <td class="highlight"><?php echo $art; ?></td>
            <td class="highlight"><?php echo $cli; ?></td>
            <td class="highlight"><?php echo $print_user; ?></td>
            <td class="highlight"><?php echo $menu; ?></td>
            <td class="highlight"><a href="editer_utilisateur.php?num_user=<?php echo $num_user ?>"><img src="image/edit.gif" border="0" alt="<?php echo $lang_editer ;?>r"></a></td>
            <td class="highlight"><a href="del_utilisateur.php?num_user=<?php echo $num_user ?>"><img src="image/delete.jpg" border="0" alt="<?php echo $lang_suprimer ;?>r" onClick='return confirmDelete2()'></a></td>

        <?php
        }
 ?>
 </tr><tr><TD colspan="13" class="submit"></TD></tr>
 </table>
 </center>



<?php
include_once("include/bas.php");
?>

