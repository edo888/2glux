<?php
/**
 * Joomla! 1.5 component sexypolling
 *
 * @version $Id: sexy_polling.php 2012-04-05 14:30:25 svn $
 * @author Simon Poghosyan
 * @package Joomla
 * @subpackage sexy_polling
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

// Require the base controller
require_once JPATH_COMPONENT.DS.'helpers'.DS.'helper.php';

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


$document =& JFactory::getDocument();
$cssFile = JURI::base(true).'/components/com_sexypolling/assets/css/icons.css';
$document->addStyleSheet($cssFile, 'text/css', null, array());

// Perform the Request task
$controller->execute( JRequest::getCmd('task'));
$controller->redirect();

function addSub($title, $v, $controller = null, $image = null) {

	$enabled = false;
	$view = JRequest::getWord("view", 'sexypolling');
	if($view == $v) {
		$img = $v;
		if($image != null) $img = $image;
		JToolBarHelper::title(   JText::_( $title).' - '.( 'Sexy Polling' ), $img.'.png' );
		$enabled = true;
	}
	$link = 'index.php?option=com_sexypolling&view='.$v;
	if($controller != null) $link .= '&controller='.$controller;
	JSubMenuHelper::addEntry( JText::_($title), $link, $enabled);
}