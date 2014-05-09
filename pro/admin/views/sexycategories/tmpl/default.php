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
 */
defined('_JEXEC') or die('Restricted access'); 
?>
<form action="index.php" method="post" name="adminForm">
<table style="width:100%"><tr><td align="left" width="100%">
   				<b><?php echo JText::_('Filter Title');?>:</b>
   				<input type="text" name="search" id="search" value="<?php echo htmlspecialchars($this->filter->search);?>" class="text_area" onchange="document.adminForm.submit();" />
   				
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_state').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
				</td>
				<td nowrap="nowrap">
				<?php echo JHTML::_('grid.state',  $this->filter->filter_state );?>
</td></tr></table>


<div id="editcell">
    <table class="adminlist">
    <thead>
        <tr>
            <th width="5">
               <?php echo JText::_( 'NUM' ); ?>
            </th>
            <th width="20">
              <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
            </th>
            <th>
                <?php echo JHTML::_('grid.sort',   'Category Title', 'c.name', @$this->filter->filter_order_Dir, @$this->filter->filter_order ); ?>
            </th>
            <th width="5%">
                 <?php echo JHTML::_('grid.sort',   'NUM Polls', 'num_polls', @$this->filter->filter_order_Dir, @$this->filter->filter_order ); ?>
            </th>
            <th width="5%">
                 <?php echo JHTML::_('grid.sort',   'Published', 'c.published', @$this->filter->filter_order_Dir, @$this->filter->filter_order ); ?>
            </th>
            <th width="1%">
            	<?php echo JHTML::_('grid.order', $this->items, 'filesave.png', 'saveordercategories' ); ?>
            </th>
             <th width="1%">
                 <?php echo JHTML::_('grid.sort',   'ID', 'c.id', @$this->filter->filter_order_Dir, @$this->filter->filter_order ); ?>
            </th>
        </tr>            
    </thead>
     <tfoot>
		<tr>
			<td colspan="8">
				<?php echo $this->pagination->getListFooter(); ?>
			</td>
		</tr>
	</tfoot>
    <?php
    $k = 0;
    for ($i=0, $n=count( $this->items ); $i < $n; $i++)
    {
        $row =& $this->items[$i];
        $checked    = JHTML::_( 'grid.id', $i, $row->id );
        $link = JRoute::_( 'index.php?option=com_sexypolling&controller=categories&task=edit&cid[]='. $row->id );
        $published 	= JHTML::_('grid.published', $row, $i );
 
        ?>
        <tr class="<?php echo "row$k"; ?>">
            <td>
                <?php echo $i; ?>
            </td>
            <td>
              <?php echo $checked; ?>
            </td>
            <td>
                <a href="<?php echo $link; ?>"><?php echo $row->name; ?></a>
            </td>
            <td align="center">
               <?php echo $row->num_polls; ?>
            </td>
            <td align="center">
				<?php echo $published;?>
			</td>
			<td class="order" >
				<input type="text" name="order[]" size="5" value="<?php echo $row->order; ?>" class="text_area" style="text-align: center" />
			</td>
			<td>
                <?php echo $row->id; ?>
            </td>
        </tr>
        <?php
        $k = 1 - $k;
    }
    ?>
    </table>
</div>
 
<input type="hidden" name="option" value="com_sexypolling" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="view" value="sexycategories" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->filter->filter_order; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->filter->filter_order_Dir; ?>" />
<input type="hidden" name="controller" value="categories" />
 
</form>

<table class="adminlist" style="width: 100%;margin-top: 12px;"><tr><td align="center"><a href="http://2glux.com/projects/sexypolling" target="_blank">Sexy Polling</a> developed and designed by <a href="http://2glux.com" target="_blank">2GLux.com</a></td></tr></table>