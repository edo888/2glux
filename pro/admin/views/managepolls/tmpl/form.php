<?php 
/**
 * Joomla! 1.5 component sexy_polling
 *
 * @version $Id: form.php 2012-04-05 14:30:25 svn $
 * @author Simon Poghosyan
 * @package Joomla
 * @subpackage sexy_polling
 * @license GNU/GPL
 *
 *
 */

defined('_JEXEC') or die('Restricted access');
 
JHTML::_('behavior.calendar');

$disabled = ($this->new && $this->limit >= 999999) ? true : false;
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
	else if (form.name.value == ""){
		form.name.style.border = "1px solid red";
		form.name.focus();
	} 
	else if (form.question.value == ""){
		form.question.style.border = "1px solid red";
		form.question.focus();
	} 
	else if (form.id_category.value == "0"){
		form.id_category.style.border = "1px solid red";
		form.id_category.focus();
	} 
	else if (form.id_template.value == "0"){
		form.id_template.style.border = "1px solid red";
		form.id_template.focus();
	} 
	else {
		submitform( task );
	}
}
</script>
<?php if($disabled) {?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
	<div class="col100" style="position: relative;">
	    <fieldset class="adminform">
	    	 <legend><?php echo JText::_( 'Please upgrade' ); ?></legend>
			<p style="font-size: 16px;">Please purchase our <a href="http://2glux.com/projects/sexypolling" target="_blank" title="Buy Version without copyright and limits">PRO Version</a> to be able to have more than two Sexy Polls.</p>
			
			<div id="cpanel">
				<div class="icon" style="float: left;">
					<a href="http://2glux.com/projects/sexypolling" target="_blank" title="Buy Version without copyright and limits">
						<table style="width: 100%;height: 100%;text-decoration: none;">
							<tr>
								<td align="center" valign="middle">
									<img src="components/com_sexypolling/assets/images/shopping_cart.png" /><br />
									Buy Pro Version
								</td>
							</tr>
						</table>
					</a>
				</div>
			</div>
		</fieldset>
	</div>
	
<input type="hidden" name="option" value="com_sexypolling" />
<input type="hidden" name="id" value="<?php echo $this->poll->id; ?>" />
<input type="hidden" name="task" value="save" />
<input type="hidden" name="controller" value="polls" />
</form>
<?php }else {?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col100" style="position: relative;">
    <fieldset class="adminform">
        <legend><?php echo JText::_( 'Details' ); ?></legend>
        <table class="admintable">
        <tr>
            <td width="110" align="right" class="key">
                <label for="name">
                    <?php echo JText::_( 'Title' ); ?>:
                </label>
            </td>
            <td>
                <input class="text_area" type="text" name="name" id="name" size="60" maxlength="250" value="<?php echo $this->poll->name;?>" />
            </td>
        </tr>
        <tr>
			<td width="110" class="key">
				<label for="alias">
					<?php echo JText::_( 'Alias' ); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="alias" id="alias" size="60" value="<?php echo $this->poll->alias; ?>" />
			</td>
		</tr>
        <tr>
        	<td width="110" align="right" class="key">
                <label for="question">
                    <?php echo JText::_( 'Question' ); ?>:
                </label>
            </td>
             <td>
                <input class="text_area" type="text" name="question" id="question" size="60" maxlength="250" value="<?php echo $this->poll->question;?>" />
            </td>
        </tr>
        <tr>
			<td width="110" class="key">
				<?php echo JText::_( 'Category' ); ?>:
			</td>
			<td>
				<select name="id_category" id="id_category" style="width: 200px">
                	<option value="0"> <?php echo JText::_( 'Select Category' ); ?></option>
                	<?php 
                	foreach($this->categories as $category) {
                		$selected = ($category->id == $this->poll->id_category) ? 'selected="selected"' : '';
                		echo '<option value="'.$category->id.'" '.$selected.'>'.$category->name.'</option>';
                	}
                	?>
                </select>
			</td>
		</tr>
        <tr>
			<td width="110" class="key">
				<?php echo JText::_( 'Template' ); ?>:
			</td>
			<td>
				<select name="id_template" id="id_template" style="width: 200px" >
                	<option value="0"> <?php echo JText::_( 'Select Template' ); ?></option>
                	<?php 
                	foreach($this->templates as $template) {
                		$selected = ($template->id == $this->poll->id_template) ? 'selected="selected"' : '';
                		echo '<option value="'.$template->id.'" '.$selected.'>'.$template->name.'</option>';
                	}
                	?>
                </select>
			</td>
		</tr>
		 <tr>
			<td width="110" class="key">
				<?php echo JText::_( 'Published' ); ?>:
			</td>
			<td>
				<?php echo JHTML::_( 'select.booleanlist',  'published', 'class="inputbox"', $this->poll->published ); ?>
			</td>
		</tr>
		 <tr>
			<td width="110" class="key">
				<?php echo JText::_( 'Multiple Answers' ); ?>:
			</td>
			<td>
				<?php echo JHTML::_( 'select.booleanlist',  'multiple_answers', 'class="inputbox"', $this->poll->multiple_answers ); ?>
			</td>
		</tr>
		 <tr>
			<td width="110" class="key">
				<?php echo JText::_( 'Date Start' ); ?>:
			</td>
			<td>
				<?php 
				$d_s = $this->poll->date_start == '0000-00-00' ? '' : $this->poll->date_start;
				echo JHTML::_('calendar', $d_s, "date_start" , "date_start", '%Y-%m-%d');
				?>
			</td>
		</tr>
		 <tr>
			<td width="110" class="key">
				<?php echo JText::_( 'Date End' ); ?>:
			</td>
			<td>
				<?php 
					$d_e = $this->poll->date_end == '0000-00-00' ? '' : $this->poll->date_end;
					echo JHTML::_('calendar', $d_e, "date_end" , "date_end", '%Y-%m-%d');
				?>
			</td>
		</tr>
    </table>
    </fieldset>
</div>
 
<div class="clr"></div>
 
<input type="hidden" name="option" value="com_sexypolling" />
<input type="hidden" name="id" value="<?php echo $this->poll->id; ?>" />
<input type="hidden" name="task" value="save" />
<input type="hidden" name="controller" value="polls" />
</form>
<?php }?>
<table class="adminlist" style="width: 100%;margin-top: 12px;"><tr><td align="center"><a href="http://2glux.com/projects/sexypolling" target="_blank">Sexy Polling</a> developed and designed by <a href="http://2glux.com" target="_blank">2GLux.com</a></td></tr></table>