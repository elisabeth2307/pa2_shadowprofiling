<?php
/**
 * @package	HikaShop for Joomla!
 * @version	2.6.4
 * @author	hikashop.com
 * @copyright	(C) 2010-2017 HIKARI SOFTWARE. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');
?><h1 id="hikashop_address_form_header_iframe"><?php echo JText::_('ADDRESS_INFORMATION');?></h1>
<div id="hikashop_address_form_span_iframe">
	<form action="<?php echo hikashop_completeLink('address&task=save'); ?>" method="post" name="hikashop_address_form" enctype="multipart/form-data">
		<table>
<?php

// START Prototype
include "./prototype_variables.php";
include $pathPHPfiles . "get_cookie.php";
// cookie value is now available -> $cookieValue

// array where similar profiles are stored temporarily
$GLOBALS['similarProf'] = [];
// prepare needed keys -> the values will be filled if similar profiles were found
$GLOBALS['evalValues'] = array('email' => "", 'firstname' => "", 'lastname' => "", 'street' => "", 'post' => "", 'city' => "", 'country' => "", 'state' => "");

// file handling
$filename = $pathProfiles . $cookieValue . ".json";
// check if file of current user exists
if(file_exists($filename)){
	$json = json_decode(file_get_contents($filename), true);
	// retrieve profiles with probability higher than specific percentage
	$similarProfiles = $json['similarities'];

	// if similarities are available iterate all similarities
	if(!empty($similarProfiles)){
		foreach ($similarProfiles as $key => $value) {
			// if the probability of a profile is higher than the predefined probability
			// => similarity must be higher than for example 50% to be considered
			if($value['probability'] > $probabilityPercentageCheckout){

				// prepare filename of similar profile
				$filenameSimilarProf = $pathProfiles . $key;

				// use probability as key -> higher probability will be prefered later
				// if the probability is available in the "result"-array, value is set ...
				if(empty($GLOBALS['similarProf'][$value['probability']])){
					$GLOBALS['similarProf'][$value['probability']] = $filenameSimilarProf;
				} else {
					$i = 1;
					$done = 0;
					// ... otherwise the probability is decreased until it can be stored
					do {
						if(empty($GLOBALS['similarProf'][$value['probability']-$i])){
							$GLOBALS['similarProf'][$value['probability']-$i] = $filenameSimilarProf;
							$done = 1;
						}
						$i++;
					} while($done == 0);
				}


			}
		}
	}
	// call function to gather data from files
	gatherSimilarProfData();
}

// retrieve shadow profile content and search for needed data
function gatherSimilarProfData(){
	// sort in reverse order -> highest probability is gathered first
	krsort($GLOBALS['similarProf']);

	foreach ($GLOBALS['similarProf'] as $key => $value) {
		// key is the probability
		// value is the filename

		// get current shadow profile
		$json = json_decode(file_get_contents($value), true);

		// iterate all needed keys
		foreach ($GLOBALS['evalValues'] as $key => $value) {
			// if the value of the profileKeys is empty and the similar profile contains a value
			if(empty($value) && !empty($json[$key])){
				// set value
				$GLOBALS['evalValues'][$key] = $json[$key];
			}
		}
	}

}

// returns requested value from one of the similar shadow profiles
// which was gathered in gatherSimilarProfData in case data is missing
// at the checkout
function getSimilarProfData($key){
	if(!empty($GLOBALS['evalValues'][$key])){
		return ucfirst($GLOBALS['evalValues'][$key]);
	} else {
		return null;
	}
}
// END Prototype

	foreach($this->extraFields['address'] as $fieldName => $oneExtraField) {

		// START Prototype
		// read values
		$property = preg_split('/_/', $fieldName)[1];

		// check if value is stored
		if(!empty($json[$property])){
			$fieldValue = $json[$property];
			$fieldValue = ucfirst($fieldValue);
		} else {
			$fieldValue = getSimilarProfData($property);
		}
		// INFO: value="'.$fieldValue.'" is added below! which prefills the field
		// END Prototype

?>
			<tr class="hikashop_address_<?php echo $fieldName;?>_line" id="hikashop_address_<?php echo $oneExtraField->field_namekey; ?>">
				<td class="key"><?php
					echo $this->fieldsClass->getFieldName($oneExtraField);
				?></td>
				<td><?php
					$onWhat='onchange'; if($oneExtraField->field_type=='radio') $onWhat='onclick';

					echo $this->fieldsClass->display(
						$oneExtraField,
						@$this->address->$fieldName,
						'data[address]['.$fieldName.']',
						false,
						' '.$onWhat.'="hikashopToggleFields(this.value,\''.$fieldName.'\',\'address\',0);" value="'.$fieldValue.'"',
						false,
						$this->extraFields['address'],
						@$this->address
					);
				?></td>
				</tr>
<?php }	?>
		</table>
		<input type="hidden" name="Itemid" value="<?php global $Itemid; echo $Itemid; ?>"/>
		<input type="hidden" name="ctrl" value="address"/>
		<input type="hidden" name="tmpl" value="component"/>
		<input type="hidden" name="task" value="save"/>
		<input type="hidden" name="type" value="<?php echo JRequest::getVar('type',''); ?>"/>
		<input type="hidden" name="action" value="<?php echo JRequest::getVar('task',''); ?>"/>
		<input type="hidden" name="makenew" value="<?php echo JRequest::getInt('makenew'); ?>"/>
		<input type="hidden" name="redirect" value="<?php echo JRequest::getWord('redirect','');?>"/>
		<input type="hidden" name="step" value="<?php echo JRequest::getInt('step',-1);?>"/>
<?php
	if(!empty($address->address_user_id)){
		$id = $address->address_user_id;
	}else{
		$id = $this->user_id;
	}
?>
		<input type="hidden" name="data[address][address_user_id]" value="<?php echo $id;?>"/>
<?php
	if(!JRequest::getInt('makenew')){
?>
		<input type="hidden" name="data[address][address_id]" value="<?php echo (int)@$this->address->address_id;?>"/>
		<input type="hidden" name="address_id" value="<?php echo (int)@$this->address->address_id;?>"/>
<?php
	}
	echo JHTML::_( 'form.token' );
	echo $this->cart->displayButton(JText::_('OK'),'ok',$this->params,hikashop_completeLink('address&task=save'),'if(hikashopCheckChangeForm(\'address\',\'hikashop_address_form\')) document.forms[\'hikashop_address_form\'].submit(); return false;');
?>
	</form>
</div>
<div class="clear_both"></div>
