<?php
//check what date format in settings
$startDay=1;
$weekday_format="N";
$lastWeekDay=7;

$slots_popup_enabled = 1;
	//$calendarObj->setCalendar($calendar_id);
	$arrayMonth = $patientAppModel->getMonthCalendar($month,$year,$weekday_format);
	
	$i = 0;
	
	foreach($arrayMonth as $daynum => $daydata) {
		if($i == 0) {
                    //check what's first week day and add cells
                    for($j=$startDay;$j<$daydata["dayofweek"];$j++) {
                            if($j == $lastWeekDay) {
                                    ?>
                        <div class="day_container day_grey" style="margin-right: 0px;"><a style="background-color:#F6F6F6"></a></div>
					
                                    <?php
                            } else {
                                    ?>
                                    <div class="day_container day_grey"><a style="background-color:#F6F6F6"></a></div>
                                    <?php
                            }


                    }
		}
		if($is_clinic == "service") {
                    $numslots = $patientAppModel->getServiceSlotsPerDay($year,$month,$daynum,$doctid,$hospitalid,$is_clinic,"count");
                }else{
                    $numslots = $patientAppModel->getSlotsPerDay($year,$month,$daynum,$calendar_id,$settingObj,$doctid,$hospitalid,$is_clinic,"count");
                }
		
		
		//get default background color from style options, have to maintain classes for js to work
		$background = "day_white";
		$background_color = "#FFFFFF";
		$newstyle='';
		$newstyle1 = 'style="color:#FFFFFFss"';
		$newstyle2 = 'style="color:#00CC33"';
		$over=1;
		//if it's a past day and there are no slots
		$date = date_create(date('Y-m-d'));
		if(function_exists("date_add")) {
			date_add($date, date_interval_create_from_date_string('0 days'));
		} else {
			date_modify($date, '+0 day');
		}
		//date_add($date, date_interval_create_from_date_string($settingObj->getBookFrom().' days'));
		$bookfromdate = date_format($date, 'Ymd');

		
		$booktodate = '30001010';
		
		if($daydata["yearnum"].$daydata["monthnum"].$daydata["daynum"] < $bookfromdate || $numslots == -1 || $daydata["yearnum"].$daydata["monthnum"].$daydata["daynum"] > $booktodate) {
			$background_color = "#FFFFFF";
			$newstyle='style="color:#CCC"';
			$newstyle1 = 'style="color:#CCCCCC"';
			$newstyle2 = 'style="color:#CCCCCC"';
			$over=0;
		}
		//no slots, it's day greater or equal to today, but it's red because it's sold out
		if($numslots == 0 && $daydata["yearnum"].$daydata["monthnum"].$daydata["daynum"] >= date('Ymd')) {
			$background="day_red";
			$background_color = "#D74E4E";
			$newstyle1 = 'style="color:#FFFFFF"';
			$newstyle2 = 'style="color:#FFFFFF"';
		} else if($daydata["yearnum"].$daydata["monthnum"].$daydata["daynum"] == date('Ymd')) {
			// today without sold out
			$background="day_black";
			$background_color = "#333333";
			$newstyle1 = 'style="color:#FFFFFF"';
			$newstyle2 = 'style="color:#FFFFFF"';
		} else if($numslots == -1) {
			//no slots but not sold out
			$background="day_white";
			$background_color = "#FFFFFF";
			$newstyle1 = 'style="color:#CCCCCC"';
			$newstyle2 = 'style="color:#CCCCCC"';
		}
		// last day of week
		if($daydata["dayofweek"] == $lastWeekDay) {
			
			?>
			<div class="day_container <?php echo $background; ?>" style="margin-right: 0px;"><a style="cursor:pointer;background-color:<?php echo $background_color; ?>" year="<?php echo $year; ?>" month="<?php echo $month; ?>" day="<?php echo $daynum; ?>" popup="<?php echo $slots_popup_enabled; ?>" over="<?php echo $over; ?>">
                            <div class="day_number" <?php echo $newstyle1; ?>><?php echo $daynum; ?></div>
                            <div class="day_book" <?php echo $newstyle1; ?>>
					<?php
					if($numslots>0 && $daydata["yearnum"].$daydata["monthnum"].$daydata["daynum"] >= $bookfromdate && $daydata["yearnum"].$daydata["monthnum"].$daydata["daynum"] <= $booktodate) {
						// there are slots, date is greater or equal to today: book now text
						echo "+ BOOK NOW";
					} else if($numslots == 0) {
						// date is greater or equal to today, there are no slots: sold out text
						echo "SOLDOUT";
					}
					?>
                            </div>
                            <div class="cleardiv"></div>
				<div class="day_slots" <?php echo $newstyle2; ?>>
					<?php
					// if there are slots: slots number text
					if($numslots>0) {
						echo "Available: ".$numslots;
					} else {
						// if there aren't slots: text no slots
						echo "Not available";
					}
					?>
				</div>
				
			</a></div>
			<?php
		// all other days
		} else {
			?>
			<div class="day_container <?php echo $background; ?>"><a style="cursor:pointer;background-color:<?php echo $background_color; ?>" year="<?php echo $year; ?>" month="<?php echo $month; ?>" day="<?php echo $daynum; ?>" popup="<?php echo $slots_popup_enabled; ?>" over="<?php echo $over; ?>">
				<!-- giorno del mese -->
                <div class="day_number" <?php echo $newstyle1; ?>><?php echo $daynum; ?></div>
                <!-- book now o sold out -->
                <div class="day_book" <?php echo $newstyle1; ?>>
					<?php
					if($numslots>0 && $daydata["yearnum"].$daydata["monthnum"].$daydata["daynum"] >= $bookfromdate && $daydata["yearnum"].$daydata["monthnum"].$daydata["daynum"] <= $booktodate) {
						echo "+ BOOK NOW";
					} else if($numslots == 0)  {
						echo "SOLDOUT";
					}
					?>
				</div>
                <div class="cleardiv"></div>
                <!-- time slots available -->
				<div class="day_slots" <?php echo $newstyle2; ?>>
					<?php
					if($numslots>0) {
						echo "Available: ".$numslots;
					} else {
						echo "Not available";
					}
					?>
				</div>
				
			</a></div>
			<?php
		}
		
		$i++;
		if($i == count($arrayMonth)) {
			$lastDay=$daydata["dayofweek"];
		}
	}
	//check what's last week day and add cells
	for($j=$lastWeekDay;$j>$lastDay;$j--) {
		if($j == ($lastDay+1)) {
			?>
			<div class="day_container day_grey" style="margin-right: 0px;"><a style="background-color:#F6F6F6"></a></div>
			
			<?php
		} else {
			?>
			<div class="day_container day_grey"><a style="background-color:#F6F6F6"></a></div>
			<?php
		}
	}
	?>
	<script>
		$(function() {
			
			$('#month_nav_prev').html("<a href=\"javascript:getPreviousMonth(1,'1',-1);\" class=\"month_nav_button month_navigation_button_custom\"><img src=\"images/prev.png\" /></a>");
			$('#month_nav_next').html("<a href=\"javascript:getNextMonth(1,'1',-1);\" class=\"month_nav_button month_navigation_button_custom\"><img src=\"images/next.png\" /></a>");
		});
	</script>

