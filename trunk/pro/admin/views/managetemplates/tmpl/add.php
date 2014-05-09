<?php 
/**
 * Joomla! 1.5 component sexy_polling
 *
 * @version $Id: add.php 2012-04-05 14:30:25 svn $
 * @author Simon Poghosyan
 * @package Joomla
 * @subpackage sexypolling
 * @license GNU/GPL
 *
 *
 */
defined('_JEXEC') or die('Restricted access'); 
?>
<script type="text/javascript">
<?php if(version_compare( JVERSION, '1.6.0', 'lt' )) { ?>
function submitbutton(task) {
<?php } else { ?>
Joomla.submitbutton = function(task) {
<?php } ?>
	var form = document.adminForm;
	if (task == 'cancel') {
		submitform( task );
	} 
	else if (form.id_template.value == 0) {
		form.id_template.style.border = "1px solid red";
		form.id_template.focus();
	}
	else if (form.name.value == ""){
		form.name.style.border = "1px solid red";
		form.name.focus();
	} 
	else {
		submitform( task );
	}
}
</script>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col100">
    <fieldset class="adminform">
        <legend><?php echo JText::_( 'Details' ); ?></legend>
        <table class="admintable">
        <tr>
            <td width="100" align="right" class="key">
                <label for="poll">
                    <?php echo JText::_( 'Stat Values' ); ?>:
                </label>
            </td>
            <td>
                <select name="id_template" id="id_template" >
                	<option value="0"> <?php echo JText::_( 'Select Template' ); ?></option>
                	<?php 
                	foreach($this->templates as $template) {
                		echo '<option value="'.$template->id.'">'.$template->name.'</option>';
                	}
                	?>
                </select>
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
                <label for="answer">
                    <?php echo JText::_( 'Name' ); ?>:
                </label>
            </td>
            <td>
                <input class="text_area" type="text" name="name" id="name" size="32" maxlength="250" value="" />
            </td>
        </tr>
    </table>
    </fieldset>
</div>
 
<div class="clr"></div>
 
<input type="hidden" name="option" value="com_sexypolling" />
<input type="hidden" name="id" value="" />
<input type="hidden" name="task" value="save" />
<input type="hidden" name="controller" value="templates" />
</form>
<table class="adminlist" style="width: 100%;margin-top: 12px;"><tr><td align="center"><a href="http://2glux.com/projects/sexypolling" target="_blank">Sexy Polling</a> developed and designed by <a href="http://2glux.com" target="_blank">2GLux.com</a></td></tr></table>