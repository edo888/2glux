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

class SexypollingViewManagepolls extends JView {
	
	function display($tpl = null) {
		//get the poll
		$poll		=& $this->get('Data');
		$limit		=& $this->get('Limit');
		$categories		=& $this->get('Categories');
		$templates		=& $this->get('Templates');
		$isNew		= ($poll->id < 1);
 
		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Sexy Poll' ).': <small><small>[ ' . $text.' ]</small></small>','manage.png' );
		
		if(!($isNew && $limit >= 2))
			JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::apply();
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}
 
		$this->assignRef('poll',$poll);
		$this->assignRef('limit',$limit);
		$this->assignRef('new',$isNew);
		$this->assignRef('categories',$categories);
		$this->assignRef('templates',$templates);
 
		parent::display($tpl);
	}
}