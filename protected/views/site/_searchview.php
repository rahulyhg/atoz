<?php
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
} else {
    $ratval = 0;
}

Yii::app()->clientScript->registerScript('myjavascript2'.$data->user_id, '
    $(".example_'.$data->user_id.'").barrating({
        theme: "fontawesome-stars",
        readonly:' . $ratval . ',
        initialRating:' . $initialRating . ',
        onSelect: function(value, text, event) {
                
            if (typeof(event) !== "undefined") {
                // rating was selected by a ser
                 rate('.$data->user_id.',value);
            }
        }
    });
', CClientScript::POS_READY);
$baseUrl = Yii::app()->baseUrl;
$enc_key = Yii::app()->params->enc_key;
$userId = CHtml::encode($data->user_id);
$clini_id = 0;
if (!empty($data->clinic_id)) {
    $clini_id = $data->clinic_id;
}
$detailLink = Yii::app()->createUrl('site/details', array('param1' => Yii::app()->getSecurityManager()->encrypt($data->user_id, $enc_key), "param2" => Yii::app()->getSecurityManager()->encrypt($clini_id, $enc_key)));
?>
<div class="col-md-12 resultrow">
    <div class="col-md-2 text-center">
        <a href="<?php echo $detailLink; ?>">
            <?php
            $imagePath = $baseUrl . "/images/icons/icon01.png";
            if (!empty($data->profile_image)) {
                $imagePath = $baseUrl . '/uploads/' . $data->profile_image;
            }
            ?>
            <img alt="profile_pic" src="<?php echo $imagePath; ?>" class="img-circle img-responsive"style="margin-top:9px;height:135px;width:135px;"/>
        </a>
    </div>
    <div class="col-md-10 col-mar">
        <h4 style=" text-transform: capitalize;"><?php echo CHtml::link("Dr. " . $data->first_name . " " . $data->last_name . "<br>", array('site/details', 'param1' => Yii::app()->getSecurityManager()->encrypt($data->user_id, $enc_key), "param2" => Yii::app()->getSecurityManager()->encrypt($clini_id, $enc_key))); ?></h4>
        <span class="col-view degreetext"><?php echo $data->doctordegree . "<br>"; ?> </span>
        <span class="col-view degreetext"><?php echo $data->doctorspeciality . "<br>"; ?> </span>
        <span class="col-view degreetext"><?php echo $data->sub_speciality . "<br>"; ?> </span>
        
        
        <span class="col-view">
            <?php
            if (!empty($data->parent_hosp_id)) {
                if( $data->area_name == 'Select Area' || $data->area_name == ''){
                    $data->area_name = '';
                }else{
                    $data->area_name = $data->area_name .', ';
                }
                
                echo  $data->area_name . $data->city_name . ", " . $data->state_name . "<br>";
            } else {
                echo $data->clinic_address . ", " . $data->area_id . "," . $data->city_id . "," . $data->state_id . ", " . $data->country_id . "<br>";
            }
            ?>
        </span>
        <h5 class="title-details" style="padding-left:0">
            <?php
            $doctor_fees = "";
            if (!empty($data->parent_hosp_id)) { //means it belong to hospital
                $hospitalName = Yii::app()->db->createCommand()->select("hospital_name")->from("az_user_details")->where("user_id = :id", array(":id" => $data->parent_hosp_id))->queryScalar();
                echo $hospitalName;
                
                $doctor_fees = (!empty($data->fees)) ? $data->fees . " Rs" : "NA";
            } else { //get clinic name
//                $clinicDetails = Yii::app()->db->createCommand()->select("GROUP_CONCAT(clinic_name) as clinicname, min(opd_consultation_fee) as minrange,max(opd_consultation_fee) as maxrange")->from("az_clinic_details")->where("doctor_id = :id", array(":id" => $data->user_id))->queryRow();
//                echo $clinicDetails['clinicname'];
                echo $data->clinic_name;
                $doctor_fees = (!empty($data->fees)) ?  $data->fees." Rs"  : "NA";
//                if($clinicDetails['minrange'] != $clinicDetails['maxrange'])
//                    $doctor_fees = $clinicDetails['minrange'] ." Rs - ".$clinicDetails['maxrange']." Rs";
//                else
//                    $doctor_fees = $clinicDetails['minrange'] ." Rs ";
            }
            ?>
        </h5>
<!--        <p class="col-view"> <?php //echo $data->description; ?></p>-->
         <div style="width: 71%; text-align: justify;"> 
        <span class="more">  
          <?php echo  $data->description; ?>
        </span>
  </div>    

        <div class="saving">
            <div class='starrr' id='star1'>
                <div style="margin-left:5px">
                    <div class="rating1"> 
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
                    <span class='your-choice-was' style='display:none;'>
                        Your rating was <span class='choice'></span>
                    </span>
                </div>
            </div>
            <?php
            $savings = "";
            if (empty($data->parent_hosp_id)) { //means it belong to hospital
                $savings = Yii::app()->db->createCommand()->select("MAX(service_discount)")->from("az_service_user_mapping")->where("user_id = :id AND clinic_id = :cid", array(":id" => $data->user_id, ":cid" => $data->clinic_id ))->queryScalar();
            }
            if(!empty($savings)) {
                echo "<span>Savings Upto $savings %*</span>";
            }else{
                echo "<span>NA</span>";
            }
            ?>
            
        </div>

        <div class="viewer">
            <ul class="view-list">
                <li style="padding-left:0"><a href="javascript:" class="btn-default">
                        <img src='<?php echo "$baseUrl/images/icons/icon34.png"; ?>' style="width:11px;vertical-align: middle;">&nbsp;
                        <?php
                        if (!empty($doctor_fees)) {
                            echo "Fees - " . $doctor_fees;
                        }
                        ?>&nbsp;</a>
                </li>
                <li><a href="" class="btn-default"><img src='<?php echo "$baseUrl/images/icons/icon35.png"; ?>' style="width:15px;vertical-align: middle;">&nbsp; Experience- 
                    
                    <?php 
                    if(!empty($data->experience))
                    {echo CommonFunction::CalculateAge($data->experience);
                    }else{echo 'NA';}
                    ?></a> </li>
<!--                <li><a href="" class="btn-default">Distance - 2km </a></li>-->
<li><a href="" class="btn-default"><img src='<?php echo "$baseUrl/images/icons/review.png"; ?>' style="width:18px;vertical-align: middle;">&nbsp; Review + <span class="reviewCount_<?php echo $data->user_id; ?>" style="display:inline;"><?php echo $review; ?></span></a></li>

                <li style="border-right:none">
                    <a class="btn-default"  onclick ="showAppointment( '<?php echo $data->user_id;?>','<?php echo $data->fees;?>','<?php echo $clini_id;?>');" href="javascript:"> <img src='<?php echo "$baseUrl/images/icons/icon41.png"; ?>' style="width:18px;vertical-align: middle;">&nbsp; Book your Appointment </a>
<!--                    <a class="btn-default"  onclick ="checkuser('<?php //echo $data->apt_contact_no_1; ?>', '<?php //echo $data->user_id; ?>');" href="javascript:">Book your Appointment </a>-->
                
                </li>
            </ul>
        </div>

    </div>
    <div class="tc-apply">

    </div>
</div> <!--col-md-12 end-->

<div class="clearfix"></div>
