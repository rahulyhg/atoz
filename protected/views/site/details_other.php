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
            zoom: 12,
            center: myLatLng,
            // This is where you would paste any style found on Snazzy Maps.
            styles: [{featureType:"landscape",stylers:[{saturation:-100},{lightness:65},{visibility:"on"}]},{featureType:"poi",stylers:[{saturation:-100},{lightness:51},{visibility:"simplified"}]},{featureType:"road.highway",stylers:[{saturation:-100},{visibility:"simplified"}]},{featureType:"road.arterial",stylers:[{saturation:-100},{lightness:30},{visibility:"on"}]},{featureType:"road.local",stylers:[{saturation:-100},{lightness:40},{visibility:"on"}]},{featureType:"transit",stylers:[{saturation:-100},{visibility:"simplified"}]},{featureType:"administrative.province",stylers:[{visibility:"off"}]},{featureType:"administrative.locality",stylers:[{visibility:"off"}]},{featureType:"administrative.neighborhood",stylers:[{visibility:"on"}]},{featureType:"water",elementType:"labels",stylers:[{visibility:"off"},{lightness:-25},{saturation:-100}]},{featureType:"water",elementType:"geometry",stylers:[{hue:"#ffff00"},{lightness:-25},{saturation:-97}]}],

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
    $docArr = Yii::app()->db->createCommand()->select('first_name,last_name,user_id,profile_image,parent_hosp_id,address,experience,doctor_fees,city_name,state_name,country_name,payment_type,description,(SELECT GROUP_CONCAT(speciality_name) FROM az_speciality_user_mapping spm WHERE spm.user_id = t.user_id) as userspeciality')->from('az_user_details t')->where('parent_hosp_id=:id and is_active = 1', array(':id' => $user_details['user_id']))->group("t.user_id")->queryAll();
}
?>  
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
                        <div class="col-md-4 back-backward">
                            <?php if ($role == 6) { ?>
                                <?php echo CHtml::link('Pathology', array('site/PathologyList', 'role' => 6), array("class" => "back-title", "style" => "display:inline;")); ?>


                                <span style="font-size:15px">
                                    > &nbsp;&nbsp;
                                </span>
                                <a class="back-title" href=""  style="display:inline;text-transform: capitalize;"> <?php echo $user_details['hospital_name']; ?></a>

                            <?php } ?>
                            <?php if ($role == 7) { ?>
                                <?php echo CHtml::link('Diagnostic', array('site/pathologyList', 'role' => 7), array("class" => "back-title", "style" => "display:inline;text-transform: capitalize;")); ?>


                                <span style="font-size:15px">
                                    > &nbsp;&nbsp;
                                </span>
                                <a class="back-title" href=""  style="display:inline;text-transform: capitalize;"> <?php echo $user_details['hospital_name']; ?></a>

                            <?php } ?>
                            <?php if ($role == 8) { ?>
                                <?php echo CHtml::link('Blood Bank', array('site/pathologyList', 'role' => 8), array("class" => "back-title", "style" => "display:inline;text-transform: capitalize;")); ?>


                                <span style="font-size:15px">
                                    > &nbsp;&nbsp;
                                </span>
                                <a class="back-title" href=""  style="display:inline;text-transform: capitalize;"> <?php echo $user_details['hospital_name']; ?></a>

                            <?php } ?>
                            <?php if ($role == 9) { ?>
                                <?php echo CHtml::link('Medical Store', array('site/pathologyList', 'role' => 9), array("class" => "back-title", "style" => "display:inline;text-transform: capitalize;")); ?>


                                <span style="font-size:15px">
                                    > &nbsp;&nbsp;
                                </span>
                                <a class="back-title" href=""  style="display:inline;text-transform: capitalize;"> <?php echo $user_details['hospital_name']; ?></a>

                            <?php } ?>
                            <div class="underline-line">

                            </div>
                        </div>
                        <div class="col-md-6">&nbsp;</div>
                        <div class="col-md-4 text-right rating">

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
                                if ($role == 6) {
                                    $profilepath .= "/images/icons/pathology.png";
                                } elseif ($role == 7) {
                                    $profilepath .= "/images/icons/diagnostics.png";
                                } elseif ($role == 9) {
                                    $profilepath .= "/images/icons/pharmacies.png";
                                } elseif ($role == 8) {
                                    $profilepath .= "/images/icons/blood-bank.png";
                                }
                            } else {
                                $profilepath .= "/uploads/" . $user_details['profile_image'];
                            }
                            echo "<img src='$profilepath' class='img-circle img-responsive' style='margin-bottom:15px;height:135px;width:135px;'>";
                            ?>

                        </div>
                        <div class="col-md-12 text-left clearfix" style="padding: 15px 0 0 0;">

                            <?php
                            if (isset($user_details['hos_establishment']) && !empty($user_details['hos_establishment'])) {
                                echo "<br><strong style='color:rgb(96,96,98);'> Year Established </strong> <br><strong style='color:rgb(96,96,98);'> " . date("Y", strtotime($user_details['hos_establishment'])) . "</strong>";
                            }
                            ?>

                        </div>
                    </div>
                    <div class="col-md-10 col-mar" style="margin-bottom:0"> 
                        <div class="col-md">
                            <div class="saving clearfix" style="border:none"> Review+ <?php echo $review; ?> <img src='<?php echo "$baseUrl/images/icons/review.png"; ?>' style="width:20px; height:20px">  
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
                                if ($user_details['role_id'] == 6) {
                                    echo "<h4 style='text-transform: capitalize;'>" . $user_details['hospital_name'] . " </h4>";

                                    echo "<h5 class='title-details' style='padding:0px;'>" . $user_details['type_of_hospital'] . "</h5>";
                                }
                                if ($user_details['role_id'] == 7) {
                                    echo "<h4 style='text-transform: capitalize;'>" . $user_details['hospital_name'] . " </h4>";

                                    echo "<h5 class='title-details' style='padding:0px;'>" . $user_details['type_of_hospital'] . "</h5>";
                                }
                                if ($user_details['role_id'] == 8) {
                                    echo "<h4 style='text-transform: capitalize;'>" . $user_details['hospital_name'] . " </h4>";

                                    echo "<h5 class='title-details' style='padding:0px;'>" . $user_details['type_of_hospital'] . "</h5>";
                                }
                                if ($user_details['role_id'] == 9) {
                                    echo "<h4 style='text-transform: capitalize;'>" . $user_details['hospital_name'] . " </h4>";

                                    echo "<h5 class='title-details' style='padding:0px;'>" . $user_details['type_of_hospital'] . "</h5>";
                                }
                                if ($user_details['landmark'] != '') {   //to remove comma character
                                    $user_details['landmark'] = $user_details['landmark'] . ', ';
                                }

                                echo "<span class='col-view' style='margin-top: 8px;text-transform: capitalize;'> " . $user_details['landmark'] . $user_details['area_name'] . ', ' . $user_details['city_name'] . ", " . $user_details['state_name'] . "</span>";
                                ?>
<!--                                <p id="descriptiontext" style="height: 25px;overflow: hidden;margin-top: 8px;text-transform: capitalize;"><?php echo $user_details['description']; ?></p>
                                <a class="" href="javascript:" onclick="$('#descriptiontext').attr('style', 'height:auto;');
                                        $(this).hide();">Read More </a>-->

                                <div style="width: 71%; text-align: justify; text-transform: capitalize;"> 
                                    <span class="more">  
<?php echo $user_details['description']; ?>
                                    </span>
                                </div>
                                <div class="clearfix"></div>

                                <div class="viewer"> 
                                    <ul class="view-list"> 
                                        <?php
                                        if ($user_details['role_id'] == 6 || $user_details['role_id'] == 7 || $user_details['role_id'] == 8 || $user_details['role_id'] == 9) {


                                            $estblishmentYear = "";
                                            if (!empty($user_details['hos_establishment'])) {
                                                $estblishmentYear = date("m-Y", strtotime($user_details['hos_establishment']));
                                            }else{
                                                $estblishmentYear = 'NA';
                                            }
                                            echo '<li style="padding-left:0"><span><img src="' . $baseUrl . '/images/icons/establish.png" style="width:18px"> <a href="" class="btn-list"> &nbsp;Established In ' . $estblishmentYear . ' </a></span> </li>';

                                            //echo $user_details['user_id'];exit;
                                            echo '<li><span><img src="' . $baseUrl . '/images/icons/icon37.png" style="width:24px; vertical-align:middle">&nbsp; Hours of Operation ';
                                            if ( $user_details['is_open_allday'] == 'N') {
                                                echo CHtml::link('(ViewAll)', 'javascript:', array('class' => 'view', 'data-toggle' => 'modal', 'data-target' => '#clinictimings'));
                                            }
                                            echo '</span>';
                                          //  echo 'hiii'.$clinicid;
                                           // if (!empty($clinicid)) {
                                                if ($user_details['is_open_allday'] == 'Y') {
                                                    echo '<span style="padding-left: 25px;"> 24X7</span>';
                                                } else {
                                                    $clinicvisitArr = Yii::app()->db->createCommand()
                                                                    ->select('*')
                                                                    ->from('az_clinic_visiting_details')
                                                                    ->where('doctor_id=:id', array(':id' => $user_details['user_id']))->queryAll();

                                                    if (count($clinicvisitArr) > 0) {
                                                        foreach ($clinicvisitArr as $key => $value) {
                                                            //echo strtolower(date("D")) ."==". strtolower($value['day'])."  ";
                                                            if (strtolower(date("D")) == strtolower($value['day'])) {
//                                                                if($value['clinic_open_time'] != NULL)
                                                                echo '<span style=""> Today  ' . date("h:i A", strtotime($value['clinic_open_time'])) . ' To ' . date("h:i A", strtotime($value['clinic_close_time'])) . '</span>';
                                                            }
                                                        }
                                                    } else {
                                                        echo '<span style="padding-left: 25px;"> &nbsp;</span>';
                                                    }
                                                }
//                                            } 
//                                            else { //check hospital time
//                                                if ($user_details['is_open_allday'] == 'Y') {
//                                                    echo '<span style="padding-left: 25px;"> 24X7</span>';
//                                                } else {
//                                                    if ($user_details['hospital_open_time'] != '')
//                                                        echo '<span style="padding-left: 25px;">  ' . $user_details['hospital_open_time'] . ' To  ' . $user_details['hospital_close_time'] . ' </span>';
//                                                }
                                            }

                                            //print_r($clinicvisitArr);exit;

                                            echo '</li>';


                                            echo'<li style="border-right:none;padding-top:10px;"> <span><img src="' . $baseUrl . '/images/icons/icon36.png" style="width:24px"> <a href="javascript:" class="btn-list" onclick ="shareProfile('.$user_details['user_id'].');"> &nbsp; Share this Profile </a></span></li>';
                                        
                                        ?>

                                    </ul>
                                </div> 
                                <div class="clearfix"></div>
                                <div class="amenities">
                                    <div class="viewer"> 
                                        <ul class="services-list"> 
                                            <?php
                                            if ($user_details['role_id'] == 6) {
                                                echo '<li style=""><span><a href="javascript:"  class="btn-list" onclick="showtab(\'#service_id\');"style="padding: 10px;"> <img src="' . $baseUrl . '/images/icons/icon38.png" style="width:30px">  &nbsp; Services &nbsp;&nbsp;</a></span></li>';
                                                echo '<li><span><a href="javascript:" class="btn-list" style="display: inline-block;" onclick="showtab(\'#service_and_saving\');" style="padding: 10px;"><img src="' . $baseUrl . '/images/icons/icon39.png" style="width:30px; vertical-align:top">  &nbsp; Savings <span style="margin-top:-8px">(*T&C apply)</span>&nbsp;&nbsp;&nbsp;  </a></span></li>';
                                                echo' <li> <span><a  href="javascript:"  class="btn-list" onclick="showtab(\'#dLocation\');"style="padding: 10px;"><img src="' . $baseUrl . '/images/icons/icon40.png" style="width:30px">  &nbsp; Location Map &nbsp;&nbsp; </a></span></li>';



                                                echo' <li class="serv-list"> <span><a href="javascript:"  class="btn-list" onclick ="checkuserlab();"style="padding: 10px;"><img src="' . $baseUrl . '/images/icons/icon41.png" style="width:24px">  &nbsp; Book Test at Lab / Home &nbsp;&nbsp;</a></span></li>';
                                            } elseif ($user_details['role_id'] == 7) {
                                                echo '<li style=""><span><a href="javascript:"  class="btn-list" onclick="showtab(\'#service_id\');"style="padding: 10px;"> <img src="' . $baseUrl . '/images/icons/icon38.png" style="width:30px">  &nbsp; Services </a></span></li>';
                                                echo '<li><span><a href="javascript:" class="btn-list" style="display: inline-block;" onclick="showtab(\'#service_and_saving\');"style="padding: 10px;"> <img src="' . $baseUrl . '/images/icons/icon39.png" style="width:30px; vertical-align:top">  &nbsp; Savings <span style="margin-top:-8px">(*T&C apply)</span>&nbsp;&nbsp;  </a></span></li>';
                                                echo' <li> <span><a  href="javascript:"  class="btn-list" onclick="showtab(\'#dLocation\');"style="padding: 10px;"><img src="' . $baseUrl . '/images/icons/icon40.png" style="width:30px">  &nbsp; Location Map &nbsp;&nbsp; </a></span></li>';
                                                echo' <li class="serv-list"> <span><a href="javascript:"  class="btn-list" onclick ="checkuserlab();"style="padding: 10px;"><img src="' . $baseUrl . '/images/icons/icon41.png" style="width:24px">  &nbsp; Book Diagnostic at Lab / Home &nbsp;&nbsp;</a></span></li>';
                                            } elseif ($user_details['role_id'] == 8) {
                                                echo '<li style=""><span><a href="javascript:"  class="btn-list" onclick="showtab(\'#service_id\');"style="padding: 10px;"> <img src="' . $baseUrl . '/images/icons/icon38.png" style="width:30px">  &nbsp; Services &nbsp;&nbsp;</a></span></li>';
                                                echo '<li><span><a href="javascript:" class="btn-list" style="display: inline-block;" onclick="showtab(\'#service_and_saving\');" style="padding: 10px;"> <img src="' . $baseUrl . '/images/icons/icon39.png" style="width:30px; vertical-align:top">  &nbsp; Savings <span style="margin-top:-8px">(*T&C apply)</span> &nbsp;&nbsp;</a></span></li>';
                                                echo' <li> <span><a  href="javascript:"  class="btn-list" onclick="showtab(\'#dLocation\');"style="padding: 10px;"><img src="' . $baseUrl . '/images/icons/icon40.png" style="width:30px">  &nbsp; Location Map  &nbsp;&nbsp;</a></span></li>';
                                                echo' <li class="serv-list"> <span><a href="javascript:"  class="btn-list" onclick ="checkuserlab();"style="padding: 10px;"><img src="' . $baseUrl . '/images/icons/icon41.png" style="width:24px">  &nbsp; Book/request your Blood </a></span></li>';
                                            } elseif ($user_details['role_id'] == 9) {
                                                echo '<li style=""><span><a href="javascript:"  class="btn-list" onclick="showtab(\'#service_id\');"style="padding: 10px;"> <img src="' . $baseUrl . '/images/icons/icon38.png" style="width:30px">  &nbsp; Services &nbsp;&nbsp;</a></span></li>';
                                                echo '<li><span><a href="javascript:" class="btn-list" style="display: inline-block;" onclick="showtab(\'#service_and_saving\');" style="padding: 10px;"> <img src="' . $baseUrl . '/images/icons/icon39.png" style="width:30px; vertical-align:top">  &nbsp; Savings <span style="margin-top:-8px">(*T&C apply)</span> &nbsp;&nbsp; </a></span></li>';
                                                echo' <li> <span><a  href="javascript:"  class="btn-list" onclick="showtab(\'#dLocation\');"style="padding: 10px;"><img src="' . $baseUrl . '/images/icons/icon40.png" style="width:30px">  &nbsp; Location Map &nbsp;&nbsp; </a></span></li>';
                                                echo' <li class="serv-list"> <span><a href="javascript:"  class="btn-list" onclick ="checkuserlab();"style="padding: 10px;"><img src="' . $baseUrl . '/images/icons/icon41.png" style="width:24px">  &nbsp;Book Medicine at Store / Home &nbsp;&nbsp;</a></span></li>';
                                            }
                                            ?>
                                        </ul>

                                    </div> 
                                    <div class="amenities-list custom_tabs" id="service_id" >
                                        <?php
                                        $serviceArr = Yii::app()->db->createCommand()
                                                ->select('service_name')
                                                ->from(' az_service_master sm')
                                                ->join('az_service_user_mapping sum', 'sm.service_id = sum.service_id')
                                                ->where(' sum.user_id=:did', array(':did' => $user_details['user_id']))
                                                ->queryAll();
                                        ?>
                                        <div class="amenities-list" id="#service_id" style="margin-left:45px;">
                                            <ul class="col-md-12" style="margin:0px;padding:0px;">
                                                <?php foreach ($serviceArr as $key => $value) {
                                                    ?> <li class="col-md-3"><div ><?php echo $value['service_name']; ?></div></li>
<?php } ?>
                                            </ul>
                                        </div>

                                    </div>
                                    <div class="custom_tabs" id="service_and_saving" style="padding-top: 10px;display: none;">
                                        <?php
                                        $serviceArr = Yii::app()->db->createCommand()
                                                ->select('service_name,service_discount,corporate_discount')
                                                ->from(' az_service_master sm')
                                                ->join('az_service_user_mapping sum', 'sm.service_id = sum.service_id')
                                                ->where(' sum.user_id=:did', array(':did' => $user_details['user_id']))
                                                ->queryAll();
                                        ?>
                                        <div id="#service_id1" style="margin-left:45px;">
                                            <ul>
                                                <li style="list-style-type: none"><div class="col-sm-6 clearfix">service_name</div><div class="col-sm-3">service_discount</div><div class="col-sm-3">corporate_discount</div></li>
                                                <?php foreach ($serviceArr as $key => $value) {
                                                    ?> <li><div class="col-sm-6 clearfix"><?php echo $value['service_name']; ?></div><div class="col-sm-3"><?php echo $value['service_discount']; ?>%</div><div class="col-sm-3"><?php echo $value['corporate_discount']; ?>%</div></li>

<?php } ?>
                                            </ul>
                                        </div>

                                    </div>
                                    <div id="dLocation" class="tab-pane clearfix custom_tabs" style="display:none;padding:15px;">
                                        <div id="p-map" style="height: 240px;width: 90%;border:1px solid #533223; border-radius: 25px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!--col-md-12 end-->  

                </div>   

                <div class="container emailmodel">
                    <!-- Modal -->
                    <div class="modal" id="myModalemail" role="dialog">
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
                                                if ($user_details['role_id'] == 6){
                                                $profilepath .= "/images/icons/pathology.png";
                                                }if ($user_details['role_id'] == 7){
                                                $profilepath .= "/images/icons/icon03.png";
                                                }if ($user_details['role_id'] == 8){
                                                $profilepath .= "/images/icons/blood-bank.png";
                                                }if ($user_details['role_id'] == 9){
                                                $profilepath .= "/images/icons/icon04.png";
                                                }
                                                
                                            } else {
                                                $profilepath .= "/uploads/" . $user_details['profile_image'];
                                            }
                                            echo "<img src='$profilepath' class='img-circle img-responsive' style='margin-bottom:15px;height:65px;width:65px;'>";
                                            ?>
                                        </div>
                                        <div class="col-sm-9 clearfix">
                                            <h5 class='title-details' style='padding-left:0px;text-transform: capitalize;'><?php
                                                if ($user_details['role_id'] == 6 || $user_details['role_id'] == 7 || $user_details['role_id'] == 8 || $user_details['role_id'] == 9) {
                                                    echo $user_details['hospital_name'];
                                                    ?></h5>
                                                <h5 class='title-details' style='padding-left:0px;'> <?php echo $user_details['type_of_hospital']; ?> </h5>
                                                <span class='col-view'>  <?php echo $user_details['city_name'] . ", " . $user_details['state_name'] . " " . $user_details['country_name'] ?> </span>

                                                <?php
                                            }
                                            ?>
                                        </div> 
                                         
                                            <span class="">  
                                                <?php echo $user_details['description']; ?>
                                            </span>
                                        
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

                <div class="modal fade bs-example-modal-lg" id="appointModal" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content appointcontent">
                        </div>
                    </div>
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
                            $html .= "<tr><th>Day</th><th>Morning Time</th><th>Evening Time</th></tr>";
                            foreach ($clinicvisitArr as $row) {
                                $html .= "<tr><td style='text-transform:capitalize;'>" . $row['day'] . "</td><td>" . date("h:i A", strtotime($row['clinic_open_time'])) . "--" . date("h:i A", strtotime($row['clinic_close_time'])) .
                                      "<td>" . date("h:i A", strtotime($row['clinic_eve_open_time'])) . "--".
                                        date("h:i A", strtotime($row['clinic_eve_close_time'])) . "</td>".
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

            <?php
            $actual_link = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $redirectUrl = Yii::app()->request->getUrl();
            ?>
             <!--<script type="text/javascript" src="<?php //echo Yii::app()->baseUrl; ?>/js/jquery-2.2.3.min.js"></script>-->
             <!--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyBacLj_vpokyTYesTfLGAf0AfKZJ9QCH-g"></script>-->
            <script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/select2.min.js"></script>
            <script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-2.2.3.min.js"></script>
            <script type="text/javascript">
                                    var redirectUrl = '<?php echo $redirectUrl; ?>';
                                    var action = '<?php // echo $action;    ?>';
                                    
                                    <?php if (isset($session['shareprofileshow'])) { ?>
                                    var userid = '<?php echo $user_details['user_id'] ?>';
                                   // alert(uid);
                                       shareProfile(userid);
                                      // take_email();
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
                                        if (action != "") {
                                            if (action == "appoint") {
                                                showAppointment(<?php //echo $param;    ?>);
                                            }
                                        }

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

                                    function showAppointment(docid) {
                                        $.ajax({
                                            //async: false,
                                            type: 'POST',
                                            cache: false,
                                            url: '<?php echo Yii::app()->createUrl("site/bookappoint"); ?> ',
                                            data: {docid: docid, redirectUrl: redirectUrl},
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

                                    function checkuserlab() {
                                        var session = '<?php echo $session['user_id']; ?>';
                                        if (session === '') {
                                            window.location.href = "<?php echo Yii::app()->createUrl("site/getlogin", array('param1' => Yii::app()->getSecurityManager()->encrypt($actual_link, $enc_key))); ?>";
                                        } else {
                                            window.location.href = "<?php echo Yii::app()->createUrl("site/labTestBook", array('param1' => Yii::app()->getSecurityManager()->encrypt($actual_link, $enc_key), 'param2' => Yii::app()->getSecurityManager()->encrypt($user_details['role_id'], $enc_key), 'param3' => Yii::app()->getSecurityManager()->encrypt($user_details['user_id'], $enc_key))); ?>";
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
                                        //alert(id);
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
                                        }
                                        else
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
                                                    alert("Review submitted successfully. Thank you For Review");
                                                    $('select').barrating('readonly', true);
                                                }
                                            });

                                        }

                                    }

//                                    function shareProfile() {   //pre  working in 2 step
//                                        $(".rerror-div").hide();
//                                        $(".sucess-div").hide();
//                                        email = $(".emailaddress").val(" ");
//                                        var session = '<?php //echo $session['user_id']; ?>';
//                                        if (session === '') {
//
//                                            window.location.href = "<?php //echo Yii::app()->createUrl("site/getlogin", array('param1' => Yii::app()->getSecurityManager()->encrypt($actual_link, $enc_key))); ?>";
//                                        }
//                                        else
//                                        {
//                                            $('#myModalemail').modal('show');
//
//                                        }
//                                    }
                                    
                                    
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
                                               
                                               $(".email").html(data);
                                                 $('#myModalemail').modal('show');
                                            }
                                        });

                                    }
                                    
                                    

                                    function take_email()
                                    {
                                        var userid = '<?php echo $user_details['user_id'] ?>';
                                        email = $(".emailaddress").val();
                                        
                                        clinicname = $(".clinicname").text();
                                        clinicaddress = $(".clinicaddress").text();

                                        $.ajax({
                                            async: false,
                                            type: 'POST',
                                            dataType: 'json',
                                            cache: false,
                                            url: '<?php echo Yii::app()->createUrl("site/shareProfile"); ?> ',
                                            data: {userid: userid, email: email, clinicname: clinicname, clinicaddress: clinicaddress},
                                            success: function (result) {
                                                var resultobj = result.result;
                                                if (resultobj.isError) {
                                                    $(".rerror-div").show();
                                                    $(".sucess-div").hide();
                                                } else
                                                {
                                                    $(".sucess-div").show();
                                                    $(".rerror-div").hide();
                                                }
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


