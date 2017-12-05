<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$baseUrl = Yii::app()->baseUrl;
$enc_key = Yii::app()->params->enc_key;

?>
<div class="col-md-12 resultrow">
    <div class="col-md-2 text-center">
        <a href="">
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
        <h4><?php echo CHtml::link("Dr. " .ucwords(strtolower($data->first_name)) . " " . ucwords(strtolower($data->last_name)) . "<br>"); ?></h4>
        <span class="col-view degreetext"><?php echo $data->doctordegree . "<br>"; ?> </span>
        <span class="col-view degreetext">Speciality - <?php echo $data->speciality_name . "<br>"; ?> </span>
        <span class="col-view">
            <?php
            if (!empty($data->parent_hosp_id)) {
                echo $data->address . ", " . $data->area_name . "," . $data->city_name . "," . $data->state_name . ", " . $data->country_name . "<br>";
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
                $doctor_fees = $data->doctor_fees . " Rs";
            } else { //get clinic name
//                $clinicDetails = Yii::app()->db->createCommand()->select("GROUP_CONCAT(clinic_name) as clinicname, min(opd_consultation_fee) as minrange,max(opd_consultation_fee) as maxrange")->from("az_clinic_details")->where("doctor_id = :id", array(":id" => $data->user_id))->queryRow();
//                echo $clinicDetails['clinicname'];
                echo $data->clinic_name;
                $doctor_fees = $data->opd_consultation_fee . " Rs";
//                if($clinicDetails['minrange'] != $clinicDetails['maxrange'])
//                    $doctor_fees = $clinicDetails['minrange'] ." Rs - ".$clinicDetails['maxrange']." Rs";
//                else
//                    $doctor_fees = $clinicDetails['minrange'] ." Rs ";
            }
            ?>
        </h5>
        <p class="col-view"> <?php echo $data->description; ?></p>
 <div class="viewer">
            <ul class="view-list">
               <li><a href="" class="btn-default"> &nbsp; Turnaround Time - 2 hours </a></li> 
                <li><a href="" class="btn-default">Experience- <?php echo CommonFunction::CalculateAge($data->experience); ?></a> </li>
                <li><a href="javascript:" class="btn-default">
                        <?php
                        if (!empty($doctor_fees)) {
                            echo "Fees - " . $doctor_fees;
                        }
                        ?>&nbsp;</a>
                </li>
               
               
                <li><a href="" class="btn-default">Distance - 2km </a></li>
               

                <li style="border-right:none"><a class="btn-default"  onclick ="checkuser('<?php echo $data->user_id; ?>', '<?php echo $data->user_id; ?>');" href="javascript:">Book/Confirm </a></li>
            </ul>
        </div>
        </div>
    <div class="tc-apply">

    </div>
</div> <!--col-md-12 end-->

<div class="clearfix"></div>

