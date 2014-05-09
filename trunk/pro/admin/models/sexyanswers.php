<?php
/**
 * Joomla! 1.5 component sexy_polling
 *
 * @version $Id: sexyanswers.php 2012-04-05 14:30:25 svn $
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
jimport( 'joomla.database.database' );

class SexypollingModelSexyanswers extends JModel {
	
	var $_data, $_total, $_pagination, $_filter, $_total_sql;
	
    function __construct() {
    	
    	parent::__construct();
    	
    	$mainframe = JFactory::getApplication();
    	
    	$this->loadFilter();
    	
    	$limit      = $mainframe->getUserStateFromRequest( 'com_sexypolling'.'.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
    	$limitstart = $mainframe->getUserStateFromRequest( 'com_sexypolling'.JRequest::getCmd( 'view').'.limitstart', 'limitstart', 0, 'int' );
    	
    	if($limitstart > $this->getTotal()) $limitstart = 0;
    	$search				= $mainframe->getUserStateFromRequest( 'com_sexypolling'.'search',			'search',			'',		'string' );
    	if (strpos($search, '"') !== false) {
    		$search = str_replace(array('=', '<'), '', $search);
    	}
    	$search = JString::strtolower($search);
    	$this->_filter->search = $search;
    	
    	$this->_filter->filter_order		= $mainframe->getUserStateFromRequest( 'com_sexypolling'.'filter_order',		'filter_order',		'm.id',	'cmd' );
    	$this->_filter->filter_order_Dir	= $mainframe->getUserStateFromRequest( 'com_sexypolling'.'filter_order_Dir',	'filter_order_Dir',	'',		'word' );
    	$this->_filter->filter_state		= $mainframe->getUserStateFromRequest( 'com_sexypolling'.'filter_state',		'filter_state',		'',		'word' );
    	if (!in_array($this->_filter->filter_order, array('sp.name','sa.name','sa.published','sa.id','count_votes'))) {
    		$this->_filter->filter_order = 'sp.name';
    	}
    	
    	if (!in_array(strtoupper($this->_filter->filter_order_Dir), array('ASC', 'DESC'))) {
    		$this->_filter->filter_order_Dir = '';
    	}
    	
    	$this->setState('limit', $limit);
    	$this->setState('limitstart', $limitstart);
    }
    
    function loadFilter() {
    	$this->_filter = new JObject();
    
    	$this->_filter->id_poll = JRequest::getInt('id_poll', 0);
    	$sql = "SELECT `id`, `name` FROM `#__sexy_polls` ";
    	$this->_db->setQuery($sql);
    	$this->_filter->polls = $this->_db->loadObjectList();
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
        	
        	$where[] = 'LOWER(sa.name) LIKE '.$this->_db->Quote( '%'.$this->_db->getEscaped( $this->_filter->search, true ).'%', false );
        }
        if($this->_filter->id_poll != 0) {
        	
        	$where[] .= 'sp.`id`="'.$this->_filter->id_poll.'"';
        }
        if ( $this->_filter->filter_state )
        {
        	if ( $this->_filter->filter_state == 'P' )
        	{
        		$where[] = 'sa.published = 1';
        	}
        	else if ($this->_filter->filter_state == 'U' )
        	{
        		$where[] = 'sa.published = 0';
        	}
        }
        
        
        $where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
        
        //create ordering
        
        $orderby 	= ' ORDER BY '. $this->_filter->filter_order .' '. $this->_filter->filter_order_Dir;
        
        $query = ' SELECT  '
        . 'COUNT(sv.id_answer) count_votes, '
        . ' sp.name poll_name, '
        . ' sp.id poll_id, '
        . ' sa.name answer_name, '
        . ' sa.id answer_id, '
        . ' sa.order `order`, '
        . ' sa.published published '
        . ' FROM #__sexy_polls sp '
        . ' JOIN #__sexy_answers sa'
        . ' ON sa.id_poll = sp.id '
        . ' LEFT JOIN #__sexy_votes sv'
        . ' ON sv.id_answer = sa.id ';
        
        $groupby 	= ' GROUP BY sa.id';
        
        $this->_total_sql = $query . $where . $groupby;
        
        $query_res = $query . $where . $groupby . $orderby;
        return $query_res;
    }
 
    /**
     * Retrieves the data
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