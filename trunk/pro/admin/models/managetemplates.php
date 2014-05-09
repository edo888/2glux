<?php
/**
 * Joomla! 1.5 component sexy_polling
 *
 * @version $Id: managetemplates.php 2012-04-05 14:30:25 svn $
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

class SexypollingModelManagetemplates extends JModel {
	
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
		$this->_list	= null;
	}

	/**
	 * Method to get a sexy template
	 * @return object with data
	 */
	function getData()
	{
		// Load the data
		if (empty( $this->_data )) {
			$query = ' SELECT * FROM #__sexy_templates '.
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
	 * Method to get a all sexy templates
	 * @return object with data
	 */
	function getList()
	{
		// Load the data
		if (empty( $this->_list )) {
			$query = ' SELECT * FROM #__sexy_templates '.
					' ORDER BY name';
			$this->_list = $this->_getList($query);
		}
		return $this->_list;
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
			
			$query = ' SELECT * FROM #__sexy_templates '.
					'  WHERE id = '.JRequest::getInt('id_template',0);;
			$this->_db->setQuery( $query );
			$tmp = $this->_db->loadObject();
			
			
			
			$new_template = new JObject();
		 	$new_template->id = NULL;
		  	$new_template->name = htmlspecialchars(JRequest::getString('name'), ENT_QUOTES);
		  	$new_template->published = JRequest::getInt('published',1);
		  	$new_template->styles = $tmp->styles;
		  	
		  	if (!$this->_db->insertObject( '#__sexy_templates', $new_template, 'id' ))
		    	return false;
		} 
		else { //else update the record
			$new_template = new JObject();
			$new_template->id = $id;
		  	$new_template->name = htmlspecialchars(JRequest::getString('name'), ENT_QUOTES);
			$styles = JRequest::getVar('styles');
			$styles_formated = '';
			$ind = 0;
			foreach($styles as $k => $val) {
				$styles_formated .= $k.'~'.$val;
				if($ind != sizeof($styles) - 1)
					$styles_formated .= '|';
				$ind ++;
			}
			
			$new_template->styles = $styles_formated;
			 
			if (!$this->_db->updateObject( '#__sexy_templates', $new_template, 'id' ))
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
				$sql = 'DELETE FROM `#__sexy_templates` '
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
			$query = 'UPDATE #__sexy_templates'
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
}