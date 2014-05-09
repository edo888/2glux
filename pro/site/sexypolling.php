<?php
/**
 * Joomla! 1.5 component sexy_polling
 *
 * @version $Id: sexy_polling.php 2012-04-05 14:30:25 svn $
 * @author Simon Poghosyan
 * @package Joomla
 * @subpackage sexypolling
 * @license GNU/GPL
 *
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');


/*
 * Define constants for all pages
 */
define( 'COM_SEXY_POLLING_DIR', 'images'.DS.'sexy_polling'.DS );
define( 'COM_SEXY_POLLING_BASE', JPATH_ROOT.DS.COM_SEXY_POLLING_DIR );
define( 'COM_SEXY_POLLING_BASEURL', JURI::root().str_replace( DS, '/', COM_SEXY_POLLING_DIR ));

// Require the base controller
require_once JPATH_COMPONENT.DS.'controller.php';


require_once( JPATH_COMPONENT.DS.'controller.php' );

// Require specific controller if requested
if($controller = JRequest::getWord('controller')) {
	$path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
	if (file_exists($path)) {
		require_once $path;
	} else {
		$controller = '';
	}
}

// Initialize the controller
$classname    = 'SexypollingController'.$controller;
$controller   = new $classname( );


// Perform the Request task
echo JRequest::getCmd('task');
$controller->execute( JRequest::getCmd('task'));
$controller->redirect();