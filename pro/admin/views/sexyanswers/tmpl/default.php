<?php 
/**
 * Joomla! 1.5 component sexy_polling
 *
 * @version $Id: default.php 2012-04-05 14:30:25 svn $
 * @author Simon Poghosyan
 * @package Joomla
 * @subpackage sexy_polling
 * @license GNU/GPL
 *
 *
 */
defined('_JEXEC') or die('Restricted access'); 
?>
<?php JHTML::_('behavior.tooltip'); ?>

<form action="index.php" method="post" name="adminForm">
<table style="width:100%"><tr><td align="left" width="100%">
   				<b><?php echo JText::_('Filter');?>:</b>
   				
   				<input type="text" name="search" id="search" value="<?php echo htmlspecialchars($this->filter->search);?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_state').value='';this.form.getElementById('id_poll').value=0;this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
				</td>
				<td nowrap="nowrap">
				<?php echo JText::_('Poll');?>:
				<select onchange="document.adminForm.id_poll.value=this.value; submitform();" name="period">
					<option <?php if($this->filter->id_poll == 0) { ?> selected="selected" <?php } ?> value="">
						<?php echo JText::_('All');?>
					</option>
					<?php foreach($this->filter->polls AS $poll) { ?>
					<option <?php if($poll->id == $this->filter->id_poll) { ?> selected="selected" <?php } ?> value="<?php echo $poll->id;?>">
						<?php echo $poll->name;?>
					</option>
					<?php } ?>
				</select>
				<?php echo JHTML::_('grid.state',  $this->filter->filter_state );?>
</td></tr></table>

<div id="editcell">
    <table class="adminlist">
    <thead>
        <tr>
            <th width="5">
               <?php echo JText::_( 'NUM' ); ?>
            </th>
            <th width="150">
               <?php echo JHTML::_('grid.sort',   'Poll Title', 'sp.name', @$this->filter->filter_order_Dir, @$this->filter->filter_order ); ?>
            </th>
            <th width="20">
              <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
            </th>
            <th>
               <?php echo JHTML::_('grid.sort',   'Answer', 'sa.name', @$this->filter->filter_order_Dir, @$this->filter->filter_order ); ?>
            </th>
            <th width="5%">
                <?php echo JHTML::_('grid.sort',   'Votes', 'count_votes', @$this->filter->filter_order_Dir, @$this->filter->filter_order ); ?>
            </th>
            <th width="5%">
                <?php echo JHTML::_('grid.sort',   'Published', 'sa.published', @$this->filter->filter_order_Dir, @$this->filter->filter_order ); ?>
            </th>
             <th width="1%">
            	<?php echo JHTML::_('grid.order', $this->items, 'filesave.png', 'saveorderanswers' ); ?>
            </th>
             <th width="1%">
                <?php echo JHTML::_('grid.sort',   'ID', 'sa.id', @$this->filter->filter_order_Dir, @$this->filter->filter_order ); ?>
            </th>
        </tr>            
    </thead>
    <tfoot>
		<tr>
			<td colspan="9">
				<?php echo $this->pagination->getListFooter(); ?>
			</td>
		</tr>
	</tfoot>
    <tbody>
    <?php
    $k = 0;
    for ($i=0, $n=count( $this->items ); $i < $n; $i++)
    {
        $row =& $this->items[$i];
        $checked    = JHTML::_( 'grid.id', $i, $row->answer_id );
        $link = JRoute::_( 'index.php?option=com_sexypolling&controller=answers&task=edit&cid[]='. $row->answer_id );
        $published 	= JHTML::_('grid.published', $row, $i );
 
        echo $poll_name;
        ?>
        <tr class="<?php echo "row$k"; ?>">
            <td>
                <?php echo $i; ?>
            </td>
            <td>
                <?php echo $row->poll_name; ?>
            </td>
            <td>
              <?php echo $checked; ?>
            </td>
             <td>
                 <a href="<?php echo $link; ?>"><?php echo $row->answer_name; ?></a>
            </td>
            <td align="center">
				<?php echo $row->count_votes; ?>
			</td>
            <td align="center">
				<?php echo $published;?>
			</td>
			<td class="order" >
				<input type="text" name="order[]" size="5" value="<?php echo $row->order; ?>" class="text_area" style="text-align: center" />
			</td>
			<td>
                <?php echo $row->answer_id; ?>
            </td>
        </tr>
        <?php
        $k = 1 - $k;
    }
    ?>
    </tbody>
    </table>
</div>
 
<input type="hidden" name="option" value="com_sexypolling" />
<input type="hidden" name="view" value="sexyanswers" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="id_poll" id="id_poll" value="<?php echo $this->filter->id_poll;?>" />
<input type="hidden" name="filter_order" value="<?php echo $this->filter->filter_order; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->filter->filter_order_Dir; ?>" />
<input type="hidden" name="controller" value="answers" />

 
</form>

<table class="adminlist" style="width: 100%;margin-top: 12px;"><tr><td align="center"><a href="http://2glux.com/projects/sexypolling" target="_blank">Sexy Polling</a> developed and designed by <a href="http://2glux.com" target="_blank">2GLux.com</a></td></tr></table>