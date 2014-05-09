<?php
/**
 * Joomla! 1.5 component sexy_polling
 *
 * @version $Id: controller.php 2012-04-05 14:30:25 svn $
 * @author Simon Poghosyan
 * @package Joomla
 * @subpackage sexypolling
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
class SexypollingController extends JController {

    function display()
    {
		//Create Submenu
		addSub( 'Overview', 'sexypolling');
		addSub( 'Polls', 'sexypolls');
		addSub( 'Answers', 'sexyanswers');
		addSub( 'Categories', 'sexycategories');
		addSub( 'Templates', 'sexytemplates');
		addSub( 'Statistics', 'sexystatistics');
		
		//Set the default view, just in case
		$view = JRequest::getCmd('view');
		if(empty($view)) {
			JRequest::setVar('view', 'sexypolling');
		};

		parent::display();
    }// function
}
?>