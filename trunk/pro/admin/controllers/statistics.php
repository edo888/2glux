<?php
/**
 * Joomla! 1.5 component sexy_polling
 *
 * @version $Id: polls.php 2012-04-05 14:30:25 svn $
 * @author Simon Poghosyan
 * @package Joomla
 * @subpackage sexy_polling
 * @license GNU/GPL
 *
 * Sexy Polling
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.controller' );
require_once( JPATH_COMPONENT.DS.'helpers'.DS.'helper.php' );

/**
 * sexy_polling Controller
 *
 * @package Joomla
 * @subpackage sexy_polling
 */
class SexypollingControllerStatistics extends SexypollingController {

	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();
 
	}
 
	/**
	 * display the edit form
	 * @return void
	 */
	function show()
	{
		JRequest::setVar( 'view', 'showstatistics' );
		//JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('hidemainmenu', 1);
 
		parent::display();
	}
	
	
	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
		$msg = JText::_( '' );
		$this->setRedirect( 'index.php?option=com_sexypolling&view=sexystatistics', $msg );
	}
	
}
?>