<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

// Page module hook
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['list_type_Info']['jfspacegallery_pi1']['jfspacegallery'] = 'EXT:jfspacegallery/lib/class.tx_jfspacegallery_cms_layout.php:tx_jfspacegallery_cms_layout->getExtensionSummary';

t3lib_extMgm::addPItoST43($_EXTKEY, 'pi1/class.tx_jfspacegallery_pi1.php', '_pi1', 'list_type', 1);
?>