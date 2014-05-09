<?php
/**
 * Joomla! 1.5 component sexy_polling
 *
 * @version $Id: view.html.php 2012-04-05 14:30:25 svn $
 * @author Simon Poghosyan
 * @package Joomla
 * @subpackage sexy_polling
 * @license GNU/GPL
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class SexypollingViewManageanswers extends JView {
	
	function display($tpl = null) {
		//get the poll
		$answer		=& $this->get('Data');
		$polls		=& $this->get('Polls');
		
		$isNew		= ($answer->id < 1);
 
		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Sexy Answers' ).': <small><small>[ ' . $text.' ]</small></small>','manage.png' );
		JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}
 
		$this->assignRef('answer',		$answer);
		$this->assignRef('polls',		$polls);
 
		parent::display($tpl);
	}
}