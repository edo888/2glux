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
 * Sexy Polling
 *
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class SexypollingViewManagetemplates extends JView {
	
	function display($tpl = null) {
		//get the poll
		$template		=& $this->get('Data');
		$templates		=& $this->get('List');
		
		$isNew		= ($template->id < 1);
 
		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Sexy Templates' ).': <small><small>[ ' . $text.' ]</small></small>','manage.png');
		JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
			$this->assignRef('templates',$templates);
		} else {
			JToolBarHelper::apply();
			JToolBarHelper::cancel( 'cancel', 'Close' );
			$this->assignRef('template',$template);
		}
 
 
		parent::display($tpl);
	}
}