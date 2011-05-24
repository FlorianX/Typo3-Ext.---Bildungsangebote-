<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_extMgm::allowTableOnStandardPages('tx_txbildungsangebote_cat');

$TCA['tx_txbildungsangebote_cat'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:tx_bildungsangebote/locallang_db.xml:tx_txbildungsangebote_cat',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
      	'sortby' => 'sorting',  
		'default_sortby' => 'ORDER BY crdate',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_txbildungsangebote_cat.png',
	),
);


t3lib_extMgm::allowTableOnStandardPages('tx_txbildungsangebote_angebot');


t3lib_extMgm::addToInsertRecords('tx_txbildungsangebote_angebot');

$TCA['tx_txbildungsangebote_angebot'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:tx_bildungsangebote/locallang_db.xml:tx_txbildungsangebote_angebot',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'sortby' => 'sorting',  
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_txbildungsangebote_angebot.png',
	),
);


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY.'_pi1']='pi_flexform';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:tx_bildungsangebote/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.png'
),'list_type');


// now, add your flexform xml-file
 t3lib_extMgm::addPiFlexFormValue($_EXTKEY.'_pi1', 'FILE:EXT:'.$_EXTKEY.'/flexform_ds.xml');            // new!
	// class for displaying the category tree in BE forms.
include_once(t3lib_extMgm::extPath($_EXTKEY).'pi1/class.tx_txbildungsangebote_pi1_addFieldsToFlexForm.php');

if (TYPO3_MODE == 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_txbildungsangebote_pi1_wizicon'] = t3lib_extMgm::extPath($_EXTKEY).'pi1/class.tx_txbildungsangebote_pi1_wizicon.php';
}
?>