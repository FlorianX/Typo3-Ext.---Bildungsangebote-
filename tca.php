<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_txbildungsangebote_cat'] = array (
	'ctrl' => $TCA['tx_txbildungsangebote_cat']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,title,parent_category'
	),
	'feInterface' => $TCA['tx_txbildungsangebote_cat']['feInterface'],
	'columns' => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'title' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tx_bildungsangebote/locallang_db.xml:tx_txbildungsangebote_cat.title',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required',
			)
		),
		'parent_category' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tx_bildungsangebote/locallang_db.xml:tx_txbildungsangebote_cat.parent_category',		
			'config' => array (
				'type' => 'group',	
				'internal_type' => 'db',	
				'allowed' => 'tx_txbildungsangebote_cat',	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, title;;;;2-2-2, parent_category;;;;3-3-3')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);



$TCA['tx_txbildungsangebote_angebot'] = array (
	'ctrl' => $TCA['tx_txbildungsangebote_angebot']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,title,description,duration,start,category,pdf,number,dayly_repeat,image,events,color'
	),
	'feInterface' => $TCA['tx_txbildungsangebote_angebot']['feInterface'],
	'columns' => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'title' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tx_bildungsangebote/locallang_db.xml:tx_txbildungsangebote_angebot.title',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required',
			)
		),
		'description' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tx_bildungsangebote/locallang_db.xml:tx_txbildungsangebote_angebot.description',		
			'config' => array (
				'type' => 'text',
				'cols' => '30',
				'rows' => '5',
				'wizards' => array(
					'_PADDING' => 2,
					'RTE' => array(
						'notNewRecords' => 1,
						'RTEonly'       => 1,
						'type'          => 'script',
						'title'         => 'Full screen Rich Text Editing|Formatteret redigering i hele vinduet',
						'icon'          => 'wizard_rte2.gif',
						'script'        => 'wizard_rte.php',
					),
				),
			)
		),
		'duration' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tx_bildungsangebote/locallang_db.xml:tx_txbildungsangebote_angebot.duration',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'start' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tx_bildungsangebote/locallang_db.xml:tx_txbildungsangebote_angebot.start',		
			'config' => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'eval'     => 'date',
				'checkbox' => '0',
				'default'  => '0'
			)
		),
		'category' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tx_bildungsangebote/locallang_db.xml:tx_txbildungsangebote_angebot.category',		
			'config' => array (
				'type' => 'group',	
				'internal_type' => 'db',	
				'allowed' => 'tx_txbildungsangebote_cat',	
				'size' => 3,	
				'minitems' => 0,
				'maxitems' => 5,	
				"MM" => "tx_txbildungsangebote_angebot_category_mm",
			)
		),
		'pdf' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tx_bildungsangebote/locallang_db.xml:tx_txbildungsangebote_angebot.pdf',		
			'config' => array (
				'type'     => 'input',
				'size'     => '15',
				'max'      => '255',
				'checkbox' => '',
				'eval'     => 'trim',
				'wizards'  => array(
					'_PADDING' => 2,
					'link'     => array(
						'type'         => 'popup',
						'title'        => 'Link',
						'icon'         => 'link_popup.gif',
						'script'       => 'browse_links.php?mode=wizard',
						'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1'
					)
				)
			)
		),
		'number' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tx_bildungsangebote/locallang_db.xml:tx_txbildungsangebote_angebot.number',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'dayly_repeat' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tx_bildungsangebote/locallang_db.xml:tx_txbildungsangebote_angebot.dayly_repeat',		
			'config' => array (
				'type' => 'check',
			)
		),
		'image' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tx_bildungsangebote/locallang_db.xml:tx_txbildungsangebote_angebot.image',		
			'config' => array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => 'gif,png,jpeg,jpg',	
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],	
				'uploadfolder' => 'uploads/tx_txbildungsangebote',
				'show_thumbs' => 1,	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'events' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tx_bildungsangebote/locallang_db.xml:tx_txbildungsangebote_angebot.events',		
			'config' => array (
				'type' => 'text',
				'cols' => '30',	
				'rows' => '5',
			)
		),
		'color' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tx_bildungsangebote/locallang_db.xml:tx_txbildungsangebote_angebot.color',		
			'config' => array (
				'type' => 'input',	
				'size' => '10',	
				'max' => '7',	
				'wizards' => array(
					'_PADDING' => 2,
					'color' => array(
						'title' => 'Color:',
						'type' => 'colorbox',
						'dim' => '12x12',
						'tableStyle' => 'border:solid 1px black;',
						'script' => 'wizard_colorpicker.php',
						'JSopenParams' => 'height=300,width=250,status=0,menubar=0,scrollbars=1',
					),
				),
				'eval' => 'nospace',
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, title;;;;2-2-2, description;;;richtext[]:rte_transform[mode=ts];3-3-3, duration, start, category, pdf, number, dayly_repeat, image, events, color')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);
?>