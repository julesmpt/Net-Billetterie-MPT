<?php
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/
?>
<center><h1>Choisir le mode de paiement</h1>
		<select name="paiement" onchange="if(this.value != -1){if(confirm('<?php echo"$lang_conf_carte_reg";?> '+ forms['payement<?php echo "$max";?>'].elements['num'].value +' <?php echo"$lang_par ";?>'+ this.value)){forms['payement<?php echo "$max";?>'].submit();}else{return false}}">
		<?php 
                if ($paiement !="")
                { ?>
                    <option value="<?php echo $paiement;?>"><?php if ($paiement=="non") { $paiement='En attente de paiement';} echo $paiement;?></option>
                   <?php
                } ?>

                        <option value="Chèque">Chèque</option>
			<option value="non">En attente de paiement</option>
			<option value="Espèces">Espèces</option>
			<option value="M ra">M ra</option>
			<option value="Gratuit">Gratuit</option>

		</select>
