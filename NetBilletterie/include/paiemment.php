<?php
/* Net Billetterie Copyright(C)2012 Jos� Das Neves
 Logiciel de billetterie libre. 
D�velopp� depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : Jos� Das Neves pitu69@hotmail.fr*/
?>
<center><h1>Choisir le mode de paiement</h1>
		<select name="paiement" onchange="if(this.value != -1){if(confirm('<?php echo"$lang_conf_carte_reg";?> '+ forms['payement<?php echo "$max";?>'].elements['num'].value +' <?php echo"$lang_par ";?>'+ this.value)){forms['payement<?php echo "$max";?>'].submit();}else{return false}}">
		<?php 
                if ($paiement !="")
                { ?>
                    <option value="<?php echo $paiement;?>"><?php if ($paiement=="non") { $paiement='En attente de paiement';} echo $paiement;?></option>
                   <?php
                } ?>

                        <option value="Ch�que">Ch�que</option>
			<option value="non">En attente de paiement</option>
			<option value="Esp�ces">Esp�ces</option>
			<option value="M ra">M ra</option>
			<option value="Gratuit">Gratuit</option>

		</select>
