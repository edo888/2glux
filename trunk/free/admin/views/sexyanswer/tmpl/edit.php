<?php
/**
 * Joomla! component sexypolling
 *
 * @version $Id: edit.php 2012-04-05 14:30:25 svn $
 * @author 2GLux.com
 * @package Sexy Polling
 * @subpackage com_sexypolling
 * @license GNU/GPL
 *
 */

// no direct access
defined('_JEXEC') or die('Restircted access');


JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<script type="text/javascript">
Joomla.submitbutton = function(task) {
	var form = document.adminForm;
	if (task == 'sexyanswer.cancel') {
		submitform( task );
	}
	else {
		if (form.jform_name.value != ""){
			form.jform_name.style.border = "1px solid green";
		} 
		
		if (form.jform_name.value == ""){
			form.jform_name.style.border = "1px solid red";
			form.jform_name.focus();
		} 
		else {
			submitform( task );
		}
	}
}
</script>
<?php if(JV == 'j2') {//////////////////////////////////////////////////////////////////////////////////////Joomla2.x/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>
<form action="<?php echo JRoute::_('index.php?option=com_sexypolling&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="helloworld-form">
<?php if(($this->max_id < 5) || ($this->item->id != 0)) {?>
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'COM_SEXYPOLLING_DETAILS' ); ?></legend>
		<ul class="adminformlist">
		<?php foreach($this->form->getFieldset() as $field): ?>
					<li><?php echo $field->label;echo $field->input;?></li>
		<?php endforeach; ?>
		</ul>
	</fieldset>
	<?php } else { ?>
				<div style="color: rgb(235, 9, 9);font-size: 16px;font-weight: bold;">Please Upgrade to PRO Version to have more than five Sexy Answers!</div>
					<div id="cpanel" style="float: left;">
					<div class="icon" style="float: right;">
					<a href="<?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_BUY_PRO_VERSION_LINK' ); ?>" target="_blank" title="Please Upgrade to PRO Version to have more than five Sexy Answers!">
					<table style="width: 100%;height: 100%;text-decoration: none;">
					<tr>
					<td align="center" valign="middle">
					<img src="components/com_sexypolling/assets/images/shopping_cart.png" /><br />
											<?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_BUY_PRO_VERSION' ); ?>
										</td>
									</tr>
								</table>
							</a>
						</div>
					</div>
					<div style="font-style: italic;font-size: 12px;color: #949494;clear: both;">If you've deleted answers, but still see this message, please clear the answers trash.</div>
			<?php }?>
	<div>
		<input type="hidden" name="task" value="sexyanswer.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
<table class="adminlist" style="width: 100%;margin-top: 12px;clear: both;"><tr><td align="center" valign="middle" id="twoglux_ext_td" style="position: relative;">
	<div id="twoglux_bottom_link"><a href="<?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_PROJECT_HOMEPAGE_LINK' ); ?>" target="_blank"><?php echo JText::_( 'COM_SEXYPOLLING' ); ?></a> <?php echo JText::_( 'COM_SEXYPOLLING_DEVELOPED_BY' ); ?> <a href="http://2glux.com" target="_blank">2GLux.com</a></div>
	<div style="position: absolute;right: 2px;top: 7px;">
		<a href="<?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_RATE_US_LINK' ); ?>" target="_blank" id="twoglux_ext_rate" class="twoglux_ext_bottom_icon" title="<?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_RATE_US_DESCRIPTION' ); ?>">&nbsp;</a>
		<a href="<?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_PROJECT_HOMEPAGE_LINK' ); ?>" target="_blank" id="twoglux_ext_homepage" style="margin: 0 2px 0 0px;" class="twoglux_ext_bottom_icon" title="<?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_PROJECT_HOMEPAGE_DESCRIPTION' ); ?>">&nbsp;</a>
		<a href="<?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_SUPPORT_FORUM_LINK' ); ?>" target="_blank" id="twoglux_ext_support" class="twoglux_ext_bottom_icon" title="<?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_SUPPORT_FORUM_DESCRIPTION' ); ?>">&nbsp;</a>
		<a href="<?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_BUY_PRO_VERSION_LINK' ); ?>" target="_blank" id="twoglux_ext_buy" class="twoglux_ext_bottom_icon" title="<?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_BUY_PRO_VERSION_DESCRIPTION' ); ?>">&nbsp;</a>
	</div>
</td></tr></table>
<?php }elseif(JV == 'j3') {//////////////////////////////////////////////////////////////////////////////////////Joomla3.x/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>
<?php 
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
?>
<form action="<?php echo JRoute::_('index.php?option=com_sexypolling&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate form-horizontal">
	<div class="row-fluid">
		<!-- Begin Newsfeed -->
		<div class="span10 form-horizontal">
			<?php if(($this->max_id < 5) || ($this->item->id != 0)) {?>
			<fieldset>
				<div class="tab-content">
					<div class="tab-pane active" id="details">
						<div class="control-group">
							<?php foreach($this->form->getFieldset() as $field): ?>
								<div class="control-label"><?php echo $field->label;?></div>
								<div class="controls"><?php echo $field->input;?></div>
								<div style="clear: both;height: 8px;">&nbsp;</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</fieldset>
			<?php } else { ?>
				<div style="color: rgb(235, 9, 9);font-size: 16px;font-weight: bold;">Please Upgrade to PRO Version to have more than five Sexy Answers!</div>
					<div id="cpanel" style="float: left;">
					<div class="icon" style="float: right;">
					<a href="<?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_BUY_PRO_VERSION_LINK' ); ?>" target="_blank" title="Please Upgrade to PRO Version to have more than five Sexy Answers!">
					<table style="width: 100%;height: 100%;text-decoration: none;">
					<tr>
					<td align="center" valign="middle">
					<img src="components/com_sexypolling/assets/images/shopping_cart.png" /><br />
											<?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_BUY_PRO_VERSION' ); ?>
										</td>
									</tr>
								</table>
							</a>
						</div>
					</div>
					<div style="font-style: italic;font-size: 12px;color: #949494;clear: both;">If you've deleted answers, but still see this message, please clear the answers trash.</div>
			<?php }?>
		</div>
	</div>
<input type="hidden" name="task" value="sexyanswer.edit" />
<?php echo JHtml::_('form.token'); ?>
</form>
<table class="adminlist" style="width: 100%;margin-top: 12px;clear: both;"><tr><td align="center" valign="middle" id="twoglux_ext_td" style="position: relative;">
	<div id="twoglux_bottom_link"><a href="<?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_PROJECT_HOMEPAGE_LINK' ); ?>" target="_blank"><?php echo JText::_( 'COM_SEXYPOLLING' ); ?></a> <?php echo JText::_( 'COM_SEXYPOLLING_DEVELOPED_BY' ); ?> <a href="http://2glux.com" target="_blank">2GLux.com</a></div>
	<div style="position: absolute;right: 2px;top: 7px;">
		<a href="<?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_RATE_US_LINK' ); ?>" target="_blank" id="twoglux_ext_rate" class="twoglux_ext_bottom_icon" title="<?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_RATE_US_DESCRIPTION' ); ?>">&nbsp;</a>
		<a href="<?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_PROJECT_HOMEPAGE_LINK' ); ?>" target="_blank" id="twoglux_ext_homepage" style="margin: 0 2px 0 0px;" class="twoglux_ext_bottom_icon" title="<?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_PROJECT_HOMEPAGE_DESCRIPTION' ); ?>">&nbsp;</a>
		<a href="<?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_SUPPORT_FORUM_LINK' ); ?>" target="_blank" id="twoglux_ext_support" class="twoglux_ext_bottom_icon" title="<?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_SUPPORT_FORUM_DESCRIPTION' ); ?>">&nbsp;</a>
		<a href="<?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_BUY_PRO_VERSION_LINK' ); ?>" target="_blank" id="twoglux_ext_buy" class="twoglux_ext_bottom_icon" title="<?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_BUY_PRO_VERSION_DESCRIPTION' ); ?>">&nbsp;</a>
	</div>
</td></tr></table>
<?php }?>
<style>
#jform_name {
	width: 650px;
}
</style>