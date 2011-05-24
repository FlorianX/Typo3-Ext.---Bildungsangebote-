<?php
/***************************************************************
 * Copyright notice
 *
 * (c) 2011 Florian Schuhmann <schuhmann.florian@googlemail.com>
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */
class tx_txbildungsangebote_pi1_addFieldsToFlexForm {
	/**
	 * Generation of TCEform elements of the type "select"
	 * This will render a selector box element, or possibly a special construction with two selector boxes. That depends on configuration.
	 *
	 * @param	array		$PA: the parameter array for the current field
	 * @param	object		$fobj: Reference to the parent object
	 * @return	string		the HTML code for the field
	 */
  function addFields ($config) {
  		$GLOBALS['TYPO3_DB']->debugOutput = TRUE; 
		$res = $GLOBALS ['TYPO3_DB']->exec_SELECTquery ( 
			'DISTINCT uid, title, parent_category', // SELECT ...
			'tx_txbildungsangebote_cat', // FROM ...
			'NOT hidden AND NOT deleted',   // all offers that are NOT deleted and NOT hidden
			'', // GROUP BY... 
			'uid asc', // ORDER BY...
			'' ); // LIMIT to 10 rows, starting with number 5 (MySQL compat.)
  	
  	
    $optionList = array();
  	while ( $row = $GLOBALS ['TYPO3_DB']->sql_fetch_assoc ( $res ) ) {
			$optionList[] = array(0 => $row ['title'], 1 => $row ['uid']);
	}    
    $config['items'] = array_merge($config['items'],$optionList);
    return $config;
  }
	




}





if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tt_news/lib/class.tx_ttnews_TCAform_selectTree.php'])    {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tt_news/lib/class.tx_ttnews_TCAform_selectTree.php']);
}
?>