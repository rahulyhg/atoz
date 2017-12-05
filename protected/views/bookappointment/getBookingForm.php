<?php
//preparing week days
$weekdays=Array();
$weekdays[0] = "SUNDAY";
$weekdays[1] = "MONDAY";
$weekdays[2] = "TUESDAY";
$weekdays[3] = "WEDNESDAY";
$weekdays[4] = "THURSDAY";
$weekdays[5] = "FRIDAY";
$weekdays[6] = "SATURDAY";

$maxColumn = 0;
if($is_clinic == "service") {
    $arraySlots = $patientAppModel->getServiceSlotsPerDay($year,$month,$daynum,$doctid,$hospitalid,$is_clinic,"slotarr");
}else{
    $arraySlots = $patientAppModel->getSlotsPerDay($year,$month,$day,$calendar_id,$settingObj,$doctid,$hospitalid,$is_clinic,"slotarr");
}
$columns=ceil(count($arraySlots)/6);
//max number columns is 9, so if there are too many slots, have to add lines instead of columns
$maxColumn = 7;
$lines=6;
if($columns>$maxColumn) {
	$columns=$maxColumn;
	$lines=7;
	do {
		$lines++;
	} while(ceil(count($arraySlots)/$lines)>$maxColumn);
}
$styleAttr = 'style="margin-left: 20px;"';
$totCols=0;
?>
<!-- close -->
<div class="font_custom close_booking"><a href="javascript:closeBooking(1,'1',<?php echo $year; ?>,<?php echo $month; ?>);">CLOSE &nbsp; X</a></div>
<div class="cleardiv"></div>

<!-- leftside -->
<div class="booking_left">
    <!-- title -->
    <div class="font_custom booking_title"><span id="booking_day"><?php echo $day."/$month/$year, ".$weekdays[intval(date('w',mktime(0,0,0,$month,$day,$year)))]; ?></span> - <span style="color:#567BD2;" id="calendar_name">Select Time</span><span style="float:right;width:30px;cursor:pointer" id="next">&nbsp;</span><span style="float:right;width:30px;cursor:pointer" id="prev">&nbsp;</span>
        <?php
        if (strlen($day) == 1) {
            $day = "0" . $day;
        }
        ?>
        <input class="appointmentdate" id="appointmentdate" name="PatientAppointmentDetails[appointment_date]" type="hidden" value="<?php echo $year."-".$month."-".$day; ?>">
    </div>
    <div class="cleardiv"></div>
    
    <!-- slots available -->
    <div class="box_preview_column" >
            <?php
            $z=1;
            if(count($arraySlots) > 0) {
                foreach($arraySlots as $slotId => $slot) {
                    $slotTo = strtotime($slot)+1800;
                    //echo date('h:i a',strtotime($slot))." - ".date('h:i a',$slotTo);
                    echo "<div class='box_preview_row ui-radio ui-radio-pink'><label class='ui-radio-inline'><input type='radio' name='reservation_slot' value='$slot' onclick=''/> <span>".date('h:i a',strtotime($slot))." - ".date('h:i a',$slotTo)."</span></label></div>";
                    if($z % $lines == 0) {
                        $totCols++;
                        if($totCols == $columns-1) {
                                $styleAttr='style="margin-right: 20px;"';
                        }
                        ?>
                        </div>
                        <div class="box_preview_column " <?php echo $styleAttr; ?>>
                        <?php
                      }
                      $z++;
                }

            } 
        ?>
    </div>
</div>
<script>
	
</script>


