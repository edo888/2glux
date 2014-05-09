<?php
/**
 * Joomla! 1.5 component sexy_polling
 *
 * @version $Id: uninstall.package.php 2012-04-05 14:30:25 svn $
 * @author Simon Poghosyan
 * @package Joomla
 * @subpackage sexy_polling
 * @license GNU/GPL
 *
 * Sexy Polling
 *
 */
defined("_JEXEC") or die("Restricted access");


// uninstalling sexypolling module
jimport('joomla.installer.installer');
$db = & JFactory::getDBO();


if(!version_compare(JVERSION,'1.6.0','lt')) {
	$sql = 'SELECT `extension_id` AS id, `name`, `element`, `folder` FROM #__extensions WHERE `type` = "module" AND ('
	. '(`element` = "mod_sexypolling") ) ';
} else {
	$sql = 'SELECT `id` FROM #__modules WHERE ('
	. '(`module` = "mod_sexypolling") ) ';
}
$db->setQuery($sql);
$sexy_polling_module = $db->loadObject();
$module_uninstaller = new JInstaller;
if($module_uninstaller->uninstall('module', $sexy_polling_module->id))
    echo 'Module uninstall success<br />';
else
    echo 'Module uninstall failed<br />';