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

require_once (PATH_tslib . 'class.tslib_pibase.php');

/**
 * Plugin 'Angebote nach Monaten' for the 'tx_bildungsangebote' extension.
 *
 * @author	Florian Schuhmann <schuhmann.florian@googlemail.com>
 * @package	TYPO3
 * @subpackage	tx_txbildungsangebote
 */
class tx_txbildungsangebote_pi1 extends tslib_pibase {
	var $prefixId = 'tx_txbildungsangebote_pi1'; // Same as class name
	var $scriptRelPath = 'pi1/class.tx_txbildungsangebote_pi1.php'; // Path to this script relative to the extension dir.
	var $extKey = 'tx_bildungsangebote'; // The extension key.
	var $pi_checkCHash = true;
	
	/**
	 * Main method of your PlugIn
	 *
	 * @param	string		$content: The content of the PlugIn
	 * @param	array		$conf: The PlugIn Configuration
	 * @return	The content that should be displayed on the website
	 */
	function main($content, $conf) {
		$this->pi_initPIflexForm (); // Init and get the flexform data of the plugin
		$piFlexForm = $this->cObj->data ['pi_flexform'];
		
		$this->lConf = array ();
		foreach ( $piFlexForm ['data'] as $sheet => $data ) {
			foreach ( $data as $lang => $value ) {
				foreach ( $value as $key => $val ) {
					$this->lConf [$key] = $this->pi_getFFvalue ( $piFlexForm, $key, $sheet );
				}
			}
		}
		
		if ($this->lConf ['what_to_display'] == "MONTH") {
			$js .= '<script src="' . t3lib_extMgm::siteRelPath ( $this->extKey ) . 'static/js/SpryTabbedPanels.js" type="text/javascript"><!-- //--></script>';
			$GLOBALS ['TSFE']->additionalHeaderData [$this->extKey] = $js;
			$GLOBALS ['TSFE']->additionalHeaderData [$this->extKey . '_css_1'] = '<link href="' . t3lib_extMgm::siteRelPath ( $this->extKey ) . 'static/css/stylesheet.css" rel="stylesheet" type="text/css" />';
			
			return $this->pi_wrapInBaseClass ( $this->monthView ( $content, $conf ) );
		
		} else if ($this->lConf ['what_to_display'] == "LIST") {
			$js .= '<script src="' . t3lib_extMgm::siteRelPath ( $this->extKey ) . 'static/js/SpryCollapsiblePanel.js" type="text/javascript"><!-- //--></script>';
			$GLOBALS ['TSFE']->additionalHeaderData [$this->extKey] = $js;
			$GLOBALS ['TSFE']->additionalHeaderData [$this->extKey . '_css_1'] = '<link href="' . t3lib_extMgm::siteRelPath ( $this->extKey ) . 'static/css/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />';
			
			return $this->pi_wrapInBaseClass ( $this->listView ( $content, $conf ) );
		} else if ($this->lConf ['what_to_display'] == "LIST2") {
			return $this->pi_wrapInBaseClass ( $this->listView2 ( $content, $conf ) );
		} else if ($this->lConf ['what_to_display'] == "LIST3") {
			return $this->pi_wrapInBaseClass ( $this->listView3 ( $content, $conf ) );
		}
	}
	
	/**
	 * Shows a month view of database entries
	 *
	 * @param	string		$content: content of the PlugIn
	 * @param	array		$conf: PlugIn Configuration
	 * @return	HTML list of table entries
	 */
	function monthView($content, $conf) {
		$this->conf = $conf; // Setting the TypoScript passed to this function in $this->conf
		$this->pi_setPiVarDefaults ();
		
		$this->pi_loadLL (); // Loading the LOCAL_LANG values
		

		$this->month = array (1 => "Jan", 2 => "Feb", 3 => "M&auml;rz", 4 => "April", 5 => "Mai", 6 => "Juni", 7 => "Juli", 8 => "Aug", 9 => "Sep", 10 => "Okt", 11 => "Nov", 12 => "Dez" );
		
		//DEBUG
		//$fullTable = var_dump ( $tRows );
		$timeShift = 10;
		$contentArray = $this->getSortedArray ( $timeShift );
		
		$navigation = '<ul class="TabbedPanelsTabGroup">';
		$tabs = '<div class="TabbedPanelsContentGroup">';
		
		for($i = date ( "n" ); $i <= date ( "n" ) + $timeShift; $i ++) {
			$tmp = date ( "n", mktime ( 0, 0, 0, $i, date ( 'y' ) ) );
            if(count($contentArray [$tmp]) > 0)
            {
			    $monat = $this->month [$tmp];
			    $navigation .= '<li tabindex="0" class="TabbedPanelsTab">' . $monat . '</li>';
			    $tabs .= $this->getTab ( $contentArray [$tmp] );
            }
		}
		$navigation .= '</ul>';
		$tabs .= '</div>';
		
		/**
		 * DEBUG: Output the content of $this->piVars for debug purposes. 
		 * REMEMBER to comment out the IP-lock in the debug() function in t3lib/config_default.php 
		 * if nothing happens when you un-comment this line! 
		 */
		//$fullTable.=t3lib_div::view_array($this->lConf);	
		

		// Returns the content from the plugin.
		$js = '<script type="text/javascript">var TabbedPanels1 = new Spry.Widget.TabbedPanels("Termine");</script>';
		return '<div id="Termine" class="TabbedPanels">' . $navigation . $tabs . '</div>' . $js;
	
	}
	/**
	 * Shows a list view of database entries
	 *
	 * @param	string		$content: content of the PlugIn
	 * @param	array		$conf: PlugIn Configuration
	 * @return	HTML list of table entries
	 */
	function listView($content, $conf) {
		$this->conf = $conf; // Setting the TypoScript passed to this function in $this->conf
		$this->pi_setPiVarDefaults ();
		
		$this->pi_loadLL (); // Loading the LOCAL_LANG values
		

		//DEBUG
		//$fullTable = var_dump ( $tabs );		
		

		$contentArray = $this->getListArray ();
		$tabs = $this->getItems ( $contentArray );
		
		$uid = $this->cObj->data ['uid'];
		$text = '<span class="textbg">' . $this->lConf['subText'] . '</span>';
		$js = '<script type="text/javascript">var CollapsiblePanel' . $uid . ' = new Spry.Widget.CollapsiblePanel("CollapsiblePanel' . $uid . '", {contentIsOpen:true});</script>';
		return '<div id="CollapsiblePanel' . $uid . '" class="CollapsiblePanel">' . $tabs . '</div>' . $text . $js;
	
	}
	/**
	 * Shows a list view2 of database entries
	 *
	 * @param	string		$content: content of the PlugIn
	 * @param	array		$conf: PlugIn Configuration
	 * @return	HTML list of table entries
	 */
	function listView2($content, $conf) {
		$this->conf = $conf; // Setting the TypoScript passed to this function in $this->conf
		$this->pi_setPiVarDefaults ();
		
		$this->pi_loadLL (); // Loading the LOCAL_LANG values
		

		//DEBUG
		//$fullTable = var_dump ( $tabs );		
		$contentArray = $this->getListArray ();
		$temp = $this->getItemsWithImages ( $contentArray );
		
		return '<ul class="ba">' . $temp . '</ul>';
	
	}	
	/**
	 * Shows a list view3 of database entries
	 *
	 * @param	string		$content: content of the PlugIn
	 * @param	array		$conf: PlugIn Configuration
	 * @return	HTML list of table entries
	 */
	function listView3($content, $conf) {
		$this->conf = $conf; // Setting the TypoScript passed to this function in $this->conf
		$this->pi_setPiVarDefaults ();
		
		$this->pi_loadLL (); // Loading the LOCAL_LANG values
		

		//DEBUG
		//$fullTable = var_dump ( $tabs );		
		$contentArray = $this->getListArray ();
		return $temp = $this->getItemsBoxed ( $contentArray );
	}	
	function getStartDateFormated($start) {
		return strftime ( '%d.%m.%Y', $start );
	
	}
	function getTab($month) {
		
		$tab = '<div class="TabbedPanelsContent">';
		
		foreach ( $month as $sub){
		foreach ($sub as $key => $cat ) {
		
		
			$cat_old = null;
			foreach ( $cat as $angebot ) {
			if ( $angebot ['cattitle'] == 'Mit täglichem Einstieg' or $angebot ['cattitle'] == 'Berufsbegleitend' or $angebot ['cattitle'] == 'Umschulung' or $angebot ['cattitle'] == 'Modulare Qualifizierung' or $angebot ['cattitle'] == 'Weiterbildungskurse'){
				if ($key != $cat_old)
					$tab .= '<span class="headline">' . $angebot ['cattitle'] . '</span>';
				
				$tab .= '<p>';
				
				if ($angebot ['pdf'] != "")
					$tab .= '<a target="_blank" href="' . $angebot ['pdf'] . '">';
				
				$tab .= '<strong>' . $angebot ['title'] . '</strong>';
				
				if ($angebot ['pdf'] != "")
					$tab .= '</a>';
				
				if ($angebot ['number'] != "")
					$tab .= '<br>' . $angebot ['number'];
				
				if ($angebot ['duration'] != "")
					$tab .= '<br>Dauer: ' . $angebot ['duration'];
				
				if ($angebot ['events'] != ""){
				    $parts= explode("\n", $angebot ['events']);
					$tab .= '<br><span class="date">Termin:<br>' . $parts [0] . '</span>';
				}
				
				$tab .= '</p>';
				$cat_old = $key;
			}
		}
		
		}
		}
		// DEBUG
		//$tab.=t3lib_div::view_array($month);
		$tab .= '</div>';
		return $tab;

	}
	function getItems($items) {
		$title = '<div class="CollapsiblePanelTab" tabindex="0"><span class="headlinebg">';
		$content = '<div class="CollapsiblePanelContent">';
		if ( $angebot ['cattitle'] == 'Mit täglichem Einstieg' or $angebot ['cattitle'] == 'Berufsbegleitend' or $angebot ['cattitle'] == 'Umschulung' or $angebot ['cattitle'] == 'Modulare Qualifizierungen' or $angebot ['cattitle'] == 'Weiterbildungskurse' ){
		foreach ( $items as $key => $angebot ) {
			if ($key == 0)
				$title .= $angebot ['cattitle'];
			
			
			
			$content .= '<div class="angebot">';
			
			if ($angebot ['pdf'] != "")
				$content .= '<a target="_blank" href="' . $angebot ['pdf'] . '">';
			
			$content .= '<strong>' . $angebot ['title'] . '</strong>';
			
			if ($angebot ['pdf'] != "")
				$content .= '</a>';
			
			
			if ($angebot ['number'] != "")
				$content .= '<br>' . $angebot ['number'];
			
			if ($angebot ['duration'] != "")
				$content .= '<br>Dauer: ' . $angebot ['duration'];
			
			if ($angebot ['events'] != "")
				$content .= '<br><span class="date">Termin:<br>' . nl2br($angebot ['events']) . '</span>';
			
			$content .= '</div>';
		}
		// DEBUG
		// $content .= t3lib_div::view_array ( $items );
		$title .= '</span></div>';
		$content .= '</div>';
		return $title . $content;
	}
	}
	function getItemsWithImages($items) {
		foreach ( $items as $key => $angebot ) {
		$content .= '<li>';
		    // IMAGE
			if ($angebot ['pdf'] != "" &&  $angebot ['image'] != "")
				$content .= '<div class="left"><a target="_blank" href="' . $angebot ['pdf'] . '">';
			
			if ($angebot ['image'] != ""){
			    $path=(!preg_match("/fileadmin/", $angebot ['image']))?'uploads/tx_txbildungsangebote/':'';
			    $content .= '<img class="border" height="90" width="90" src="' . $path . $angebot ['image'] . '"/>';
			}
			
			if ($angebot ['pdf'] != "" &&  $angebot ['image'] != "")
				$content .= '</a></div>';
		    
			if ($angebot ['pdf'] != "")
				$content .= '<div class="right"><a target="_blank" href="' . $angebot ['pdf'] . '">';
			
			$content .= '<strong>' . $angebot ['title'] . '</strong>';
			
			if ($angebot ['pdf'] != "")
				$content .= '</a>';
			
			if ($angebot ['description'] != "")
				$content .= '<br>' . $angebot ['description'].'<br>';

			if ($angebot ['events'] != "")
				$content .= '<br><span class="nornal">Termin:<br>' . nl2br($angebot ['events']) . '</span>';
				
				if ($angebot ['duration'] != "")
				$content .= 'Dauer: ' . $angebot ['duration'];
				
		$content .= '</div></li>';			
		}
		// DEBUG
		// $content .= t3lib_div::view_array ( $items );
		return $content;
	
	}
	function getItemsBoxed($items) {
	    $content ='<div class="module_container">';
		foreach ( $items as $key => $angebot ) {
			if ($key == 0)
				$title = $angebot ['cattitle'];
		    
			$content .= '<div class="module_box">';

			if($angebot['color'] == '') $angebot['color'] = '#0E555B';
			$content .= '<div class="top" style="color:'.$angebot['color'].'">' .
			            $angebot ['title'] . '</div>';

			$content .='<div class="top_content" >';
			if ($angebot ['description'] != "")
				$content .= $angebot ['description'];
			
			if ($angebot ['events'] != "")
				$content .= '<br><br><span class="date">Termin:<br>' . nl2br($angebot ['events']) . '</span>';
			
			if ($angebot ['duration'] != "")
				$content .= '<br><span class="nornal">Dauer: ' . $angebot ['duration'] . '</span>';
			
			$content .= '</div>';
			
			$content .= '<div class="module_box_link" >';
			if ($angebot ['pdf'] != "")
				$content .= '<a target="_blank" href="' . $angebot ['pdf'] . '">Download Flyer &raquo;</a>';
            $content .= '</div>';


			
		$content .= '</div>';			
		}
		$content .= '</div>';
		// DEBUG
		// $content .= t3lib_div::view_array ( $items );
		return $content;
	
	}
	function getSortedArray($timeShift) {
		
		$from_date = mktime ( 0, 0, 0, date ( 'm' ), 1, date ( 'y' ) ); // todays date
		

		$tmp = mktime ( 0, 0, 0, date ( 'm' ) + $timeShift, 1, date ( 'y' ) );
		$to_date = mktime ( 0, 0, 0, date ( 'm' ) + $timeShift, date ( 't', $tmp ), date ( 'y' ) ); // date with one year difference i.e. same date of next year
		

		//$GLOBALS['TYPO3_DB']->debugOutput = TRUE; 
		$res = $GLOBALS ['TYPO3_DB']->exec_SELECTquery ( 'DISTINCT c.sorting as sort, a.*, c.uid as cat, FROM_UNIXTIME(a.start,"%m") as monat, c.title as cattitle', // SELECT ...
'tx_txbildungsangebote_angebot a, tx_txbildungsangebote_cat c, tx_txbildungsangebote_angebot_category_mm mm ', // FROM ...
'a.start >= "' . $from_date . '" and a.start <= "' . $to_date . '"' . ' and dayly_repeat=0 and mm.uid_foreign=c.uid' . ' and mm.uid_local=a.uid' . ' and not a.hidden and not a.deleted' . // all offers that are NOT deleted and NOT hidden
' and not c.hidden and not c.deleted' . ' and a.pid="' . $this->lConf ['pages'] . '"', // all categories that are NOT deleted and NOT hidden
'', // GROUP BY... 
'a.sorting asc, c.sorting asc, monat asc, cat asc', // ORDER BY...
'' ); // LIMIT to 10 rows, starting with number 5 (MySQL compat.)
		

		$tRows = null;
		$c = array ();
		while ( $row = $GLOBALS ['TYPO3_DB']->sql_fetch_assoc ( $res ) ) {
			$c2 = $c [$row ['monat']];
			$c2 = ($c2) ? $c2 : 0;
			echo($row['sort']);
			$tRows [intval ( $row ['monat'] )][$row['sort']] [$row ['cat']] [$c2] = $row;
			$c [$row ['monat']] ++;
		}
		
		
			$res = $GLOBALS ['TYPO3_DB']->exec_SELECTquery ( 'DISTINCT  c.sorting as sort,a.*, c.uid as cat, c.title as cattitle', // SELECT ...
'tx_txbildungsangebote_angebot a, tx_txbildungsangebote_cat c, tx_txbildungsangebote_angebot_category_mm mm ', // FROM ...
'a.dayly_repeat=1' . ' and mm.uid_foreign=c.uid' . ' and mm.uid_local=a.uid' . ' and not a.hidden and not a.deleted' . // all offers that are NOT deleted and NOT hidden
' and not c.hidden and not c.deleted' . ' and a.pid="' . $this->lConf ['pages'] . '"', // all categories that are NOT deleted and NOT hidden
'', // GROUP BY... 
'a.sorting asc, c.sorting asc, cat asc', // ORDER BY...
'' ); // LIMIT to 10 rows, starting with number 5 (MySQL compat.)
		

		while ( $row = $GLOBALS ['TYPO3_DB']->sql_fetch_assoc ( $res ) ) {
		    $from_date = mktime ( 0, 0, 0, date ( 'm' ), 1, date ( 'y' ) ); // todays date
		    $i=1;
            while ($from_date <$to_date){
                $tRows[date('n',$from_date)][$row['sort']][$row['cat']][] = $row;
                ksort($tRows[date('n',$from_date)]);
                
                $from_date = mktime ( 0, 0, 0, date ( 'm' )+$i, 1, date ( 'y' ) ); // todays date
                $i++;
            }
            
		}
		
		//die(t3lib_div::view_array ($tRows ));
		return $tRows;
	}
	
	function getListArray() {
		
		$from_date = mktime ( 0, 0, 0, date ( 'm' ), 1, date ( 'y' ) ); // todays date
		

		//$GLOBALS['TYPO3_DB']->debugOutput = TRUE; 
		$res = $GLOBALS ['TYPO3_DB']->exec_SELECTquery ( 'DISTINCT a.*, c.uid as cat, FROM_UNIXTIME(a.start,"%m") as monat, c.title as cattitle', // SELECT ...
'tx_txbildungsangebote_angebot a, tx_txbildungsangebote_cat c, tx_txbildungsangebote_angebot_category_mm mm ', // FROM ...
'(a.start >= "' . $from_date . '" or a.start = "0")' . ' and mm.uid_foreign=c.uid' . ' and mm.uid_local=a.uid' . ' and not a.hidden and not a.deleted' . // all offers that are NOT deleted and NOT hidden
' and not c.hidden and not c.deleted' . // all categories that are NOT deleted and NOT hidden 
' and a.pid="' . $this->lConf ['pages'] . '"' . ' and c.uid="' . $this->lConf ['categorySelection'] . '"', '', // GROUP BY... 
'a.sorting asc, c.sorting asc, monat asc, cat asc', // ORDER BY...
'' ); // LIMIT to 10 rows, starting with number 5 (MySQL compat.)
		

		$tRows = null;
		while ( $row = $GLOBALS ['TYPO3_DB']->sql_fetch_assoc ( $res ) ) {
			$tRows [] = $row;
		}
		return $tRows;
	}
}

if (defined ( 'TYPO3_MODE' ) && $TYPO3_CONF_VARS [TYPO3_MODE] ['XCLASS'] ['ext/tx_bildungsangebote/pi1/class.tx_txbildungsangebote_pi1.php']) {
	include_once ($TYPO3_CONF_VARS [TYPO3_MODE] ['XCLASS'] ['ext/tx_bildungsangebote/pi1/class.tx_txbildungsangebote_pi1.php']);
}

?>