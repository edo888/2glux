<?php
/**
 * Joomla! 1.5 component sexy_polling
 *
 * @version $Id: managepolls.php 2012-04-05 14:30:25 svn $
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

// Import Joomla! libraries
jimport('joomla.application.component.model');
jimport( 'joomla.utilities.date' );

class SexypollingModelManagepolls extends JModel {
	
	/**
	 * Constructor that retrieves the ID from the request
	 *
	 * @access	public
	 * @return	void
	 */
	function __construct()
	{
		parent::__construct();

		$array = JRequest::getVar('cid',  0, '', 'array');
		$this->setId((int)$array[0]);
	}

	/**
	 * Method to set the hello identifier
	 *
	 * @access	public
	 * @param	int Hello identifier
	 * @return	void
	 */
	function setId($id)
	{
		// Set id and wipe data
		$this->_id		= $id;
		$this->_data	= null;
		$this->_categories	= null;
		$this->_templates	= null;
	}

	/**
	 * Method to get a hello
	 * @return object with data
	 */
	function getData()
	{
		// Load the data
		if (empty( $this->_data )) {
			$query = ' SELECT * FROM #__sexy_polls '.
					'  WHERE id = '.$this->_id;
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
		}
		if (!$this->_data) {
			$this->_data = new stdClass();
			$this->_data->id = 0;
			$this->_data->name = null;
		}
		return $this->_data;
	}
	
	/**
	 * Method to get a hello
	 * @return object with data
	 */
	function getLimit()
	{
		//set limit
		$sql = "SELECT COUNT(id) `count_polls` FROM `#__sexy_polls`";
		$this->_db->setQuery($sql);
		$count = $this->_db->loadResult();
		return $count;
	}
	
	/**
	 * Method to get a categories
	 * @return object with data
	 */
	function &getCategories()
	{
		// Load the data
		if (empty( $this->_categories )) {
			$query = ' SELECT * FROM #__sexy_categories ';
			$this->_db->setQuery( $query );
			$this->_categories = $this->_db->loadObjectList();
		}
		if (!$this->_categories) {
			$this->_categories = new stdClass();
			$this->_categories->id = 0;
			$this->_categories->name = null;
		}
		return $this->_categories;
	}
	
	/**
	 * Method to get a templates
	 * @return object with data
	 */
	function &getTemplates()
	{
		// Load the data
		if (empty( $this->_templates )) {
			$query = ' SELECT * FROM #__sexy_templates ';
			$this->_db->setQuery( $query );
			$this->_templates = $this->_db->loadObjectList();
		}
		if (!$this->_templates) {
			$this->_templates = new stdClass();
			$this->_templates->id = 0;
			$this->_templates->name = null;
		}
		return $this->_templates;
	}

	/**
	 * Method to store a record
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function store()
	{	
		$date = new JDate();
		$id = JRequest::getInt('id',0);
		
		//if id ==0, we add the record
		if($id == 0) {
			
			$new_poll = new JObject();
		 	$new_poll->id = NULL;
		 	$new_poll->date = $date->toMySQL();
		  	$new_poll->name = htmlspecialchars(JRequest::getString('name'), ENT_QUOTES);
		  	$new_poll->question = htmlspecialchars(JRequest::getString('question'), ENT_QUOTES);
		  	$new_poll->date_start = JRequest::getString('date_start');
		  	$new_poll->date_end = JRequest::getString('date_end');
		  	$new_poll->published = JRequest::getInt('published',1);
		  	$new_poll->multiple_answers = JRequest::getInt('multiple_answers',0);
		  	$new_poll->id_category = JRequest::getInt('id_category',0);
		  	$new_poll->id_template = JRequest::getInt('id_template',0);
		  	$new_poll->alias = JRequest::getString('alias') == '' ? JFilterOutput::stringURLSafe(JRequest::getString('name')) : JFilterOutput::stringURLSafe(JRequest::getString('alias'));
		  	
		  	if (!$this->_db->insertObject( '#__sexy_polls', $new_poll, 'id' ))
		    	return false;
		} 
		else { //else update the record
			$new_poll = new JObject();
			$new_poll->id = $id;
			$new_poll->name = htmlspecialchars(JRequest::getString('name'), ENT_QUOTES);
			$new_poll->question = htmlspecialchars(JRequest::getString('question'), ENT_QUOTES);
			$new_poll->published = JRequest::getInt('published',1);
			$new_poll->multiple_answers = JRequest::getInt('multiple_answers',0);
			$new_poll->id_category = JRequest::getInt('id_category',0);
		  	$new_poll->id_template = JRequest::getInt('id_template',0);
		  	$new_poll->date_start = JRequest::getString('date_start');
		  	$new_poll->date_end = JRequest::getString('date_end');
			$new_poll->alias = JRequest::getString('alias') == '' ? JFilterOutput::stringURLSafe(JRequest::getString('name')) : JFilterOutput::stringURLSafe(JRequest::getString('alias'));
			 
			if (!$this->_db->updateObject( '#__sexy_polls', $new_poll, 'id' ))
				return false;
		}

		return true;
	}

	/**
	 * Method to delete record(s)
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function delete()
	{
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		if (count( $cids )) {
			foreach($cids AS $id) {
				$sql = 'DELETE FROM `#__sexy_polls` '
				. ' WHERE `id` = '.$id
				. ' LIMIT 1'; 
				$this->_db->setQuery($sql);
				$this->_db->query();
				if($this->_db->getErrorMsg()) {
					//echo $this->_db->stderr();
					return false;
				}
			}
		}
		
		return true;
	}
	
	/**
	 * Method to delete record(s)
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function publish($publish)
	{
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		
		if (count( $cids )) {
			$cids_sql = implode(',',$cids);
			$query = 'UPDATE #__sexy_polls'
			. ' SET published = ' . (int) $publish
			. ' WHERE id IN ( '. $cids_sql .' )'
			;
			$this->_db->setQuery( $query );
			if (!$this->_db->query())
			{
				JError::raiseError(500, $this->_db->getErrorMsg() );
			}
			
		}
		
		return true;
	}
	
	function saveorder($cid = array(), $order)
	{
		// update ordering values
		for( $i=0; $i < count($cid); $i++ )
		{
			$row = new JObject();
			$row->id = $cid[$i];
			$row->order = $order[$i];
				
			$this->_db->updateObject('#__sexy_polls', $row, 'id');
		}
	
		return true;
	}
}