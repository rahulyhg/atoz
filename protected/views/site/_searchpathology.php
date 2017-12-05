<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$session = new CHttpSession;
$session->open();
 $actual_link = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; 
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/fontawesome-stars.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.barrating.js', CClientScript::POS_END);
$review = 0;
$review = Yii::app()->db->createCommand()->select('COUNT(id) as count')->from(' az_rating')->where('user_id=:uid', array(':uid' => $data->user_id))->queryScalar();
$ratingmodel = Yii::app()->db->createCommand()->select('rating,user_id')
                ->from(' az_rating')
                ->where('created_by=:id and user_id=:uid', array(':id' => Yii::app()->user->id, ':uid' => $data->user_id))->queryRow();
$initialRating = "null";
if (!empty($ratingmodel['rating'])) {
    $initialRating = $ratval = $ratingmodel['rating'];
    //$review = $ratingmodel['count'];
} else {

    $ratval = 0;
}

Yii::app()->clientScript->registerScript('myjavascript2' . $data->user_id, '
    $(".example_' . $data->user_id . '").barrating({
        theme: "fontawesome-stars",
        readonly:' . $ratval . ',
        initialRating:' . $initialRating . ',
        onSelect: function(value, text, event) {
                
            if (typeof(event) !== "undefined") {
                // rating was selected by a ser
                 rate(' . $data->user_id . ',value);
            }
        }
    
    });
', CClientScript::POS_READY);
$enc_key = Yii::app()->params->enc_key;
$baseUrl = Yii::app()->baseUrl;

// echo $role.'huuuu';
?>
<div class="col-md-12 resultrow">
    <div class="col-md-2 text-center">
        <a href="<?php echo Yii::app()->createUrl("site/detailsOther", array('param1' => Yii::app()->getSecurityManager()->encrypt($data->user_id, $enc_key), "param2" => $role)); ?>">
            <?php
           
            if($role == 6){
                 $imagePath = $baseUrl . "/images/icons/icon06.png";
            }
            elseif($role == 7){
            $imagePath = $baseUrl . "/images/icons/icon03.png";
            }elseif($role == 8){
            $imagePath = $baseUrl . "/images/icons/icon05.png";
            }elseif($role == 9){
            $imagePath = $baseUrl . "/images/icons/icon04.png";
            }
            if (!empty($data->profile_image)) {
                $imagePath = $baseUrl . '/uploads/' . $data->profile_image;
            }
            ?>
            <img alt="profile_pic" src="<?php echo $imagePath; ?>" class="img-circle img-responsive"style="margin:12px;height:135px;width:135px"/>
        </a>
    </div>
    <div class="col-md-10 col-mar">
        <?php if ($role == 6) { ?>
            <h4> <?php echo CHtml::link(ucwords(strtolower($data->hospital_name)) . " " . "<br>", array('site/detailsOther', 'param1' => Yii::app()->getSecurityManager()->encrypt($data->user_id, $enc_key), "param2" => Yii::app()->getSecurityManager()->encrypt(0, $enc_key), "role" => 6)); ?></h4>  
        <?php } ?>
        <?php if ($role == 7) { ?>
            <h4> <?php echo CHtml::link(ucwords(strtolower($data->hospital_name)) . " " . "<br>", array('site/detailsOther', 'param1' => Yii::app()->getSecurityManager()->encrypt($data->user_id, $enc_key), "param2" => Yii::app()->getSecurityManager()->encrypt(0, $enc_key), "role" => 7)); ?></h4>   

        <?php } ?>

        <?php if ($role == 8) { ?>
            <h4> <?php echo CHtml::link(ucwords(strtolower($data->hospital_name)). " " . "<br>", array('site/detailsOther', 'param1' => Yii::app()->getSecurityManager()->encrypt($data->user_id, $enc_key), "param2" => Yii::app()->getSecurityManager()->encrypt(0, $enc_key), "role" => 8)); ?></h4>   

        <?php } ?>

        <?php if ($role == 9) { ?>
            <h4> <?php echo CHtml::link(ucwords(strtolower($data->hospital_name)). " " . "<br>", array('site/detailsOther', 'param1' => Yii::app()->getSecurityManager()->encrypt($data->user_id, $enc_key), "param2" => Yii::app()->getSecurityManager()->encrypt(0, $enc_key), "role" => 9)); ?></h4>   

        <?php } ?>


        <span class="col-view" style='text-transform: capitalize;'><?php echo $data->area_name . ", " . $data->city_name .", "  . $data->state_name?> </span>

<!--        <p id="descriptiontext" style="height: 25px;overflow: hidden;text-transform: capitalize;width: 80%;"><?php //echo $data->description; ?></p>
        <a class="" href="javascript:" onclick="$('#descriptiontext').attr('style', 'height:auto;');
                $(this).hide();">Read More </a>-->
        
<!--        <p class="show-read-more" style="    width: 76%;">
            <?php //echo $data->description; ?>
        </p>-->
        
         <div style="width: 71%; text-align: justify;"> 
        <span class="more">  
          <?php echo  $data->description; ?>
        </span>
        </div>
        
        <div class="saving">
            <span style="">&nbsp;
                
                  <?php
            $savings = "";
           
            if (!empty($data->user_id)) { //means it belong to hospital
                $savings = Yii::app()->db->createCommand()->select("MAX(service_discount)")->from("az_service_user_mapping")->where("user_id = :id AND clinic_id = :cid", array(":id" => $data->user_id, ":cid" => 0 ))->queryScalar();
               
            }
            if(!empty($savings)) {
                echo "<span>Savings Upto $savings %*</span>";
            }else{
                echo "<span>NA</span>";
            }
            ?>
            
            </span>
            <div class="rating1" style="padding-top:10px;"> 
                <select class="example_<?php echo $data->user_id; ?> clearfix">
                    <option value=""></option>
                    <?php
                    for ($i = 1; $i <= 5; $i++) {
                        echo "<option value='$i' class='star' ";
                        if ($i == $ratval) {
                            echo " selected ";
                        }
                        echo ">$i</option>";
                    }
                    ?>

                </select></div>


        </div>
        <div class="viewer">
            <ul class="view-list">

                <?php
                
                echo '<li style="padding-left:0"><span><img src="' . $baseUrl . '/images/icons/establish.png" style="width:18px"> <a href="" class="btn-list"> &nbsp;';
                ?>
                

                         Established In  <?php 
                if($data->hos_establishment == NULL){ echo 'NA'; }
                else{
                echo ' - '.date("Y", strtotime($data->hos_establishment));} ?>
                <?php echo ' </a></span> </li>';?>
                
<!--                <li><a href="" class="btn-default"> Distance - 2Km </a> </li>-->
                <li> <a href="" class="btn-default"><img src="<?php $baseUrl ?>images/icons/review.png" style="width:18px">&nbsp; Review + <?php echo $review; ?></a> </li>
                
                <?php if ($role == 8) { ?>
                <li style="border-right:none"><a href="javascript:"  class="btn-list" onclick ="checkuser(<?php echo $data->user_id; ?>,'<?php echo $actual_link; ?>');"><img src="<?php $baseUrl ?>images/icons/icon41.png" style="width:18px">&nbsp; Book / Request your Blood</a> </li>
                <?php }else if($role == 6) { ?>
                <li style="border-right:none"><a href="javascript:"  class="btn-list" onclick ="checkuser(<?php echo $data->user_id; ?>,'<?php echo $actual_link; ?>','<?php echo $role;?>');"><img src="<?php $baseUrl ?>images/icons/icon41.png" style="width:18px">&nbsp; Book Test at Lab / Home </a> </li>  
                <?php } else if($role == 7) { ?>
                <li style="border-right:none"><a href="javascript:"  class="btn-list" onclick ="checkuser(<?php echo $data->user_id; ?>,'<?php echo $actual_link; ?>','<?php echo $role;?>');"><img src="<?php $baseUrl ?>images/icons/icon41.png" style="width:18px">&nbsp; Book Diagnostic at Lab / Home</a> </li>
                <?php } 
                else if($role == 9) { ?>
                <li style="border-right:none"><a href="javascript:"  class="btn-list" onclick ="checkuser(<?php echo $data->user_id; ?>,'<?php echo $actual_link; ?>','<?php echo $role;?>');"><img src="<?php $baseUrl ?>images/icons/icon41.png" style="width:18px">&nbsp; Book Medicine at Store / Home</a> </li>
                <?php  }  ?>
               
            </ul>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-2.2.3.min.js"></script>
<script type="text/javascript">
    
    $(document).ready(function(){
	var maxLength = 200;
	$(".show-read-more").each(function(){
		var myStr = $(this).text();
		if($.trim(myStr).length > maxLength){
			var newStr = myStr.substring(0, maxLength);
			var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
			$(this).empty().html(newStr);
			$(this).append(' <a href="javascript:void(0);" class="read-more">read more...</a>');
			$(this).append('<span class="more-text">' + removedStr + '</span>');
		}
	});
	$(".read-more").click(function(){
		$(this).siblings(".more-text").contents().unwrap();
		$(this).remove();
               // $(this).removeClass('read-more');
	});
});
    
                    
</script>

<style type="text/css">
    .show-read-more .more-text{
        display: none;
    }
</style>