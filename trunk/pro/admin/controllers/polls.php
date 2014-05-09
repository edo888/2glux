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
class SexypollingControllerPolls extends SexypollingController {

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
		JRequest::setVar( 'view', 'managepolls' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('hidemainmenu', 1);
 
		parent::display();
	}
	
	/**
	 * save a record (and redirect to main page)
	 * @return void
	 */
	function save()
	{
		$model = $this->getModel('managepolls');
	
		$rsp = $model->store($post);
		
		if ($rsp === 'count_limit') {
			$msg = JText::_( 'Buy <a style="font-style: italic;text-decoration: underline" href="http://2glux.com/projects/sexypolling" target="_blank">Pro Version</a> to have more that 2 polls' );
		} elseif($rsp) {
			$msg = JText::_( 'Poll Saved!' );
		} else {
			$msg = JText::_( 'Error Saving Poll' );
		}
	
		// Check the table in so it can be edited.... we are done with it anyway
		$link = 'index.php?option=com_sexypolling&view=sexypolls';
		$this->setRedirect($link, $msg);
	}
	
	/**
	 * save a record (no redirect)
	 * @return void
	 */
	function apply()
	{
		$model = $this->getModel('managepolls');
		$id = JRequest::getInt('id',0);
	
		if ($model->store($post)) {
			$msg = JText::_( 'Poll Saved!' );
		} else {
			$msg = JText::_( 'Error Saving Poll' );
		}
	
		// Check the table in so it can be edited.... we are done with it anyway
		$link = 'index.php?option=com_sexypolling&controller=polls&task=edit&cid[]='.$id;
		$this->setRedirect($link, $msg);
	}
	
	/**
	 * publish a record (and redirect to main page)
	 * @return void
	 */
	function publish()
	{
		$publish = ( $this->getTask() == 'publish' ? 1 : 0 );
		$model = $this->getModel('managepolls');
		if(!$model->publish($publish)) {
			$msg = JText::_( 'Error: One or More Polls Could not be Published' );
		} else {
			$msg = '';
		}
	
		$this->setRedirect( 'index.php?option=com_sexypolling&view=sexypolls', $msg );
	}
	
	/**
	 * remove record(s)
	 * @return void
	 */
	function remove()
	{
		$model = $this->getModel('managepolls');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or More Polls Could not be Deleted' );
		} else {
			$msg = JText::_( 'Poll(s) Deleted' );
		}
	
		$this->setRedirect( 'index.php?option=com_sexypolling&view=sexypolls', $msg );
	}
	
	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_sexypolling', $msg );
	}
	
	function saveorderpolls()
	{
		$cid 	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$order 	= JRequest::getVar( 'order', array(0), 'post', 'array' );
		JArrayHelper::toInteger($order, array(0));
	
		$model = $this->getModel('managepolls');
		$model->saveorder($cid, $order);
	
		$msg = 'New ordering saved';
		$this->setRedirect('index.php?option=com_sexypolling&view=sexypolls', $msg);
	}
}
?>