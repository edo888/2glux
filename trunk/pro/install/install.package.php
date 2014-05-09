<?php
/**
 * Joomla! 1.5 component sexy_polling
 *
 * @version $Id: install.package.php 2012-04-05 14:30:25 svn $
 * @author Simon Poghosyan
 * @package Joomla
 * @subpackage sexy_polling
 * @license GNU/GPL
 *
 *
 */
defined("_JEXEC") or die("Restricted access");

// installing module
/*$module_installer = new JInstaller;
if($module_installer->install(dirname(__FILE__).DS.'module'))
    echo 'Module install success', '<br />';
else
    echo 'Module install failed', '<br />';
*/
jimport('joomla.installer.installer');
$db = & JFactory::getDBO();

$src = $this->parent->getPath('source');
$installer = new JInstaller;
if($installer->install($src.'/modules/module'))
    echo 'Module install success', '<br />';
else
    echo 'Module install failed', '<br />';

//get ip address
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
	$ip=$_SERVER['HTTP_CLIENT_IP'];
}
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
	$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
}
else {
	$ip=$_SERVER['REMOTE_ADDR'];
}

/*
$query = "UPDATE #__sexy_votes SET ip = '$ip'";
$db->setQuery($query);
$db->query();
*/
