<?php
/**
 *
 * @version $Id: sexytemplates.php 2012-04-05 14:30:25 svn $
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
jimport('joomla.application.component.model');

class SexypollingModelSexytemplates extends JModel {
var $_data, $_total, $_pagination, $_filter, $_total_sql;
	
    function __construct() {
    	
    	parent::__construct();
    	
    	$this->_filter = new JObject();
    	
    	$mainframe = JFactory::getApplication();
    	
    	$limit      = $mainframe->getUserStateFromRequest( 'com_sexypolling'.'.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
    	$limitstart = $mainframe->getUserStateFromRequest( 'com_sexypolling'.JRequest::getCmd( 'view').'.limitstart', 'limitstart', 0, 'int' );
    	
    	if($limitstart > $this->getTotal()) $limitstart = 0;
    	
    	$search				= $mainframe->getUserStateFromRequest( 'com_sexypolling'.'search',			'search',			'',		'string' );
    	if (strpos($search, '"') !== false) {
    		$search = str_replace(array('=', '<'), '', $search);
    	}
    	$search = JString::strtolower($search);
    	$this->_filter->search = $search;
    	
    	$this->_filter->filter_order		= $mainframe->getUserStateFromRequest( 'com_sexypolling'.'filter_order',		'filter_order',		't.id',	'cmd' );
    	$this->_filter->filter_order_Dir	= $mainframe->getUserStateFromRequest( 'com_sexypolling'.'filter_order_Dir',	'filter_order_Dir',	'',		'word' );
    	$this->_filter->filter_state		= $mainframe->getUserStateFromRequest( 'com_sexypolling'.'filter_state',		'filter_state',		'',		'word' );
    	if (!in_array($this->_filter->filter_order, array('t.name','t.id','t.published'))) {
    		$this->_filter->filter_order = 't.id';
    	}
    	
    	if (!in_array(strtoupper($this->_filter->filter_order_Dir), array('ASC', 'DESC'))) {
    		$this->_filter->filter_order_Dir = '';
    	}
    	
    	$this->setState('limit', $limit);
    	$this->setState('limitstart', $limitstart);
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
    
    	if ($this->_filter->search != '') {
    		 
    		$where[] = 'LOWER(t.name) LIKE '.$this->_db->Quote( '%'.$this->_db->getEscaped( $this->_filter->search, true ).'%', false );
    	}
    	if ( $this->_filter->filter_state )
    	{
    		if ( $this->_filter->filter_state == 'P' )
    		{
    			$where[] = 't.published = 1';
    		}
    		else if ($this->_filter->filter_state == 'U' )
    		{
    			$where[] = 't.published = 0';
    		}
    	}
    
    
    	$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
    
    	//create ordering
    
    	$orderby 	= ' ORDER BY '. $this->_filter->filter_order .' '. $this->_filter->filter_order_Dir;
    
    	$query = 'SELECT t.* '
            . ' FROM #__sexy_templates t ';
    
    	$this->_total_sql = $query . $where;
    
    	$query_res = $query .  $where . $orderby;
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