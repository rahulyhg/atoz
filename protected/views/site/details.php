<?php
$session = new CHttpSession;
$session->open();
$enc_key = Yii::app()->params->enc_key;
$baseUrl = Yii::app()->baseUrl;
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/fontawesome-stars.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.barrating.js', CClientScript::POS_END);
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-modal.js', CClientScript::POS_END);
$review = 0;
$review = Yii::app()->db->createCommand()->select('COUNT(id) as count')->from(' az_rating')->where('user_id=:uid', array(':uid' => $user_details['user_id']))->queryScalar();
$ratingmodel = Yii::app()->db->createCommand()->select('rating,user_id')
                ->from(' az_rating')
                ->where('created_by=:id and user_id=:uid', array(':id' => Yii::app()->user->id, ':uid' => $user_details['user_id']))->queryRow();
$initialRating = "null";
if (!empty($ratingmodel['rating'])) {
    $initialRating = $ratval = $ratingmodel['rating'];
} else {

    $ratval = 0;
}

$speciality = "";
$latitude = !empty($user_details['latitude']) ? $user_details['latitude'] : 21.2143;
$longitude = !empty($user_details['longitude']) ? $user_details['longitude'] : 81.6496;
Yii::app()->clientScript->registerScript('myjavascript1', '
   var map ;
   var myLatLng;
function initialize() {
        var lattitude =  ' . $latitude . ';
        var longitutde = ' . $longitude . ' ;
         myLatLng = new google.maps.LatLng(lattitude, longitutde);
        var mapOptions = {
            zoom: 14,
            center: myLatLng,
            // Extra options
            mapTypeControl: false,
            panControl: false,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.SMALL,
                position: google.maps.ControlPosition.LEFT_BOTTOM
            }
        };
        map = new google.maps.Map(document.getElementById("p-map"), mapOptions);
        var image = "' . Yii::app()->baseUrl . '/images/marker-1.png";

        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            draggable: false,
            icon: image
        });
    }
    google.maps.event.addDomListener(window, "load", initialize);
    
', CClientScript::POS_END);
Yii::app()->clientScript->registerScript('myjavascript2', '
    $(".example").barrating({
        theme: "fontawesome-stars",
        readonly:' . $ratval . ',
        initialRating:' . $initialRating . '
    });
', CClientScript::POS_READY);
$clinicvisitArr = array();
$docArr = array();
if ($user_details['role_id'] == 5) {
    $docArr = Yii::app()->db->createCommand()->select('first_name,last_name,user_id,profile_image,parent_hosp_id,address,experience,doctor_fees,landmark,city_name,state_name,country_name,payment_type,description,(SELECT GROUP_CONCAT(speciality_name) FROM az_speciality_user_mapping spm WHERE spm.user_id = t.user_id) as userspeciality,(select COUNT(ar.id) FROM az_rating ar WHERE ar.user_id = t.user_id ) as ratecount')
                    ->from('az_user_details t')
                    ->where('parent_hosp_id=:id and is_active = 1', array(':id' => $user_details['user_id']))->group("t.user_id")->queryAll();
}
?>  
<?php $roleid = $user_details['role_id']; ?>
<input type="hidden" class="doctorid" value="<?php echo $user_details['user_id']; ?>">
<input type="hidden" class="clinicaddress" value="<?php echo $user_details['city_name'] . ", " . $user_details['state_name'] . " " . $user_details['country_name']; ?>">
<div class="section-body"> 
    <section id="intro" class="section-doctors">
        <div class="overlay">
            <div class="row search-banner">
                <div class="container main-text">
                    <div class="col-md-12 backward">

                        <a class="back-home" href="<?php echo Yii::app()->baseUrl; ?>">Home </a> 

                    </div>

                    <!-- Start Search box -->
                    <?php $this->renderPartial('_searchbox'); ?>
                    <!-- End Search box -->
                    <div class="row">
                        <div class="col-md-12 back-backward">
                            <?php if ($user_details['role_id'] == 3) {
                                ?>
                                <?php echo CHtml::link('Doctor', array('site/doctordetails'), array("class" => "back-title", "style" => "display:inline;")); ?>

                                <span style="font-size:15px">
                                    &gt; &nbsp;&nbsp;
                                </span>
                                <?php
                                if (!empty($user_details['parent_hosp_id'])) {
                                    $HospitalName = Yii::app()->db->createCommand()
                                                    ->select('hospital_name')
                                                    ->from('az_user_details')
                                                    ->where('user_id=:id ', array(':id' => $user_details['parent_hosp_id']))->queryScalar();

                                    echo CHtml::link($HospitalName, array('site/details', 'param1' => yii::app()->getSecurityManager()->encrypt($user_details['parent_hosp_id'], $enc_key), "param2" => Yii::app()->getSecurityManager()->encrypt(0, $enc_key)), array("class" => "back-title", "style" => "display:inline; text-transform: capitalize;"));
                                    ?>
                                    <span style="font-size:15px">
                                        > &nbsp;&nbsp;
                                    </span>
                                <?php } ?>
                                <a class="back-title" href=""  style="display:inline; text-transform: capitalize;  ">  Dr.<?php echo $user_details['first_name'] . " " . $user_details['last_name']; ?></a>
                            <?php } elseif ($user_details['role_id'] == 5) { 
                                echo CHtml::link('Hospital', array('site/HospitalList'), array("class" => "back-title", "style" => "display:inline;text-transform: capitalize;"));
                                ?>
                                <span style="font-size:15px">
                                    &gt; &nbsp;&nbsp;
                                </span>
                                <a class="back-title" href="" style="display:inline;text-transform: capitalize;"> <?php echo $user_details['hospital_name']; ?></a>
                            <?php } elseif ($user_details['role_id'] == 6) { ?>
                                <?php echo CHtml::link('Pathology', array('site/PathologyList', 'role' => 6), array("class" => "back-title", "style" => "display:inline;")); ?>
                                <span style="font-size:15px">
                                    &gt; &nbsp;&nbsp;
                                </span>
                                <a class="back-title" href=""  style="display:inline;"> <?php echo $user_details['hospital_name']; ?></a>
                            <?php } elseif ($user_details['role_id'] == 7) { ?>
                                <?php echo CHtml::link('Diagnostic', array('site/PathologyList', 'role' => 7), array("class" => "back-title", "style" => "display:inline;")); ?>
                                <span style="font-size:15px">
                                    &gt; &nbsp;&nbsp;
                                </span>
                                <a class="back-title" href=""  style="display:inline;"> <?php echo $user_details['hospital_name']; ?></a>

                            <?php } elseif ($user_details['role_id'] == 8) { ?>
                                <?php echo CHtml::link('Blood Bank', array('site/PathologyList', 'role' => 8), array("class" => "back-title", "style" => "display:inline;")); ?>
                                <span style="font-size:15px">
                                    &gt; &nbsp;&nbsp;
                                </span>
                                <a class="back-title" href=""  style="display:inline;"> <?php echo $user_details['hospital_name']; ?></a>
                            <?php } elseif ($user_details['role_id'] == 9) { ?>
                                <?php echo CHtml::link('Medical Store', array('site/PathologyList', 'role' => 9), array("class" => "back-title", "style" => "display:inline;")); ?>
                                <span style="font-size:15px">
                                    > &nbsp;&nbsp;
                                </span>
                                <a class="back-title" href=""  style="display:inline;"> <?php echo $user_details['hospital_name']; ?></a>
                            <?php } ?>
                            <div class="underline-line">

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div> 

<section class="container-fuild" style=" background-color:#fff;border-bottom: 1px solid #e9e9e9;">
    <div class="overlay">
        <div class="row">

            <!-- 2-column layout -->
            <div class="container">

                <div class="col-md section resultrow">

                    <div class="col-md-2 text-center">
                        <div class="col-md-12 text-left text-img" style="padding-top: 6px;padding-bottom: 15px;">
                            <?php
                            $profilepath = Yii::app()->baseUrl;
                            if (empty($user_details['profile_image'])) {
                                if ($user_details['role_id'] == 3) {
                                    $profilepath .= "/images/icons/doctors.png";
                                }
                                if ($user_details['role_id'] == 5) {
                                    $profilepath .= "/images/icons/icon02.png";
                                }
                            } else {
                                $profilepath .= "/uploads/" . $user_details['profile_image'];
                            }
                            echo "<img src='$profilepath' class='img-circle img-responsive' style='margin-bottom:15px;height:135px;width:135px;'>";
                            ?>

                        </div>
                        <div class="col-md-12 text-left clearfix" style="padding: 15px 0 0 0;">
                            <strong  style='color:rgb(96,96,98);'> Modes of Payment </strong> 
                            <ul class="payment-list text-left col-pad clearfix" style="list-style-type: none;">
                                <?php
                                $paymentArr = explode(",", $user_details['payment_type']);
                                foreach ($paymentArr as $key => $value) {
                                    echo "<li style='line-height: 1.3;color: rgb(132, 134, 136);'>$value</li>";
                                }
                                ?>

                            </ul>
                            <?php
                            if ($user_details['role_id'] == 5) {
                                if (isset($user_details['hos_establishment']) && !empty($user_details['hos_establishment'])) {
                                    echo "<br><strong style='color:rgb(96,96,98);'> Year Established </strong> <br><strong style='color:rgb(96,96,98);'> " . date("Y", strtotime($user_details['hos_establishment'])) . "</strong>";
                                }
                            }
                            ?>

                        </div>
                    </div>
                    <div class="col-md-10 col-mar" style="margin-bottom:0"> 
                        <div class="col-md">
                            <div class="saving clearfix" style="border:none"> Review+ <?php echo $review; ?> <img src='<?php echo"$baseUrl/images/icons/review.png"; ?>' style="width:20px; height:20px">  
                                <div class="rating1" style="padding-top:10px;">   
                                    <select class=" example clearfix" onchange="rate('<?php echo $user_details['user_id']; ?>');">
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
                                <div class='starrr navbar-right' id='star1' style="margin-right: -99px;margin-top: 20px;"> 
                                    <div style="margin-left:5px">&nbsp;
                                        <span class='your-choice-was' style='display:none;'>
                                            Your rating was <span class='choice'></span>
                                        </span>
                                    </div> 
                                </div>   

                            </div>

                            <div class="col-md">
                                <?php
                                if ($user_details['role_id'] == 3) {
                                    echo "<h4 style='text-transform: capitalize;'>Dr." . $user_details['first_name'] . " " . $user_details['last_name'] . "</h4>";
                                } elseif ($user_details['role_id'] == 5) {
                                    echo "<h4 style='text-transform: capitalize;'>" . $user_details['hospital_name'] . " </h4>";
                                } elseif ($user_details['role_id'] == 6) {
                                    echo "<h4 style='text-transform: capitalize;'>" . $user_details['hospital_name'] . " </h4>";
                                } elseif ($user_details['role_id'] == 7) {
                                    echo "<h4 style='text-transform: capitalize;'>" . $user_details['hospital_name'] . " </h4>";
                                } elseif ($user_details['role_id'] == 8) {
                                    echo "<h4 style='text-transform: capitalize;'>" . $user_details['hospital_name'] . " </h4>";
                                } elseif ($user_details['role_id'] == 9) {
                                    echo "<h4 style='text-transform: capitalize;'>" . $user_details['hospital_name'] . " </h4>";
                                }

                                if ($user_details['role_id'] == 3) {
                                    $degreeArr = Yii::app()->db->createCommand()
                                            ->select('GROUP_CONCAT(degree_name SEPARATOR " , " )')
                                            ->from('az_doctor_degree_mapping dm')
                                            ->where("dm.doctor_id =:did", array(':did' => $user_details['user_id']))
                                            ->queryScalar();

                                    echo "<span class='col-view degreetext'>$degreeArr</span>";
                                    ?>
                                    <input type="hidden" class="degree" value="<?php echo $degreeArr; ?>">        
                                    <?php
                                } elseif ($user_details['role_id'] == 5) {
                                    echo "<h5 class='title-details' style='padding-left:0px;'>" . $user_details['type_of_hospital'] . "</h5>";
                                }
                                echo "<span class='col-view' style='margin-top: 8px; text-transform: capitalize; width:70%;'> " . $user_details['landmark'] . ", " . $user_details['area_name'] . ', ' . $user_details['city_name'] . ", " . $user_details['state_name'] . "</span>";

                                if ($user_details['role_id'] == 3) {
                                    ?>
                                    <input type="hidden" class="clinicname" value="<?php echo $user_details['clinic_name']; ?>">

                                    <?php
//                                $clinicArr = Yii::app()->db->createCommand()
//                                        ->select('GROUP_CONCAT(clinic_name)')
//                                        ->from('az_clinic_details')
//                                        ->where('doctor_id=:id', array(':id' => $user_details['user_id']))
//                                        ->queryScalar();
                                    if (!empty($clinicid)) {
                                        echo "<h5 class='title-details' style='padding-left:0;'>" . $user_details['clinic_name'] . "</h5>" . $user_details['city_name'];
                                    } else { //for hospital doctor
                                        echo "<h5 class='title-details' style='padding-left:0;'>";
                                        if (isset($user_details['clinic_name'])) {
                                            echo $user_details['clinic_name'];
                                        }
                                        echo "</h5>";
                                    }
                                } elseif ($user_details['role_id'] == 5) {

                                    echo "<h5 class='title-details' style='padding-left:1px;'>Bed Strength-  ";
                                    if (!empty($user_details['total_no_of_bed'])) {
                                        echo $user_details['total_no_of_bed'];
                                    } else {
                                        echo 'N/A';
                                    } echo "  </h5>";
                                }
                                ?>
<!--                                <p id="descriptiontext" style="height: 25px;overflow: hidden;margin-top: 8px;"><?php //echo $user_details['description'];     ?></p>
<a class="" href="javascript:" onclick="$('#descriptiontext').attr('style', 'height:auto;');
    $(this).hide();">Read More </a>-->

<!--                                <p class="show-read-more" style="    width: 76%;">
                                <?php //echo $user_details['description']; ?>
                                </p>-->

                                <div style="width: 71%; text-align: justify; text-transform: capitalize;"> 
                                    <span class="more">  
                                        <?php echo $user_details['description']; ?>
                                    </span>
                                </div>


                                <div class="viewer"> 
                                    <ul class="view-list" style="padding-top: 20px;"> 
                                        <?php
                                        if ($user_details['role_id'] == 3) {
                                            $doctor_fees = (!empty($user_details['doctor_fees'])) ? $user_details['doctor_fees'] . " Rs" : "NA";
                                            echo "<li style='padding-left:0'><span><img src='$baseUrl/images/icons/icon34.png' style='width:12px'> <a href='' class='btn-list'> &nbsp; Fees - " . $doctor_fees . " </a></span><span><img src='$baseUrl/images/icons/icon35.png' style='width:18px'> <a href='' class='btn-list'> &nbsp; Experience - " . CommonFunction::CalculateAge($user_details['experience']) . "</a></span> </li>";
                                        } elseif ($user_details['role_id'] == 5) {
                                            $estblishmentYear = "";
                                            if (!empty($user_details['hos_establishment'])) {
                                                $estblishmentYear = date("m-Y", strtotime($user_details['hos_establishment']));
                                            }
                                            echo '<li style="padding-left:0"><span><img src="' . $baseUrl . '/images/icons/establish.png" style="width:18px"> <a href="" class="btn-list"> &nbsp;Established In ' . $estblishmentYear . ' </a></span><span><img src="' . $baseUrl . '/images/icons/doctor.png" style="width:12px"> <a href="" class="btn-list"> &nbsp;  ' . count($docArr) . ' Doctors</a></span> </li>';
                                        }
                                        if ($user_details['role_id'] == 3) {
                                            //echo $user_details['user_id'];exit;
                                            echo '<li><span><img src="' . $baseUrl . '/images/icons/icon37.png" style="width:24px; vertical-align:middle">&nbsp; Hours of Operation';
                                            if (!empty($clinicid) && $user_details['is_open_allday'] == 'N') {
                                                echo CHtml::link('(ViewAll)', 'javascript:', array('class' => 'view', 'data-toggle' => 'modal', 'data-target' => '#clinictimings'));
                                            }
                                            echo '</span>';
                                            if (!empty($clinicid)) {
                                                if ($user_details['is_open_allday'] == 'Y') {
                                                    echo '<span style="padding-left: 25px;"> 24X7</span>';
                                                } else {
                                                    $clinicvisitArr = Yii::app()->db->createCommand()
                                                                    ->select('*')
                                                                    ->from('az_clinic_visiting_details')
                                                                    ->where('doctor_id=:id and clinic_id = :clinic_id', array(':id' => $user_details['user_id'], ":clinic_id" => $clinicid))->queryAll();
                                                    //print_r($clinicvisitArr);
                                                    if (count($clinicvisitArr) > 0) {
                                                        foreach ($clinicvisitArr as $key => $value) {
                                                            //echo strtolower(date("D")) ."==". strtolower($value['day'])."  ";
                                                            if (strtolower(date("D")) == strtolower($value['day'])) {
                                                                echo '<span style=""> Today  ' . date("h:i A", strtotime($value['clinic_open_time'])) . ' To ' . date("h:i A", strtotime($value['clinic_close_time'])) . '</span>';
                                                            }
                                                        }
                                                    } else {
                                                        echo '<span style="padding-left: 25px;"> &nbsp;</span>';
                                                    }
                                                }
                                            } else { //check hospital time
                                                if ($user_details['is_open_allday'] == 'Y') {
                                                    echo '<span style="padding-left: 25px;"> 24X7</span>';
                                                } else {
                                                    echo '<span style="padding-left: 25px;">  ' . $user_details['hospital_open_time'] . ' To  ' . $user_details['hospital_close_time'] . ' </span>';
                                                }
                                            }

                                            //print_r($clinicvisitArr);exit;

                                            echo '</li>';
                                            echo'<li style="padding-top:10px;"> <span><img src="' . $baseUrl . '/images/icons/icon36.png" style="width:20px"> <a href="javascript:" class="btn-list" onclick ="shareProfile(' . $user_details['user_id'] . ');"> &nbsp; Share this Profile </a></span></li>';

                                            echo' <li class="serv-list"> <span><a href="javascript:"  class="btn-list" onclick ="showAppointment( ' . $user_details['user_id'] . ',' . $user_details['doctor_fees'] . ',' . $clinicid . ');"> <img src="' . $baseUrl . '/images/icons/icon41.png" style="width:24px">  &nbsp; Book Your Appointment </a></span></li>';
                                        } else if ($user_details['role_id'] == 5) {
                                            if ($user_details['is_open_allday'] == 'Y') {
                                                echo '<li><span><img src="' . $baseUrl . '/images/icons/icon37.png" style="width:24px; vertical-align:middle">&nbsp; Hours of Operation   <aside style="padding-left: 25px;">24x7</aside></span></li>';
                                            } else if (empty($user_details['hospital_open_time'])) {
                                                echo '<li><span><img src="' . $baseUrl . '/images/icons/icon37.png" style="width:24px; vertical-align:middle">&nbsp; Hours of Operation   <aside style="padding-left: 25px;"></aside></span></li>';
                                            } else {
                                                echo '<li><span><img src="' . $baseUrl . '/images/icons/icon37.png" style="width:24px; vertical-align:middle">&nbsp; Hours of Operation   <aside style="padding-left: 25px;"> ' . date('h:i:s a', strtotime($user_details['hospital_open_time'])) . ' To  ' . date('h:i:s a', strtotime($user_details['hospital_close_time'])) . '</aside></span></li> ';
                                            }
                                            echo'<li style="padding-top:10px;"> <span><img src="' . $baseUrl . '/images/icons/icon36.png" style="width:24px"> <a href="javascript:" class="btn-list" onclick ="shareProfile(' . $user_details['user_id'] . ');"> &nbsp; Share this Profile </a></span></li>';
                                            echo'<li style="border-right:none;padding-top:10px;"> <span><img src="' . $baseUrl . '/images/icons/icon41.png" style="width:24px"> <a href="javascript:" class="btn-list" onclick ="checkHospitalservices();"> &nbsp; Book Your Appointment </a></span></li>';
                                        }
                                        ?>

                                    </ul>
                                </div> 

                                <div class="clearfix"></div>                            
                                <div class="amenities">
                                    <div class="viewer" id="tabsdetails"> 
                                        <ul class="services-list"> 
                                            <?php
                                            if ($user_details['role_id'] == 3) {
                                                echo '<li style="padding-left:10px;margin-right: 25px;"><span><a href="javascript:"  class="btn-list" onclick="showtab(\'#service_id\');"> <img src="' . $baseUrl . '/images/icons/icon38.png" style="width:35px">  &nbsp; Services &nbsp;&nbsp;&nbsp;</a></span></li>';
                                                echo '<li style="padding-left:10px;margin-right: 25px;"><span><a href="javascript:" class="btn-list" style="display: inline-block;" onclick="showtab(\'#service_and_saving\');" > <img src="' . $baseUrl . '/images/icons/icon39.png" style="width:30px; vertical-align:top">  &nbsp; Saving*&nbsp;&nbsp; <span style="margin-top:-8px">&nbsp;&nbsp;&nbsp;</span>  </a></span></li>';
                                                echo' <li style="padding-left:10px;margin-right: 25px;"> <span><a  href="javascript:"  class="btn-list" onclick="showtab(\'#dLocation\');"><img src="' . $baseUrl . '/images/icons/icon40.png" style="width:30px">  &nbsp; Location Map &nbsp;&nbsp;&nbsp; </a></span></li>';
                                                echo' <li style="padding-left:10px;margin-right: 25px;"> <span><a  href="javascript:"  class="btn-list" onclick="showtab(\'#otherphoto\');"><img src="' . $baseUrl . '/images/icons/Gallery.png" style="width:17px">  &nbsp;Gallery&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  </a></span></li>';

                                                //     showAppointment( ".$value['user_id'].",".$value['doctor_fees'].",".$clinicid.");
                                            } elseif ($user_details['role_id'] == 5) {
                                                echo '<li style="padding-left:0;margin-right: 15px;"><span><a href="javascript:"  class="btn-list" onclick="showtab(\'#doctor_list\');"> <img src="' . $baseUrl . '/images/icons/doctor.png" style="width:22px">  &nbsp; Specialty Doctor &nbsp;&nbsp;&nbsp;</a></span></li>';
                                                echo '<li style="margin-right: 15px;"><span><a href="javascript:"  class="btn-list" onclick="showtab(\'#service_and_saving\');"> <img src="' . $baseUrl . '/images/icons/icon39.png" style="width:30px">  &nbsp; Saving*&nbsp;&nbsp;&nbsp;&nbsp;</a></span></li>';
                                                echo '<li style="margin-right: 15px;"><span><a href="javascript:" class="btn-list" style="display: inline-block;"   onclick="showtab(\'#hosp_amenities\');"> <img src="' . $baseUrl . '/images/icons/amenities.png" style="width:24px; vertical-align:top">  &nbsp;Amenities &nbsp;&nbsp;&nbsp;&nbsp;</a></span></li>';
                                                echo' <li style="margin-right: 15px;"> <span><a  href="javascript:"  class="btn-list" onclick="showtab(\'#dLocation\'); "><img src="' . $baseUrl . '/images/icons/icon40.png" style="width:24px">  &nbsp; Location Map&nbsp;&nbsp;&nbsp;&nbsp;</a></span></li>';
                                                echo' <li style="margin-right: 15px;"> <span><a  href="javascript:"  class="btn-list" onclick="showtab(\'#otherphoto\');"><img src="' . $baseUrl . '/images/icons/Gallery.png" style="width:17px">  &nbsp;Gallery  &nbsp;&nbsp;&nbsp;&nbsp;</a></span></li>';
                                            }
                                            ?>
                                        </ul>

                                    </div> 
                                    <div class="amenities custom_tabs" id="service_id" style="<?php echo $user_details['role_id'] == 5 ? "display:none;" : ""; ?>">
                                        <?php
                                        $serviceArr = Yii::app()->db->createCommand()
                                                ->select('service_name,service_discount')
                                                ->from(' az_service_master sm')
                                                ->join('az_service_user_mapping sum', 'sm.service_id = sum.service_id')
                                                ->where(' sum.user_id=:did', array(':did' => $user_details['user_id']))
                                                ->queryAll();
                                        ?>
                                        <div  class="col-md-12 amenities-list "style="margin-left:45px;">
                                            <ul class="" style="margin:0px;padding:0px;">

                                                <?php foreach ($serviceArr as $key => $value) {
                                                    ?> <li><?php echo $value['service_name']; ?></li>

                                                <?php } ?>
                                            </ul>
                                        </div>

                                    </div>
                                    <div class=" custom_tabs" id="service_and_saving" style="display:none;padding-top: 10px;">
                                        <?php
                                        $serviceArr = Yii::app()->db->createCommand()
                                                ->select('service_name,service_discount,corporate_discount')
                                                ->from(' az_service_master sm')
                                                ->join('az_service_user_mapping sum', 'sm.service_id = sum.service_id')
                                                ->where(' sum.user_id=:did', array(':did' => $user_details['user_id']))
                                                ->queryAll();
                                        ?>
                                        <div id="#service_id" style="margin-left:45px;">
                                            <ul style="padding-top:2px;">
                                                <li style="list-style-type:none; "><div class="col-sm-6 clearfix"><?php echo 'Service'; ?></div><div class="col-sm-3"><?php echo ' Discount'; ?>%</div><div class="col-sm-3"><?php echo 'Corporate Discount'; ?>%</div></li><br>
                                                <?php foreach ($serviceArr as $key => $value) { ?>
                                                    <li><div class="col-sm-6 clearfix"><?php echo $value['service_name']; ?></div><div class="col-sm-3"><?php echo $value['service_discount']; ?>%</div><div class="col-sm-3"><?php echo $value['corporate_discount']; ?>%</div></li>
                                                <?php } ?>
                                            </ul>
                                        </div>

                                    </div>
                                    <div class=" custom_tabs" id="otherphoto" style="display:none;">
                                        <?php
                                        $otherphotoArr = Yii::app()->db->createCommand()
                                                ->select('user_id,doc_type,document')
                                                ->from(' az_document_details dd')
                                                ->where(' dd.user_id=:did AND doc_type =:doctype ', array(':did' => $user_details['user_id'], ':doctype' => "Gallery_photos")) // other_photos
                                                ->queryAll();
                                        ?>
                                        <div id="#service_id" style="margin-left:45px;">
                                            <ul>
                                                <?php foreach ($otherphotoArr as $key => $value) {
                                                    ?> 
                                                    <?php echo CHtml::image(Yii::app()->request->baseUrl . "/uploads/" . $value['document'], 'Photos', array('class' => 'otherimg_details', 'title' => 'Gallery', 'style' => 'height:100px;width:100px'));
                                                    ?>

                                                <?php } ?>
                                            </ul>
                                        </div>

                                    </div>
                                    <div id="dLocation" class="tab-pane clearfix custom_tabs" style="display:none;padding:15px;">
                                        <div id="p-map" style="height: 240px;width: 90%;border:1px solid #533223; border-radius: 25px;"></div>
                                    </div>
                                    <?php if ($user_details['role_id'] == 5) { ?>
                                        <div id="doctor_list" class="clearfix custom_tabs"> <!-- doctor_list start  -->
                                            <div class="col-md-12 text-left rating" style=" padding-bottom:15px">
                                                <?php
                                                $user = Yii::app()->db->createCommand()->select('spm.user_id,spm.speciality_name,COUNT(spm.speciality_id) as no')->from('az_user_details ud')->join('az_speciality_user_mapping spm', 'ud.user_id = spm.user_id')->where("ud.parent_hosp_id =:userid", array('userid' => $user_details['user_id']))->group('spm.speciality_id')
                                                        ->queryAll();
                                                ?>
                                                <span> <select class="minimal" id="doctorlist" onchange="showSpecialist(this);">
                                                        <option value="">All Specialist</option>
                                                        <?php
                                                        foreach ($user as $key => $value) {
                                                            // $sepciality_name = str_replace(" ", "", $value['speciality_name']);
                                                            $sepciality_name = str_replace(array('(', ')', ' '), "", $value['speciality_name']);
                                                            ?>

                                                            <option value='<?php echo $sepciality_name; ?>'><?php echo $value['speciality_name'] . "(" . $value['no'] . ")"; ?>

                                                            </option>

                                                        <?php } ?>
                                                    </select> </span> 

                                            </div>
                                            <?php
                                            foreach ($docArr as $dockey => $value) {

                                                $extraClass = "";
                                                if (!empty($value['userspeciality'])) {
                                                    $doctSpeArr = explode(",", $value['userspeciality']);
                                                    if (!empty($doctSpeArr)) {
                                                        foreach ($doctSpeArr as $sepciality) {
                                                            $sepciality = str_replace(array('(', ')', ' '), "", $sepciality);
                                                            $extraClass .= " doct_" . $sepciality;
                                                        }
                                                    }
                                                }
                                                ?>
                                                <div class="doct_cls clearfix <?php echo $extraClass; ?>">
                                                    <div class="col-md-2 text-center">
                                                        <div class="col-md-12 text-left" style="padding-top: 6px;">
                                                            <?php
                                                            $profilepath = Yii::app()->baseUrl;

                                                            if (empty($value['profile_image'])) {
                                                                $profilepath .= "/images/icons/icon01.png";
                                                            } else {
                                                                $profilepath .= "/uploads/" . $value['profile_image'];
                                                            }

                                                            echo CHtml::link("<img src='$profilepath' class='img-circle img-responsive' style='margin-bottom:15px;padding-top:8px;'>", array('site/details', 'param1' => Yii::app()->getSecurityManager()->encrypt($value['user_id'], $enc_key), "param2" => Yii::app()->getSecurityManager()->encrypt(0, $enc_key)));
                                                            ?>

                                                        </div>
                                                    </div>
                                                    <?php ?>
                                                    <div class="col-md-10 col-mar" style="margin-bottom:0"> 
                                                        <div class="col-md">                   
                                                            <?php
                                                            echo CHtml::link("<h4 style='padding-top: 8px;'>" . ucfirst($value['first_name']) . " " . ucfirst($value['last_name']) . " " . "</h4>", array('site/details', 'param1' => Yii::app()->getSecurityManager()->encrypt($value['user_id'], $enc_key), "param2" => Yii::app()->getSecurityManager()->encrypt(0, $enc_key)));

                                                            echo "<span class='col-view'>" . $value['userspeciality'] . "</span>";
                                                            $degreeArr = Yii::app()->db->createCommand()
                                                                    ->select('GROUP_CONCAT(degree_name)')
                                                                    ->from('az_degree_master dm')
                                                                    ->where("dm.degree_id IN (SELECT degree_id FROM `az_doctor_degree_mapping` as dmp where dmp.doctor_id =:did)", array(':did' => $value['user_id']))
                                                                    ->queryScalar();

                                                            echo "<h5 class='title-details' style='padding-left:0;font-size:14px'>$degreeArr</h5>";
                                                            ?>

                        <!--                                                            <p style=""><?php //echo $value['description'];    ?></p>-->
                                                            <div style="width: 71%; text-align: justify; text-transform: capitalize;"> 
                                                                <span class="more">  
                                                                    <?php echo $value['description']; ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="viewer"> 
                                                            <ul class="sec-list">          
                                                                <?php
                                                                $doctor_fees = (!empty($value['doctor_fees'])) ? $value['doctor_fees'] . " Rs" : "NA";
                                                                echo "<li style='padding-left:0'> <span><a href='' class='btn-list'> &nbsp; Fees - " . $doctor_fees . " &nbsp;&nbsp;</a></span></li><li><span> <a href='' class='btn-list'> &nbsp;&nbsp; Experience - " . CommonFunction::CalculateAge($value['experience']) . "&nbsp;&nbsp;</a></span> </li><li> <span><a href='' class='btn-list'> &nbsp;&nbsp; Review+" . $value['ratecount'] . " &nbsp;&nbsp;</a></span></li><li style='border-right:none'> <span><a href='javascript:'  class='btn-list' onclick ='showAppointment( " . $value['user_id'] . "," . $value['doctor_fees'] . ",0);'> &nbsp;&nbsp; Book Your Appointment </a></span></li>";
                                                                //   print_r($value);                   
                                                                ?>
                                                            </ul>

                                                        </div>

                                                        <div class="clearfix"></div>  
                                                        <div style="border-bottom: 1px dashed #C3C3C3;padding-top: 30px;"></div>
                                                    </div><!--/row-->
                                                    <div class="clearfix" style="margin:10px 0px;"></div> 
                                                </div>

                                            <?php } ?>
                                        </div>    <!-- doctor_list end  -->
                                        <div id="hosp_amenities" class="amenities-list custom_tabs" style="display:none;"> <!-- doctor_list start  -->
                                            <?php
                                            $hospAmenitiesArr = Yii::app()->db->createCommand()
                                                    ->select('amenities')
                                                    ->from('az_amenities')
                                                    ->where('hos_id=:did', array(':did' => $user_details['user_id']))
                                                    ->queryAll();
                                            // echo $user_details['user_id'];

                                            if (!empty($hospAmenitiesArr[0]['amenities'])) {
                                                ?>
                                                <ul>
                                                    <?php foreach ($hospAmenitiesArr as $key => $value) { ?> 
                                                        <li><?php echo $value['amenities']; ?></li>

                                                    <?php } ?>
                                                </ul>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>

                                </div>



                            </div>


                        </div>
                    </div> <!--col-md-12 end-->  

                    <div class="container visitmodel">
                        <!-- Modal -->

                        <div class="clearfix"></div>                

                    </div><!--/row-->
                </div>   
            </div>
            <?php $actual_link = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>
            </section><!--/.container-->
            <div class="modal fade bs-example-modal-lg" id="clinictimings" role="dialog">
                <div class="modal-dialog modal-md">
                    <div style="background-color:#56b8a8;">
                        <div class="modal-header" style="border:none;padding: 0px;">
                            <button type="button" class="close" data-dismiss="modal" style="padding:10px;color:#fff;font-size:45px;">&times;</button>
                            <!--<h4 class="modal-title">Modal Header</h4>-->
                        </div>

                        <!-- Modal content-->
                        <div class="modal-content">
                            <?php
                            if (count($clinicvisitArr) > 0) {
                                $html = "<table class='table table-stripped'>";
                                $html .= "<tr><th>Day</th><th>Open Time</th><th>Close Time</th></tr>";
                                foreach ($clinicvisitArr as $row) {
                                    $html .= "<tr><td style='text-transform:capitalize;'>" . $row['day'] . "</td><td>" . date("h:i A", strtotime($row['clinic_open_time'])) . "--" . date("h:i A", strtotime($row['clinic_close_time'])) .
                                            "<td>" . date("h:i A", strtotime($row['clinic_eve_open_time'])) . "--" .
                                            date("h:i A", strtotime($row['clinic_eve_close_time'])) . "</td>" .
                                            "</tr>";
                                    //echo '<span style=""> Today  ' . date("h:i A",strtotime($value['clinic_open_time'])) . ' To ' . date("h:i A",strtotime($value['clinic_close_time'])) . '</span>';
                                }
                                $html .= "</table>";
                                echo $html;
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade bs-example-modal-lg" id="appointModal" role="dialog">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content appointcontent">
                    </div>
                </div>
            </div>
            <div class="modal fade bs-example-modal-lg" id="profileModal" role="dialog">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content profilecontent">

                        <div class="modal-dialog modal-md">
                            <div class="modal-content email">
                                <div class=" clearfix search-fields rerror-div " style="display: none" id="rerrorid">
                                    <div class="alert alert-warning alert-dismissible fade in register-error" role="alert"  style="margin-top:15px; background-color:#E91724;border:1px solid #E91724;"><p class="text-center">Please Enter valid Email Address</p>
                                    </div>
                                </div>
                                <div class=" clearfix search-fields sucess-div " style="display: none" id="sucessid">
                                    <div class="alert alert-warning alert-dismissible fade in register-error" role="alert"  style="margin-top:15px; background-color:#0DB7A8;border:1px solid #0DB7A8;"><p class="text-center">Profile Share successfully </p>
                                    </div>
                                </div>
                                <div class="modal-header">
                                    <h4 class="text-center">Share Profile</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                                </div>
                                <div class="modal-body text-centert" style="padding:0px;">
                                    <div class="box box-primary">
                                        <div class= "col-sm-3 clearfix">
                                            <?php
                                            $profilepath = Yii::app()->baseUrl;
                                            if (empty($user_details['profile_image'])) {
                                                $profilepath .= "/images/icons/doctors.png";
                                            } else {
                                                $profilepath .= "/uploads/" . $user_details['profile_image'];
                                            }
                                            echo "<img src='$profilepath' class='img-circle img-responsive' style='margin-bottom:15px;height:65px;width:65px;'>";
                                            ?>
                                        </div>
                                        <div class="col-sm-9 clearfix">
                                            <h5 class='title-details' style='padding-left:0px;'><?php
                                                if ($user_details['role_id'] == 5) {
                                                    echo $user_details['hospital_name'];
                                                    ?></h5>
                                                <h5 class='title-details' style='padding-left:0px;'> <?php echo $user_details['type_of_hospital']; ?> </h5>
                                                <span class='col-view'>  <?php echo $user_details['city_name'] . ", " . $user_details['state_name'] . " " . $user_details['country_name'] ?> </span>

                                                <?php
                                            }
                                            ?>
                                        </div> 
                                        <div style="width: 71%; text-align: justify; text-transform: capitalize;"> 
                                            <span class="more">  
                                                <?php echo $user_details['description']; ?>
                                            </span>
                                        </div>
                                        <div>&nbsp;</div>
                                    </div>
                                    <div class="emailsend clearfix"style="margin:15px 15px 15px 15px;">
                                        <div class="col-sm-3" style="padding:15px;">
                                            <label >Share With:</label>
                                        </div>
                                        <div class="col-sm-8" >
                                            <input type="text" name="email" class="emailaddress form-control">
                                            <p>Note:Enter Email Address Separated by comma </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer text-center" style="text-align:center;">
                                    <button type="button" class="btn" onclick="take_email();">Send</button>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <?php $hospitalservices = Yii::app()->db->createCommand()->select('t.role_id,r.role_name,apt_contact_no_1')->from('az_user_details t')->andWhere('parent_hosp_id=:id ', array(':id' => $id))->andWhere('t.role_id >:start AND t.role_id <= :end', array(':start' => 5, ':end' => 9))->join('az_role_master r', 't.role_id=r.role_id')->queryAll(); ?>
            <div class="modal fade" id="myModal1" role="dialog" style="background-color:rgba(83,116,115,0.8);">
                <div class="modal-dialog" style="width:768px;margin:60px auto">

                    <!-- Modal content-->
                    <div style="background-color:rgba(83,116,115,0.8);">
                        <div class="modal-header" style="border:none;">
                            <button type="button" class="close" data-dismiss="modal" style="padding:10px;color:#fff;font-size:45px;">&times;</button>
                            <!--<h4 class="modal-title">Modal Header</h4>-->
                        </div>
                        <div class="modal-body" style="background-color:rgba(83,116,115,0.8); color:#fff;">
                            <div class="form-group">
                                <div class='col-sm-4' style="margin-top:15px;"> <h4 class='modal-title' onclick=" $('#myModal1').modal('hide');
                                        $(window).scrollTop($('#tabsdetails').offset().top);">OPD</h4><p> </p></div>
                                    <?php foreach ($hospitalservices as $key => $services) {
                                        ?>
                                    <div class="col-sm-4" style="margin-top:15px;">
                                        <h4 class="modal-title"><?php echo $services['role_name']; ?></h4>
                                        <p>+91 <?php echo $services['apt_contact_no_1']; ?></p>
                                    </div>
                                <?php }
                                ?>

                                <div class="modal-footer" style="border:none;">
                                    <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                                </div>
                            </div>

                        </div>
                    </div> 
                </div>
            </div>


            <?php
            $actual_link = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $redirectUrl = Yii::app()->request->getUrl();
            ?>
        <!--<script type="text/javascript" src="<?php //echo Yii::app()->baseUrl;    ?>/js/jquery-2.2.3.min.js"></script>-->
        <!--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyBacLj_vpokyTYesTfLGAf0AfKZJ9QCH-g"></script>-->
            <script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/select2.min.js"></script>
            <script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-2.2.3.min.js"></script>
            <script type="text/javascript">
                                    var redirectUrl = '<?php echo $redirectUrl; ?>';
                                    var action = '<?php echo $action; ?>';
                                    //var source = '<?php //echo $source;     ?>';
<?php if (isset($session['shareprofileshow'])) { ?>
                                        //     take_email();
                                        //alert('hiiii');
<?php } ?>

                                    $(document).ready(function () {

                                        var roleid = '<?php echo $user_details['role_id']; ?>';
                                        if (roleid == 5) {
                                            $('.hospital').show();
                                            $('.hos_doc_header').show();
                                        } else if (roleid == 3) {
                                            $('.doctor').show();
                                            $('.doctor_header').show();
                                        }
<?php if (isset($session['isshowappoint']) && !empty($param)) { ?>

                                            //alert('hiii');
                                            showAppointment(<?php echo $param; ?>,<?php echo $session['bkaptdocfee']; ?>,<?php echo $session['bkaptclinicid']; ?>);

<?php } ?>

                                        var showChar = 100;  // How many characters are shown by default
                                        var ellipsestext = "...";
                                        var moretext = "Show more >";
                                        var lesstext = "Show less";


                                        $('.more').each(function () {
                                            var content = $(this).html();

                                            if (content.length > showChar) {

                                                var c = content.substr(0, showChar);
                                                var h = content.substr(showChar, content.length - showChar);

                                                var html = c + '<span class="moreellipses">' + ellipsestext + '&nbsp;</span><span class="morecontent" ><span >' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

                                                $(this).html(html);
                                            }

                                        });

                                        $(".morelink").click(function () {
                                            if ($(this).hasClass("less")) {
                                                $(this).removeClass("less");
                                                $(this).html(moretext);
                                            } else {
                                                $(this).addClass("less");
                                                $(this).html(lesstext);
                                            }
                                            $(this).parent().prev().toggle();
                                            $(this).prev().toggle();
                                            return false;
                                        });



                                    });
                                    function showAppointment(docid, docfee, clinicid) {
                                        $.ajax({
                                            //async: false,
                                            type: 'POST',
                                            cache: false,
                                            url: '<?php echo Yii::app()->createUrl("site/bookappoint"); ?> ',
                                            data: {docid: docid, docfee: docfee, redirectUrl: redirectUrl, clinicid: clinicid},
                                            success: function (data)
                                            {
                                                //alert(data);
                                                $(".appointcontent").html(data);
                                                $("#appointModal").modal("show");
                                            }
                                        });
                                    }
                                    function checkuser()
                                    {

                                        var session = '<?php echo $session['user_id']; ?>';

                                        if (session === '') {
                                            window.location.href = "<?php echo Yii::app()->createUrl("site/getlogin", array('param1' => Yii::app()->getSecurityManager()->encrypt($actual_link, $enc_key))); ?>";
                                        } else {
                                            $('#myModallogin').modal('show');
                                        }
                                    }
                                    function checkHospitalservices()
                                    {

                                        var session = '<?php echo $session['user_id']; ?>';

                                        if (session === '') {
                                            window.location.href = "<?php echo Yii::app()->createUrl("site/getlogin", array('param1' => Yii::app()->getSecurityManager()->encrypt($actual_link, $enc_key))); ?>";
                                        } else {
                                            $('#myModal1').modal('show');
                                        }
                                    }
                                    function showtab(id)
                                    {
                                        $(".custom_tabs").hide();
                                        $(id).show();
                                        if (id == "#dLocation") {
                                            google.maps.event.trigger(map, 'resize');
                                            map.setCenter(myLatLng);
                                        }

                                    }
                                    function viewvisitdetails()
                                    {
                                        $('#myModalview').modal('show');
                                    }
                                    function showSpecialist(doctorlist) {
                                        var id = $("#doctorlist").val();
//                                        alert(doctorlist);
                                        if (id != "") {
                                            $(".doct_cls").hide();
                                            $(".doct_" + id).fadeIn(1000);

                                        } else {
                                            $(".doct_cls").fadeIn(1000);
                                        }

                                    }
                                    function rate(userid)
                                    {

                                        var session = '<?php echo $session['user_id']; ?>';

                                        if (session === '') {

                                            window.location.href = "<?php echo Yii::app()->createUrl("site/getlogin", array('param1' => Yii::app()->getSecurityManager()->encrypt($actual_link, $enc_key))); ?>";
                                        } else
                                        {
                                            var rate = $(".br-current-rating").text();


                                            $.ajax({
                                                //async: false,
                                                type: 'POST',
                                                //dataType: 'json',
                                                cache: false,
                                                url: '<?php echo Yii::app()->createUrl("site/addRating"); ?> ',
                                                data: {userid: userid, rate: rate},
                                                success: function (data)
                                                {
                                                    alert("Review submitted successfully Thank you For Review");
                                                    $('select').barrating('readonly', true);
                                                }
                                            });

                                        }

                                    }
                                    function take_email()
                                    {
                                        var email = $(".emailaddress").val(" ");
                                        //alert('in take_email');
                                        var userid = $(".doctorid").val();
                                        var degree = $(".degree").val();
                                        var clinicname = $(".clinicname").val();
                                        var clinicaddress = $(".clinicaddress").val();
                                        $.ajax({
                                            async: false,
                                            type: 'POST',
                                            cache: false,
                                            processData: false,
                                            dataType: 'json',
                                            url: '<?php echo Yii::app()->createUrl("site/shareProfile"); ?> ',
                                            data: {userid: userid, email: email, degree: degree, clinicname: clinicname, clinicaddress: clinicaddress},
                                            success: function (data) {
                                                var resultobj = data.result;
                                                if (resultobj.isError) {
                                                    $(".rerror-div").show();
                                                    $(".sucess-div").hide();
                                                } else {
                                                    $(".sucess-div").show();
                                                    $(".rerror-div").hide();
                                                }

                                            }
                                        });

                                    }
                                    function shareProfile(userid)
                                    {

                                        $(".rerror-div").hide();
                                        $(".sucess-div").hide();
                                        $.ajax({
                                            //async: false,
                                            type: 'POST',
                                            cache: false,
                                            url: '<?php echo Yii::app()->createUrl("site/shareProfileLogin"); ?> ',
                                            data: {redirectUrl: redirectUrl, userid: userid},
                                            success: function (data)
                                            {
                                                //alert(data);
                                                $(".profilecontent").html(data);
                                                $("#profileModal").modal("show");
                                            }
                                        });

                                    }


            </script>

            <style type="text/css">

                .morecontent span {
                    display: none;

                }
                .morelink {
                    display: block;
                }

            </style>
