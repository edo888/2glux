<?php
/**
 * Joomla! 1.5 component sexy_polling
 *
 * @version $Id: templates.php 2012-04-05 14:30:25 svn $
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

jimport( 'joomla.application.component.controller' );
require_once( JPATH_COMPONENT.DS.'helpers'.DS.'helper.php' );

$document =& JFactory::getDocument();
$cssFile = JURI::base(true).'/components/com_sexypolling/assets/css/colorpicker.css';
$document->addStyleSheet($cssFile, 'text/css', null, array());

$cssFile = JURI::base(true).'/components/com_sexypolling/assets/css/layout.css';
$document->addStyleSheet($cssFile, 'text/css', null, array());

$cssFile = JURI::base(true).'/components/com_sexypolling/assets/css/temp.css';
$document->addStyleSheet($cssFile, 'text/css', null, array());

$cssFile = JURI::base(true).'/components/com_sexypolling/assets/css/jquery-ui-1.7.1.custom.css';
$document->addStyleSheet($cssFile, 'text/css', null, array());

$cssFile = JURI::base(true).'/components/com_sexypolling/assets/css/ui.slider.extras.css';
$document->addStyleSheet($cssFile, 'text/css', null, array());

$cssFile = JURI::base(true).'/components/com_sexypolling/assets/css/main.css';
$document->addStyleSheet($cssFile, 'text/css', null, array());

$jsFile = JURI::base(true).'/components/com_sexypolling/assets/js/jquery-1.7.2.min.js';
$document->addScript($jsFile);

$document->addScriptDeclaration ( 'jQuery.noConflict();' );

$jsFile = JURI::base(true).'/components/com_sexypolling/assets/js/colorpicker.js';
$document->addScript($jsFile);

$jsFile = JURI::base(true).'/components/com_sexypolling/assets/js/eye.js';
$document->addScript($jsFile);

$jsFile = JURI::base(true).'/components/com_sexypolling/assets/js/utils.js';
$document->addScript($jsFile);

$jsFile = JURI::base(true).'/components/com_sexypolling/assets/js/layout.js?ver=1.0.2';
//$document->addScript($jsFile);



/**
 * sexy_polling Controller
 *
 * @package Joomla
 * @subpackage sexy_polling
 */
class SexypollingControllerTemplates extends SexypollingController {

	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();
 
		// Register Extra tasks
		$this->registerTask( 'unpublish', 	'publish');
	}
 
	/**
	 * display the edit form
	 * @return void
	 */
	function edit()
	{
		JRequest::setVar( 'view', 'managetemplates' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('hidemainmenu', 1);
 
		parent::display();
	}
	function add()
	{
		JRequest::setVar( 'view', 'managetemplates' );
		JRequest::setVar( 'layout', 'add'  );
		JRequest::setVar('hidemainmenu', 1);
 
		parent::display();
	}
	
	/**
	 * save a record (and redirect to main page)
	 * @return void
	 */
	function save()
	{
		$model = $this->getModel('managetemplates');
	
		if ($model->store($post)) {
			$msg = JText::_( 'Template Saved!' );
		} else {
			$msg = JText::_( 'Error Saving Template' );
		}
	
		// Check the table in so it can be edited.... we are done with it anyway
		$link = 'index.php?option=com_sexypolling&view=sexytemplates';
		$this->setRedirect($link, $msg);
	}
	
	/**
	 * save a record (no redirect)
	 * @return void
	 */
	function apply()
	{
		$model = $this->getModel('managetemplates');
		$id = JRequest::getInt('id',0);
	
		if ($model->store()) {
			$msg = JText::_( 'Template Saved!' );
		} else {
			$msg = JText::_( 'Error Saving Template' );
		}
	
		// Check the table in so it can be edited.... we are done with it anyway
		$link = 'index.php?option=com_sexypolling&controller=templates&task=edit&cid[]='.$id;
		$this->setRedirect($link, $msg);
	}
	
	/**
	 * publish a record (and redirect to main page)
	 * @return void
	 */
	function publish()
	{
		$publish = ( $this->getTask() == 'publish' ? 1 : 0 );
		$model = $this->getModel('managetemplates');
		if(!$model->publish($publish)) {
			$msg = JText::_( 'Error: One or More Polls Could not be Published' );
		} else {
			$msg = '';
		}
	
		$this->setRedirect( 'index.php?option=com_sexypolling&view=sexytemplates', $msg );
	}
	
	/**
	 * remove record(s)
	 * @return void
	 */
	function remove()
	{
		$model = $this->getModel('managetemplates');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or More Templates Could not be Deleted' );
		} else {
			$msg = JText::_( 'Template(s) Deleted' );
		}
	
		$this->setRedirect( 'index.php?option=com_sexypolling&view=sexytemplates', $msg );
	}
	
	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_sexypolling&view=sexytemplates', $msg );
	}
}
?>