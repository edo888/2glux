(function($) {
$(document).ready(function() {
	
			var sexyCountry = '',
				sexyCountryCode = '',
				sexyCity = '',
				sexyRegion = '';
			
			
			$.ajax
			({
				url: sexyPath + 'components/com_sexypolling/geoip.php?ip=' + sexyIp,
				type: "get",
				dataType: "json",
				success: function(data)
				{
					sexyCountry = data.countryName;
					sexyCountryCode = data.countryCode;
					sexyCity = data.cityName;
					sexyRegion = data.regionName;
				},
				error: function()
				{
				}
			});
	
			setTimeout(function() {
				$(".polling_container_wrapper").each(function() {
					var w = $(this).width();
					$(this).css("width",w);
					var curr_h = $(this).find('.answer_wrapper').height();
					$(this).find('.answer_wrapper').attr("h",curr_h);
				});
			},100);
			
			
			function doNotAllow(poll_id) {
				//check if already voted
				var onlyVotedIds = new Array();
				for(t in votedIds) {
					onlyVotedIds.push(votedIds[t][0]);
				};
				if($.inArray(poll_id,onlyVotedIds) != -1) {
					make_alert(sexyPolling_words[9],'sexy_normal');
					return false;
				}
			};
			
			//alert box ////////////////////////////////////////////////////////////////////////////////////////
			//function to create shadow
			function create_shadow() {
				var $shadow = '<div id="sexy_shadow"></div>';
				$('body').css('position','relative').append($shadow);
				$("#sexy_shadow")
				.css( {
					'position' : 'absolute',
					'top' : '0',
					'right' : '0',
					'bottom' : '0',
					'left' : '0',
					'z-index' : '10000',
					'opacity' : '0',
					'backgroundColor' : '#000'
				})
				.fadeTo(200,'0.7');
			};
			
			function make_alert(txt,type) {
				//create shadow
				create_shadow();
				
				//make alert
				var $alert_body = '<div id="sexy_alert_wrapper"><div id="sexy_alert_body" class="' + type + '">' + txt + '</div><input type="button" id="close_sexy_alert" value="OK" /></div>';
				$('body').append($alert_body);
				var scollTop = $(window).scrollTop();
				var w_width = $(window).width();
				var w_height = $(window).height();
				var s_height = $("#sexy_alert_wrapper").height();
				
				
				var alert_left = (w_width - 420) / 2;
				var alert_top = (w_height - s_height) / 2;
				
				$("#sexy_alert_wrapper")
				.css( {
					'top' : -1 * (s_height  + 55 * 1) + scollTop * 1,
					'left' : alert_left
				})
				.stop()
				.animate({
					'top' : alert_top + scollTop * 1
				},450,'easeOutBack',function() {
					//$(this).css('position','fixed');
				});
			};
			
			function remove_alert_box() {
				$("#sexy_shadow").stop().fadeTo(200,0,function() {$(this).remove();});
				$("#sexy_alert_wrapper").stop().fadeTo(200,0,function() {$(this).remove();});
			}
			
			function move_alert_box() {
				var scollTop = $(window).scrollTop();
				var w_width = $(window).width();
				var w_height = $(window).height();
				var s_height = $("#sexy_alert_wrapper").height();
				
				
				var alert_left = (w_width - 420) / 2;
				var alert_top = (w_height - s_height) / 2;
				
				$("#sexy_alert_wrapper")
				.stop()
				.animate({
					'top' : alert_top + scollTop * 1,
					'left' : alert_left
				},450,'easeOutBack',function() {
					//$(this).css('position','fixed');
				});
			};
			
			$('#close_sexy_alert').live('click', function() {
				remove_alert_box();
			});
			
			$(window).resize(function() {
				move_alert_box();
			});
			$(window).scroll(function() {
				move_alert_box();
			});
			
			
			//function to prevent uncheck user added input boxes
			$('.doNotUncheck').live('click',function() {
				if(! $(this).is(':checked') ) {
					$(this).parent('div').parent('li').remove();
				}
			});
	
			$(".polling_bottom_wrapper1").each(function() {
				var h = $(this).height();
				$(this).attr("h",h);
			});
			
			$(".polling_loading").each(function() {
				var h = $(this).height();
				$(this).attr("h",h);
			});
			
			$(".answer_input").each(function() {
				var w = $(this).width();
				$(this).attr("w",w);
			});
			
			$(".polling_ul").each(function() {
				var h = $(this).height();
				$(this).attr("h",h);
			});
			
			$(".polling_li").each(function() {
				var h = $(this).height();
				$(this).attr("h_start",h);
			});
			$(".answer_navigation").each(function() {
				var b = parseInt($(this).css("borderWidth"));
				$(this).attr("b",b);
			});
	
			$('.polling_submit').click(function() {
				if($(this).hasClass('voted_button')) {
					make_alert(sexyPolling_words[9],'sexy_error');
					return;
				}
				
				var t_id = $(this).attr("id");
				var polling_id = $(this).parent('span').parent('div').find('.poll_answer').attr('name');
				
				//check if already voted
				var onlyVotedIds = new Array();
				for(t in votedIds) {
					onlyVotedIds.push(votedIds[t][0])
				};
				if($.inArray(polling_id,onlyVotedIds) != -1) {
					make_alert(sexyPolling_words[9],'sexy_error');
					return false;
				}
				
				//check start dates
				s_length = startDisabledIds.length;
				for(var i = 0;i <= s_length; i++) {
					if(typeof startDisabledIds[i] !== 'undefined') {
						var c_id = "poll_" + startDisabledIds[i][2] + "_" + startDisabledIds[i][0];
						if(c_id == t_id) {
							make_alert(startDisabledIds[i][1],'sexy_error');
							return false;
						}
					}
				};
				
				//check end dates
				e_length = endDisabledIds.length;
				for(var i = 0;i <= e_length; i++) {
					if(typeof endDisabledIds[i] !== 'undefined') {
						var c_id = "poll_" + endDisabledIds[i][2] + "_" + endDisabledIds[i][0];
						if(c_id == t_id) {
							make_alert(endDisabledIds[i][1],'sexy_normal');
							return false;
						}
					}
				};
				
				var polling_checked_value = $(this).parent('span').parent('div').find('.poll_answer:checked').val();
				if(polling_checked_value == undefined) {
					make_alert(sexyPolling_words[8],'sexy_normal');
					return false;
				};
				
				var $t = $(this);
				vote_polling($t);
			});
			$('.polling_result').click(function() {
				var $t = $(this);
				show_polling($t);
			});
			$('.polling_select2,.polling_select1').change(function() {
				var $t = $(this).parents('.polling_container');
				show_polling_by_date($t);
			});
			function show_polling($t) {
				var polling_id = $t.parent('span').parent('div').find('.poll_answer').attr('name');
				var module_id = $t.parent('span').parent('div').parent('div').attr('roll');
				$container = $t.parent('span').parent('div');
				
				//function to prevent uncheck user added input boxes
				$container.find('.doNotUncheck').parent('div').parent('li').remove();

				//hide all radio buttons
				$t.parent('span').parent('div').find('.answer_input').animate({
					width:0,
					opacity:0
				},1000);

				//animate answers
				$t.parent('span').parent('div').find('.answer_name label').animate({
					marginLeft:0
				},1000);
				

				//show navigation bar
				var b = $t.parent('span').parent('div').find('.answer_navigation').attr("b");
				$t.parent('span').parent('div').find('.answer_navigation').css("borderWidth","0").show().animate({
					height:animation_styles[module_id+"_"+polling_id][9],
					borderWidth: b,
					opacity:1
				},1000);


				//animate loading
				var l_h = $t.parent('span').parent('div').find('.polling_loading').height();
				$t.parent('span').parent('div').find('.polling_loading').css({display:'block',opacity:0,height:0});
				$t.parent('span').parent('div').find('.polling_loading').animate({
					opacity:0.85,
					height: l_h
				},1000);

				//send request
				var h = $container.find('.answer_votes_data').height();
				setTimeout(function() {
					$.ajax
					({
						
						url: sexyPath + 'components/com_sexypolling/vote.php',
						type: "post",
						data: 'polling_id=' + polling_id + '&mode=view' + '&dateformat=' + dateFormat + '&module_id=' + module_id,
						dataType: "json",
						success: function(data)
						{
							$container = $("#mod_" + data[0].module_id + "_" + data[0].poll_id);
							answers_array = new Array();
							orders_array = new Array();
							orders_array_start = new Array();
							data_length = data.length;
							
							max_percent = 'none';
							$.each(data, function(i) {
								
							 	answer_id = this.answer_id;
							 	percent = this.percent;
							 	percent_formated = parseFloat(this.percent_formated);
							 	response_votes = this.votes;
							 	order = this.order;
								order_start = this.order_start;
								
								total_votes = this.total_votes;
								min_date = this.min_date;
								max_date = this.max_date;
								
								if(max_percent == 'none')
							 		max_percent = percent;

							 	answers_array.push(parseInt(answer_id));
							 	orders_array.push(order);
							 	orders_array_start.push(order_start);


							 	//sets the title of navigations
							 	$container.find('#answer_navigation_' + answer_id).attr('title',sexyPolling_words[0] + ': ' + response_votes);
			
							 	//start animating navigation bar
							 	$nav_width = $container.find(".polling_li").width();
							 	
								$current_width_rel = parseInt($nav_width * percent / 100 );
								$current_width_rel = $current_width_rel == 0 ? '1' : $current_width_rel;
								$current_width = parseInt($nav_width * percent / max_percent );
								$current_width = $current_width == 0 ? '1' : $current_width;
								$container.find('#answer_navigation_' + answer_id).attr({"rel_width":$current_width_rel,"ab_width":$current_width}).animate({
									width: $current_width
								},1000,sexyAnimationTypeBar[module_id]);
								$container.find('#answer_navigation_' + answer_id).next(".ie-shadow").animate({
									width: $current_width
								},1000,sexyAnimationTypeBar[module_id]);
			
								//set the value
								$container.find('#answer_votes_data_count_' + answer_id).html(response_votes);
								$container.find('#answer_votes_data_count_val_' + answer_id).html(response_votes);
								$container.find('#answer_votes_data_percent_' + answer_id).html(percent_formated);
								$container.find('#answer_votes_data_percent_val_' + answer_id).html(percent_formated);

								//show answer data
								$container.find('.answer_votes_data').css({'display':'block','height':0}).animate({height:h},1000);

								//set to absolute
								if(i == data_length - 1) {
									animate_poll_items($container,answers_array,polling_id,module_id,total_votes,min_date,max_date,orders_array,orders_array_start);
								}
							 	
							});
						},
						error: function()
						{
						}
					});
				},1000);

			};
			
			
			//function to animate elements
			function animate_poll_items($container,answers_array,polling_id,module_id,total_votes,min_date,max_date,orders_array,orders_array_start) {
				
				setTimeout(function(){
					
					var offset_0_ = $container.find('.polling_ul').offset();
					offset_0 = offset_0_.top;
					
					//calculates offsets
					var offsets_array = new Array();
					for(var b = 0; b < answers_array.length; b++) {
						var offset_1_ = $container.find("#answer_" + answers_array[b]).offset();
						var offset_1 = offset_1_.top;
						var total_offset = offset_1 * 1 - offset_0;
						offsets_array.push(total_offset);
					};

					//animate items
					curr_top = 0;
					curr_height = 0;
					curr_z_index = 1000;
					$container.find('.polling_ul').css('height',$container.find('.polling_ul').height());
					for(var b = 0; b < answers_array.length; b++) {
						var li_item_height = $container.find("#answer_" + answers_array[b]).height() + 6;
						curr_height = curr_height * 1 + li_item_height;
						
						$container.find("#answer_" + answers_array[b]).css({position:'absolute',top:offsets_array[b],'z-index':curr_z_index});

						
						
						$container.find("#answer_" + answers_array[b]).stop(true,false).animate({
							top: curr_top
						},1200,sexyAnimationTypeContainerMove[module_id]);

						
						$container.find("#answer_" + answers_array[b] + " .animation_block")
							.css({'display':'block','opacity' : '0'})
							.stop(true,false).animate({
								opacity: 1,
								boxShadow: animation_styles[module_id+"_"+polling_id][2],
								borderTopColor: animation_styles[module_id+"_"+polling_id][1],
								borderBottomColor: animation_styles[module_id+"_"+polling_id][1],
								borderLeftColor: animation_styles[module_id+"_"+polling_id][1],
								borderRightColor: animation_styles[module_id+"_"+polling_id][1],
								backgroundColor: animation_styles[module_id+"_"+polling_id][0],
								borderTopLeftRadius: animation_styles[module_id+"_"+polling_id][3], 
							    borderTopRightRadius: animation_styles[module_id+"_"+polling_id][4], 
							    borderBottomLeftRadius: animation_styles[module_id+"_"+polling_id][5], 
							    borderBottomRightRadius: animation_styles[module_id+"_"+polling_id][6]
							},1200,sexyAnimationTypeContainer[module_id],function(){
								$(this).animate({
									opacity: 0,
									boxShadow: animation_styles[module_id+"_"+polling_id][8] + '0 0 0 0 ' + animation_styles[module_id+"_"+polling_id][7],
									borderTopColor: animation_styles[module_id+"_"+polling_id][7],
									borderBottomColor: animation_styles[module_id+"_"+polling_id][7],
									borderLeftColor: animation_styles[module_id+"_"+polling_id][7],
									borderRightColor: animation_styles[module_id+"_"+polling_id][7],
									backgroundColor: animation_styles[module_id+"_"+polling_id][7],
									borderTopLeftRadius: 0, 
								    borderTopRightRadius: 0, 
								    borderBottomLeftRadius: 0, 
								    borderBottomRightRadius: 0
								},1200,sexyAnimationTypeContainer[module_id],function() {
								$(this).hide();
							});
						});
						
						$container.find("#answer_" + answers_array[b]).attr('order',orders_array[b]);
						$container.find("#answer_" + answers_array[b]).attr('order_start',orders_array_start[b]);
						curr_top = curr_top + li_item_height;
						curr_z_index = curr_z_index - 1;
					};
					
					$container.find('.polling_ul').css('height',curr_height);
					
				},2700,function() {
				});

				
				//show total votes, min and max dates
				$container.find('.total_votes').html(total_votes);
				$container.find('.total_votes_val').html(total_votes);
				$container.find('.first_vote').html(min_date);
				$container.find('.last_vote').html(max_date);
				
				//hide submit button and loading
				
				$container.find('.polling_bottom_wrapper1')
				.stop(true,true).animate({
					height:0
				},
				1000,
				function(){
					$container.find('.polling_bottom_wrapper1').hide();
					$container.find('.polling_loading').hide();
				});

				setTimeout(function() {
					//show polling info
					$container.find('.polling_info').css({'display':'block'});
					var h = $container.find('.polling_info').height();
					$container.find('.polling_info').css({'display':'none'});
					$container.find('.polling_info')
					.css({'height': 0,'display':'block'})
					.animate({height:h},1000);

					//show timeline
					$container.find('.timeline_icon').animate({height:32},1000);
					
					//show add answer
					$container.find('.add_answer_icon').animate({height:32},1000);
					
					//show add answer
					$container.find('.sexyback_icon').animate({height:32},1000);
					
					//show add answer
					$container.find('.scale_icon').animate({height:32},1000);
				},1700);

				if(autoOpenTimeline == 0) {
					setTimeout(function() {
						$container.find('.timeline_icon').trigger("click");
					},2700);
				}
			}
			
			
			

			//global variable, to store digit animations
			$digit_int = new Array();
			$digit_int_percent = new Array();
			$digit_int_total = '';
			
			function show_polling_by_date($t,use_current_date) {
				use_current_date = typeof use_current_date !== 'undefined' ? use_current_date : 'no';
				
				var polling_id = $t.find('.poll_answer').attr('name');
				var module_id = $t.parent('div').attr('roll');
				var min_date = $t.find('.polling_select1').val();
				var max_date = $t.find('.polling_select2').val();
				$container = $t;

				//clear all intervals
				for(i_v in $digit_int) {
					clearInterval($digit_int[i_v]);
				}
				//clear all intervals
				for(i_v in $digit_int_percent) {
					clearInterval($digit_int_percent[i_v]);
				}
				clearInterval($digit_int_total);

				setTimeout(function() {
					
					$nav_width = $container.find(".polling_li").width();
					//send request
					$.ajax
					({
						url: sexyPath + 'components/com_sexypolling/vote.php',
						type: "post",
						data: 'polling_id=' + polling_id + '&mode=view_by_date&min_date=' + min_date + '&max_date=' + max_date + '&dateformat=' + dateFormat + '&curr_date=' + use_current_date,
						dataType: "json",
						success: function(data)
						{
							//count of json objects
							data_length = data.length;
							
							//assign variables
							answers_array = new Array();
							orders_array = new Array();
							orders_array_start = new Array();
							
							$curr_count = new Array();
							$new_count = new Array();
							$step_sign = new Array();
							$steps = new Array();
							$interval_value = new Array();
							$curr_count_ = new Array();
							$curr_step = new Array();
							
							$curr_percent = new Array();
							$new_percent = new Array();
							$step_sign_percent = new Array();
							$steps_percent = new Array();
							$interval_value_percent = new Array();
							$curr_percent_ = new Array();
							$curr_step_percent = new Array();
							
							var max_percent = 'none';
							$.each(data, function(i) {
								
							 	answer_id = this.answer_id;
							 	percent = this.percent;
							 	percent_formated = parseFloat(this.percent_formated);
							 	response_votes = parseInt(this.votes);
							 	order = this.order;
							 	order_start = this.order_start;
							 	
							 	if(max_percent == 'none')
							 		max_percent = percent;
							 	
							 	total_votes = this.total_votes;
								min_date = this.min_date;
								max_date = this.max_date;
			
							 	answers_array.push(answer_id);
							 	orders_array.push(order);
							 	orders_array_start.push(order_start);
				
							 	//sets the title of navigations
							 	$container.find('#answer_navigation_' + answer_id).attr('title','Votes: ' + response_votes);
				
							 	
							 	//start animating navigation bar
							 	$current_width_rel = parseInt($nav_width * percent / 100 );
								$current_width_rel = $current_width_rel == 0 ? '1' : $current_width_rel;
								$current_width = parseInt($nav_width * percent / max_percent );
								$current_width = $current_width == 0 ? '1' : $current_width;
								
								if($container.find('.scale_icon').hasClass('opened'))
									new_w = $current_width_rel;
								else
									new_w = $current_width;
								$container.find('#answer_navigation_' + answer_id).attr({"rel_width":$current_width_rel,"ab_width":$current_width}).stop(true,false).animate({
									width: new_w
								},1000,sexyAnimationTypeBar[module_id]);

								//ie box shadow animation
								if($container.find('#answer_navigation_' + answer_id).next(".ie-shadow").width() != $current_width + 4*1)
									$container.find('#answer_navigation_' + answer_id).next(".ie-shadow").stop(true,false).animate({
										width: new_w
									},1000,sexyAnimationTypeBar[module_id]);
				

								//digit animation //remember min_count_of_votes / $steps_count_percent must have influance on tofixed(it's value) ...

								//animate percents
								$curr_percent[answer_id] = parseFloat($container.find('#answer_votes_data_percent_' + answer_id).html());
								$new_percent[answer_id] = percent_formated;
								$steps_percent[answer_id] = Math.abs($curr_percent[answer_id] - $new_percent[answer_id]);
								$steps_count_percent = 20;
								$step_item_percent = $steps_percent[answer_id] / $steps_count_percent;
								//get sign
								$step_sign_percent[answer_id] = ($new_percent[answer_id] > $curr_percent[answer_id]) ? 1 * $step_item_percent : (($new_percent[answer_id] < $curr_percent[answer_id]) ? -1 * $step_item_percent : 0);
								$interval_value_percent[answer_id] = parseFloat(1000 / $steps_count_percent);
								
								//animate total count
								$curr_total = parseInt($t.find('.total_votes').html());
								$new_total = total_votes;
								$steps_total = Math.abs($curr_total - $new_total);
								$steps_count_total = 20;
								$step_item_total = $steps_total / $steps_count_total;
								//get sign
								$step_sign_total = ($new_total > $curr_total) ? 1 * $step_item_total : (($new_total < $curr_total) ? -1 * $step_item_total : 0);
								$interval_value_total = parseFloat(1000 / $steps_count_total);

								//animate answer votes count
								$curr_count[answer_id] = parseInt($container.find('#answer_votes_data_count_' + answer_id).html());
								$new_count[answer_id] = response_votes;
								$steps[answer_id] = Math.abs($curr_count[answer_id] - $new_count[answer_id]);
								$steps_count = 15;
								$step_item = $steps[answer_id] / $steps_count;
								//get sign
								$step_sign[answer_id] = ($new_count[answer_id] > $curr_count[answer_id]) ? 1 * $step_item : (($new_count[answer_id] < $curr_count[answer_id]) ? -1 * $step_item : 0);
								$interval_value[answer_id] = parseFloat(1000 / $steps_count);

								if(i == data_length - 1) {
									//show total votes, min and max dates
									$t.find('.first_vote').html(min_date);
									$t.find('.last_vote').html(max_date);
									

									function animate_total() {
										if($step_sign_total != 0) {
											
											$digit_int_total = setInterval(function(){
												$curr_total_ = parseFloat($t.find('.total_votes_val').html());
												$curr_total_ = $curr_total_ + 1 * $step_sign_total;
												$t.find('.total_votes').html($curr_total_.toFixed(1));
												$t.find('.total_votes_val').html($curr_total_);
			
												if($step_sign_total > 0) {
													if($curr_total_ >= $new_total) {
														clearInterval($digit_int_total);
														$t.find('.total_votes').html($new_total);
														$t.find('.total_votes_val').html($new_total);
													}
												}
												else {
													if($curr_total_ <= $new_total) {
														clearInterval($digit_int_total);
														$t.find('.total_votes').html($new_total);
														$t.find('.total_votes_val').html($new_total);
													}
												}
											},$interval_value_total);
										}
										else {
											$t.find('.total_votes').html($new_total);
											$t.find('.total_votes_val').html($new_total);
										}
									};
									animate_total();
									var animate_percent = function(ans_id) {
										
										if($step_sign_percent[ans_id] !== 0) {
											$digit_int_percent[ans_id] = setInterval(function(){
												
												$curr_percent_[ans_id] = parseFloat($container.find('#answer_votes_data_percent_val_' + ans_id).html());
												
												$curr_percent_[ans_id] = $curr_percent_[ans_id] + 1 * $step_sign_percent[ans_id];
												$container.find('#answer_votes_data_percent_val_' + ans_id).html($curr_percent_[ans_id]);
												$container.find('#answer_votes_data_percent_' + ans_id).html($curr_percent_[ans_id].toFixed(2));

												if($step_sign_percent[ans_id] > 0) {
													if($curr_percent_[ans_id] >= $new_percent[ans_id]) {
														clearInterval($digit_int_percent[ans_id]);
														$container.find('#answer_votes_data_percent_' + ans_id).html($new_percent[ans_id]);
														$container.find('#answer_votes_data_percent_val_' + ans_id).html($new_percent[ans_id]);
													}
												}
												else {
													if($curr_percent_[ans_id] <= $new_percent[ans_id]) {
														clearInterval($digit_int_percent[ans_id]);
														$container.find('#answer_votes_data_percent_' + ans_id).html($new_percent[ans_id]);
														$container.find('#answer_votes_data_percent_val_' + ans_id).html($new_percent[ans_id]);
													}
												}
														
											},$interval_value_percent[ans_id]);
										}
										else {
											$container.find('#answer_votes_data_percent_' + ans_id).html($new_percent[ans_id]);
											$container.find('#answer_votes_data_percent_val_' + ans_id).html($new_percent[ans_id]);
										}
									};
									
									var animate_digit = function(ans_id) {

										if($step_sign[ans_id] != 0) {
											
											$digit_int[ans_id] = setInterval(function(){
												$curr_count_[ans_id] = parseFloat($container.find('#answer_votes_data_count_val_' + ans_id).html());
												$curr_count_[ans_id] = $curr_count_[ans_id] + 1 * $step_sign[ans_id];
												$container.find('#answer_votes_data_count_' + ans_id).html($curr_count_[ans_id].toFixed(1));
												$container.find('#answer_votes_data_count_val_' + ans_id).html($curr_count_[ans_id]);
			
												if($step_sign[ans_id] > 0) {
													if($curr_count_[ans_id] >= $new_count[ans_id]) {
														clearInterval($digit_int[ans_id]);
														$container.find('#answer_votes_data_count_' + ans_id).html($new_count[ans_id]);
														$container.find('#answer_votes_data_count_val_' + ans_id).html($new_count[ans_id]);
													}
												}
												else {
													if($curr_count_[ans_id] <= $new_count[ans_id]) {
														clearInterval($digit_int[ans_id]);
														$container.find('#answer_votes_data_count_' + ans_id).html($new_count[ans_id]);
														$container.find('#answer_votes_data_count_val_' + ans_id).html($new_count[ans_id]);
													}
												}
														
											},$interval_value[ans_id]);
										}
										else {
											$container.find('#answer_votes_data_count_' + ans_id).html($new_count[ans_id]);
											$container.find('#answer_votes_data_count_val_' + ans_id).html($new_count[ans_id]);
										}
									};
									for(var b = 0; b < answers_array.length; b++) {
										animate_digit(answers_array[b]);
										animate_percent(answers_array[b]);
									}
								};
									

								//set to absolute
								if(i == data_length - 1) {
									var offset_0_ = $t.find('.polling_ul').offset();
									offset_0 = offset_0_.top;
									
									setTimeout(function(){
				
										//calculates offsets
										var offsets_array = new Array();
										for(var b = 0; b < answers_array.length; b++) {
											var offset_1_ = $container.find("#answer_" + answers_array[b]).offset();
											var offset_1 = offset_1_.top;
											var total_offset = offset_1 * 1 - offset_0;
											offsets_array.push(total_offset);
										};
				
										//animate items
										curr_top = 0;
										curr_height = 0;
										curr_z_index = 1000;
										for(var b = 0; b < answers_array.length; b++) {
											var li_item_height = $container.find("#answer_" + answers_array[b]).height() + 6;
											curr_height = curr_height * 1 + li_item_height;
				
											$container.find("#answer_" + answers_array[b]).css({position:'absolute',top:offsets_array[b],'z-index':curr_z_index});
											$container.find("#answer_" + answers_array[b]).stop(true,false).animate({
												top: curr_top
											},1200,sexyAnimationTypeContainerMove[module_id]);

											$container.find("#answer_" + answers_array[b] + " .animation_block")
												.css({'display':'block'})
												.stop(false,false)
												.animate( {
													opacity: 1,
													boxShadow: animation_styles[module_id+"_"+polling_id][2],
													borderTopColor: animation_styles[module_id+"_"+polling_id][1],
													borderBottomColor: animation_styles[module_id+"_"+polling_id][1],
													borderLeftColor: animation_styles[module_id+"_"+polling_id][1],
													borderRightColor: animation_styles[module_id+"_"+polling_id][1],
													backgroundColor: animation_styles[module_id+"_"+polling_id][0],
													borderTopLeftRadius: animation_styles[module_id+"_"+polling_id][3], 
												    borderTopRightRadius: animation_styles[module_id+"_"+polling_id][4], 
												    borderBottomLeftRadius: animation_styles[module_id+"_"+polling_id][5], 
												    borderBottomRightRadius: animation_styles[module_id+"_"+polling_id][6]
												},1200,sexyAnimationTypeContainer[module_id],
												function() {
													$(this).animate( {
														opacity: 0,
														boxShadow: animation_styles[module_id+"_"+polling_id][8] + '0 0 0 0 ' + animation_styles[module_id+"_"+polling_id][7],
														borderTopColor: animation_styles[module_id+"_"+polling_id][7],
														borderBottomColor: animation_styles[module_id+"_"+polling_id][7],
														borderLeftColor: animation_styles[module_id+"_"+polling_id][7],
														borderRightColor: animation_styles[module_id+"_"+polling_id][7],
														backgroundColor: animation_styles[module_id+"_"+polling_id][7],
														borderTopLeftRadius: 0, 
													    borderTopRightRadius: 0, 
													    borderBottomLeftRadius: 0, 
													    borderBottomRightRadius: 0
													},1200,sexyAnimationTypeContainer[module_id],function() {
													$(this).hide();
												})
											});
											
											$container.find("#answer_" + answers_array[b]).attr('order',orders_array[b]);
											$container.find("#answer_" + answers_array[b]).attr('order_start',orders_array_start[b]);
											curr_top = curr_top + li_item_height;
											curr_z_index = curr_z_index - 1;
										};
										$container.find('.polling_ul').css('height',curr_height);
										
									},1);
								}
								
							});
						},
						error: function()
						{
						}
					})

				},1);
			};
			
			function vote_polling($t) {
				var polling_id = $t.parent('span').parent('div').find('.poll_answer').attr('name');
				var module_id = $t.parent('span').parent('div').parent('div').attr('roll');
				$container = $t.parent('span').parent('div');
				
				//close answer
				$container.find('.answer_wrapper')
				.css({'overflow':'hidden'})
				.animate({
							height:0
				},600);
				$container.find('.add_answer_icon').removeClass('opened').addClass('voted_button');
				$container.find('.polling_submit').addClass('voted_button');
				
				//recalculate ul height
				$ul_height = $container.children("ul").height();
				$container.children("ul").attr("h",$ul_height);
				
				//if we have added answers, add them to post
				var additionalAnswers = '';
				$container.find('.doNotUncheck').each(function(i) {
					var htm = $(this).parents('li').find('label').html();
					additionalAnswers += '&answers[]=' + htm;
				});
				

				//hide all radio buttons
				$container.find('.answer_input').animate({
					width:0,
					opacity:0
				},1000);

				//animate answers
				$container.find('.answer_name label').animate({
					marginLeft:0
				},1000);

				//show navigation bar
				var b = $container.find('.answer_navigation').attr("b");
				$container.find('.answer_navigation').css("borderWidth","0").show().animate({
					height:animation_styles[module_id+"_"+polling_id][9],
					borderWidth: b,
					opacity:1
				},1000);



				//animate loading
				var l_h = $t.parent('span').parent('div').find('.polling_loading').height();
				$t.parent('span').parent('div').find('.polling_loading').attr("h",l_h).css({display:'block',opacity:0,height:0});
				$t.parent('span').parent('div').find('.polling_loading').animate({
					opacity:0.85,
					height: l_h
				},1000);

				//send request

				$nav_width = $container.find(".polling_li").width();
				var h = $container.find('.answer_votes_data').height();
				
				var ch_data = '';
				$t.parent('span').parent('div').find('.poll_answer:checked').not('.doNotUncheck').each(function() {
					ch_data += '&answer_id[]=' + $(this).val();
				});
				setTimeout(function() {
					$.ajax
					({
						url: sexyPath + 'components/com_sexypolling/vote.php',
						type: "post",
						data: 'polling_id=' + polling_id +ch_data + '&dateformat=' + dateFormat + additionalAnswers  + '&country_name=' + sexyCountry + '&country_code=' + sexyCountryCode + '&city_name=' + sexyCity + '&region_name=' + sexyRegion,
						dataType: "json",
						success: function(data)
						{
							$container.find('.doNotUncheck').each(function(i) {
								if(typeof data[0].addedanswers !== 'undefined') {
									$(this).parents('li').attr("id",'answer_' + data[0].addedanswers[i]);
									$(this).parents('li').find('.answer_navigation').attr("id",'answer_navigation_' + data[0].addedanswers[i]);
									$(this).parents('li').find('.answer_votes_data').attr("id",'answer_votes_data_' + data[0].addedanswers[i]);
									$(this).parents('li').find('#answer_votes_data_count_0').attr("id",'answer_votes_data_count_' + data[0].addedanswers[i]);
									$(this).parents('li').find('#answer_votes_data_count_val_0').attr("id",'answer_votes_data_count_val_' + data[0].addedanswers[i]);
									$(this).parents('li').find('#answer_votes_data_percent_0').attr("id",'answer_votes_data_percent_' + data[0].addedanswers[i]);
									$(this).parents('li').find('#answer_votes_data_percent_val_0').attr("id",'answer_votes_data_percent_val_' + data[0].addedanswers[i]);
								}
							});
							$container.find('.doNotUncheck').removeClass('doNotUncheck');
							
							answers_array = new Array();
							orders_array = new Array();
							orders_array_start = new Array();
							max_percent = 'none';
							
							$.each(data, function(i) {
							 	answer_id = this.answer_id;
							 	percent = this.percent;
							 	percent_formated = this.percent_formated;
							 	response_votes = this.votes;
							 	order = this.order;
								order_start = this.order_start;
								
								if(max_percent == 'none')
							 		max_percent = percent;
								
							 	answers_array.push(answer_id);
							 	orders_array.push(order);
							 	orders_array_start.push(order_start);
			
							 	//sets the title of navigations
							 	$container.find('#answer_navigation_' + answer_id).attr('title','Votes: ' + response_votes);
			
								//start animating navigation bar
								$current_width_rel = parseInt($nav_width * percent / 100 );
								$current_width_rel = $current_width_rel == 0 ? '1' : $current_width_rel;
								$current_width = parseInt($nav_width * percent / max_percent );
								$current_width = $current_width == 0 ? '1' : $current_width;
								$container.find('#answer_navigation_' + answer_id).attr({"rel_width":$current_width_rel,"ab_width":$current_width}).animate({
									width: $current_width
								},1000,sexyAnimationTypeBar[module_id]);
								
								$container.find('#answer_navigation_' + answer_id).next(".ie-shadow").animate({
									width: $current_width
								},1000,sexyAnimationTypeBar[module_id]);

								//set the value
								$container.find('#answer_votes_data_count_' + answer_id).html(response_votes);
								$container.find('#answer_votes_data_count_val_' + answer_id).html(response_votes);
								$container.find('#answer_votes_data_percent_' + answer_id).html(percent_formated);
								$container.find('#answer_votes_data_percent_val_' + answer_id).html(percent_formated);
								
								//show answer data
								$container.find('.answer_votes_data').css({'display':'block','height':0}).animate({height:h},1000);

								//set to absolute
								if(i == 0) {
									var offset_0_ = $container.find('.polling_ul').offset();
									offset_0 = offset_0_.top;
									setTimeout(function(){
				
										//calculates offsets
										var offsets_array = new Array();
										for(var b = 0; b < answers_array.length; b++) {
											var offset_1_ = $container.find("#answer_" + answers_array[b]).offset();
											var offset_1 = offset_1_.top;
											var total_offset = offset_1 * 1 - offset_0;
											offsets_array.push(total_offset);
										};
				
										//animate items
										curr_top = 0;
										curr_height = 0;
										curr_z_index = 1000;
										$container.find('.polling_ul').css('height',$container.find('.polling_ul').height());
										for(var b = 0; b < answers_array.length; b++) {
											var li_item_height = $container.find("#answer_" + answers_array[b]).height() + 6;
											curr_height = curr_height * 1 + li_item_height;
				
											$container.find("#answer_" + answers_array[b]).css({position:'absolute',top:offsets_array[b],'z-index':curr_z_index});
											
											$container.find("#answer_" + answers_array[b]).stop(true,false).animate({
												top: curr_top
											},1200,sexyAnimationTypeContainerMove[module_id]);

											
											$container.find("#answer_" + answers_array[b] + " .animation_block")
												.css({'display':'block','opacity' : '0'})
												.stop(true,false).animate({
													opacity: 1,
													boxShadow: animation_styles[module_id+"_"+polling_id][2],
													borderTopColor: animation_styles[module_id+"_"+polling_id][1],
													borderBottomColor: animation_styles[module_id+"_"+polling_id][1],
													borderLeftColor: animation_styles[module_id+"_"+polling_id][1],
													borderRightColor: animation_styles[module_id+"_"+polling_id][1],
													backgroundColor: animation_styles[module_id+"_"+polling_id][0],
													borderTopLeftRadius: animation_styles[module_id+"_"+polling_id][3], 
												    borderTopRightRadius: animation_styles[module_id+"_"+polling_id][4], 
												    borderBottomLeftRadius: animation_styles[module_id+"_"+polling_id][5], 
												    borderBottomRightRadius: animation_styles[module_id+"_"+polling_id][6]
												},1200,sexyAnimationTypeContainer[module_id],function(){
													$(this).animate({
														opacity: 0,
														boxShadow: animation_styles[module_id+"_"+polling_id][8] + '0 0 0 0 ' + animation_styles[module_id+"_"+polling_id][7],
														borderTopColor: animation_styles[module_id+"_"+polling_id][7],
														borderBottomColor: animation_styles[module_id+"_"+polling_id][7],
														borderLeftColor: animation_styles[module_id+"_"+polling_id][7],
														borderRightColor: animation_styles[module_id+"_"+polling_id][7],
														backgroundColor: animation_styles[module_id+"_"+polling_id][7],
														borderTopLeftRadius: 0, 
													    borderTopRightRadius: 0, 
													    borderBottomLeftRadius: 0, 
													    borderBottomRightRadius: 0
													},1200,sexyAnimationTypeContainer[module_id],function() {
													$(this).hide();
												});
											});
											
											$container.find("#answer_" + answers_array[b]).attr('order',orders_array[b]);
											$container.find("#answer_" + answers_array[b]).attr('order_start',orders_array_start[b]);
											curr_top = curr_top + li_item_height;
											curr_z_index = curr_z_index - 1;
										};
										$container.find('.polling_ul').css('height',curr_height);
										
									},2700);

									
									//show total votes, min and max dates
									total_votes = this.total_votes;
									min_date = this.min_date;
									max_date = this.max_date;

									$container.find('.total_votes').html(total_votes);
									$container.find('.total_votes_val').html(total_votes);
									$container.find('.first_vote').html(min_date);
									$container.find('.last_vote').html(max_date);
									
									//hide submit button and loading
									$container.find('.polling_bottom_wrapper1')
									.animate({
										height:0
									},
									1000,
									function(){
										$container.find('.polling_bottom_wrapper1').hide();
										$container.find('.polling_loading').hide();
									});
			
									setTimeout(function() {
										//show polling info
										$container.find('.polling_info').css({'display':'block'});
										var h = $container.find('.polling_info').height();
										$container.find('.polling_info').css({'display':'none'});
										$container.find('.polling_info')
										.css({'height': 0,'display':'block'})
										.animate({height:h},1000);
										//show timeline
										$container.find('.timeline_icon').animate({height:32},1000);
										
										//show add answer
										$container.find('.add_answer_icon').animate({height:32},1000);
										
										//show add answer
										$container.find('.sexyback_icon').animate({height:32},1000);
										
										//show add answer
										$container.find('.scale_icon').animate({height:32},1000);
									},1700);

									if(autoOpenTimeline == 0) {
										setTimeout(function() {
											$container.find('.timeline_icon').trigger("click");
										},2700);
									};
								};
							 	
							});
						},
						error: function()
						{
						}
					})
				},1000);

			};
			
			$('.timeline_icon').click(function() {
				var $c = $(this).parent('div').children('.timeline_select_wrapper');
				var curr_h = 90;
				var new_class = $c.hasClass('opened') ? 'closed' : 'opened';
				if(new_class == 'opened') {
					$(this).addClass('opened');
					$c.removeClass('closed');
					$c.addClass('opened');
					$(this).attr('title',sexyPolling_words[5]);
				}
				else {
					$(this).removeClass('opened');
					$c.removeClass('opened');
					$c.addClass('closed');
					$(this).attr('title',sexyPolling_words[4]);
				}

				//open timeline
				$(this).parent('div').children('.timeline_select_wrapper.opened')
				.css({'overflow':'hidden','height':0})
				.stop(true,true)
				.animate({
							height:curr_h
							},
							1000,
							function(){
								$(this).css({'overflow':'visible'})
				});

				//close timeline
				$(this).parent('div').children('.timeline_select_wrapper.closed') 
				.css({'overflow':'hidden'})
				.stop(true,true)
				.animate({
							height:0
				},1000);
			});
			
			function make_relative($t) {
				var module_id = $t.parent('div').parent('div').parent('div').attr('roll');
				$t.parent('div').parent('div').find('.answer_navigation').each(function() {
					var rel_width = $(this).attr("rel_width");
					$(this).stop(true,false).animate({
						width: rel_width
					},1000,sexyAnimationTypeBar[module_id]);
				});
			};
			
			function make_absolute($t) {
				var module_id = $t.parent('div').parent('div').parent('div').attr('roll');
				$t.parent('div').parent('div').find('.answer_navigation').each(function() {
					var ab_width = $(this).attr("ab_width");
					$(this).stop(true,false).animate({
						width: ab_width
					},1000,sexyAnimationTypeBar[module_id]);
				});
			};
			
			function animate_back($t) {
				$container = $t.parents('.polling_container');
				
				//uncheck all inpust
				$container.find('.poll_answer').attr("checked",false);
				
				//hide polling info
				$container.find('.polling_info')
				.stop()
				.stop(true,true).animate({height:0},1000,
						function() {
					//$(this).css({'display':'none'});
					$(this).removeAttr("style");
				});
				
				//hide timeline
				$container.find('.timeline_select_wrapper')
				.stop()
				.stop(true,true).animate({height:0},1000,
						function() {
					$(this).css({'overflow':'hidden'});
				});
				
				$('.timeline_icon').removeClass('opened');
				$('.timeline_select_wrapper').removeClass('opened');
				
				//hide loading
				var l_h = $container.find('.polling_loading').attr("h");
				$container.find('.polling_loading').css({'display':'none'});
				
				//show bottons
				var h = $container.find('.polling_bottom_wrapper1').attr("h");
				
				$container.find('.polling_bottom_wrapper1')
				.css({'display':'block'})
				.stop()
				.stop(true,true).animate({height:h},1000);
				
				var answer_w = $container.find('.answer_input').attr("w");
				var ratio_h = $container.find('.answer_result').height();
				var ul_h = $container.find('.polling_ul').attr("h");

				//hide timeline
				$container.find('.timeline_icon').stop(true,true).animate({height:0},1000);
				
				//hide add answer
				$container.find('.add_answer_icon').stop(true,true).animate({height:0},1000);
				
				//hide add answer
				$container.find('.sexyback_icon').stop(true,true).animate({height:0},1000);
				
				//hide add answer
				$container.find('.scale_icon').stop(true,true).animate({height:0},1000);
				
				$container.find('.answer_votes_data').stop(true,true).animate({height:0},1000,function(){$(this).removeAttr("style");});
				
				$container.find('.answer_input').stop(true,true).animate({width:answer_w,opacity:1},1000);
				
				$container.find('.answer_name label').stop(true,true).animate({marginLeft:answer_w},1000);
				
				$container.find('.answer_navigation').stop(true,true).animate({height:0,borderWidth:0},1000,function() {$(this).hide();});
				
				var total_h = 0;
				$container.find('.polling_li').each(function(k) {
					var h = $(this).attr("h_start")*1 + 6*1;
					
					$(this).stop(true,true).animate({"top" :total_h},1000,function() {
						$(this).removeAttr("style");
					});
					
					total_h = total_h + h*1;
				});
				
				$container.find('.polling_ul').stop(true,true).animate({height:ul_h},1000,function(){$(this).removeAttr("style");});
				
			};
			
			$('.scale_icon').click(function() {
				if($(this).hasClass('opened') ) {
					$(this).removeClass('opened');
					$(this).attr("title",sexyPolling_words[16]);
					make_absolute($(this));
				}
				else {
					$(this).addClass('opened');
					$(this).attr("title",sexyPolling_words[15]);
					make_relative($(this));
				}
			});
			
			$('.sexyback_icon').click(function() {
				animate_back($(this));
			});
			
			
			$('.add_answer_icon').click(function() {
				if($(this).hasClass('voted_button')) {
					make_alert(sexyPolling_words[9],'sexy_error');
					return;
				}
					
				if($(this).hasClass('disabled'))
					return;
				var $c = $(this).parents('.polling_container').find('.answer_wrapper');
				var curr_h = $(this).parents('.polling_container').find('.answer_wrapper').attr("h");

				//open answer
				$(this).parents('.polling_container').find('.answer_wrapper.closed')
				.css({'overflow':'hidden','height':0})
				.animate({
							height:curr_h
							},
							600,
							function(){
								$(this).css({'overflow':'visible'});
				});

				//close answer
				$(this).parents('.polling_container').find('.answer_wrapper.opened')
				.css({'overflow':'hidden'})
				.animate({
							height:0
				},600);
				
				var new_class = $c.hasClass('opened') ? 'closed' : 'opened';
				if(new_class == 'opened') {
					$(this).addClass('opened');
					$c.removeClass('closed');
					$c.addClass('opened');
				}
				else {
					$(this).removeClass('opened');
					$c.removeClass('opened');
					$c.addClass('closed');
				}
			});
			
			//add new answer
			$('.add_ans_name').focus(function() {
				var polling_id = $(this).parents('.polling_container').find('.poll_answer').attr('name');
				var module_id = $(this).parents('.polling_container_wrapper').attr('roll');
				if($(this).val() == sexyPolling_words[11]) {
					$(this).val('');
					$(this).css('color',animation_styles[module_id+"_"+polling_id][11]);
					
					$(this).parent('div').children('.add_ans_submit').show();
					var s_w = $(this).parent('div').children('.add_ans_submit').width();
					s_w += 14;
					$(this).parent('.add_answer').css('paddingRight',s_w);
				}
			});
			$('.add_ans_name').blur(function() {
				var polling_id = $(this).parents('.polling_container').find('.poll_answer').attr('name');
				var module_id = $(this).parents('.polling_container_wrapper').attr('roll');
				if($.trim($(this).val()) == '') {
					$(this).val(sexyPolling_words[11]);
					$(this).css('color',animation_styles[module_id+"_"+polling_id][10]);
					$(this).parent('div').children('.add_ans_submit').hide();
					$(this).parent('.add_answer').css('paddingRight',0);
				}
				else {
					$(this).val($.trim($(this).val()));
				}
			});
			
			$(".add_ans_name").keydown(function(e) {
				if(e.keyCode == 13) {
					var dis = $(this).parent('div').children('.add_ans_submit').css("display");
					if(dis == 'block' || dis == 'inline-block') {
						$(this).parent('div').children('.add_ans_submit').trigger('click');
						$(this).blur();
					}
				}
			});
			
			
			//add new answer functions
			$('.add_ans_submit').click(function() {
				
				$this = $(this);
				$ans_name = $.trim($this.parent('div').children('.add_ans_name').val());
				if($ans_name == '')
					return false;
				$poll_id = $this.parent('div').children('.poll_id').val();
				var module_id = $(this).parents('.polling_container_wrapper').attr('roll');
				//check if opened
				var cOpened = false;
				var position = $this.parents('.polling_container').find('.polling_li').css('position');
				if (position == 'absolute') {
				    cOpened = true;
				};
				
				var buttonType = multipleAnswersInfoArray[$poll_id] == 1 ? 'checkbox' : 'radio';
				
				//if we have checkboxes and sexy poll is closed, then we do not write answer to database, untill user do not vote vor it
				var writeInto = (buttonType == 'checkbox' && !cOpened) ? 0 : 1;
				
				$this.parent('div').children('.loading_small').fadeIn(400);
				$this.fadeOut(400);
				$.ajax
				({
					url: sexyPath + 'components/com_sexypolling/addanswer.php',
					type: "post",
					data: 'polling_id=' + $poll_id + '&answer=' + $ans_name + '&autopublish=' + sexyAutoPublish + '&writeinto=' + writeInto  + '&country_name=' + sexyCountry + '&country_code=' + sexyCountryCode + '&city_name=' + sexyCity + '&region_name=' + sexyRegion,
					dataType: "json",
					success: function(data)
					{
						if(buttonType == 'radio' || (buttonType == 'checkbox' && cOpened))
							$this.parents('.polling_container').find('.add_answer_icon').addClass('voted_button');
						
						$this.parent('div').children('.loading_small').fadeOut(400);
						if(sexyAutoPublish == 0) {

							//disable icon clicking
							$this.parents('.polling_container').find('.add_answer_icon').addClass('disabled');

							setTimeout(function() {

								/*we keep add answer box opened only if
								 * 1. we have checkboxes
								 * 2. poll box is closed
								 */
								if((buttonType == 'checkbox' && !cOpened)) {
									
									
									//close add answer box
									//reset values
									$this.parent('div').children('.add_ans_name')
									.css("color",animation_styles[module_id+"_"+$poll_id][10])
									.removeAttr('readonly')
									.val(sexyPolling_words[11]);

									//remove icon disabled
									$this.parents('.polling_container').find('.add_answer_icon').removeClass('disabled');
									
									//reset padding
									$this.parent('.add_answer').css('paddingRight',0);
									
									
								}
								else {
									$this.parents('.polling_container').find('.add_answer_icon').removeClass('opened');
									//close add answer box
									$this.parents('.answer_wrapper')
									.removeClass('opened')
									.addClass('closed')
									.css({'overflow':'hidden'})
									.animate({
												height:0
									},600,function() {
	
										//reset values
										$this.parent('div').children('.add_ans_name')
										.css("color",animation_styles[module_id+"_"+$poll_id][10])
										.removeAttr('readonly')
										.val(sexyPolling_words[11]);
	
										//remove icon disabled
										$this.parents('.polling_container').find('.add_answer_icon').removeClass('disabled');
										
										//reset padding
										$this.parent('.add_answer').css('paddingRight',0);
										
									});
									
								};
							
							},1);

							
							//add new answer
							add_answer($this.parents('.polling_container'),data[0].answer,data[0].id);
						}
						else {

							//show moderation message
							$this.parent('div').children('.add_ans_name')
							.css("color",animation_styles[module_id+"_"+$poll_id][10])
							.attr("readonly","readonly")
							.val(sexyPolling_words[13]);
							
							make_alert(sexyPolling_words[13],'sexy_normal');
							
							$this.parent('.add_answer').css('paddingRight',0);

							$this.parents('.polling_container').find('.add_answer_icon').addClass('disabled');

							setTimeout(function() {

								//change icon background
								$this.parents('.polling_container').find('.add_answer_icon').removeClass('opened');

								//close add answer box
								$this.parents('.answer_wrapper')
								.removeClass('opened')
								.addClass('closed')
								.css({'overflow':'hidden'})
								.animate({
											height:0
								},600,function() {

									//reset values
									$this.parent('div').children('.add_ans_name')
									.css("color",animation_styles[module_id+"_"+$poll_id][10])
									.removeAttr('readonly')
									.val(sexyPolling_words[11]);

									//remove icon disabled
									$this.parents('.polling_container').find('.add_answer_icon').removeClass('disabled');
									
								});
							
							},3000)
						}
					}
				});

				//function to add new answer to the answers list
				function add_answer($c,$answer,$id) {
					
					//check if opened
					var cOpened = false;
					var position = $c.find('.polling_li').css('position');
					if (position == 'absolute') {
					    cOpened = true;
					};
					
					var polling_id = $c.find('.poll_answer').attr('name');
					var module_id = $c.parent('div').attr('roll');
					var h = $c.find('.answer_votes_data').height();
					
					var buttonType = multipleAnswersInfoArray[polling_id] == 1 ? 'checkbox' : 'radio';
					var buttonType = multipleAnswersInfoArray[polling_id] == 1 ? 'checkbox' : 'radio';

					//create new element html
					if(cOpened) {
						var t_votes = $c.find('.total_votes_val').html();
						var t_votes_new = ++t_votes;
						$c.find('.total_votes_val').html(t_votes_new);
						$c.find('.total_votes').html(t_votes_new);
						var new_percent = parseFloat(100 / t_votes).toFixed(1);
						$new_li = '<li id="answer_' + $id + '" class="polling_li"><div class="animation_block"></div><div class="answer_name"><label style="margin-left:0" for="' + $id + '">' + $answer + '</label></div><div class="answer_input" style="width: 0px; opacity: 0; "><input  id="' + $id + '" type="' + buttonType + '" checked="checked" class="poll_answer ' + $id + '" value="' + $id + '" /></div><div class="answer_result"><div class="answer_navigation polling_bar_' + newAnswerBarIndex + '" id="answer_navigation_' + $id + '" style=" opacity: 1; width: 1px;display:block;"><div class="grad"></div></div><div class="answer_votes_data" id="answer_votes_data_' + $id + '" style="height: ' + h + 'px;display:block; ">' + sexyPolling_words[0] + ': <span id="answer_votes_data_count_' + $id + '">1</span><span id="answer_votes_data_count_val_' + $id + '" style="display:none">1</span> (<span id="answer_votes_data_percent_' + $id + '">' + new_percent + '</span><span style="display:none" id="answer_votes_data_percent_val_' + $id + '">' + new_percent + '</span>%)</div><div class="sexy_clear"></div></div></li>';
						//add html to DOM
						$c.find("li").last().after($new_li);
						
						//set height
						$("#answer_navigation_" + $id).css('height',animation_styles[module_id+"_"+polling_id][9]);
						
						$new_height = $("#answer_" + $id).height() + 6;
						$ul_height = $c.children("ul").height();
						
						$("#answer_" + $id).css({"position":"absolute","top":$ul_height});
						$c.children("ul").stop(true,false).animate( {
							height: "+=" + $new_height
						},600,function() {
							show_polling_by_date($c,'yes');
						});
					}
					else {
						var user_class = buttonType == 'checkbox' ? 'doNotUncheck' : '';
						var added_length = $c.find(".doNotUncheck").length;
						$new_li = '<li id="answer_' + $id + '" class="polling_li"><div class="animation_block"></div><div class="answer_name"><label for="elem_' + $id + '_' + added_length + '">' + $answer + '</label></div><div class="answer_input"><input id="elem_' + $id + '_' + added_length + '" type="' + buttonType + '" checked="checked"  class="' + user_class + ' poll_answer ' + $id + '" value="' + $id + '" /></div><div class="answer_result"><div class="answer_navigation polling_bar_' + newAnswerBarIndex + '" id="answer_navigation_' + $id + '"><div class="grad"></div></div><div class="answer_votes_data" id="answer_votes_data_' + $id + '">' + sexyPolling_words[0] + ': <span id="answer_votes_data_count_' + $id + '"></span><span id="answer_votes_data_count_val_' + $id + '" style="display:none">0</span> (<span id="answer_votes_data_percent_' + $id + '">0</span><span style="display:none" id="answer_votes_data_percent_val_' + $id + '">0</span>%)</div><div class="sexy_clear"></div></div></li>';
						//add html to DOM
						$c.find("li").last().after($new_li);
						$ul_height = $c.children("ul").height();
						$c.children("ul").attr("h",$ul_height);
					};

					if(cOpened)
					$("#answer_" + $id + " .animation_block")
					.css({'display':'block','opacity' : '0'})
					.stop(true,false).animate({
						opacity: 1,
						boxShadow: animation_styles[module_id+"_"+polling_id][2],
						borderTopColor: animation_styles[module_id+"_"+polling_id][1],
						borderBottomColor: animation_styles[module_id+"_"+polling_id][1],
						borderLeftColor: animation_styles[module_id+"_"+polling_id][1],
						borderRightColor: animation_styles[module_id+"_"+polling_id][1],
						backgroundColor: animation_styles[module_id+"_"+polling_id][0],
						borderTopLeftRadius: animation_styles[module_id+"_"+polling_id][3], 
					    borderTopRightRadius: animation_styles[module_id+"_"+polling_id][4], 
					    borderBottomLeftRadius: animation_styles[module_id+"_"+polling_id][5], 
					    borderBottomRightRadius: animation_styles[module_id+"_"+polling_id][6]
					},1200,sexyAnimationTypeContainer[module_id],function(){
						$(this).animate({
							opacity: 0,
							boxShadow: animation_styles[module_id+"_"+polling_id][8] + '0 0 0 0 ' + animation_styles[module_id+"_"+polling_id][7],
							borderTopColor: animation_styles[module_id+"_"+polling_id][7],
							borderBottomColor: animation_styles[module_id+"_"+polling_id][7],
							borderLeftColor: animation_styles[module_id+"_"+polling_id][7],
							borderRightColor: animation_styles[module_id+"_"+polling_id][7],
							backgroundColor: animation_styles[module_id+"_"+polling_id][7],
							borderTopLeftRadius: 0, 
						    borderTopRightRadius: 0, 
						    borderBottomLeftRadius: 0, 
						    borderBottomRightRadius: 0
						},1200,sexyAnimationTypeContainer[module_id],function() {
						$(this).hide();
						})
					});
					
					//show polling
					if(!cOpened && buttonType == 'radio') {
						var sub_object = $c.find(".polling_submit");
						show_polling(sub_object);
					}
				}

			});
			
			//add box shadow effect for ie
			/*
			if($.browser.msie) {
			    $(".answer_navigation").each(function() {
			    	var $elm = $(this);
				    $elm.after("<div class='ie-shadow'></div>");
				})
			}
			*/
			
			//slider function
			s_length = sexyPollingIds.length;
			for(var i = 0;i <= s_length; i++) {
				if(typeof sexyPollingIds[i] !== 'undefined') {
					var select1 = sexyPollingIds[i][0];
					var select2 = sexyPollingIds[i][1];
					$("#" + select1 + ",#" + select2).selectToUISlider(
							{
								labels:0,
								sliderOptions:
												{	
													stop: function(e,ui)
																		{
																			show_polling_by_date($(this).parents('.polling_container'));
																		}
												}
							}
					);
				}
				
			};
			
			if(autoAnimate == 1) {
				v_length = votedIds.length;
				for(var i = 0;i <= v_length; i++) {
					if(typeof votedIds[i] !== 'undefined') {
						var time = (i * 1 + 1) * 10;
						var t = $("#res_" + votedIds[i][1] + "_" + votedIds[i][0]);
						animate_poll(t,time);
					}
					
				};
				
				function animate_poll(t,time) {
					setTimeout(function() {
						show_polling(t);
					},time)
				}
			}
	
})
})(sexyJ);