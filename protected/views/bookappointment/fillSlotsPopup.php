<?php
if($is_clinic == "service") {
    $arraySlots = $patientAppModel->getServiceSlotsPerDay($year,$month,$daynum,$doctid,$hospitalid,$is_clinic,"slotarr");
}else{
    $arraySlots = $patientAppModel->getSlotsPerDay($year,$month,$day,$calendar_id,$settingObj,$doctid,$hospitalid,$is_clinic,"slotarr");
}

//calculate how many columns we need
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
//print_r($arraySlots);exit;
?>
<div class="box_preview_column" <?php echo $styleAttr; ?>>
	<?php
	$z=1;
	if(count($arraySlots) > 0) {
            foreach($arraySlots as $slotId => $slot) {
                $slotTo = strtotime($slot)+1800;
                //echo date('h:i a',strtotime($slot))." - ".date('h:i a',$slotTo);
                echo "<div class='box_preview_row'>".date('h:i a',strtotime($slot))." - ".date('h:i a',$slotTo)."</div>";
                if($z % $lines == 0) {
                    $totCols++;
                    if($totCols == $columns-1) {
                            $styleAttr='style="margin-right: 20px;"';
                    }
                    ?>
                    </div>
                    <div class="box_preview_column" <?php echo $styleAttr; ?>>
                    <?php
		  }
		  $z++;
            }
		
	} 
    ?>
</div>
|
