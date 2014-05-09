<?php
/**
 * Joomla! 1.5 component sexy_polling
 *
 * @version $Id: answers.php 2012-04-05 14:30:25 svn $
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
class SexypollingControlleranswers extends SexypollingController {

	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();
 
		// Register Extra tasks
		$this->registerTask( 'add'  , 	'edit' );
		$this->registerTask( 'unpublish', 	'publish');
	}
 
	/**
	 * display the edit form
	 * @return void
	 */
	function edit()
	{
		JRequest::setVar( 'view', 'manageanswers' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('controller', 'answers');
		JRequest::setVar('hidemainmenu', 1);
 
		parent::display();
	}
	
	/**
	 * save a record (and redirect to main page)
	 * @return void
	 */
	function save()
	{
		$model = $this->getModel('manageanswers');
	
		if ($model->store($post)) {
			$msg = JText::_( 'Answer Saved!' );
		} else {
			$msg = JText::_( 'Error Saving Answer' );
		}
	
		// Check the table in so it can be edited.... we are done with it anyway
		$link = 'index.php?option=com_sexypolling&view=sexyanswers';
		$this->setRedirect($link, $msg);
	}
	
	/**
	 * publish a record (and redirect to main page)
	 * @return void
	 */
	function publish()
	{
		$publish = ( $this->getTask() == 'publish' ? 1 : 0 );
		$model = $this->getModel('manageanswers');
		if(!$model->publish($publish)) {
			$msg = JText::_( 'Error: One or More Answers Could not be Published/Unbublished' );
		} else {
			$msg = '';
		}
	
		$this->setRedirect( 'index.php?option=com_sexypolling&view=sexyanswers', $msg );
	}
	
	/**
	 * remove record(s)
	 * @return void
	 */
	function remove()
	{
		$model = $this->getModel('manageanswers');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or More Answers Could not be Deleted' );
		} else {
			$msg = JText::_( 'Answer(s) Deleted' );
		}
	
		$this->setRedirect( 'index.php?option=com_sexypolling&view=sexyanswers', $msg );
	}
	
	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_sexypolling&view=sexyanswers', $msg );
	}
	
	function saveorderanswers()
	{
		$cid 	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$order 	= JRequest::getVar( 'order', array(0), 'post', 'array' );
		JArrayHelper::toInteger($order, array(0));
	
		$model = $this->getModel('manageanswers');
		$model->saveorder($cid, $order);
	
		$msg = 'New ordering saved';
		$this->setRedirect('index.php?option=com_sexypolling&view=sexyanswers', $msg);
	}
}
?>