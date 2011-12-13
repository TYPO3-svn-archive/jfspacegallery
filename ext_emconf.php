<?php

########################################################################
# Extension Manager/Repository config file for ext "jfspacegallery".
#
# Auto generated 13-12-2011 23:33
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Spacegallery',
	'description' => 'Shows image in a spacegallery. Requires EXT:imagecycle. Add media from DAM and DAM-Category. Use t3jquery for better integration with other jQuery extensions.',
	'category' => 'plugin',
	'author' => 'Juergen Furrer',
	'author_email' => 'juergen.furrer@gmail.com',
	'shy' => '',
	'dependencies' => 'cms,imagecycle,jftcaforms',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => 'uploads/tx_imagecycle',
	'modify_tables' => '',
	'clearCacheOnLoad' => 1,
	'lockType' => '',
	'author_company' => '',
	'version' => '0.2.6',
	'constraints' => array(
		'depends' => array(
			'cms' => '',
			'php' => '5.0.0-0.0.0',
			'typo3' => '4.3.0-4.99.999',
			'imagecycle' => '2.4.0-0.0.0',
			'jftcaforms' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:22:{s:12:"ext_icon.gif";s:4:"d070";s:17:"ext_localconf.php";s:4:"d320";s:14:"ext_tables.php";s:4:"e2e1";s:15:"flexform_ds.xml";s:4:"d51a";s:13:"locallang.xml";s:4:"8b48";s:16:"locallang_db.xml";s:4:"3049";s:12:"t3jquery.txt";s:4:"4bc6";s:14:"doc/manual.sxw";s:4:"d045";s:42:"lib/class.tx_jfspacegallery_cms_layout.php";s:4:"6012";s:14:"pi1/ce_wiz.gif";s:4:"2d0e";s:35:"pi1/class.tx_jfspacegallery_pi1.php";s:4:"a652";s:43:"pi1/class.tx_jfspacegallery_pi1_wizicon.php";s:4:"4067";s:17:"pi1/locallang.xml";s:4:"e8a5";s:28:"res/tx_jfspacegallery_pi1.js";s:4:"bf01";s:17:"res/css/style.css";s:4:"5726";s:22:"res/img/ajax_small.gif";s:4:"c02b";s:17:"res/img/blank.gif";s:4:"5639";s:33:"res/jquery/js/jquery-1.7.1.min.js";s:4:"ddb8";s:34:"res/jquery/js/jquery.easing-1.3.js";s:4:"6516";s:36:"res/jquery/js/jquery.spacegallery.js";s:4:"f8bc";s:20:"static/constants.txt";s:4:"e337";s:16:"static/setup.txt";s:4:"9b1d";}',
	'suggests' => array(
	),
);

?>