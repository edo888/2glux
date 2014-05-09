<?php
/**
 * Joomla! 1.5 component sexy_polling
 *
 * @version $Id: view.html.php 2012-04-05 14:30:25 svn $
 * @author Simon Poghosyan
 * @package Joomla
 * @subpackage sexypolling
 * @license GNU/GPL
 *
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class SexypollingViewShowStatistics extends JView {
	
	function display($tpl = null) {
		//get the poll
		$poll		=& $this->get('Data');
		$categories		=& $this->get('Categories');
		$templates		=& $this->get('Templates');
 
		JToolBarHelper::cancel( 'cancel', 'Close' );
 
		$this->assignRef('poll',$poll);
		$this->assignRef('limit',$limit);
		$this->assignRef('new',$isNew);
		$this->assignRef('categories',$categories);
		$this->assignRef('templates',$templates);
 
		parent::display($tpl);
	}
}