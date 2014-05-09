<?php
/**
 * Joomla! 1.5 component sexy_polling
 *
 * @version $Id: sexypolls.php 2012-04-05 14:30:25 svn $
 * @author Simon Poghosyan
 * @package Joomla
 * @subpackage sexy_polling
 * @license GNU/GPL
 *
 * Sexy Polling
 *
 * This component file was created using the Joomla Component Creator by Not Web Design
 * http://www.notwebdesign.com/joomla_component_creator/
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport('joomla.application.component.model');

class SexypollingModelSexypolls extends JModel {
    function __construct() {
		parent::__construct();
		
		$app	 = &JFactory::getApplication();
		$params	 = &$app->getParams();
		$id_16 = $params->get('category',0);
		
		$id_15 = JRequest::getVar('category',  0, '', 'int');
		$id = $id_15 != 0 ? $id_15 : $id_16;
		$this->setId($id);
    }
    
function setId($id)
	{
		// Set id and wipe data
		$this->_id		= $id;
		$this->_data	= null;
	}

	/**
	 * Method to get a hello
	 * @return object with data
	 */
	function getData()
	{
		// Load the data
		if (empty( $this->_data )) {
			$query = 'SELECT '.
						'sp.id polling_id, '.
						'sp.date_start date_start, '.
						'sp.date_end date_end, '.
						'sp.multiple_answers multiple_answers, '.
						'st.styles styles, '.
						'sp.name polling_name, '.
						'sp.question polling_question, '.
						'sa.id answer_id, '.
						'sa.name answer_name '.
					'FROM '.
						'`#__sexy_polls` sp '.
					'JOIN '.
						'`#__sexy_answers` sa ON sa.id_poll = sp.id '.
						'AND sa.published = \'1\' '.
					'LEFT JOIN '.
						'`#__sexy_templates` st ON st.id = sp.id_template '.
					'WHERE sp.published = \'1\' '.
					'AND sp.id_category = '.$this->_id.' '.
						'ORDER BY sp.order,sp.name,sa.order,sa.name';
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObjectList();
		}
		if (!$this->_data) {
			$this->_data = new stdClass();
			$this->_data->polling_id = 0;
			$this->_data->polling_name = null;
		}
		return $this->_data;
	}
    
}
?>