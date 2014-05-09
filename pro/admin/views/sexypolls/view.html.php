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
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class SexypollingViewsexypolls extends JView {
    function display($tpl = null) {
    	
		JToolBarHelper::deleteList();
        JToolBarHelper::editListX();
        JToolBarHelper::addNewX();
        JToolBarHelper::publishList();
        JToolBarHelper::unpublishList();
        JToolBarHelper::preferences('com_sexypolling', '500');
 
        // Get data from the model
        $items =& $this->get( 'Data');
        $filter = $this->get('Filter');
        $pagination = $this->get('Pagination');
        
        $this->assignRef( 'items', $items );
        $this->assignRef('filter', $filter);
        $this->assignRef('pagination', $pagination);
 
        parent::display($tpl);
    }
}