<?php
/**
 * Joomla! 1.5 component sexy_polling
 *
 * @version $Id: polls.php 2012-04-05 14:30:25 svn $
 * @author Simon Poghosyan
 * @package Joomla
 * @subpackage sexy_polling
 * @license GNU/GPL
 *
 *
 */
defined('_JEXEC') or die();

class JFormFieldPolls extends JFormField
{

	protected $type 		= 'sexypolling';

	function getInput()
	{
		$doc 		=& JFactory::getDocument();
		$fieldName	= $this->name;

		$db = &JFactory::getDBO();

		$query = "SELECT name text,id value FROM #__sexy_categories";
		$db->setQuery($query);
		$options = $db->loadObjectList();

		$html = array();

		$html[] = "<select name=\"$fieldName\">";
		//$html[] = '<option value="0">'.JText::_("All").'</option>';
		foreach($options AS $o) {
			$html[] = '<option value="'.$o->value.'"'.(($o->value == $this->value) ? ' selected="selected"' : '').'>';
			$html[] = $o->text;
			$html[] = '</option>';
		}
		$html[] = "</select>";

		return implode("", $html);
	}
}
?>
