<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$session = new CHttpSession;
$session->open();
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
//$detailLink = Yii::app()->createUrl("site/HospitalList", array('param1' => Yii::app()->getSecurityManager()->encrypt($data->user_id, $enc_key), "param2" => Yii::app()->getSecurityManager()->encrypt(0, $enc_key)));
$detailLink = Yii::app()->request->getUrl();
?>
<div class="col-md-12 resultrow">
    <div class="col-md-2 text-center">
        <a href="<?php echo Yii::app()->createUrl("site/details", array('param1' => Yii::app()->getSecurityManager()->encrypt($data->user_id, $enc_key), "param2" => Yii::app()->getSecurityManager()->encrypt(0, $enc_key))); ?>">
            <?php
            $imagePath = $baseUrl . "/images/icons/icon01.png";
            if (!empty($data->profile_image)) {
                $imagePath = $baseUrl . '/uploads/' . $data->profile_image;
            }
            ?>
            <img alt="profile_pic" src="<?php echo $imagePath; ?>" class="img-circle img-responsive"style="margin:12px;height:135px;width:135px"/>
        </a>
    </div>
    <div class="col-md-10 col-mar">
        <h4> <?php echo CHtml::link(ucwords(strtolower($data->hospital_name)) . " " . "<br>", array('site/details', 'param1' => Yii::app()->getSecurityManager()->encrypt($data->user_id, $enc_key), "param2" => Yii::app()->getSecurityManager()->encrypt(0, $enc_key))); ?></h4>     
        <h5 class="title-details" style="padding-left:0; padding-top:0"> <?php echo $data->type_of_hospital; ?> </h5>
        <span class="col-view" style="text-transform: capitalize;"><?php echo $data->area_name . ", " . $data->city_name.", ".$data->state_name; ?> </span>
        <h5 class="title-details" style="padding:1px;"> Bed Strength - 
        <?php if(!empty($data->total_no_of_bed)){echo $data->total_no_of_bed ;}else { ?><sapn style="font-size:13px;vertical-align:top">N/A</span><?php } ?>
        </h5>
<!--        <p id="descriptiontext" style="height: 25px;overflow: hidden;    width: 70%;"><?php // echo $data->description; ?></p>
        <a class="" href="javascript:" onclick="$('#descriptiontext').attr('style', 'height:auto;');
                $(this).hide();">Read More </a>-->
        
        <div style="width: 71%; text-align: justify;"> 
        <span class="more">  
          <?php echo  $data->description; ?>
        </span>
  </div>       

        <div class="saving">
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
            <div class="rating1" style="padding-top:10px;"> 
               
                <select class="example_<?php echo $data->user_id; ?> clearfix" >
                    <option value="" ></option>
                    <?php
                    for ($i = 1; $i <= 5; $i++) {
                        echo "<option value='$i' class='star' ";
                        if ($i == $ratval) {
                            echo " selected ";
                        }
                        echo " >$i</option>";
                    }
                    ?>

                </select></div>
            <span> Review+ <span class="reviewCount_<?php echo $data->user_id; ?>  "><?php echo $review.' '; ?></span><img src='<?php echo"$baseUrl/images/icons/review.png"; ?>' style="width:20px; height:20px"></span>      

            
           
        </div>
        <?php
        $docArr = array();
        $docCount = Yii::app()->db->createCommand()->select('count(user_id)')->from('az_user_details t')->where('parent_hosp_id=:id and is_active = 1', array(':id' => $data->user_id))->queryScalar();
        ?>
        <div class="viewer">
            <ul class="view-list">
 <li> <a href="javascript:" class="btn-default">   </a>  </li> 
                <li style="padding-left:0;"><a href="javascript:" class="btn-default"><img src='<?php echo "$baseUrl/images/icons/establish.png"; ?>' style="width:22px;vertical-align: middle;">&nbsp; <?php echo CHtml::link(ucwords(strtolower("Established in ")) . " " , array('site/details', 'param1' => Yii::app()->getSecurityManager()->encrypt($data->user_id, $enc_key), "param2" => Yii::app()->getSecurityManager()->encrypt(0, $enc_key))); ?> <?php
                        if (!empty($data->hos_establishment)) {
                            echo date("Y", strtotime($data->hos_establishment));
                        } else {
                            echo "";
                        }
                        ?></a> </li>

                <li> <a href="" class="btn-default"><img src='<?php echo "$baseUrl/images/icons/doctor.png"; ?>' style="width:18px;vertical-align: middle;">&nbsp;  <?php echo CHtml::link(ucwords(strtolower("No Of Doctors -" . $docCount)) . " " . "<br>", array('site/details', 'param1' => Yii::app()->getSecurityManager()->encrypt($data->user_id, $enc_key), "param2" => Yii::app()->getSecurityManager()->encrypt(0, $enc_key))); ?> </a>  </li> 


                <li style="border-right:none">
                    <a class="btn-default"  onclick ="checkuser( '<?php echo $data->user_id; ?>');" href="javascript:"> <img src='<?php echo "$baseUrl/images/icons/icon41.png"; ?>' style="width:18px;vertical-align: middle;">&nbsp; Book your Appointment </a>
                    
<!--                    <a href="javascript:" class="btn-default" onclick="checkuser(<?php //echo $data->user_id; ?>, '<?php //echo $detailLink; ?>');"><img src='<?php //echo "$baseUrl/images/icons/icon41.png"; ?>' style="width:18px;vertical-align: middle;">&nbsp;  Book Your Appointment</a>  showAppointment -->
                </li>
            </ul>
        </div>
    </div>
</div>


<!--   <script type="text/javascript">

$(document).ready(function() {  
     
}); 


 </script>-->
