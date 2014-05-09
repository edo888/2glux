<?php
/**
 * Joomla! 1.5 component sexy_polling
 *
 * @version $Id: categories.php 2012-04-05 14:30:25 svn $
 * @author Simon Poghosyan
 * @package Joomla
 * @subpackage sexy_polling
 * @license GNU/GPL
 *
 * Sexy Polling
 *
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class SexypollingControllerCategories extends SexypollingController {

	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();
 
		// Register Extra tasks
		$this->registerTask( 'add', 	'edit');
		$this->registerTask( 'unpublish', 	'publish');
	}
 
	/**
	 * display the edit form
	 * @return void
	 */
	function edit()
	{
		JRequest::setVar( 'view', 'managecategories' );
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
		$model = $this->getModel('managecategories');
	
		if ($model->store()) {
			$msg = JText::_( 'Category Saved!' );
		} else {
			$msg = JText::_( 'Error Saving Category' );
		}
	
		// Check the table in so it can be edited.... we are done with it anyway
		$link = 'index.php?option=com_sexypolling&view=sexycategories';
		$this->setRedirect($link, $msg);
	}
	
	/**
	 * save a record (no redirect)
	 * @return void
	 */
	function apply()
	{
		$model = $this->getModel('managecategories');
		$id = JRequest::getInt('id',0);
	
		if ($model->store()) {
			$msg = JText::_( 'Category Saved!' );
		} else {
			$msg = JText::_( 'Error Saving Category' );
		}
	
		// Check the table in so it can be edited.... we are done with it anyway
		$link = 'index.php?option=com_sexypolling&controller=categories&task=edit&cid[]='.$id;
		$this->setRedirect($link, $msg);
	}
	
	/**
	 * publish a record (and redirect to main page)
	 * @return void
	 */
	function publish()
	{
		$publish = ( $this->getTask() == 'publish' ? 1 : 0 );
		$model = $this->getModel('managecategories');
		if(!$model->publish($publish)) {
			$msg = JText::_( 'Error: One or More Categories Could not be Published' );
		} else {
			$msg = '';
		}
	
		$this->setRedirect( 'index.php?option=com_sexypolling&view=sexycategories', $msg );
	}
	
	/**
	 * remove record(s)
	 * @return void
	 */
	function remove()
	{
		$model = $this->getModel('managecategories');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or More Categories Could not be Deleted' );
		} else {
			$msg = JText::_( 'Category(s) Deleted' );
		}
	
		$this->setRedirect( 'index.php?option=com_sexypolling&view=sexycategories', $msg );
	}
	
	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_sexypolling&view=sexycategories', $msg );
	}
	
	function saveordercategories()
	{
		$cid 	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$order 	= JRequest::getVar( 'order', array(0), 'post', 'array' );
		JArrayHelper::toInteger($order, array(0));
	
		$model = $this->getModel('managecategories');
		$model->saveorder($cid, $order);
	
		$msg = 'New ordering saved';
		$this->setRedirect('index.php?option=com_sexypolling&view=sexycategories', $msg);
	}
}
?>