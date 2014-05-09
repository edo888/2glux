<?php
/**
 * Joomla! 1.5 component sexy_polling
 *
 * @version $Id: default.php 2012-04-05 14:30:25 svn $
 * @author Simon Poghosyan
 * @package Joomla
 * @subpackage sexypolling
 * @license GNU/GPL
 *
 *
 */
//no direct access
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

//get ip
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
	$sexyip=$_SERVER['HTTP_CLIENT_IP'];
}
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
	$sexyip=$_SERVER['HTTP_X_FORWARDED_FOR'];
}
else {
	$sexyip=$_SERVER['REMOTE_ADDR'];
}

$userRegistered = (JFactory::getUser()->id == 0) ? false : true;

$comparams = &JComponentHelper::getParams( 'com_sexypolling' );
$answerPermission = $comparams->get( 'answerPermission',0 );
$autoPublish = $comparams->get( 'autoPublish',0 );
$autoOpenTimeline = $comparams->get( 'autoOpenTimeline',0 );
$loadJquery = $comparams->get( 'loadJquery',1 );
$loadJqueryUi = $comparams->get( 'loadJqueryUi',1 );
$dateFormat = $comparams->get( 'dateFormat',0 );
$checkIp = $comparams->get( 'checkIp',1 );
$checkCookie = $comparams->get( 'checkCookie',1 );
$autoAnimate = $comparams->get( 'autoAnimate',1 );
$sexyAnimationTypeBar = $comparams->get( 'barAnimationType','linear' );
$sexyAnimationTypeContainer = $comparams->get( 'colorAnimationType','linear' );
$sexyAnimationTypeContainerMove = $comparams->get( 'reorderingAnimationType','linear' );

$document =& JFactory::getDocument();

$cssFile = JURI::base(true).'/components/com_sexypolling/assets/css/main.css';
$document->addStyleSheet($cssFile, 'text/css', null, array());

$cssFile = JURI::base(true).'/components/com_sexypolling/assets/css/ui.slider.extras.css';
$document->addStyleSheet($cssFile, 'text/css', null, array());

$cssFile = JURI::base(true).'/components/com_sexypolling/assets/css/jquery-ui-1.7.1.custom.css';
$document->addStyleSheet($cssFile, 'text/css', null, array());

if($loadJquery == 1) {
	$jsFile = JURI::base(true).'/components/com_sexypolling/assets/js/jquery-1.7.2.min.js';
	$document->addScript($jsFile);
	$document->addScriptDeclaration ( 'jQuery.noConflict();' );
}

if($loadJqueryUi == 1) {
	$jsFile = JURI::base(true).'/components/com_sexypolling/assets/js/jquery-ui-1.8.19.custom.min.js';
	$document->addScript($jsFile);
}

$jsFile = JURI::base(true).'/components/com_sexypolling/assets/js/selectToUISlider.jQuery.js';
$document->addScript($jsFile);

$jsFile = JURI::base(true).'/components/com_sexypolling/assets/js/color.js';
$document->addScript($jsFile);

$jsFile = JURI::base(true).'/components/com_sexypolling/assets/js/sexypolling.js';
$document->addScript($jsFile);


// get a parameter from the module's configuration
$module_id = 0;

$db = JFactory::getDBO();


$polling_words = array("Votes","Total Votes","First Vote","Last Vote","Show Timeline","Hide Timeline","Poll","View","Please select answer","You have allready voted on this poll","Add new answer","Add an answer...","Add","Your answer will apear after moderation","Scaling","Relative","Absolute","This poll will start on ","This poll expired on ","Back to Answers");

for ($i=0, $n=count( $this->items ); $i < $n; $i++) {
	$pollings[$this->items[$i]->polling_id][] = $this->items[$i];
}

$polling_select_id = array();
$custom_styles = array();
$voted_ids = array();
$start_disabled_ids = array();
$end_disabled_ids = array();
$date_format = $dateFormat == 0 ? 'str' : 'digits';
$date_now = strtotime("now");


if(sizeof($pollings) > 0)
	foreach ($pollings as $poll_index => $polling_array) {
	
		//check start,end dates
		if($polling_array[0]->date_start != '0000-00-00' &&  $date_now < strtotime($polling_array[0]->date_start)) {
			$start_disabled_ids[] = array($poll_index,$polling_words[17] . date('F j, Y',strtotime($polling_array[0]->date_start)));
		}
		if($polling_array[0]->date_end != '0000-00-00' &&  $date_now > strtotime($polling_array[0]->date_end)) {
			$end_disabled_ids[] = array($poll_index,$polling_words[18] . date('F j, Y',strtotime($polling_array[0]->date_end)));
		}
	
		//check cookie
		if ($checkCookie == 1)
			if (isset($_COOKIE["sexy_poll_$poll_index"]))
			if(!in_array($poll_index,$voted_ids))
			$voted_ids[] = $poll_index;
		//check ip
		if ($checkIp == 1) {
			$query = "SELECT ip FROM #__sexy_votes sv JOIN #__sexy_answers sa ON sa.id_poll = '$poll_index' WHERE sv.id_answer = sa.id AND sv.ip = '$sexyip'";
			$db->setQuery($query);
			$db->query();
			$num_rows = $db->getNumRows();
			if($num_rows > 0) {
				if(!in_array($poll_index,$voted_ids))
					$voted_ids[] = $poll_index;
			}
		}
	
		//set styles
		$custom_styles[$poll_index] = $polling_array[0]->styles;
		echo '<div class="polling_container_wrapper" id="mod_'.$module_id.'_'.$poll_index.'" roll="'.$module_id.'"><div class="polling_container" id="poll_'.$poll_index.'">';
		echo '<div class="polling_name">'.$polling_array[0]->polling_question.'</div>';
	
		$multiple_answers = $polling_array[0]->multiple_answers;
		$multiple_answers_info_array[$poll_index] = $multiple_answers;
	
		echo '<ul class="polling_ul">';
		foreach ($polling_array as $k => $poll_data) {
			$color_index = $k % 20 + 1;
			echo '<li id="answer_'.$poll_data->answer_id.'" class="polling_li"><div class="animation_block"></div>';
			echo '<div class="answer_name"><label for="'.$module_id.'_'.$poll_data->answer_id.'">'.$poll_data->answer_name.'</label></div>';
			echo '<div class="answer_input">';
	
			if($multiple_answers == 0)
				echo '<input  id="'.$module_id.'_'.$poll_data->answer_id.'" type="radio" class="poll_answer '.$poll_data->answer_id.'" value="'.$poll_data->answer_id.'" name="'.$poll_data->polling_id.'" />';
			else
				echo '<input  id="'.$module_id.'_'.$poll_data->answer_id.'" type="checkbox" class="poll_answer '.$poll_data->answer_id.'" value="'.$poll_data->answer_id.'" name="'.$poll_data->polling_id.'" />';
	
			echo '</div>';
			echo '<div class="answer_result">
			<div class="answer_navigation polling_bar_'.$color_index.'" id="answer_navigation_'.$poll_data->answer_id.'"><div class="grad"></div></div>
			<div class="answer_votes_data" id="answer_votes_data_'.$poll_data->answer_id.'">'.$polling_words[0].': <span id="answer_votes_data_count_'.$poll_data->answer_id.'"></span><span id="answer_votes_data_count_val_'.$poll_data->answer_id.'" style="display:none"></span> (<span id="answer_votes_data_percent_'.$poll_data->answer_id.'">0</span><span style="display:none" id="answer_votes_data_percent_val_'.$poll_data->answer_id.'"></span>%)</div>
			<div class="sexy_clear"></div>
			</div>';
			echo '</li>';
		}
		echo '</ul>';
	
		//check perrmision, to show add answer option
		if($answerPermission == 0 || ($answerPermission == 1 && $userRegistered)) {
			if(!in_array($poll_index,$voted_ids)) {
				echo '<div class="answer_wrapper opened" ><div style="padding:6px">';
				echo '<div class="add_answer"><input name="answer_name" class="add_ans_name" value="'.$polling_words[11].'" />
				<input type="button" value="'.$polling_words[12].'" class="add_ans_submit" /><input type="hidden" value="'.$poll_index.'" class="poll_id" /><img class="loading_small" src="'.JURI::base(true).'/components/com_sexypolling/assets/images/loading_small.gif" /></div>';
				echo '</div></div>';
			}
		}
	
		$new_answer_bar_index = ($k + 1) % 20 + 1;
	
	
		echo '<span class="polling_bottom_wrapper1"><img src="components/com_sexypolling/assets/images/loading_polling.gif" class="polling_loading" />';
		echo '<input type="button" value="'.$polling_words[6].'" class="polling_submit" id="poll_'.$module_id.'_'.$poll_index.'" />';
		echo '<input type="button" value="'.$polling_words[7].'" class="polling_result" id="res_'.$module_id.'_'.$poll_index.'" /></span>';
		echo '<div class="polling_info"><table cellpadding="0" cellspacing="0" border="0"><tr><td class="left_col">'.$polling_words[1].':<span class="total_votes_val" style="display:none"></span> </td><td class="total_votes right_col"></td></tr><tr><td class="left_col">'.$polling_words[2].': </td><td class="first_vote right_col"></td></tr><tr><td class="left_col">'.$polling_words[3].': </td><td class="last_vote right_col"></td></tr></table></div>';
	
	
		//timeline
		$polling_select_id[$poll_index]['select1'] = 'polling_select_'.$module_id.'_'.$poll_index.'_1';
		$polling_select_id[$poll_index]['select2'] = 'polling_select_'.$module_id.'_'.$poll_index.'_2';
	
		//get count of total votes, min and max dates of voting
		$query = "SELECT COUNT(sv.`id_answer`) total_count, MAX(sv.`date`) max_date,MIN(sv.`date`) min_date FROM `#__sexy_votes` sv JOIN `#__sexy_answers` sa ON sa.id_poll = '$poll_index' WHERE sv.id_answer = sa.id";
		$db->setQuery($query);
		$row_total = $db->loadAssoc();
		$count_total_votes = $row_total[total_count];
		$min_date = strtotime($row_total[min_date]);
		$max_date = strtotime($row_total[max_date]);
		//if no votes, set time to current
		if((int)$min_date == 0) {
			$min_date = $max_date = strtotime("now");
		}
	
	
		$timeline_array = array();
	
	
		for($current = $min_date; $current <= $max_date; $current += 86400) {
			$timeline_array[] = $current;
		}
	
		//check, if max date is not included in timeline array, then add it.
		if(date('F j, Y', $max_date) !== date('F j, Y', $timeline_array[sizeof($timeline_array) - 1]))
			$timeline_array[] = $max_date;
	
	
		echo '<div class="timeline_wrapper">';
		echo '<div class="timeline_icon" title="'.$polling_words[4].'"></div>';
		echo '<div class="sexyback_icon" title="'.$polling_words[19].'"></div>';
		if($answerPermission == 0 || ($answerPermission == 1 && $userRegistered)) {
			if(!in_array($poll_index,$voted_ids)) {
				$add_ans_txt = $polling_words[10];
				$o_class = 'opened';
			}
			else {
				$add_ans_txt = $polling_words[9];
				$o_class = 'voted_button';
			}
			echo '<div class="add_answer_icon '.$o_class.'" title="'.$add_ans_txt.'"></div>';
		}
	
		echo '<div class="scale_icon" title="'.$polling_words[14].'"></div>';
	
		echo '<div class="timeline_select_wrapper" >';
		echo '<div style="padding:5px 6px"><select class="polling_select1" id="polling_select_'.$module_id.'_'.$poll_index.'_1" name="polling_select_'.$module_id.'_'.$poll_index.'_1">';
	
		$optionGroups = array();
		foreach ($timeline_array as $k => $curr_time) {
			if(!in_array(date('F Y', $curr_time),$optionGroups)) {
	
				if (sizeof($optionGroups) != 0)
					echo '</optgroup>';
	
				$optionGroups[] = date('F Y', $curr_time);
				echo '<optgroup label="'.date('F Y', $curr_time).'">';
			}
			$first_label = (intval((sizeof($timeline_array) * 0.4)) - 1) == -1 ? 0 : (intval((sizeof($timeline_array) * 0.4)) - 1);
			$first_label = 0;
			$selected = $k == $first_label ? 'selected="selected"' : '';
	
			$date_item = $date_format == 'str' ? date('F j, Y', $curr_time) : date('d/m/Y', $curr_time);
	
			echo '<option '.$selected.' value="'.date('Y-m-d', $curr_time).'">'.$date_item.'</option>';
		}
		echo '</select>';
		echo '<select class="polling_select2" id="polling_select_'.$module_id.'_'.$poll_index.'_2" name="polling_select_'.$module_id.'_'.$poll_index.'_2">';
		$optionGroups = array();
		foreach ($timeline_array as $k => $curr_time) {
	
			if(!in_array(date('F Y', $curr_time),$optionGroups)) {
	
				if (sizeof($optionGroups) != 0)
					echo '</optgroup>';
	
				$optionGroups[] = date('F Y', $curr_time);
				echo '<optgroup label="'.date('F Y', $curr_time).'">';
			}
			$selected = $k == sizeof($timeline_array) - 1 ? 'selected="selected"' : '';
	
			$date_item = $date_format == 'str' ? date('F j, Y', $curr_time) : date('d/m/Y', $curr_time);
	
			echo '<option '.$selected.' value="'.date('Y-m-d', $curr_time).'">'.$date_item.'</option>';
		}
		echo '</select></div>';
		echo '</div>';
		echo '</div>';
		echo '</div></div>';
	}
	
	if(sizeof($custom_styles) > 0)
		foreach ($custom_styles as $poll_id => $styles_list) {
		$styles_array = explode('|',$styles_list);
		foreach ($styles_array as $val) {
			$arr = explode('~',$val);
			$styles_[$poll_id][$arr[0]] = $arr[1];
		}
	}
	
	
	//create javascript animation styles array
	$jsInclude = 'if (typeof animation_styles === \'undefined\') { var animation_styles = new Array();};';
	
	if(sizeof($styles_) > 0)
		foreach ($styles_ as $poll_id => $styles) {
		$s1 = $styles[12];//backround-color
		$s2 = $styles[73];//border-color
		$s3 = $styles[68].' '.$styles[69].'px '.$styles[70].'px '.$styles[71].'px '.$styles[72].'px '.$styles[11];//box-shadow
		$s4 = $styles[74].'px';//border-top-left-radius
		$s5 = $styles[75].'px';//border-top-right-radius
		$s6 = $styles[76].'px';//border-bottom-left-radius
		$s7 = $styles[77].'px';//border-bottom-right-radius
		$s8 = $styles[0];//static color
		$s9 = $styles[68];//shadow type
		$s9 = $styles[68];//shadow type
		$s10 = $styles[90];//navigation bar height
		$s11 = $styles[251];//Answer Color Inactive
		$s12 = $styles[270];//Answer Color Active
		$jsInclude .= 'animation_styles["'.$module_id.'_'.$poll_id.'"] = new Array("'.$s1.'", "'.$s2.'", "'.$s3.'", "'.$s4.'", "'.$s5.'", "'.$s6.'", "'.$s7.'","'.$s8.'","'.$s9.'","'.$s10.'","'.$s11.'","'.$s12.'");';
	}
	$jsInclude .= 'if (typeof sexyPolling_words === \'undefined\') { var sexyPolling_words = new Array();};';
	foreach ($polling_words as $k => $val) {
		$jsInclude .= 'sexyPolling_words["'.$k.'"] = "'.$val.'";';
	}
	$jsInclude .= 'if (typeof multipleAnswersInfoArray === \'undefined\') { var multipleAnswersInfoArray = new Array();};';
	foreach ($multiple_answers_info_array as $k => $val) {
		$jsInclude .= 'multipleAnswersInfoArray["'.$k.'"] = "'.$val.'";';
	}
	$jsInclude .= 'var newAnswerBarIndex = "'.$new_answer_bar_index.'";';
	$jsInclude .= 'var sexyIp = "'.$sexyip.'";';
	$jsInclude .= 'var autoOpenTimeline = "'.$autoOpenTimeline.'";';
	$jsInclude .= 'var autoAnimate = "'.$autoAnimate.'";';
	$jsInclude .= 'var sexyAutoPublish = "'.$autoPublish.'";';
	$jsInclude .= 'var dateFormat = "'.$date_format.'";';
	$jsInclude .= 'var sexyPath = "'.JURI::base(true).'/";';
	
	$jsInclude .= 'if (typeof sexyPollingIds === \'undefined\') { var sexyPollingIds = new Array();};';
	$k = 0;
	foreach ($polling_select_id as $poll_id) {
		$jsInclude .= 'sexyPollingIds.push(Array("'.$poll_id[select1].'","'.$poll_id[select2].'"));';
		$k ++;
	}
	$jsInclude .= 'if (typeof votedIds === \'undefined\') { var votedIds = new Array();};';
	foreach ($voted_ids as $voted_id) {
		$jsInclude .= 'votedIds.push(Array("'.$voted_id.'","'.$module_id.'"));';
	}
	$jsInclude .= 'if (typeof startDisabledIds === \'undefined\') { var startDisabledIds = new Array();};';
	foreach ($start_disabled_ids as $start_disabled_data) {
		$jsInclude .= 'startDisabledIds.push(Array("'.$start_disabled_data[0].'","'.$start_disabled_data[1].'","'.$module_id.'"));';
	}
	$jsInclude .= 'if (typeof endDisabledIds === \'undefined\') { var endDisabledIds = new Array();};';
	foreach ($end_disabled_ids as $end_disabled_data) {
		$jsInclude .= 'endDisabledIds.push(Array("'.$end_disabled_data[0].'","'.$end_disabled_data[1].'","'.$module_id.'"));';
	}
	$jsInclude .= 'if (typeof sexyAnimationTypeBar === \'undefined\') { var sexyAnimationTypeBar = new Array();};';
	$jsInclude .= 'sexyAnimationTypeBar["'.$module_id.'"] = "'.$sexyAnimationTypeBar.'";';
	$jsInclude .= 'if (typeof sexyAnimationTypeContainer === \'undefined\') { var sexyAnimationTypeContainer = new Array();};';
	$jsInclude .= 'sexyAnimationTypeContainer["'.$module_id.'"] = "'.$sexyAnimationTypeContainer.'";';
	$jsInclude .= 'if (typeof sexyAnimationTypeContainerMove === \'undefined\') { var sexyAnimationTypeContainerMove = new Array();};';
	$jsInclude .= 'sexyAnimationTypeContainerMove["'.$module_id.'"] = "'.$sexyAnimationTypeContainerMove.'";';
	$document->addScriptDeclaration ( $jsInclude );
?>

<?php 
echo '<style type="text/css">'; foreach($styles_ as $poll_id => $styles) { ?> 
#mod_<?php echo $module_id;?>_<?php echo $poll_id;?> .add_answer{border:<?php echo $styles[264];?>px <?php echo $styles[265];?> <?php echo $styles[263];?>;background-color:<?php echo $styles[273];?>;height:<?php echo $styles[272];?>px;-webkit-border-top-left-radius:<?php echo $styles[266];?>px;-moz-border-radius-topleft:<?php echo $styles[266];?>px;border-top-left-radius:<?php echo $styles[266];?>px;-webkit-border-top-right-radius:<?php echo $styles[267];?>px;-moz-border-radius-topright:<?php echo $styles[267];?>px;border-top-right-radius:<?php echo $styles[267];?>px;-webkit-border-bottom-left-radius:<?php echo $styles[268];?>px;-moz-border-radius-bottomleft:<?php echo $styles[268];?>px;border-bottom-left-radius:<?php echo $styles[268];?>px;-webkit-border-bottom-right-radius:<?php echo $styles[269];?>px;-moz-border-radius-bottomright:<?php echo $styles[269];?>px;border-bottom-right-radius:<?php echo $styles[269];?>px;-moz-box-shadow:<?php echo $styles[258];?> <?php echo $styles[259];?>px <?php echo $styles[260];?>px <?php echo $styles[261];?>px <?php echo $styles[262];?>px <?php echo $styles[257];?>;-webkit-box-shadow:<?php echo $styles[258];?> <?php echo $styles[259];?>px <?php echo $styles[260];?>px <?php echo $styles[261];?>px <?php echo $styles[262];?>px <?php echo $styles[257];?>;box-shadow:<?php echo $styles[258];?> <?php echo $styles[259];?>px <?php echo $styles[260];?>px <?php echo $styles[261];?>px <?php echo $styles[262];?>px <?php echo $styles[257];?>}#mod_<?php echo $module_id;?>_<?php echo $poll_id;?> .add_ans_name{color:<?php echo $styles[251];?>;font-size:<?php echo $styles[252];?>px;font-style:<?php echo $styles[254];?>;font-weight:<?php echo $styles[253];?>;text-decoration:<?php echo $styles[255];?>;font-family:<?php echo $styles[256];?>;text-shadow:<?php echo $styles[275];?>px <?php echo $styles[276];?>px <?php echo $styles[277];?>px <?php echo $styles[274];?>;-webkit-border-top-left-radius:<?php echo $styles[266];?>px;-moz-border-radius-topleft:<?php echo $styles[266];?>px;border-top-left-radius:<?php echo $styles[266];?>px;-webkit-border-top-right-radius:<?php echo $styles[267];?>px;-moz-border-radius-topright:<?php echo $styles[267];?>px;border-top-right-radius:<?php echo $styles[267];?>px;-webkit-border-bottom-left-radius:<?php echo $styles[268];?>px;-moz-border-radius-bottomleft:<?php echo $styles[268];?>px;border-bottom-left-radius:<?php echo $styles[268];?>px;-webkit-border-bottom-right-radius:<?php echo $styles[269];?>px;-moz-border-radius-bottomright:<?php echo $styles[269];?>px;border-bottom-right-radius:<?php echo $styles[269];?>px}#mod_<?php echo $module_id;?>_<?php echo $poll_id;?> .add_ans_submit{border-left:<?php echo $styles[264];?>px <?php echo $styles[265];?> <?php echo $styles[263];?>;color:<?php echo $styles[271];?>;font-size:<?php echo $styles[252];?>px;font-style:<?php echo $styles[254];?>;font-weight:<?php echo $styles[253];?>;text-decoration:<?php echo $styles[255];?>;font-family:<?php echo $styles[256];?>;text-shadow:<?php echo $styles[275];?>px <?php echo $styles[276];?>px <?php echo $styles[277];?>px <?php echo $styles[274];?>;-webkit-border-top-left-radius:<?php echo $styles[266];?>px;-moz-border-radius-topleft:<?php echo $styles[266];?>px;border-top-left-radius:<?php echo $styles[266];?>px;-webkit-border-top-right-radius:<?php echo $styles[267];?>px;-moz-border-radius-topright:<?php echo $styles[267];?>px;border-top-right-radius:<?php echo $styles[267];?>px;-webkit-border-bottom-left-radius:<?php echo $styles[268];?>px;-moz-border-radius-bottomleft:<?php echo $styles[268];?>px;border-bottom-left-radius:<?php echo $styles[268];?>px;-webkit-border-bottom-right-radius:<?php echo $styles[269];?>px;-moz-border-radius-bottomright:<?php echo $styles[269];?>px;border-bottom-right-radius:<?php echo $styles[269];?>px}
#mod_<?php echo $module_id;?>_<?php echo $poll_id;?> .polling_container { border: <?php echo $styles[2];?>px <?php echo $styles[165];?> <?php echo $styles[1];?>; background-color: <?php echo $styles[0];?>; -moz-box-shadow: <?php echo $styles[50];?> <?php echo $styles[46];?>px <?php echo $styles[47];?>px <?php echo $styles[48];?>px <?php echo $styles[49];?>px <?php echo $styles[3];?>; -webkit-box-shadow: <?php echo $styles[50];?> <?php echo $styles[46];?>px <?php echo $styles[47];?>px <?php echo $styles[48];?>px <?php echo $styles[49];?>px <?php echo $styles[3];?>; box-shadow: <?php echo $styles[50];?> <?php echo $styles[46];?>px <?php echo $styles[47];?>px <?php echo $styles[48];?>px <?php echo $styles[49];?>px <?php echo $styles[3];?>; -webkit-border-top-left-radius: <?php echo $styles[51];?>px; -moz-border-radius-topleft: <?php echo $styles[51];?>px; border-top-left-radius: <?php echo $styles[51];?>px; -webkit-border-top-right-radius: <?php echo $styles[52];?>px; -moz-border-radius-topright: <?php echo $styles[52];?>px; border-top-right-radius: <?php echo $styles[52];?>px; -webkit-border-bottom-left-radius: <?php echo $styles[53];?>px; -moz-border-radius-bottomleft: <?php echo $styles[53];?>px; border-bottom-left-radius: <?php echo $styles[53];?>px; -webkit-border-bottom-right-radius: <?php echo $styles[54];?>px; -moz-border-radius-bottomright: <?php echo $styles[54];?>px; border-bottom-right-radius: <?php echo $styles[54];?>px; } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?> .polling_container:hover { -moz-box-shadow: <?php echo $styles[55];?> <?php echo $styles[56];?>px <?php echo $styles[57];?>px <?php echo $styles[58];?>px <?php echo $styles[59];?>px <?php echo $styles[5];?>; -webkit-box-shadow: <?php echo $styles[55];?> <?php echo $styles[56];?>px <?php echo $styles[57];?>px <?php echo $styles[58];?>px <?php echo $styles[59];?>px <?php echo $styles[5];?>; box-shadow: <?php echo $styles[55];?> <?php echo $styles[56];?>px <?php echo $styles[57];?>px <?php echo $styles[58];?>px <?php echo $styles[59];?>px <?php echo $styles[5];?>; } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .polling_name { color: <?php echo $styles[7];?>; font-size: <?php echo $styles[8];?>px; font-style: <?php echo $styles[37];?>; font-weight: <?php echo $styles[36];?>; text-align: <?php echo $styles[39];?>; text-decoration: <?php echo $styles[38];?>; font-family: <?php echo $styles[40];?>; text-shadow: <?php echo $styles[60];?>px <?php echo $styles[61];?>px <?php echo $styles[62];?>px <?php echo $styles[63];?>; } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .answer_name { font-size: <?php echo $styles[10];?>px; color: <?php echo $styles[9];?>; font-style: <?php echo $styles[42];?>; font-weight: <?php echo $styles[41];?>; text-align: <?php echo $styles[44];?>; text-decoration: <?php echo $styles[43];?>; font-family: <?php echo $styles[45];?>; text-shadow: <?php echo $styles[64];?>px <?php echo $styles[65];?>px <?php echo $styles[66];?>px <?php echo $styles[67];?>; } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?> .polling_container .polling_li {} #mod_<?php echo $module_id;?>_<?php echo $poll_id;?> .polling_container .polling_li .animation_block { border: 1px solid <?php echo $styles[0];?>; -webkit-border-top-left-radius: <?php echo $styles[74];?>px; -moz-border-radius-topleft: <?php echo $styles[74];?>px; border-top-left-radius: <?php echo $styles[74];?>px; -webkit-border-top-right-radius: <?php echo $styles[75];?>px; -moz-border-radius-topright: <?php echo $styles[75];?>px; border-top-right-radius: <?php echo $styles[75];?>px; -webkit-border-bottom-left-radius: <?php echo $styles[76];?>px; -moz-border-radius-bottomleft: <?php echo $styles[76];?>px; border-bottom-left-radius: <?php echo $styles[76];?>px; -webkit-border-bottom-right-radius: <?php echo $styles[77];?>px; -moz-border-radius-bottomright: <?php echo $styles[77];?>px; border-bottom-right-radius: <?php echo $styles[77];?>px; background-color: <?php echo $styles[0];?>; box-shadow: <?php echo $styles[68];?> 0 0 0 0 <?php echo $styles[0];?>; } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .polling_container .polling_li.active_li { -moz-box-shadow: <?php echo $styles[68];?> <?php echo $styles[69];?>px <?php echo $styles[70];?>px <?php echo $styles[71];?>px <?php echo $styles[72];?>px <?php echo $styles[11];?>; -webkit-box-shadow: <?php echo $styles[68];?> <?php echo $styles[69];?>px <?php echo $styles[70];?>px <?php echo $styles[71];?>px <?php echo $styles[72];?>px <?php echo $styles[11];?>; box-shadow: <?php echo $styles[68];?> <?php echo $styles[69];?>px <?php echo $styles[70];?>px <?php echo $styles[71];?>px <?php echo $styles[72];?>px <?php echo $styles[11];?>; border: 1px solid <?php echo $styles[73];?>; background-color: <?php echo $styles[12];?>; }/* Polling Vote */ #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .polling_submit { background-color: <?php echo $styles[91];?>; padding: <?php echo $styles[92];?>px <?php echo $styles[93];?>px; -moz-box-shadow: <?php echo $styles[95];?> <?php echo $styles[96];?>px <?php echo $styles[97];?>px <?php echo $styles[98];?>px <?php echo $styles[99];?>px <?php echo $styles[94];?>; -webkit-box-shadow: <?php echo $styles[95];?> <?php echo $styles[96];?>px <?php echo $styles[97];?>px <?php echo $styles[98];?>px <?php echo $styles[99];?>px <?php echo $styles[94];?>; box-shadow: <?php echo $styles[95];?> <?php echo $styles[96];?>px <?php echo $styles[97];?>px <?php echo $styles[98];?>px <?php echo $styles[99];?>px <?php echo $styles[94];?>; border-style: <?php echo $styles[127];?>; border-width: <?php echo $styles[101];?>px; border-color: <?php echo $styles[100];?>; -webkit-border-top-left-radius: <?php echo $styles[102];?>px; -moz-border-radius-topleft: <?php echo $styles[102];?>px; border-top-left-radius: <?php echo $styles[102];?>px; -webkit-border-top-right-radius: <?php echo $styles[103];?>px; -moz-border-radius-topright: <?php echo $styles[103];?>px; border-top-right-radius: <?php echo $styles[103];?>px; -webkit-border-bottom-left-radius: <?php echo $styles[104];?>px; -moz-border-radius-bottomleft: <?php echo $styles[104];?>px; border-bottom-left-radius: <?php echo $styles[104];?>px; -webkit-border-bottom-right-radius: <?php echo $styles[105];?>px; -moz-border-radius-bottomright: <?php echo $styles[105];?>px; border-bottom-right-radius: <?php echo $styles[105];?>px;font-size: <?php echo $styles[107];?>px; color: <?php echo $styles[106];?>; font-style: <?php echo $styles[109];?>; font-weight: <?php echo $styles[108];?>; text-decoration: <?php echo $styles[110];?>; font-family: <?php echo $styles[112];?>; text-shadow: <?php echo $styles[114];?>px <?php echo $styles[115];?>px <?php echo $styles[116];?>px <?php echo $styles[113];?>; } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .polling_submit:hover { background-color:<?php echo $styles[123];?>; color: <?php echo $styles[124];?>; text-shadow: <?php echo $styles[114];?>px <?php echo $styles[115];?>px <?php echo $styles[116];?>px <?php echo $styles[125];?>; -moz-box-shadow: <?php echo $styles[118];?> <?php echo $styles[119];?>px <?php echo $styles[120];?>px <?php echo $styles[121];?>px <?php echo $styles[122];?>px <?php echo $styles[117];?>; -webkit-box-shadow: <?php echo $styles[118];?> <?php echo $styles[119];?>px <?php echo $styles[120];?>px <?php echo $styles[121];?>px <?php echo $styles[122];?>px <?php echo $styles[117];?>; box-shadow: <?php echo $styles[118];?> <?php echo $styles[119];?>px <?php echo $styles[120];?>px <?php echo $styles[121];?>px <?php echo $styles[122];?>px <?php echo $styles[117];?>; border-style: <?php echo $styles[127];?>; border-width: <?php echo $styles[101];?>px; border-color: <?php echo $styles[126];?>; }/* Polling result */ #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .polling_result { background-color: <?php echo $styles[128];?>; padding: <?php echo $styles[129];?>px <?php echo $styles[130];?>px; -moz-box-shadow: <?php echo $styles[132];?> <?php echo $styles[133];?>px <?php echo $styles[134];?>px <?php echo $styles[135];?>px <?php echo $styles[136];?>px <?php echo $styles[131];?>; -webkit-box-shadow: <?php echo $styles[132];?> <?php echo $styles[133];?>px <?php echo $styles[134];?>px <?php echo $styles[135];?>px <?php echo $styles[136];?>px <?php echo $styles[131];?>; box-shadow: <?php echo $styles[132];?> <?php echo $styles[133];?>px <?php echo $styles[134];?>px <?php echo $styles[135];?>px <?php echo $styles[136];?>px <?php echo $styles[131];?>; border-style: <?php echo $styles[164];?>; border-width: <?php echo $styles[138];?>px; border-color: <?php echo $styles[137];?>; -webkit-border-top-left-radius: <?php echo $styles[139];?>px; -moz-border-radius-topleft: <?php echo $styles[139];?>px; border-top-left-radius: <?php echo $styles[139];?>px; -webkit-border-top-right-radius: <?php echo $styles[140];?>px; -moz-border-radius-topright: <?php echo $styles[140];?>px; border-top-right-radius: <?php echo $styles[140];?>px; -webkit-border-bottom-left-radius: <?php echo $styles[141];?>px; -moz-border-radius-bottomleft: <?php echo $styles[141];?>px; border-bottom-left-radius: <?php echo $styles[141];?>px; -webkit-border-bottom-right-radius: <?php echo $styles[142];?>px; -moz-border-radius-bottomright: <?php echo $styles[142];?>px; border-bottom-right-radius: <?php echo $styles[142];?>px;font-size: <?php echo $styles[144];?>px; color: <?php echo $styles[143];?>; font-style: <?php echo $styles[146];?>; font-weight: <?php echo $styles[145];?>; text-decoration: <?php echo $styles[147];?>; font-family: <?php echo $styles[149];?>; text-shadow: <?php echo $styles[151];?>px <?php echo $styles[152];?>px <?php echo $styles[153];?>px <?php echo $styles[150];?>; } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .polling_result:hover { background-color:<?php echo $styles[160];?>; color: <?php echo $styles[161];?>; text-shadow: <?php echo $styles[151];?>px <?php echo $styles[152];?>px <?php echo $styles[153];?>px <?php echo $styles[162];?>; -moz-box-shadow: <?php echo $styles[155];?> <?php echo $styles[156];?>px <?php echo $styles[157];?>px <?php echo $styles[158];?>px <?php echo $styles[159];?>px <?php echo $styles[154];?>; -webkit-box-shadow: <?php echo $styles[155];?> <?php echo $styles[156];?>px <?php echo $styles[157];?>px <?php echo $styles[158];?>px <?php echo $styles[159];?>px <?php echo $styles[154];?>; box-shadow: <?php echo $styles[155];?> <?php echo $styles[156];?>px <?php echo $styles[157];?>px <?php echo $styles[158];?>px <?php echo $styles[159];?>px <?php echo $styles[154];?>; border-style: <?php echo $styles[164];?>; border-width: <?php echo $styles[138];?>px; border-color: <?php echo $styles[163];?>; }#mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .answer_navigation { -webkit-border-top-left-radius: <?php echo $styles[85];?>px; -moz-border-radius-topleft: <?php echo $styles[85];?>px; border-top-left-radius: <?php echo $styles[85];?>px; -webkit-border-top-right-radius: <?php echo $styles[86];?>px; -moz-border-radius-topright: <?php echo $styles[86];?>px; border-top-right-radius: <?php echo $styles[86];?>px; -webkit-border-bottom-left-radius: <?php echo $styles[87];?>px; -moz-border-radius-bottomleft: <?php echo $styles[87];?>px; border-bottom-left-radius: <?php echo $styles[87];?>px; -webkit-border-bottom-right-radius: <?php echo $styles[88];?>px; -moz-border-radius-bottomright: <?php echo $styles[88];?>px; border-bottom-right-radius: <?php echo $styles[88];?>px; height: <?php echo $styles[90];?>; -moz-box-shadow: <?php echo $styles[79];?> <?php echo $styles[80];?>px <?php echo $styles[81];?>px <?php echo $styles[82];?>px <?php echo $styles[83];?>px <?php echo $styles[78];?>; -webkit-box-shadow: <?php echo $styles[79];?> <?php echo $styles[80];?>px <?php echo $styles[81];?>px <?php echo $styles[82];?>px <?php echo $styles[83];?>px <?php echo $styles[78];?>; box-shadow: <?php echo $styles[79];?> <?php echo $styles[80];?>px <?php echo $styles[81];?>px <?php echo $styles[82];?>px <?php echo $styles[83];?>px <?php echo $styles[78];?>; border: <?php echo $styles[89];?>px solid <?php echo $styles[84];?>; } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .grad1 { -moz-box-shadow: <?php echo $styles[79];?> <?php echo $styles[80];?>px <?php echo $styles[81];?>px <?php echo $styles[82];?>px <?php echo $styles[83];?>px <?php echo $styles[78];?>; -webkit-box-shadow: <?php echo $styles[79];?> <?php echo $styles[80];?>px <?php echo $styles[81];?>px <?php echo $styles[82];?>px <?php echo $styles[83];?>px <?php echo $styles[78];?>; box-shadow: <?php echo $styles[79];?> <?php echo $styles[80];?>px <?php echo $styles[81];?>px <?php echo $styles[82];?>px <?php echo $styles[83];?>px <?php echo $styles[78];?>; border: <?php echo $styles[89];?>px solid <?php echo $styles[84];?>; -webkit-border-top-left-radius: <?php echo $styles[85];?>px; -moz-border-radius-topleft: <?php echo $styles[85];?>px; border-top-left-radius: <?php echo $styles[85];?>px; -webkit-border-top-right-radius: <?php echo $styles[86];?>px; -moz-border-radius-topright: <?php echo $styles[86];?>px; border-top-right-radius: <?php echo $styles[86];?>px; -webkit-border-bottom-left-radius: <?php echo $styles[87];?>px; -moz-border-radius-bottomleft: <?php echo $styles[87];?>px; border-bottom-left-radius: <?php echo $styles[87];?>px; -webkit-border-bottom-right-radius: <?php echo $styles[88];?>px; -moz-border-radius-bottomright: <?php echo $styles[88];?>px; border-bottom-right-radius: <?php echo $styles[88];?>px; }#mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .answer_votes_data { font-size: <?php echo $styles[167];?>px; color: <?php echo $styles[166];?>; font-style: <?php echo $styles[169];?>; font-weight: <?php echo $styles[168];?>; text-decoration: <?php echo $styles[170];?>; font-family: <?php echo $styles[171];?>; text-shadow: <?php echo $styles[173];?>px <?php echo $styles[174];?>px <?php echo $styles[175];?>px <?php echo $styles[172];?>; } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .answer_votes_data span { font-size: <?php echo $styles[177];?>px; color: <?php echo $styles[176];?>; font-style: <?php echo $styles[179];?>; font-weight: <?php echo $styles[178];?>; text-decoration: <?php echo $styles[180];?>; font-family: <?php echo $styles[181];?>; text-shadow: <?php echo $styles[183];?>px <?php echo $styles[184];?>px <?php echo $styles[185];?>px <?php echo $styles[182];?>; } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .left_col { font-size: <?php echo $styles[187];?>px; color: <?php echo $styles[186];?>; font-style: <?php echo $styles[189];?>; font-weight: <?php echo $styles[188];?>; text-decoration: <?php echo $styles[190];?>; font-family: <?php echo $styles[191];?>; text-shadow: <?php echo $styles[193];?>px <?php echo $styles[194];?>px <?php echo $styles[195];?>px <?php echo $styles[192];?>; } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .right_col { font-size: <?php echo $styles[197];?>px; color: <?php echo $styles[196];?>; font-style: <?php echo $styles[199];?>; font-weight: <?php echo $styles[198];?>; text-decoration: <?php echo $styles[200];?>; font-family: <?php echo $styles[201];?>; text-shadow: <?php echo $styles[203];?>px <?php echo $styles[204];?>px <?php echo $styles[205];?>px <?php echo $styles[202];?>; }#mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .polling_select1,#mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .polling_select2 { background-color: <?php echo $styles[206]?>; padding: <?php echo $styles[207]?>px <?php echo $styles[208]?>px; font-size: <?php echo $styles[210];?>px; color: <?php echo $styles[209];?>; font-style: <?php echo $styles[212];?>; font-weight: <?php echo $styles[211];?>; text-decoration: <?php echo $styles[213];?>; font-family: <?php echo $styles[214];?>; text-shadow: <?php echo $styles[216];?>px <?php echo $styles[217];?>px <?php echo $styles[218];?>px <?php echo $styles[215];?>; border: <?php echo $styles[220];?>px <?php echo $styles[221];?> <?php echo $styles[219];?>; -webkit-border-top-left-radius: <?php echo $styles[222];?>px; -moz-border-radius-topleft: <?php echo $styles[222];?>px; border-top-left-radius: <?php echo $styles[222];?>px; -webkit-border-top-right-radius: <?php echo $styles[223];?>px; -moz-border-radius-topright: <?php echo $styles[223];?>px; border-top-right-radius: <?php echo $styles[223];?>px; -webkit-border-bottom-left-radius: <?php echo $styles[224];?>px; -moz-border-radius-bottomleft: <?php echo $styles[224];?>px; border-bottom-left-radius: <?php echo $styles[224];?>px; -webkit-border-bottom-right-radius: <?php echo $styles[225];?>px; -moz-border-radius-bottomright: <?php echo $styles[225];?>px; border-bottom-right-radius: <?php echo $styles[225];?>px; }#mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .polling_select1:hover,#mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .polling_select1:focus { background-color: <?php echo $styles[226]?>; color: <?php echo $styles[228];?>; border: <?php echo $styles[220];?>px <?php echo $styles[221];?> <?php echo $styles[227];?>; text-shadow: <?php echo $styles[216];?>px <?php echo $styles[217];?>px <?php echo $styles[218];?>px <?php echo $styles[229];?>; }#mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .polling_select2:hover,#mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .polling_select2:focus { background-color: <?php echo $styles[226]?>; color: <?php echo $styles[228];?>; border: <?php echo $styles[220];?>px <?php echo $styles[221];?> <?php echo $styles[227];?>; text-shadow: <?php echo $styles[216];?>px <?php echo $styles[217];?>px <?php echo $styles[218];?>px <?php echo $styles[229];?>; }/* slider */ #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .ui-corner-all { -webkit-border-radius: <?php echo $styles[232];?>px; -moz-border-radius: <?php echo $styles[232];?>px; border-radius: <?php echo $styles[232];?>px; } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .ui-widget-content { background: none; background-color: <?php echo $styles[230];?>; border-color: <?php echo $styles[231];?>; color: <?php echo $styles[231];?>; } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .ui-widget-content .ui-state-default{ background: none; background-color: <?php echo $styles[235];?>; border: 1px solid <?php echo $styles[236];?>; } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .ui-widget-content .ui-state-default:hover { background: none; background-color: <?php echo $styles[237];?>; border: 1px solid <?php echo $styles[238];?>; } /*keep this for js loaded file*/ #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .ui-widget-content .ui-state-hover, .ui-widget-content .ui-state-focus{ background: none; background-color: <?php echo $styles[237];?>; border: 1px solid <?php echo $styles[238];?>; } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .ui-slider dt { border-bottom: 1px dotted <?php echo $styles[249];?>; font-size: <?php echo $styles[248];?>px; color: <?php echo $styles[239];?>; font-style: <?php echo $styles[241];?>; font-weight: <?php echo $styles[240];?>; text-decoration: <?php echo $styles[242];?>; font-family: <?php echo $styles[243];?>; text-shadow: <?php echo $styles[245];?>px <?php echo $styles[246];?>px <?php echo $styles[247];?>px <?php echo $styles[244];?>; top: 12px; height: <?php echo $styles[250];?>px; }#mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .ui-widget-header { background: none; background-color: <?php echo $styles[234];?>; background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[233];?>), to(<?php echo $styles[234];?>));/* Safari 4-5, Chrome 1-9 */ background: -webkit-linear-gradient(top, <?php echo $styles[233];?>, <?php echo $styles[234];?>); /* Safari 5.1, Chrome 10+ */ background: -moz-linear-gradient(top, <?php echo $styles[233];?>, <?php echo $styles[234];?>);/* Firefox 3.6+ */ background: -ms-linear-gradient(top, <?php echo $styles[233];?>, <?php echo $styles[234];?>);/* IE 10 */ background: -o-linear-gradient(top, <?php echo $styles[233];?>, <?php echo $styles[234];?>);/* Opera 11.10+ */ filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[233];?>', endColorstr='<?php echo $styles[234];?>'); /* for IE */ } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .ui-slider dt span { background: <?php echo $styles[0];?>; } /* answers */ #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .polling_bar_1{ background-color: <?php echo $styles[501];?>; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[500];?>', endColorstr='<?php echo $styles[501];?>'); /* for IE */ background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[500];?>), to(<?php echo $styles[501];?>));/* Safari 4-5, Chrome 1-9 */ background: -webkit-linear-gradient(top, <?php echo $styles[500];?>, <?php echo $styles[501];?>); /* Safari 5.1, Chrome 10+ */ background: -moz-linear-gradient(top, <?php echo $styles[500];?>, <?php echo $styles[501];?>);/* Firefox 3.6+ */ background: -ms-linear-gradient(top, <?php echo $styles[500];?>, <?php echo $styles[501];?>);/* IE 10 */ background: -o-linear-gradient(top, <?php echo $styles[500];?>, <?php echo $styles[501];?>);/* Opera 11.10+ */ } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .polling_bar_2{ background-color: <?php echo $styles[503];?>; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[502];?>', endColorstr='<?php echo $styles[503];?>'); /* for IE */ background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[502];?>), to(<?php echo $styles[501];?>));/* Safari 4-5, Chrome 1-9 */ background: -webkit-linear-gradient(top, <?php echo $styles[502];?>, <?php echo $styles[503];?>); /* Safari 5.1, Chrome 10+ */ background: -moz-linear-gradient(top, <?php echo $styles[502];?>, <?php echo $styles[503];?>);/* Firefox 3.6+ */ background: -ms-linear-gradient(top, <?php echo $styles[502];?>, <?php echo $styles[503];?>);/* IE 10 */ background: -o-linear-gradient(top, <?php echo $styles[502];?>, <?php echo $styles[503];?>);/* Opera 11.10+ */ } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .polling_bar_3 { background-color: <?php echo $styles[505];?>; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[504];?>', endColorstr='<?php echo $styles[505];?>'); /* for IE */ background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[504];?>), to(<?php echo $styles[505];?>));/* Safari 4-5, Chrome 1-9 */ background: -webkit-linear-gradient(top, <?php echo $styles[504];?>, <?php echo $styles[505];?>); /* Safari 5.1, Chrome 10+ */ background: -moz-linear-gradient(top, <?php echo $styles[504];?>, <?php echo $styles[505];?>);/* Firefox 3.6+ */ background: -ms-linear-gradient(top, <?php echo $styles[504];?>, <?php echo $styles[505];?>);/* IE 10 */ background: -o-linear-gradient(top, <?php echo $styles[504];?>, <?php echo $styles[505];?>);/* Opera 11.10+ */ } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .polling_bar_4 { background-color: <?php echo $styles[507];?>; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[506];?>', endColorstr='<?php echo $styles[507];?>'); /* for IE */ background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[506];?>), to(<?php echo $styles[507];?>));/* Safari 4-5, Chrome 1-9 */ background: -webkit-linear-gradient(top, <?php echo $styles[506];?>, <?php echo $styles[507];?>); /* Safari 5.1, Chrome 10+ */ background: -moz-linear-gradient(top, <?php echo $styles[506];?>, <?php echo $styles[507];?>);/* Firefox 3.6+ */ background: -ms-linear-gradient(top, <?php echo $styles[506];?>, <?php echo $styles[507];?>);/* IE 10 */ background: -o-linear-gradient(top, <?php echo $styles[506];?>, <?php echo $styles[507];?>);/* Opera 11.10+ */ } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .polling_bar_5 { background-color: <?php echo $styles[509];?>; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[508];?>', endColorstr='<?php echo $styles[509];?>'); /* for IE */ background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[508];?>), to(<?php echo $styles[509];?>));/* Safari 4-5, Chrome 1-9 */ background: -webkit-linear-gradient(top, <?php echo $styles[508];?>, <?php echo $styles[509];?>); /* Safari 5.1, Chrome 10+ */ background: -moz-linear-gradient(top, <?php echo $styles[508];?>, <?php echo $styles[509];?>);/* Firefox 3.6+ */ background: -ms-linear-gradient(top, <?php echo $styles[508];?>, <?php echo $styles[509];?>);/* IE 10 */ background: -o-linear-gradient(top, <?php echo $styles[508];?>, <?php echo $styles[509];?>);/* Opera 11.10+ */ } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .polling_bar_6 { background-color: <?php echo $styles[511];?>; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[510];?>', endColorstr='<?php echo $styles[511];?>'); /* for IE */ background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[510];?>), to(<?php echo $styles[511];?>));/* Safari 4-5, Chrome 1-9 */ background: -webkit-linear-gradient(top, <?php echo $styles[510];?>, <?php echo $styles[511];?>); /* Safari 5.1, Chrome 10+ */ background: -moz-linear-gradient(top, <?php echo $styles[510];?>, <?php echo $styles[511];?>);/* Firefox 3.6+ */ background: -ms-linear-gradient(top, <?php echo $styles[510];?>, <?php echo $styles[511];?>);/* IE 10 */ background: -o-linear-gradient(top, <?php echo $styles[510];?>, <?php echo $styles[511];?>);/* Opera 11.10+ */ } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .polling_bar_7 { background-color: <?php echo $styles[513];?>; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[512];?>', endColorstr='<?php echo $styles[513];?>'); /* for IE */ background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[512];?>), to(<?php echo $styles[513];?>));/* Safari 4-5, Chrome 1-9 */ background: -webkit-linear-gradient(top, <?php echo $styles[512];?>, <?php echo $styles[513];?>); /* Safari 5.1, Chrome 10+ */ background: -moz-linear-gradient(top, <?php echo $styles[512];?>, <?php echo $styles[513];?>);/* Firefox 3.6+ */ background: -ms-linear-gradient(top, <?php echo $styles[512];?>, <?php echo $styles[513];?>);/* IE 10 */ background: -o-linear-gradient(top, <?php echo $styles[512];?>, <?php echo $styles[513];?>);/* Opera 11.10+ */ } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .polling_bar_8 { background-color: <?php echo $styles[515];?>; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[514];?>', endColorstr='<?php echo $styles[515];?>'); /* for IE */ background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[514];?>), to(<?php echo $styles[515];?>));/* Safari 4-5, Chrome 1-9 */ background: -webkit-linear-gradient(top, <?php echo $styles[514];?>, <?php echo $styles[515];?>); /* Safari 5.1, Chrome 10+ */ background: -moz-linear-gradient(top, <?php echo $styles[514];?>, <?php echo $styles[515];?>);/* Firefox 3.6+ */ background: -ms-linear-gradient(top, <?php echo $styles[514];?>, <?php echo $styles[515];?>);/* IE 10 */ background: -o-linear-gradient(top, <?php echo $styles[514];?>, <?php echo $styles[515];?>);/* Opera 11.10+ */ } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .polling_bar_9 { background-color: <?php echo $styles[517];?>; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[516];?>', endColorstr='<?php echo $styles[517];?>'); /* for IE */ background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[516];?>), to(<?php echo $styles[517];?>));/* Safari 4-5, Chrome 1-9 */ background: -webkit-linear-gradient(top, <?php echo $styles[516];?>, <?php echo $styles[517];?>); /* Safari 5.1, Chrome 10+ */ background: -moz-linear-gradient(top, <?php echo $styles[516];?>, <?php echo $styles[517];?>);/* Firefox 3.6+ */ background: -ms-linear-gradient(top, <?php echo $styles[516];?>, <?php echo $styles[517];?>);/* IE 10 */ background: -o-linear-gradient(top, <?php echo $styles[516];?>, <?php echo $styles[517];?>);/* Opera 11.10+ */ } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .polling_bar_10 { background-color: <?php echo $styles[519];?>; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[518];?>', endColorstr='<?php echo $styles[519];?>'); /* for IE */ background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[518];?>), to(<?php echo $styles[519];?>));/* Safari 4-5, Chrome 1-9 */ background: -webkit-linear-gradient(top, <?php echo $styles[518];?>, <?php echo $styles[519];?>); /* Safari 5.1, Chrome 10+ */ background: -moz-linear-gradient(top, <?php echo $styles[518];?>, <?php echo $styles[519];?>);/* Firefox 3.6+ */ background: -ms-linear-gradient(top, <?php echo $styles[518];?>, <?php echo $styles[519];?>);/* IE 10 */ background: -o-linear-gradient(top, <?php echo $styles[518];?>, <?php echo $styles[519];?>);/* Opera 11.10+ */ } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .polling_bar_11 { background-color: <?php echo $styles[521];?>; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[520];?>', endColorstr='<?php echo $styles[521];?>'); /* for IE */ background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[520];?>), to(<?php echo $styles[521];?>));/* Safari 4-5, Chrome 1-9 */ background: -webkit-linear-gradient(top, <?php echo $styles[520];?>, <?php echo $styles[521];?>); /* Safari 5.1, Chrome 10+ */ background: -moz-linear-gradient(top, <?php echo $styles[520];?>, <?php echo $styles[521];?>);/* Firefox 3.6+ */ background: -ms-linear-gradient(top, <?php echo $styles[520];?>, <?php echo $styles[521];?>);/* IE 10 */ background: -o-linear-gradient(top, <?php echo $styles[520];?>, <?php echo $styles[521];?>);/* Opera 11.10+ */ } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .polling_bar_12 { background-color: <?php echo $styles[523];?>; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[522];?>', endColorstr='<?php echo $styles[523];?>'); /* for IE */ background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[522];?>), to(<?php echo $styles[523];?>));/* Safari 4-5, Chrome 1-9 */ background: -webkit-linear-gradient(top, <?php echo $styles[522];?>, <?php echo $styles[523];?>); /* Safari 5.1, Chrome 10+ */ background: -moz-linear-gradient(top, <?php echo $styles[522];?>, <?php echo $styles[523];?>);/* Firefox 3.6+ */ background: -ms-linear-gradient(top, <?php echo $styles[522];?>, <?php echo $styles[523];?>);/* IE 10 */ background: -o-linear-gradient(top, <?php echo $styles[522];?>, <?php echo $styles[523];?>);/* Opera 11.10+ */ } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .polling_bar_13 { background-color: <?php echo $styles[525];?>; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[524];?>', endColorstr='<?php echo $styles[525];?>'); /* for IE */ background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[524];?>), to(<?php echo $styles[525];?>));/* Safari 4-5, Chrome 1-9 */ background: -webkit-linear-gradient(top, <?php echo $styles[524];?>, <?php echo $styles[525];?>); /* Safari 5.1, Chrome 10+ */ background: -moz-linear-gradient(top, <?php echo $styles[524];?>, <?php echo $styles[525];?>);/* Firefox 3.6+ */ background: -ms-linear-gradient(top, <?php echo $styles[524];?>, <?php echo $styles[525];?>);/* IE 10 */ background: -o-linear-gradient(top, <?php echo $styles[524];?>, <?php echo $styles[525];?>);/* Opera 11.10+ */ } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .polling_bar_14 { background-color: <?php echo $styles[527];?>; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[526];?>', endColorstr='<?php echo $styles[527];?>'); /* for IE */ background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[526];?>), to(<?php echo $styles[527];?>));/* Safari 4-5, Chrome 1-9 */ background: -webkit-linear-gradient(top, <?php echo $styles[526];?>, <?php echo $styles[527];?>); /* Safari 5.1, Chrome 10+ */ background: -moz-linear-gradient(top, <?php echo $styles[526];?>, <?php echo $styles[527];?>);/* Firefox 3.6+ */ background: -ms-linear-gradient(top, <?php echo $styles[526];?>, <?php echo $styles[527];?>);/* IE 10 */ background: -o-linear-gradient(top, <?php echo $styles[526];?>, <?php echo $styles[527];?>);/* Opera 11.10+ */ } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .polling_bar_15 { background-color: <?php echo $styles[529];?>; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[528];?>', endColorstr='<?php echo $styles[529];?>'); /* for IE */ background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[528];?>), to(<?php echo $styles[529];?>));/* Safari 4-5, Chrome 1-9 */ background: -webkit-linear-gradient(top, <?php echo $styles[528];?>, <?php echo $styles[529];?>); /* Safari 5.1, Chrome 10+ */ background: -moz-linear-gradient(top, <?php echo $styles[528];?>, <?php echo $styles[529];?>);/* Firefox 3.6+ */ background: -ms-linear-gradient(top, <?php echo $styles[528];?>, <?php echo $styles[529];?>);/* IE 10 */ background: -o-linear-gradient(top, <?php echo $styles[528];?>, <?php echo $styles[529];?>);/* Opera 11.10+ */ } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .polling_bar_16 { background-color: <?php echo $styles[531];?>; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[530];?>', endColorstr='<?php echo $styles[531];?>'); /* for IE */ background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[530];?>), to(<?php echo $styles[531];?>));/* Safari 4-5, Chrome 1-9 */ background: -webkit-linear-gradient(top, <?php echo $styles[530];?>, <?php echo $styles[531];?>); /* Safari 5.1, Chrome 10+ */ background: -moz-linear-gradient(top, <?php echo $styles[530];?>, <?php echo $styles[531];?>);/* Firefox 3.6+ */ background: -ms-linear-gradient(top, <?php echo $styles[530];?>, <?php echo $styles[531];?>);/* IE 10 */ background: -o-linear-gradient(top, <?php echo $styles[530];?>, <?php echo $styles[531];?>);/* Opera 11.10+ */ } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .polling_bar_17 { background-color: <?php echo $styles[533];?>; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[532];?>', endColorstr='<?php echo $styles[533];?>'); /* for IE */ background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[532];?>), to(<?php echo $styles[533];?>));/* Safari 4-5, Chrome 1-9 */ background: -webkit-linear-gradient(top, <?php echo $styles[532];?>, <?php echo $styles[533];?>); /* Safari 5.1, Chrome 10+ */ background: -moz-linear-gradient(top, <?php echo $styles[532];?>, <?php echo $styles[533];?>);/* Firefox 3.6+ */ background: -ms-linear-gradient(top, <?php echo $styles[532];?>, <?php echo $styles[533];?>);/* IE 10 */ background: -o-linear-gradient(top, <?php echo $styles[532];?>, <?php echo $styles[533];?>);/* Opera 11.10+ */ } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .polling_bar_18 { background-color: <?php echo $styles[535];?>; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[534];?>', endColorstr='<?php echo $styles[535];?>'); /* for IE */ background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[534];?>), to(<?php echo $styles[535];?>));/* Safari 4-5, Chrome 1-9 */ background: -webkit-linear-gradient(top, <?php echo $styles[534];?>, <?php echo $styles[535];?>); /* Safari 5.1, Chrome 10+ */ background: -moz-linear-gradient(top, <?php echo $styles[534];?>, <?php echo $styles[535];?>);/* Firefox 3.6+ */ background: -ms-linear-gradient(top, <?php echo $styles[534];?>, <?php echo $styles[535];?>);/* IE 10 */ background: -o-linear-gradient(top, <?php echo $styles[534];?>, <?php echo $styles[535];?>);/* Opera 11.10+ */ } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .polling_bar_19 { background-color: <?php echo $styles[537];?>; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[536];?>', endColorstr='<?php echo $styles[537];?>'); /* for IE */ background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[536];?>), to(<?php echo $styles[537];?>));/* Safari 4-5, Chrome 1-9 */ background: -webkit-linear-gradient(top, <?php echo $styles[536];?>, <?php echo $styles[537];?>); /* Safari 5.1, Chrome 10+ */ background: -moz-linear-gradient(top, <?php echo $styles[536];?>, <?php echo $styles[537];?>);/* Firefox 3.6+ */ background: -ms-linear-gradient(top, <?php echo $styles[536];?>, <?php echo $styles[537];?>);/* IE 10 */ background: -o-linear-gradient(top, <?php echo $styles[536];?>, <?php echo $styles[537];?>);/* Opera 11.10+ */ } #mod_<?php echo $module_id;?>_<?php echo $poll_id;?>  .polling_bar_20 { background-color: <?php echo $styles[539];?>; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[538];?>', endColorstr='<?php echo $styles[539];?>'); /* for IE */ background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[538];?>), to(<?php echo $styles[539];?>));/* Safari 4-5, Chrome 1-9 */ background: -webkit-linear-gradient(top, <?php echo $styles[538];?>, <?php echo $styles[539];?>); /* Safari 5.1, Chrome 10+ */ background: -moz-linear-gradient(top, <?php echo $styles[538];?>, <?php echo $styles[539];?>);/* Firefox 3.6+ */ background: -ms-linear-gradient(top, <?php echo $styles[538];?>, <?php echo $styles[539];?>);/* IE 10 */ background: -o-linear-gradient(top, <?php echo $styles[538];?>, <?php echo $styles[539];?>);/* Opera 11.10+ */ } <?php } echo '</style>';
?>