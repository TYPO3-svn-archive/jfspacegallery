<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Juergen Furrer <juergen.furrer@gmail.com>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */

require_once(t3lib_extMgm::extPath('imagecycle').'pi1/class.tx_imagecycle_pi1.php');

/**
 * Plugin 'Spacegallery' for the 'jfspacegallery' extension.
 *
 * @author	Juergen Furrer <juergen.furrer@gmail.com>
 * @package	TYPO3
 * @subpackage	tx_jfspacegallery
 */
class tx_jfspacegallery_pi1 extends tx_imagecycle_pi1
{
	var $prefixId      = 'tx_jfspacegallery_pi1';
	var $scriptRelPath = 'pi1/class.tx_jfspacegallery_pi1.php';
	var $extKey        = 'jfspacegallery';
	var $pi_checkCHash = true;

	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content, $conf)
	{
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();

		// define the key of the element
		$this->contentKey = "jfspacegallery";

		// set the system language
		$this->sys_language_uid = $GLOBALS['TSFE']->sys_language_content;

		if ($this->cObj->data['list_type'] == $this->extKey.'_pi1') {
			$this->type = 'normal';
			// It's a content, al data from flexform
			// Set the Flexform information
			$this->pi_initPIflexForm();
			$piFlexForm = $this->cObj->data['pi_flexform'];
			foreach ($piFlexForm['data'] as $sheet => $data) {
				foreach ($data as $lang => $value) {
					foreach ($value as $key => $val) {
						$this->lConf[$key] = $this->pi_getFFvalue($piFlexForm, $key, $sheet);
					}
				}
			}

			// define the key of the element
			$this->contentKey .= "_c" . $this->cObj->data['uid'];

			// define the images
			switch ($this->lConf['mode']) {
				case "" : {}
				case "folder" : {}
				case "upload" : {
					$this->setDataUpload();
					break;
				}
				case "dam" : {
					$this->setDataDam(false, 'tt_content', $this->cObj->data['uid']);
					break;
				}
				case "dam_catedit" : {
					$this->setDataDam(true, 'tt_content', $this->cObj->data['uid']);
					break;
				}
			}
			// Override the config with flexform data
			if ($this->lConf['imagewidth']) {
				$this->conf['imagewidth'] = $this->lConf['imagewidth'];
			}
			if ($this->lConf['imageheight']) {
				$this->conf['imageheight'] = $this->lConf['imageheight'];
			}
			if ($this->lConf['border']) {
				$this->conf['border'] = $this->lConf['border'];
			}
			if ($this->lConf['duration']) {
				$this->conf['duration'] = $this->lConf['duration'];
			}
			if ($this->lConf['perspective']) {
				$this->conf['perspective'] = $this->lConf['perspective'];
			}
			if ($this->lConf['minScale']) {
				$this->conf['minScale'] = $this->lConf['minScale'];
			}
			if ($this->lConf['loadingClass']) {
				$this->conf['loadingClass'] = $this->lConf['loadingClass'];
			}
			$this->conf['options'] = $this->lConf['options'];
		}

		$data = array();
		foreach ($this->images as $key => $image) {
			$data[$key]['image']   = $image;
			$data[$key]['href']    = $this->hrefs[$key];
			$data[$key]['caption'] = ($this->conf['showcaption'] ? $this->captions[$key] : '');
		}

		return $this->parseTemplate($data);
	}

	/**
	 * Parse all images into the template
	 * @param $data
	 * @return string
	 */
	function parseTemplate($data=array(), $dir='', $onlyJS=false)
	{
		// define the directory of images
		if ($dir == '') {
			$dir = $this->imageDir;
		}

		// Check if $data is array
		if (count($data) == 0 && $onlyJS === false) {
			return false;
		}

		// define the contentKey if not exist
		if ($this->contentKey == '') {
			$this->contentKey = "jfspacegallery_key";
		}

		// define the jQuery mode and function
		if ($this->conf['jQueryNoConflict']) {
			$jQueryNoConflict = "jQuery.noConflict();";
		} else {
			$jQueryNoConflict = "";
		}

		$options = array();

		if (! $this->conf['imagewidth']) {
			$this->conf['imagewidth'] = ($this->conf['imagewidth'] ? $this->conf['imagewidth'] : "200c");
		}
		if (! $this->conf['imageheight']) {
			$this->conf['imageheight'] = ($this->conf['imageheight'] ? $this->conf['imageheight'] : "200c");
		}
		if ($this->conf['border']) {
			$options['border'] = "border: {$this->conf['border']}";
		}
		if ($this->conf['duration']) {
			$options['duration'] = "duration: {$this->conf['duration']}";
		}
		if ($this->conf['perspective']) {
			$options['perspective'] = "perspective: {$this->conf['perspective']}";
		}
		if ($this->conf['minScale']) {
			$options['minScale'] = "minScale: {$this->conf['minScale']}";
		}
		if ($this->conf['loadingClass']) {
			$options['loadingClass'] = "loadingClass: {$this->conf['loadingClass']}";
		}

		// overwrite all options if set
		if (trim($this->conf['options'])) {
			$options = array($this->conf['options']);
		}

		// define the js file
		$this->addJsFile($this->conf['jQueryCycle']);

		// define the css file
		$this->addCssFile($this->conf['cssFile']);

		// The template for JS
		if (! $this->templateFileJS = $this->cObj->fileResource($this->conf['templateFileJS'])) {
			$this->templateFileJS = $this->cObj->fileResource("EXT:jfspacegallery/res/tx_jfspacegallery_pi1.js");
		}
		// get the Template of the Javascript
		if (! $templateCode = trim($this->cObj->getSubpart($this->templateFileJS, "###TEMPLATE_JS###"))) {
			$templateCode = "alert('Template TEMPLATE_JS is missing')";
		}
		// set the key
		$markerArray = array();
		$markerArray["KEY"] = $this->contentKey;
		$markerArray["OPTIONS"] = implode(",\n		", $options);
		// set the markers
		$templateCode = $this->cObj->substituteMarkerArray($templateCode, $markerArray, '###|###', 0);

		$this->addJS($jQueryNoConflict . $templateCode);

		// Add the ressources
		$this->addResources();

		if ($onlyJS === true) {
			return true;
		}

		$return_string = null;
		$images = null;
		$pager = null;
		$GLOBALS['TSFE']->register['key'] = $this->contentKey;
		$GLOBALS['TSFE']->register['imagewidth']  = $this->conf['imagewidth'];
		$GLOBALS['TSFE']->register['imageheight'] = $this->conf['imageheight'];
		$GLOBALS['TSFE']->register['showcaption'] = $this->conf['showcaption'];
		$GLOBALS['TSFE']->register['IMAGE_NUM_CURRENT'] = 0;
		if (count($data) > 0) {
			foreach ($data as $key => $item) {
				$image = null;
				$imgConf = $this->conf['cycle.'][$this->type.'.']['image.'];
				$totalImagePath = $dir . $item['image'];
				$GLOBALS['TSFE']->register['file']    = $totalImagePath;
				$GLOBALS['TSFE']->register['href']    = $item['href'];
				$GLOBALS['TSFE']->register['caption'] = $item['caption'];
				$GLOBALS['TSFE']->register['CURRENT_ID'] = $GLOBALS['TSFE']->register['IMAGE_NUM_CURRENT'] + 1;
				if ($this->hrefs[$key]) {
					$imgConf['imageLinkWrap.'] = $imgConf['imageHrefWrap.'];
				}
				$image = $this->cObj->IMAGE($imgConf);
				$image = $this->cObj->typolink($image, $imgConf['imageLinkWrap.']);
				if ($item['caption'] && $this->conf['showcaption']) {
					$image = $this->cObj->stdWrap($image, $this->conf['cycle.'][$this->type.'.']['captionWrap.']);
				}
				$image = $this->cObj->stdWrap($image, $this->conf['cycle.'][$this->type.'.']['itemWrap.']);
				$images .= $image;
				// create the pager
				if ($this->conf['showPager']) {
					$pager .= trim($this->cObj->cObjGetSingle($this->conf['cycle.'][$this->type.'.']['pager'], $this->conf['cycle.'][$this->type.'.']['pager.']));
				}
				$GLOBALS['TSFE']->register['IMAGE_NUM_CURRENT'] ++;
			}
			$markerArray['PAGER'] = $this->cObj->stdWrap($pager, $this->conf['cycle.'][$this->type.'.']['pagerWrap.']);
			// the stdWrap
			$images = $this->cObj->stdWrap($images, $this->conf['cycle.'][$this->type.'.']['stdWrap.']);
			$return_string = $this->cObj->substituteMarkerArray($images, $markerArray, '###|###', 0);
		}
		return $return_string;
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/jfspacegallery/pi1/class.tx_jfspacegallery_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/jfspacegallery/pi1/class.tx_jfspacegallery_pi1.php']);
}

?>