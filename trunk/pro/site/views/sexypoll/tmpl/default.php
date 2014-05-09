<?php
/**
 * Joomla! component sexypolling
 *
 * @version $Id: default.php 2012-04-05 14:30:25 svn $
 * @author 2GLux.com
 * @package Sexy Polling
 * @subpackage com_sexypolling
 * @license GNU/GPL
 *
 */

// no direct access
defined('_JEXEC') or die('Restircted access');

//get ip
$REMOTE_ADDR = null;
if(isset($_SERVER['REMOTE_ADDR'])) { $REMOTE_ADDR = $_SERVER['REMOTE_ADDR']; }
elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { $REMOTE_ADDR = $_SERVER['HTTP_X_FORWARDED_FOR']; }
elseif(isset($_SERVER['HTTP_CLIENT_IP'])) { $REMOTE_ADDR = $_SERVER['HTTP_CLIENT_IP']; }
elseif(isset($_SERVER['HTTP_VIA'])) { $REMOTE_ADDR = $_SERVER['HTTP_VIA']; }
else { $REMOTE_ADDR = 'Unknown'; }
$sexyip = $REMOTE_ADDR;

$comparams = JComponentHelper::getParams( 'com_sexypolling' );
$version = '1.0.7-pro';

//get user groups
$user = JFactory::getUser();
$user_id = $user->get('id');
jimport( 'joomla.access.access' );
$groups = JAccess::getGroupsByUser($user_id);

//add scripts, styles
$document = JFactory::getDocument();

$cssFile = JURI::base(true).'/components/com_sexypolling/assets/css/main.css?version='.$version;
$document->addStyleSheet($cssFile, 'text/css', null, array());

$cssFile = JURI::base(true).'/components/com_sexypolling/assets/css/sexycss-ui.css';
$document->addStyleSheet($cssFile, 'text/css', null, array());

$cssFile = JURI::base(true).'/components/com_sexypolling/assets/css/countdown.css';
$document->addStyleSheet($cssFile, 'text/css', null, array());

$jsFile = JURI::base(true).'/components/com_sexypolling/assets/js/sexylib.js';
$document->addScript($jsFile);

$jsFile = JURI::base(true).'/components/com_sexypolling/assets/js/sexylib-ui.js';
$document->addScript($jsFile);

$jsFile = JURI::base(true).'/components/com_sexypolling/assets/js/selectToUISlider.jQuery.js';
$document->addScript($jsFile);

$jsFile = JURI::base(true).'/components/com_sexypolling/assets/js/color.js';
$document->addScript($jsFile);

$jsFile = JURI::base(true).'/components/com_sexypolling/assets/js/countdown.js';
$document->addScript($jsFile);

$jsFile = JURI::base(true).'/components/com_sexypolling/assets/js/sexypolling.js?version='.$version;
$document->addScript($jsFile);

$id_poll = isset($_REQUEST['poll']) ? (int)$_REQUEST['poll'] : 0;
$cssFile = JURI::base(true).'/components/com_sexypolling/generate.css.php?id_poll='.$id_poll.'&module_id=0';
$document->addStyleSheet($cssFile, 'text/css', null, array());


// get a parameter from the module's configuration
$module_id = 0;
$db = JFactory::getDBO();

$polling_words = array(JText::_("COM_SEXYPOLLING_WORD_1"),JText::_("COM_SEXYPOLLING_WORD_2"),JText::_("COM_SEXYPOLLING_WORD_3"),JText::_("COM_SEXYPOLLING_WORD_4"),JText::_("COM_SEXYPOLLING_WORD_5"),JText::_("COM_SEXYPOLLING_WORD_6"),JText::_("COM_SEXYPOLLING_WORD_7"),JText::_("COM_SEXYPOLLING_WORD_8"),JText::_("COM_SEXYPOLLING_WORD_9"),JText::_("COM_SEXYPOLLING_WORD_10"),JText::_("COM_SEXYPOLLING_WORD_11"),JText::_("COM_SEXYPOLLING_WORD_12"),JText::_("COM_SEXYPOLLING_WORD_13"),JText::_("COM_SEXYPOLLING_WORD_14"),JText::_("COM_SEXYPOLLING_WORD_15"),JText::_("COM_SEXYPOLLING_WORD_16"),JText::_("COM_SEXYPOLLING_WORD_17"),JText::_("COM_SEXYPOLLING_WORD_18"),JText::_("COM_SEXYPOLLING_WORD_19"),JText::_("COM_SEXYPOLLING_WORD_20"),JText::_("COM_SEXYPOLLING_WORD_21"),JText::_("COM_SEXYPOLLING_WORD_22"),JText::_("COM_SEXYPOLLING_WORD_23"),JText::_("COM_SEXYPOLLING_WORD_24"),JText::_("COM_SEXYPOLLING_WORD_25"));

if($this->items === false)
	$pollings = array();
else
	for ($i=0, $n=count( $this->items ); $i < $n; $i++) {
	$pollings[$this->items[$i]->polling_id][] = $this->items[$i];
}

$polling_select_id = array();
$custom_styles = array();
$voted_ids = array();
$start_disabled_ids = array();
$end_disabled_ids = array();
$date_now = strtotime("now");
$voting_periods = array();
$voting_permissions = array();
$number_answers_array = array();
$answerPermission = array();
$autoPublish = array();
$autoOpenTimeline = array();
$dateFormat = array();
$autoAnimate = array();
$sexyAnimationTypeBar = array();
$sexyAnimationTypeContainer = array();
$sexyAnimationTypeContainerMove = array();

//function to check if array2 contain an element from array1
if(!function_exists('if_contain')) {
	function if_contain($array1,$array2) {
		if(is_array($array2))
			foreach($array1 as $val) {
				if(in_array($val,$array2))
					return true;
			}
		return false;
	}
}

if(sizeof($pollings) > 0) {
	foreach ($pollings as $poll_index => $polling_array) {
		
		//create parameters array
		$autoPublish[$poll_index] = $polling_array[0]->autopublish;
		$autoOpenTimeline[$poll_index] = $polling_array[0]->autoopentimeline;
		$dateFormat[$poll_index] = $polling_array[0]->dateformat == 1 ? 'str' : 'digits';
		$autoAnimate[$poll_index] = $polling_array[0]->autoanimate;
		$sexyAnimationTypeBar[$poll_index] = $polling_array[0]->baranimationtype;
		$sexyAnimationTypeContainer[$poll_index] = $polling_array[0]->coloranimationtype;
		$sexyAnimationTypeContainerMove[$poll_index] = $polling_array[0]->reorderinganimationtype;
		$showresultbutton = $polling_array[0]->showresultbutton;
		
		$number_answers = $polling_array[0]->number_answers;
		$number_answers_array[$poll_index] = $number_answers;
		$voting_period = $polling_array[0]->voting_period;
		$voting_periods[$poll_index] = $voting_period;
		
		//check ACL to add answer
		$add_answer_permissions_id = $polling_array[0]->answerpermission;
		$query = "SELECT `rules` FROM #__viewlevels WHERE id = '$add_answer_permissions_id'";
		$db->setQuery($query);
		$db->query();
		$levels = explode(',',str_replace(array('[',']'),'',$db->loadResult()));
		$permission_to_show_add_answer_block = if_contain($levels,$groups);
		
		//check ACL to vote
		$voting_permission_id = $polling_array[0]->voting_permission;
		$query = "SELECT `rules` FROM #__viewlevels WHERE id = '$voting_permission_id'";
		$db->setQuery($query);
		$db->query();
		$levels = explode(',',str_replace(array('[',']'),'',$db->loadResult()));
		$voting_permissions[$poll_index] = if_contain($levels,$groups);
		
		//check start,end dates
		if($polling_array[0]->date_start != '0000-00-00' &&  $date_now < strtotime($polling_array[0]->date_start)) {
			$datevoted = strtotime($polling_array[0]->date_start);
			$hours_diff = ($datevoted - $date_now) / 3600;
			$start_disabled_ids[] = array($poll_index,$polling_words[17] . date('F j, Y',strtotime($polling_array[0]->date_start)),$hours_diff);
		}
		if($polling_array[0]->date_end != '0000-00-00' &&  $date_now > strtotime($polling_array[0]->date_end)) {
			$end_disabled_ids[] = array($poll_index,$polling_words[18] . date('F j, Y',strtotime($polling_array[0]->date_end)));
		}
	
		//check ip
		$query = "SELECT sv.`ip`,sv.`date` FROM #__sexy_votes sv JOIN #__sexy_answers sa ON sa.id_poll = '$poll_index' WHERE sv.id_answer = sa.id AND sv.ip = '$sexyip' ORDER BY sv.`date` DESC LIMIT 1";
		$db->setQuery($query);
		$db->query();
		$num_rows = $db->getNumRows();
		$row = $db->loadAssoc();
		if($num_rows > 0) {
			$datevoted = strtotime($row['date']);
			$hours_diff = ($date_now - $datevoted) / 3600;
			if($voting_period == 0 && !in_array($poll_index,array_keys($voted_ids))) {
				$voted_ids[$poll_index] = '17520';//two years
			}
			elseif(!in_array($poll_index,array_keys($voted_ids)) && ($hours_diff < $voting_period))
				$voted_ids[$poll_index] = $voting_period - $hours_diff;
		}
		
		//check cookie
		if (isset($_COOKIE["sexy_poll_$poll_index"])) {
			$datevoted = $_COOKIE["sexy_poll_$poll_index"];
			$hours_diff = ($date_now - $datevoted) / 3600;
			if(!in_array($poll_index,array_keys($voted_ids)))
				$voted_ids[$poll_index] = $voting_period - $hours_diff;
		}
		
		$est_time = isset($voted_ids[$poll_index]) ? (float)$voted_ids[$poll_index] : -1;
	
		//set styles
		$custom_styles[$poll_index] = $polling_array[0]->styles;
		echo '<div class="polling_container_wrapper" id="mod_'.$module_id.'_'.$poll_index.'" roll="'.$module_id.'"><div class="polling_container" id="poll_'.$poll_index.'">';
		echo '<div class="polling_name">'.stripslashes($polling_array[0]->polling_question).'</div>';
	
		$multiple_answers = $polling_array[0]->multiple_answers;
		$multiple_answers_info_array[$poll_index] = $multiple_answers;
		
		$colors_array = array("black","blue","red","litegreen","yellow","liteblue","green","crimson","litecrimson");
		echo '<ul class="polling_ul">';
		foreach ($polling_array as $k => $poll_data) {
			$color_index = $k % 20 + 1;
			$data_color_index = $k % 9;
			echo '<li id="answer_'.$poll_data->answer_id.'" class="polling_li"><div class="animation_block"></div>';
			echo '<div class="answer_name"><label uniq_index="'.$module_id.'_'.$poll_data->answer_id.'" class="twoglux_label">'.stripslashes($poll_data->answer_name).'</label></div>';
			echo '<div class="answer_input">';
	
			if($multiple_answers == 0)
				echo '<input  id="'.$module_id.'_'.$poll_data->answer_id.'" type="radio" class="poll_answer '.$poll_data->answer_id.' twoglux_styled" value="'.$poll_data->answer_id.'" name="'.$poll_data->polling_id.'" data-color="'.$colors_array[$data_color_index].'" />';
			else
				echo '<input  id="'.$module_id.'_'.$poll_data->answer_id.'" type="checkbox" class="poll_answer '.$poll_data->answer_id.' twoglux_styled" value="'.$poll_data->answer_id.'" name="'.$poll_data->polling_id.'"  data-color="'.$colors_array[$data_color_index].'" />';
	
			echo '</div><div class="sexy_clear"></div>';
			echo '<div class="answer_result">
			<div class="answer_navigation polling_bar_'.$color_index.'" id="answer_navigation_'.$poll_data->answer_id.'"><div class="grad"></div></div>
			<div class="answer_votes_data" id="answer_votes_data_'.$poll_data->answer_id.'">'.$polling_words[0].': <span id="answer_votes_data_count_'.$poll_data->answer_id.'"></span><span id="answer_votes_data_count_val_'.$poll_data->answer_id.'" style="display:none"></span> (<span id="answer_votes_data_percent_'.$poll_data->answer_id.'">0</span><span style="display:none" id="answer_votes_data_percent_val_'.$poll_data->answer_id.'"></span>%)</div>
			<div class="sexy_clear"></div>
			</div>';
			echo '</li>';
		}
		echo '</ul>';
	
		//check perrmision, to show add answer option
		if($permission_to_show_add_answer_block) {
			echo '<div class="answer_wrapper opened" ><div style="padding:6px">';
			echo '<div class="add_answer"><input name="answer_name" class="add_ans_name" value="'.$polling_words[11].'" />
			<input type="button" value="'.$polling_words[12].'" class="add_ans_submit" /><input type="hidden" value="'.$poll_index.'" class="poll_id" /><img class="loading_small" src="'.JURI::base(true).'/components/com_sexypolling/assets/images/loading_small.gif" /></div>';
			echo '</div></div>';
		}
	
		$new_answer_bar_index = ($k + 1) % 20 + 1;
	
		echo '<span class="polling_bottom_wrapper1"><img src="components/com_sexypolling/assets/images/loading_polling.gif" class="polling_loading" />';
		echo '<input type="button" value="'.$polling_words[6].'" class="polling_submit" id="poll_'.$module_id.'_'.$poll_index.'" />';
		$result_button_class = (($showresultbutton == 0) && ($est_time < 0)) ? 'hide_sexy_button' : '';
		echo '<input type="button" value="'.$polling_words[7].'" class="polling_result '.$result_button_class.'" id="res_'.$module_id.'_'.$poll_index.'" /></span>';
		echo '<div class="polling_info"><table cellpadding="0" cellspacing="0" border="0"><tr><td class="left_col">'.$polling_words[1].':<span class="total_votes_val" style="display:none"></span> </td><td class="total_votes right_col"></td></tr><tr><td class="left_col">'.$polling_words[2].': </td><td class="first_vote right_col"></td></tr><tr><td class="left_col">'.$polling_words[3].': </td><td class="last_vote right_col"></td></tr></table></div>';
	
		//timeline
		$polling_select_id[$poll_index]['select1'] = 'polling_select_'.$module_id.'_'.$poll_index.'_1';
		$polling_select_id[$poll_index]['select2'] = 'polling_select_'.$module_id.'_'.$poll_index.'_2';
	
		//get count of total votes, min and max dates of voting
		$query = "SELECT COUNT(sv.`id_answer`) total_count, MAX(sv.`date`) max_date,MIN(sv.`date`) min_date FROM `#__sexy_votes` sv JOIN `#__sexy_answers` sa ON sa.id_poll = '$poll_index' WHERE sv.id_answer = sa.id";
		$db->setQuery($query);
		$row_total = $db->loadAssoc();
		$count_total_votes = $row_total['total_count'];
		$min_date = strtotime($row_total['min_date']);
		$max_date = strtotime($row_total['max_date']);
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
		if($permission_to_show_add_answer_block) {
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
	
			$date_item = $dateFormat[$poll_index] == 'str' ? date('F j, Y', $curr_time) : date('d/m/Y', $curr_time);
	
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
	
			$date_item = $dateFormat[$poll_index] == 'str' ? date('F j, Y', $curr_time) : date('d/m/Y', $curr_time);
	
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
	
	//new version added
	//add voting period to javascript
	$jsInclude .= ' if (typeof voting_periods === \'undefined\') { var voting_periods = new Array();};';
	if(sizeof($voting_periods) > 0)
		foreach ($voting_periods as $poll_id => $voting_period) {
		$jsInclude .= 'voting_periods["'.$module_id.'_'.$poll_id.'"] = "'.$voting_period.'";';
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
	$jsInclude .= 'var sexyPath = "'.JURI::base(true).'/";';
	
	$jsInclude .= 'if (typeof sexyPollingIds === \'undefined\') { var sexyPollingIds = new Array();};';
	$k = 0;
	foreach ($polling_select_id as $poll_id) {
		$jsInclude .= 'sexyPollingIds.push(Array("'.$poll_id["select1"].'","'.$poll_id["select2"].'"));';
		$k ++;
	}
	$jsInclude .= 'if (typeof votingPermissions === \'undefined\') { var votingPermissions = new Array();};';
	foreach ($voting_permissions as $key => $voting_permission) {
		$message = $voting_permission ? 'allow_voting' : $polling_words['24'];
		$jsInclude .= 'votingPermissions.push("'.$key.'");';
		$jsInclude .= 'votingPermissions["'.$key.'"]="'.$message.'";';
	}
	$jsInclude .= 'if (typeof votedIds === \'undefined\') { var votedIds = new Array();};';
	foreach (array_keys($voted_ids) as $voted_id) {
		$hoursdiff = $voted_ids[$voted_id];
		$estimated_days = (int) ($hoursdiff / 24);
		$estimated_hours = ((int) $hoursdiff) % 24;
		$estimated_minutes = ((int) ($hoursdiff * 60)) % 60;
		$estimated_seconds = (((int) ($hoursdiff * 3600)) % 3600) % 60;
		
		$est_time = $estimated_days > 99 ? 'never' : $hoursdiff;
		$jsInclude .= 'votedIds.push(Array("'.$voted_id.'","'.$module_id.'","'.$est_time.'"));';
	}
	$jsInclude .= 'if (typeof startDisabledIds === \'undefined\') { var startDisabledIds = new Array();};';
	foreach ($start_disabled_ids as $start_disabled_data) {
		$hoursdiff = $start_disabled_data['2'];
		$estimated_days = (int) ($hoursdiff / 24);
		$est_time = $estimated_days > 99 ? 'never' : $hoursdiff;
		$jsInclude .= 'startDisabledIds.push(Array("'.$start_disabled_data[0].'","'.$start_disabled_data[1].'","'.$module_id.'","'.$est_time.'"));';
	}
	$jsInclude .= 'if (typeof endDisabledIds === \'undefined\') { var endDisabledIds = new Array();};';
	foreach ($end_disabled_ids as $end_disabled_data) {
		$jsInclude .= 'endDisabledIds.push(Array("'.$end_disabled_data[0].'","'.$end_disabled_data[1].'","'.$module_id.'"));';
	}
	$jsInclude .= 'if (typeof allowedNumberAnswers === \'undefined\') { var allowedNumberAnswers = new Array();};';
	foreach ($number_answers_array as $poll_id => $number_answers_data) {
		$jsInclude .= 'allowedNumberAnswers.push("'.$poll_id.'");';
		$jsInclude .= 'allowedNumberAnswers["'.$poll_id.'"]="'.$number_answers_data.'";';
	}
	
	$jsInclude .= 'if (typeof autoOpenTimeline === \'undefined\') { var autoOpenTimeline = new Array();};';
	foreach ($autoOpenTimeline as $poll_id => $v) {
		$jsInclude .= 'autoOpenTimeline.push("'.$poll_id.'");';
		$jsInclude .= 'autoOpenTimeline["'.$poll_id.'"]="'.$v.'";';
	}

	$jsInclude .= 'if (typeof autoAnimate === \'undefined\') { var autoAnimate = new Array();};';
	foreach ($autoAnimate as $poll_id => $v) {
		$jsInclude .= 'autoAnimate.push("'.$poll_id.'");';
		$jsInclude .= 'autoAnimate["'.$poll_id.'"]="'.$v.'";';
	}

	$jsInclude .= 'if (typeof sexyAutoPublish === \'undefined\') { var sexyAutoPublish = new Array();};';
	foreach ($autoPublish as $poll_id => $v) {
		$jsInclude .= 'sexyAutoPublish.push("'.$poll_id.'");';
		$jsInclude .= 'sexyAutoPublish["'.$poll_id.'"]="'.$v.'";';
	}

	$jsInclude .= 'if (typeof dateFormat === \'undefined\') { var dateFormat = new Array();};';
	foreach ($dateFormat as $poll_id => $v) {
		$jsInclude .= 'dateFormat.push("'.$poll_id.'");';
		$jsInclude .= 'dateFormat["'.$poll_id.'"]="'.$v.'";';
	}

	$jsInclude .= 'if (typeof sexyAnimationTypeBar === \'undefined\') { var sexyAnimationTypeBar = new Array();};';
	foreach ($sexyAnimationTypeBar as $poll_id => $v) {
		$jsInclude .= 'sexyAnimationTypeBar.push("'.$poll_id.'");';
		$jsInclude .= 'sexyAnimationTypeBar["'.$poll_id.'"]="'.$v.'";';
	}

	$jsInclude .= 'if (typeof sexyAnimationTypeContainer === \'undefined\') { var sexyAnimationTypeContainer = new Array();};';
	foreach ($sexyAnimationTypeContainer as $poll_id => $v) {
		$jsInclude .= 'sexyAnimationTypeContainer.push("'.$poll_id.'");';
		$jsInclude .= 'sexyAnimationTypeContainer["'.$poll_id.'"]="'.$v.'";';
	}

	$jsInclude .= 'if (typeof sexyAnimationTypeContainerMove === \'undefined\') { var sexyAnimationTypeContainerMove = new Array();};';
	foreach ($sexyAnimationTypeContainerMove as $poll_id => $v) {
		$jsInclude .= 'sexyAnimationTypeContainerMove.push("'.$poll_id.'");';
		$jsInclude .= 'sexyAnimationTypeContainerMove["'.$poll_id.'"]="'.$v.'";';
	}
	
	$document->addScriptDeclaration ( $jsInclude );
?>
<?php }?>