<?php
/**
 * Joomla! 1.5 component sexy_polling
 *
 * @version $Id: poll.php 2012-04-05 14:30:25 svn $
 * @author Simon Poghosyan
 * @package Joomla
 * @subpackage sexy_polling
 * @license GNU/GPL
 *
 *
 */
defined('_JEXEC') or die();

class JElementPoll extends JElement
{
	var	$_name = 'Title';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$doc 		=& JFactory::getDocument();
		$fieldName	= $control_name.'['.$name.']';
		$db 		=& JFactory::getDBO();

		$query = "SELECT name text,id value FROM #__sexy_polls WHERE published = '1'";
		$db->setQuery($query);
		$options = $db->loadObjectList();

		$html = array();
		
		$html[] = "<select name=\"$fieldName\">";
		//$html[] = '<option value="0">'.JText::_("All").'</option>';
		foreach($options AS $o) {
			$html[] = '<option value="'.$o->value.'"'.(($o->value == $value) ? ' selected="selected"' : '').'>';
			$html[] = $o->text;
			$html[] = '</option>';
		}
		$html[] = "</select>";
		
		return implode("", $html);
	}
}
?>
