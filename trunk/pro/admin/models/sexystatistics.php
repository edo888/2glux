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
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport('joomla.application.component.model');

class SexypollingModelSexystatistics extends JModel {
var $_data, $_total, $_pagination, $_filter, $_total_sql;
	
    function __construct() {
    	
    	parent::__construct();
    	
    	$this->loadFilter();
    	
    	$mainframe = JFactory::getApplication();
    	
    	$limit      = $mainframe->getUserStateFromRequest( 'com_sexypolling'.'.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
    	$limitstart = $mainframe->getUserStateFromRequest( 'com_sexypolling'.JRequest::getCmd( 'view').'.limitstart', 'limitstart', 0, 'int' );
    	
    	if($limitstart > $this->getTotal()) $limitstart = 0;
    	
    	$search_title				= $mainframe->getUserStateFromRequest( 'com_sexypolling'.'search_title',			'search_title',			'',		'string' );
    	if (strpos($search_title, '"') !== false) {
    		$search_title = str_replace(array('=', '<'), '', $search_title);
    	}
    	$search_title = JString::strtolower($search_title);
    	$this->_filter->search_title = $search_title;
    	$search_question				= $mainframe->getUserStateFromRequest( 'com_sexypolling'.'search_question',			'search_question',			'',		'string' );
    	if (strpos($search_question, '"') !== false) {
    		$search_question = str_replace(array('=', '<'), '', $search_question);
    	}
    	$search_question = JString::strtolower($search_question);
    	$this->_filter->search_question = $search_question;
    	
    	$this->_filter->filter_order		= $mainframe->getUserStateFromRequest( 'com_sexypolling'.'filter_order',		'filter_order',		'm.id',	'cmd' );
    	$this->_filter->filter_order_Dir	= $mainframe->getUserStateFromRequest( 'com_sexypolling'.'filter_order_Dir',	'filter_order_Dir',	'',		'word' );
    	$this->_filter->filter_state		= $mainframe->getUserStateFromRequest( 'com_sexypolling'.'filter_state',		'filter_state',		'',		'word' );
    	if (!in_array($this->_filter->filter_order, array('sp.name','sp.question','sp.published','sp.id','num_answers','category','template'))) {
    		$this->_filter->filter_order = 'sp.id';
    	}
    	
    	if (!in_array(strtoupper($this->_filter->filter_order_Dir), array('ASC', 'DESC'))) {
    		$this->_filter->filter_order_Dir = '';
    	}
    	
    	$this->setState('limit', $limit);
    	$this->setState('limitstart', $limitstart);
    }
    
    function loadFilter() {
    	$this->_filter = new JObject();
    
    	$this->_filter->id_category = JRequest::getInt('id_category', 0);
    	$sql = "SELECT `id`, `name` FROM `#__sexy_categories` ";
    	$this->_db->setQuery($sql);
    	$this->_filter->categories = $this->_db->loadObjectList();
    }
    
    function getFilter() {
    	return $this->_filter;
    }
    
    /**
     * Returns the query
     * @return string The query to be used to retrieve the rows from the database
     */
    function _buildQuery() {
    
    	 
    	//create where
    	$where = array();
    
    	if ($this->_filter->search_title != '') {
    		 
    		$where[] = 'LOWER(sp.name) LIKE '.$this->_db->Quote( '%'.$this->_db->getEscaped( $this->_filter->search_title, true ).'%', false );
    	}
    	if ($this->_filter->search_question != '') {
    		 
    		$where[] = 'LOWER(sp.question) LIKE '.$this->_db->Quote( '%'.$this->_db->getEscaped( $this->_filter->search_question, true ).'%', false );
    	}
    	if($this->_filter->id_category != 0) {
    		 
    		$where[] .= 'sp.`id_category`="'.$this->_filter->id_category.'"';
    	}
    	if ( $this->_filter->filter_state )
    	{
    		if ( $this->_filter->filter_state == 'P' )
    		{
    			$where[] = 'sp.published = 1';
    		}
    		else if ($this->_filter->filter_state == 'U' )
    		{
    			$where[] = 'sp.published = 0';
    		}
    	}
    
    
    	$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
    
    	//create ordering
    
    	$orderby 	= ' ORDER BY '. $this->_filter->filter_order .' '. $this->_filter->filter_order_Dir;
    	$groupby 	=  ' GROUP BY sp.id ';
    
    	$query = 'SELECT sp.*, COUNT(sa.id) num_answers, sc.name category, st.name template '
            . ' FROM #__sexy_polls sp '
            . ' LEFT JOIN #__sexy_answers sa '
            . ' ON sa.id_poll = sp.id '
            . ' LEFT JOIN #__sexy_categories sc '
            . ' ON sc.id = sp.id_category '
            . ' LEFT JOIN #__sexy_templates st '
            . ' ON st.id = sp.id_template ';
    
    	$this->_total_sql = $query . $where . $groupby;
    
    	$query_res = $query .  $where . $groupby . $orderby;
    	return $query_res;
    }
 
    /**
     * Retrieves the hello data
     * @return array Array of objects containing the data from the database
     */
    function getData() {
    	// Lets load the data if it doesn't already exist
    	if (empty( $this->_data )) {
    		$query = $this->_buildQuery();
    		$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
    	}
    
    	return $this->_data;
    }
    
    function getTotal()
    {
    	//-- Load the content if it doesn't already exist
    	if(empty($this->_total))
    	{
    		$this->_buildQuery();
    		$this->_total = $this->_getListCount($this->_total_sql);
    	}
    
    	return $this->_total;
    }//function
    
    function getPagination()
    {
    	//-- Load the content if it doesn't already exist
    	if(empty($this->_pagination))
    	{
    		jimport('joomla.html.pagination');
    		$this->_pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit'));
    	}
    
    	return $this->_pagination;
    }//function
}