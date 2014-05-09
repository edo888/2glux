<?php
/**
 * Joomla! 1.5 component sexy_polling
 *
 * @version $Id: managecategories.php 2012-04-05 14:30:25 svn $
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

class SexypollingModelManagecategories extends JModel {
	
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
	}

	/**
	 * Method to get a sexy template
	 * @return object with data
	 */
	function getData()
	{
		// Load the data
		if (empty( $this->_data )) {
			$query = ' SELECT * FROM #__sexy_categories '.
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
			
			
			$new_category = new JObject();
		 	$new_category->id = NULL;
		  	$new_category->name = htmlspecialchars(JRequest::getString('name'), ENT_QUOTES);
		  	$new_category->published = JRequest::getInt('published',1);
		  	
		  	if (!$this->_db->insertObject( '#__sexy_categories', $new_category, 'id' ))
		    	return false;
		} 
		else { //else update the record
			$new_category = new JObject();
			$new_category->id = $id;
		  	$new_category->name = htmlspecialchars(JRequest::getString('name'), ENT_QUOTES);
			 
			if (!$this->_db->updateObject( '#__sexy_categories', $new_category, 'id' ))
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
				$sql = 'DELETE FROM `#__sexy_categories` '
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
			$query = 'UPDATE #__sexy_categories'
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
	
			$this->_db->updateObject('#__sexy_categories', $row, 'id');
		}
	
		return true;
	}
}