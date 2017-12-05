<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyA1vr2RVgKBydJQhSo1LUsP3pUcKh4IFGI"></script>
<?php
$clientScriptObj = Yii::app()->clientScript;
//Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/admin/select2.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/admin/multiple-select.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/admin/bootstrap-datetimepicker.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/admin/jquery.timepicker.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/admin/radio_style.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/admin/bootstrap-datepicker.css');

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/bootstrap.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/jquery.timepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/moment-with-locales.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/jquery.validate.min.js', CClientScript::POS_END);
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/bootstrap-datepicker.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/bootstrap-datetimepicker.js', CClientScript::POS_END);
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/select2.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/multiple-select.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/bootstrap-fileupload.min.js', CClientScript::POS_END);

$model->latitude = !empty($model->latitude) ? $model->latitude : 18.5204303;
$model->longitude = !empty($model->longitude) ? $model->longitude : 73.8567437;
Yii::app()->clientScript->registerScript('myjavascript', '

    function showNextSlide(nextslideid, tabid){
        
        if($("#add-hospital-services-form").valid()){
            $.ajax({
               
           
                data: $("#add-hospital-services-form").serialize(),
                //dataType: "json",
                success: function (result)
                {
                    $(".mySlides").hide();
                    $("#"+nextslideid).show();
                    $("#myTabs a[href=\"#"+tabid+"\"]").tab("show");
                    $(".fa-angle-double-right").remove();
                    $("#myTabs a[href=\"#"+tabid+"\"]").append("<i class=\"fa fa-angle-double-right\" aria-hidden=\"true\"></i>");
                }
            });
        }
    }
    function showPrevSlide(prevslideid, tabid){
        
        $(".mySlides").hide();
        $("#"+prevslideid).show();
        $("#myTabs a[href=\"#"+tabid+"\"]").tab("show");
        $(".fa-angle-double-right").remove();
        $("#myTabs a[href=\"#"+tabid+"\"]").append("<i class=\"fa fa-angle-double-right\" aria-hidden=\"true\"></i>");
        

    }

      $(".multipleselect1").multipleSelect({
            filter: true,
            multiple: true,
            placeholder: "Select Payment Type",
            width: "100%",
            multipleWidth: 500
        });
         $(".multipleselect2").multipleSelect({
            filter: true,
            multiple: true,
            placeholder: "Select Speciality type",
            width: "100%",
            multipleWidth: 500
        });
         $(".multipleselect3").multipleSelect({
            filter: true,
            multiple: true,
            placeholder: "Select payment type",
            width: "100%",
            multipleWidth: 500
        });
        
   

     $(".pincode-id-class").blur(function(){
        var pincode = $(this).val();
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            cache: false,
            url: "' . Yii::app()->createUrl("UserDetails/getPincodeData") . '",
            data: {pincode: pincode},
            success: function (result) {
                var citydata = result.citydata;
                $(".cityId").html(citydata);
                var areadata = result.areadata;
                $(".areaId").html(areadata);
                $(".state-class").val(result.stateid);
                //$(".state-id-class").val(result.stateid);
                $(".area-id-class").val(result.areaname);
                $(".city-id-class").val(result.cityname);
                
                var state1 = $(".state-class option:selected").text();
                $(".state-id-class").val(state1);
            }
        });
    })
    function initialize() {
        var lattitude =  ' . $model->latitude . ';
        var longitutde = ' . $model->longitude . ' ;
        var myLatLng = new google.maps.LatLng(lattitude, longitutde);
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
        var map = new google.maps.Map(document.getElementById("p-map"), mapOptions);
        var image = "' . Yii::app()->baseUrl . '/images/marker-1.png";

        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            draggable: true,
            icon: image
        });
        if (jQuery("#UserDetails_address").length > 0) {
            var input = document.getElementById("UserDetails_address");
            var autocomplete = new google.maps.places.Autocomplete(input);
            google.maps.event.addListener(autocomplete, "place_changed", function () {
                var place = autocomplete.getPlace();
                jQuery("#UserDetails_latitude").val(place.geometry.location.lat());
                jQuery("#UserDetails_longitude").val(place.geometry.location.lng());
                marker.setPosition(place.geometry.location);
                map.setCenter(place.geometry.location);
                map.setZoom(15);
            });
        }
        google.maps.event.addListener(marker, "dragend", function (event) {
            jQuery("#UserDetails_latitude").val(event.latLng.lat());
            jQuery("#UserDetails_longitude").val(event.latLng.lng());
        });
    }
    google.maps.event.addDomListener(window, "load", initialize);
', CClientScript::POS_END);
Yii::app()->clientScript->registerScript('myjavascript1', '
   
     $(".datepick").datetimepicker({
        format:"MM-YYYY"
       
    });
    $(".timepick").datetimepicker({
        format: "LT"
    });
    
 $(".clinictime").datetimepicker({
                    format: "LT"
                });
 ', CClientScript::POS_READY);
?>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'add-hospital-services-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    ?>
    <div class="col-sm-12">

        <?php if ($role == 6) { ?>
            <h1>Add Pathology</h1>
        <?php } ?>
        <?php if ($role == 7) { ?>
            <h1>Add Diagnostic</h1>
        <?php } ?>
        <?php if ($role == 8) { ?>
            <h1>Add Blood Bank</h1>
        <?php } ?>
        <?php if ($role == 9) { ?>
            <h1>Add Medical Store</h1>
        <?php } ?>


        <?php echo $form->errorSummary($model); ?>

    </div>
    <div class="bs-example">
        <ul class="nav nav-tabs" id="myTabs">

            <li class="active disabled" ><a data-toggle="pill" href="#tab_a">Personal Details</a></li>
            <li ><a  href="#tab_b">Services</a></li>
            <li ><a  href="#tab_c">Upload Documents</a></li>
            <li  ><a  href="#tab_d">Bank Details</a></li>

        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_a" style="padding: 0px;">                                         

                <div class="mySlides" id="slide1">

                    <?php if (Yii::app()->user->hasFlash('Success')): ?>
                        <div class="alert alert-success" role="alert">
                            <button type="button" class="close" data-dismiss="alert">
                                <span aria-hidden="true">x</span>
                            </button>
                            <div>
                                <?php echo Yii::app()->user->getFlash('Success'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                        <h3 class="title text-center">Enter Your Details </h3>
                        <div class="underline"></div>
                        <div class="form-group clearfix">
                            <div class="col-sm-4">
                                <label class="control-label">Profile Image</label>
                                <?php
                                if (!empty($model->profile_image)) {
                                    $baseDir = Yii::app()->baseUrl . "/uploads/";
                                    echo CHtml::image($baseDir . $model->profile_image, "icon_image", array('width' => 75, 'height' => 75));
                                }
                                echo $form->fileField($model, 'profile_image', array("class" => "img-circle", 'maxlength' => 150));
                                echo $form->error($model, 'profile_image');
                                ?>
                            </div>
                            <div class="col-sm-4">
                                <?php if ($role == 6) { ?>
                                    <b><span>Pathology Name </span></b>
                                <?php } ?>
                                <?php if ($role == 7) { ?>
                                    <b><span>Diagnostic Name </span></b>
                                <?php } ?>
                                <?php if ($role == 8) { ?>
                                    <b><span>Blood Bank Name </span></b>
                                <?php } ?>
                                <?php if ($role == 9) { ?>
                                    <b><span>Store Name </span></b>
                                <?php } ?>
                                <?php
                                echo $form->textField($model, 'hospital_name', array('maxlength' => 60, 'class' => 'form-control ', "data-rule-required" => "true", "data-msg-required" => "Please Enter Name"));
                                echo $form->error($model, 'hospital_name');
                                ?>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-md-10">

                                <?php if ($role == 8) { ?>
                                    <b><span>Type of Establishment </span></b>                          
                                    <?php
                                    echo $form->radioButtonList($model, 'type_of_establishment', array("Individual" => "Individual", "partnership" => "Partnership", "Company " => "Company", "Charitable trust" => "Charitable trust", "NGO" => "NGO", "Govt." => "Govt.", "Hospital" => "Hospital", "others" => "Others"), array('labelOptions' => array('style' => 'display:inline;float:left', 'class' => 'clerafix'), 'separator' => "", "class" => "selecttype col-sm-1 clerafix", 'template' => '<label class="ui-radio-inline">{input} <span style="padding-left: 31px;padding-top:0px;">{label}</span></label>', 'container' => 'div class="ui-radio ui-radio-pink"', 'onClick' => 'typeestablishment();'));
                                }
                                ?>

                                <?php if ($role == 9) { ?>
                                    <b><span>Type of Center </span></b>  
                                    <?php
                                    echo $form->radioButtonList($model, 'type_of_establishment', array("Individual owner" => "Individual owner", "Company out let" => "Company out let", "Govt " => "Govt", "Partnership " => "Partnership ", "others" => "Others"), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '&nbsp;&nbsp;&nbsp;', "class" => "selecttype", 'template' => '<label class="ui-radio-inline">{input} <span style="padding-left: 31px;padding-top:0px;">{label}</span></label>', 'container' => 'div class="ui-radio ui-radio-pink"', 'onClick' => 'typeestablishment();'));
                                }
                                ?>
                                <?php if ($role == 6 || $role == 7) { ?> 
                                    <b><span>Types Of Company</span></b>
                                    <?php
                                    if (empty($model->type_of_hospital)) {
                                        $model->type_of_hospital = 'Franchise';
                                    }
                                    echo $form->radioButtonList($model, 'type_of_hospital', array('Franchise' => 'Franchise', 'Self Own' => 'Self Own', 'Collection Center' => 'Collection Center', 'Other' => 'Other'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '&nbsp;&nbsp;&nbsp;', 'container' => 'div class="ui-radio ui-radio-pink"', 'onClick' => 'typeestablishment();'));
                                    ?>
                                    <?php echo $form->error($model, 'type_of_hospital'); ?>             
                                <?php } ?>
                                <?php echo $form->error($model, 'type_of_establishment'); ?>
                                <div class="col-sm-4 hospitaltype" style="display:none">
                                    <?php echo $form->textField($model, 'other_est_type', array("class" => "form-control")); ?>
                                    <?php echo $form->error($model, 'other_est_type'); ?>   
                                </div>

                            </div>

                        </div>
                        <div class="form-group clearfix "<?php
                        if ($role == 8 || $role == 9) {
                            echo "";
                        } else {
                            echo 'style="display:none;"';
                        }
                        ?>>
                            <div class="col-md-4 clearfix">
                                <b><span>Company Name </span></b>
                                <?php echo $form->textField($model, 'company_name', array("class" => "form-control")); ?>
                                <?php echo $form->error($model, 'company_name'); ?>                                              
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-4">
                                <b><span>Mobile<strong class="mandatory">*</strong></span></b>
                                <?php
                                echo $form->textField($model, 'mobile', array('maxlength' => 10, "class" => "form-control mobileclass ", "data-msg-required" => "Please Enter Mobile", "data-rule-required" => "true", "data-rule-regexp" => "^[\d]+$", "onblur" => "chk_mobile()")); ?>
                                 <span id="mobileno" style="color: red;"></span>
                               <?php echo $form->error($model, 'mobile');
                                ?>                                   
                            </div>
                            <div class="col-sm-4">
                                <b><span>Password<strong class="mandatory">*</strong></span></b>
                                <?php
                                echo $form->passwordField($model, 'password', array("class" => "form-control", "data-rule-required" => "true", "data-msg-required" => "Please Enter Password"));
                                echo $form->error($model, 'password');
                                ?>                                   
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-4">
                                <?php if ($role == 6) { ?>
                                    <b><span>Pathology Registration No </span></b>

                                <?php } ?>
                                <?php if ($role == 7) { ?>
                                    <b><span>Diagnostic Registration No </span></b>

                                <?php } ?>
                                <?php if ($role == 8) { ?>
                                    <b><span>Blood Bank Registration No </span></b>

                                <?php } ?>
                                <?php if ($role == 9) { ?>

                                    <b><span>Medical Store Registration No </span></b>
                                <?php } ?>
                                <?php
                                echo $form->textField($model, 'hospital_registration_no', array('maxlength' => 60, 'class' => 'form-control '));
                                echo $form->error($model, 'hospital_registration_no');
                                ?>
                            </div>
                            <?php if ($role == 8 || $role == 6 || $role == 7) { ?>
                                <div class="col-sm-4">
                                    <?php if ($role == 8) { ?>
                                        <b><span>Blood-Bank Establishment </span></b>
                                    <?php } ?>
                                    <?php if ($role == 6) { ?>
                                        <b><span>Pathology Establishment </span></b>
                                    <?php } ?>
                                    <?php if ($role == 7) { ?>
                                        <b><span>Diagnostic Center Establishment </span></b>
                                    <?php } ?>
                                    <?php
                                    echo $form->textField($model, 'hos_establishment', array('class' => 'form-control datepick'));
                                    echo $form->error($model, 'hos_establishment');
                                    ?>
                                </div>
                            <?php } ?> 
                        </div>
                        <div class="form-group clearfix">
                            <div>  <b><span>Authorised Person Name</span></b> </div>
                            <div class="col-sm-4">

                                <b><span>First Name</span></b>
                                <?php
                                if (isset($session['first_name'])) {
                                    $model->first_name = $session['first_name'];
                                }
                                ?>
                                <?php echo $form->textField($model, 'first_name', array("class" => "form-control",  "data-msg-required" => "Please Enter Name", "data-rule-regexp" => "^[\w.,-\s\n\/\']+$")); ?>
                                <?php echo $form->error($model, 'first_name'); ?>
                            </div>
                            <div class="col-sm-4">

                                <b><span>Last Name </span></b>
                                <?php
                                if (isset($session['last_name'])) {
                                    $model->last_name = $session['last_name'];
                                }
                                ?>

                                <?php echo $form->textField($model, 'last_name', array("class" => "form-control",  "data-rule-regexp" => "^[\w.,-\s\n\/\']+$")); ?>
                                <?php echo $form->error($model, 'last_name'); ?>                                             
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-4">

                                <div class="">
                                    <b><span> Contact No</span></b>
                                    <?php echo $form->textField($model, 'apt_contact_no_1', array("data-rule-regexp" => "^[7-9]{1}[0-9]{9,29}$", "class" => "form-control")); ?>
                                    <?php echo $form->error($model, 'apt_contact_no_1'); ?>
                                </div>
                                <?php if (empty($model->apt_contact_no_2)) {
                                    ?>
                                    <button type="button" onclick="showscontact('.contact_2', this);">+</button>
                                <?php }
                                ?>
                                <div class="clearfix">&nbsp;</div>
                                <div class="contact_2 "<?php
                                if (!empty($model->apt_contact_no_2)) {
                                    echo "";
                                } else {
                                    echo 'style="display:none;"';
                                }
                                ?>>
                                    <b><span> Contact No</span></b>
                                    <?php echo $form->textField($model, 'apt_contact_no_2', array("data-rule-regexp" => "^[7-9]{1}[0-9]{9,29}$", "class" => "form-control")); ?>
                                    <?php echo $form->error($model, 'apt_contact_no_2'); ?>
                                </div>
                            </div>  
                            <div class="col-sm-4">

                                <div class="">
                                    <b><span> Email</span></b>
                                    <?php echo $form->textField($model, 'email_1', array('size' => 60, 'maxlength' => 200, "class" => "form-control")); ?>
                                    <?php echo $form->error($model, 'email_1'); ?>
                                </div>
                                <?php if (empty($model->email_2)) {
                                    ?>
                                    <button type="button" onclick="showscontact('.email_2', this);">+</button>
                                <?php }
                                ?>
                                <div class="clearfix">&nbsp;</div>
                                <div class="email_2"<?php
                                if (!empty($model->email_2)) {
                                    echo "";
                                } else {
                                    echo 'style="display:none;"';
                                }
                                ?>>
                                    <b><span> Email</span></b>
                                    <?php echo $form->textField($model, 'email_2', array('size' => 60, 'maxlength' => 200, "class" => "form-control")); ?>
                                    <?php echo $form->error($model, 'email_2'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-12">
                                A-Z Health+ Co-ordinator
                            </div>
                            <div class="col-sm-4">
                                <b><span>1.Coordinator Name</span></b>
                                <?php
                                echo $form->textField($model, 'coordinator_name_1', array("class" => "form-control"));
                                echo $form->error($model, 'coordinator_name_1');
                                ?>
                            </div>
                            <div class="col-sm-4">
                                <b><span>Coordinator Mobile</span></b>
                                <?php
                                echo $form->textField($model, 'coordinator_mobile_1', array("class" => "form-control", "maxlength" => 10));
                                echo $form->error($model, 'coordinator_mobile_1');
                                ?>
                            </div>
                            <div class="col-sm-4">

                                <b><span> Coordinator Email</span></b>
                                <?php
                                echo $form->textField($model, 'coordinator_email_1', array("class" => "form-control"));
                                echo $form->error($model, 'coordinator_email_1');
                                ?>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-4">
                                <b><span>2.Coordinator Name</span></b>
                                <?php
                                echo $form->textField($model, 'coordinator_name_2', array("class" => "form-control"));
                                echo $form->error($model, 'coordinator_name_2');
                                ?>
                            </div>
                            <div class="col-sm-4">
                                <b><span>Coordinator Mobile</span></b>
                                <?php
                                echo $form->textField($model, 'coordinator_mobile_2', array("class" => "form-control", "maxlength" => 10));
                                echo $form->error($model, 'coordinator_mobile_2');
                                ?>
                            </div>
                            <div class="col-sm-4">
                                <b><span>Coordinator Email</span></b>
                                <?php
                                echo $form->textField($model, 'coordinator_email_2', array("class" => "form-control"));
                                echo $form->error($model, 'coordinator_email_2');
                                ?>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <!-- Timing start here -->
                            <div class="textdetails">
                                <b><span>Timing<strong class="mandatory">*</strong></span></b>
                                <div class="col-md-12" style=""> 
                                    <b><label><input  type="checkbox" name="UserDetails[is_open_allday]" value="Y" onclick="isalldayopen(this)" class="isall"> 24x7</label></b>
                                </div>
                                <div class="col-md-12 day" style="">
                                    <ul class="list-inline">
                                        <li id="mon" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="mon" data-rule-oneormorechecked="true" data-msg-oneormorechecked="Check one or more!"> Monday</li>
                                        <li id="tue" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="tue"> Tuesday</li>
                                        <li id="wed" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="wed"> Wednesday</li>
                                        <li id="thur" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="thur"> Thursday</li>
                                        <li id="fri" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="fri"> Friday</li>
                                        <li id="sat" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="sat"> Saturday</li>
                                        <li id="sun" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="sun"> Sunday</li>
                                    </ul>

                                </div>



                            </div>
                            <!-- Timing end here -->

                        </div>
                        <?php if ($role == 8 || $role == 9) { ?>
                            <div class="form-group clearfix">
                                <h4 class="title-details">Registration</h4>
                                <div class="col-sm-4">
                                    <label class="control-label">Payment Details </label>
                                    <?php echo $form->textField($model, 'registration_Fees', array("class" => "form-control input-group")); ?>
                                </div>

                            </div>
                        <?php } ?>
                        <div class="form-group clearfix">

                            <div class="col-sm-4">

                                <b><span>Description </span></b>
                                <?php echo $form->textArea($model, 'description', array('class' => ' form-control')); ?>
                                <?php echo $form->error($model, 'description'); ?>
                            </div>

                        </div>
                        <div class="form-group clearfix">
                            <div class="col-md-4">
                                <b><span>Zip Code </span></b>
                                <?php
                                if (isset($session['pincode'])) {
                                    $model->pincode = $session['pincode'];
                                }
                                echo $form->textField($model, 'pincode', array("class" => "form-control input-group pincode-id-class"));
                                echo $form->error($model, 'pincode');
                                ?>
                            </div>  
                            <div class="col-md-4">
                                <b><span>State</span></b>
                                <?php
                                $stateArr = array();
                                $selected = array();
                                $stateType = Yii::app()->db->createCommand()->select("state_id,state_name")->from("az_state_master")->queryAll();
                                foreach ($stateType as $row) {
                                    $stateArr[$row['state_id']] = $row['state_name'];
                                }
                                if (isset($session['state_id'])) {
                                    $model->state_id = $session['state_id'];
                                }
                                echo $form->dropDownList($model, 'state_id', $stateArr, array("class" => "form-control state-class", "style" => "width:100%;", "prompt" => "Select State", "data-msg-required" => "Please Select State", 'onchange' => 'getCity()'));
                                echo $form->error($model, 'state_id');
                                if (isset($session['state_name'])) {
                                    $model->state_name = $session['state_name'];
                                }
                                echo $form->hiddenField($model, "state_name", array("class" => "state-id-class"));
                                ?>   

                            </div>
                            <div class="col-md-4">
                                <b><span>City </span></b>
                                <?php
                                $cityArr = array();
                                if (!empty($model->state_id)) {
                                    $citycmd = Yii::app()->db->createCommand()->select('city_id,city_name')->from('az_city_master')->where('state_id=:id', array(':id' => $model->state_id))->queryAll();
                                    foreach ($citycmd as $row) {
                                        $cityArr[$row['city_id']] = $row['city_name'];
                                    }
                                }
                                if (isset($session['city_id'])) {
                                    $model->city_id = $session['city_id'];
                                }
                                echo $form->dropDownList($model, 'city_id', $cityArr, array("class" => "form-control cityId city-class", "style" => "width:100%;", "prompt" => "Select City", "data-msg-required" => "Please Select City", 'onchange' => 'getArea()'));
                                echo $form->error($model, 'city_id');
                                if (isset($session['city_name'])) {
                                    $model->city_name = $session['city_name'];
                                }
                                echo $form->hiddenField($model, "city_name", array("class" => "city-id-class"));
                                ?>

                            </div>

                        </div>
                        <div class="form-group clearfix">

                            <div class="col-md-4">
                                <b><span>Area</span></b>
                                <?php
                                $areaArr = array();
                                $selected = array();
                                if (!empty($model->city_id)) {
                                    $stateType = Yii::app()->db->createCommand()->select("area_id,area_name")->from("az_area_master")->where('city_id=:id', array(':id' => $model->city_id))->queryAll();
                                    foreach ($stateType as $row) {
                                        $areaArr[$row['area_id']] = $row['area_name'];
                                    }
                                }
                                if (isset($session['area_id'])) {
                                    $model->area_id = $session['area_id'];
                                }
                                echo $form->dropDownList($model, 'area_id', $areaArr, array("class" => "form-control area-class areaId", "style" => "width:100%;", "prompt" => "Select Area", "data-msg-required" => "Please Select Area", 'onchange' => 'getAreaid()'));
                                echo $form->error($model, 'area_id');
                                if (isset($session['area_name'])) {
                                    $model->area_name = $session['area_name'];
                                }
                                echo $form->hiddenField($model, "area_name", array("class" => "area-id-class"));
                                ?>   

                            </div>
                            <div class="col-md-4">

                                <b><span>Landmark </span></b>
                                <?php
                                if (isset($session['landmark'])) {
                                    $model->landmark = $session['landmark'];
                                }
                                echo $form->textField($model, 'landmark', array("class" => "form-control input-group"));
                                echo $form->error($model, 'landmark');
                                ?>


                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-4">

                                <b><span>Address </span></b>
                                <?php
                                echo $form->textField($model, 'address', array("class" => "form-control input-group"));
                                echo $form->error($model, 'address');
                                ?>
                                <br>
                                <b><span>Latitude</span></b>
                                <?php
                                echo $form->textField($model, 'latitude', array("class" => "form-control input-group latitude"));
                                echo $form->error($model, 'latitude');
                                ?>
                                <br><b><span>Longitude</span></b>
                                <?php
                                echo $form->textField($model, 'longitude', array("class" => "form-control input-group longitude"));
                                echo $form->error($model, 'longitude');
                                ?>
                            </div>
                            <div class="col-sm-6 clearfix">
                                <div id="p-map" style="height: 340px;width: 100%;border:1px solid #533223;"></div>
                            </div>
                        </div>
                        <div class="button-arrow clearfix">
                            <button class="w3-button w3-black w3-display-right" onClick="showNextSlide('slide2', 'tab_b')" type="button">&#10095;</button>
                        </div>
                    
                </div>
            </div>
            <div id="tab_b" class="tab-pane fade">
                
                    <div class="mySlides"  id="slide2">
                      

                            <div class="textdetails">
                                        <?php
                            $service = ServiceMaster::model()->findAll();
                            $servicenameArr = CHtml::listData($service, 'service_id', 'service_name');
                            ?>
                                        
                                                                    <div class="col-sm-3">
                                <span>Service</span>
                                <select class="form-control servicename" name="service[]" >
                                    <option value="">Select Services</option>
                                    <?php foreach ($servicenameArr as $servicekey => $value) {
                                        ?>

                                        <option value='<?php echo $servicekey; ?>'> <?php echo $value; ?></option>
                                    <?php }
                                    ?>
                                </select>
                            </div>
                            <?php echo $form->error($model1, 'service_id'); ?>   
                                          <div class="col-sm-2  clearfix">
                                <span>Discount</span>
                                <input type="text" name="service_discount[]" value=''  class='form-control'>
                                <?php echo $form->error($model1, 'service_discount', array('class' => 'col-sm-1 control-label')); ?>
                            </div>
                            
                            <div class="col-sm-3  clearfix">
                                <span>Corporate Discount</span>
                                <input type="text" name="corporate_discount[]" value=''  class='form-control'>
                                <?php echo $form->error($model1, 'corporate_discount', array('class' => 'col-sm-1 control-label')); ?>
                            </div>
                                        <?php
                            $isallday = array('Yes' => "Yes", 'No' => "No");
                            ?> 
                            
                            <div class ="col-md-2">
                                <span>24x7</span>
                                <select class="form-control twentyfour" name="twentyfour[]">
                                    <?php foreach ($isallday as $key => $value) { ?>
                                        <option value='<?php echo $key; ?>' > <?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                                        <div class="clearfix">&nbsp;</div>
                                        <div class="col-md-12 btnaddservice">
                                            <a class="" href="javascript:" onclick="addMoreServices(this);"><i class="fa fa-plus" aria-hidden="true"></i> Add Services </a>
                                        </div>
                                    </div>
                           
                            
                            <div class="col-md-3">
                                <label class="control-label">Take Home Service</label>
                                <?php
                                echo $form->dropDownList($model, 'take_home', array("Yes" => "Yes", "No" => "No"), array("class" => "form-control input-group take_home", "onchange" => "extra_charge ();"));
                                ?>
                            </div>
                            <div class="col-md-3 excharges" style="display:none">
                                <label class="control-label">Extra charges</label>
                                <?php echo $form->dropDownList($model, 'extra_charges', array("Yes" => "Yes", "No" => "No"), array("class" => "form-control input-group take_home"));
                                ?>
                            </div>
                            <div class="col-md-3">
                                <label class="control-label">24x7 Emergency</label>

                                <?php echo $form->dropDownList($model, 'emergency', array("Yes" => "Yes", "No" => "No"), array("class" => "form-control input-group"));
                                ?>
                            </div>
                            <div class="clearfix"></div><br>
                            <div class="button-arrow">
                                <button class="w3-button w3-black w3-display-left" onClick="showPrevSlide('slide1', 'tab_a')" type="button">&#10094;</button>
                                <button class="w3-button w3-black w3-display-right" onClick="showNextSlide('slide3', 'tab_c')" type="button">&#10095;</button>
                            </div>

                      

                    </div>
            </div>
               
                <div class="tab-pane" id="tab_c">
                    
                        <div class="mySlides"  id="slide3">   <!--    id="slide3"-->
                            
                            <h3 class="title">Documents / Certificates</h3>
                            <?php if ($role == 8 || $role == 9) { ?>
                                <div class="textdetails">
                                    <div class="col-md-4">

                                        <?php if ($role == 8) { ?>
                                            <h4 class="title">Blood-Bank Registration</h4>
                                        <?php } ?>
                                        <?php if ($role == 9) { ?>
                                            <h4 class="title">Store Registration</h4>
                                        <?php } ?>
                                        <?php
                                        echo $form->fileField($model3, 'document', array("class" => "w3-input input-group"));
                                        echo $form->error($model, 'document');
                                        ?> 
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            <?php } ?> 
                            <?php if ($role == 6 || $role == 7) { ?>
                                <div class="textdetails">
                                    <div class="col-md-4">
                                        <b><span>Center Certificate</span></b>
                                        <?php
                                        echo $form->fileField($model3, 'document', array("class" => "w3-input input-group"));
                                        echo $form->error($model, 'document');
                                        ?> 
                                    </div>
                                    <div class="col-md-4">
                                        <b><span>Other Certificate</span></b>
                                        <?php
                                        echo $form->fileField($model3, 'otherdoc', array("class" => "w3-input input-group"));
                                        echo $form->error($model3, 'otherdoc');
                                        ?> 
                                    </div>


                                    <div class="col-md-4">
                                        <b><span>Add Photo</span></b>
                                        <?php
                                        echo $form->fileField($model3, 'doc_photo[]', array("class" => "w3-input input-group", "multiple" => "multiple"));
                                        echo $form->error($model3, 'doc_photo');
                                        ?> 
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            <?php } ?> 
                            <div class="clearfix"></div><br>
                            <div class="button-arrow">
                                <button class="w3-button w3-black w3-display-left" onClick="showPrevSlide('slide2', 'tab_b')" type="button">&#10094;</button>
                                <button class="w3-button w3-black w3-display-right" onClick="showNextSlide('slide4', 'tab_d')" type="button">&#10095;</button>
                            </div>
                       
                        </div>
                </div>
                <div class="tab-pane" id="tab_d">
                   
                        <div class="mySlides"  id="slide4">   <!--    id="slide4"-->
                           
                            <h3 class="title">Bank A/C Details</h3>

                            <div class="textdetails">
                                <div class="col-md-4">
                                    <label class="control-label">Acount Holder Name</label>
                                    <?php
                                    if (isset($session['acc_holder_name'])) {
                                        $model7->acc_holder_name = $session['acc_holder_name'];
                                    }
                                    echo $form->textField($model7, 'acc_holder_name', array("class" => "form-control", "data-rule-required" => "true"));
                                    echo $form->error($model7, 'acc_holder_name');
                                    ?> 
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label">Bank Name</label>
                                    <?php
                                    if (isset($session['bank_name'])) {
                                        $model7->bank_name = $session['bank_name'];
                                    }
                                    echo $form->textField($model7, 'bank_name', array("class" => "form-control"));
                                    echo $form->error($model7, 'bank_name');
                                    ?> 
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label">Branch Name</label>
                                    <?php
                                    if (isset($session['branch_name'])) {
                                        $model7->branch_name = $session['branch_name'];
                                    }
                                    echo $form->textField($model7, 'branch_name', array("class" => "form-control"));
                                    echo $form->error($model7, 'branch_name');
                                    ?> 

                                </div>

                            </div>
                            <div class="clearfix"></div>
                            <div class="textdetails">
                                <div class="col-md-4">
                                    <label class="control-label">Acount No</label>
                                    <?php
                                    if (isset($session['account_no'])) {
                                        $model7->account_no = $session['account_no'];
                                    }
                                    echo $form->textField($model7, 'account_no', array("class" => "form-control"));
                                    echo $form->error($model7, 'account_no');
                                    ?> 

                                </div>
                                <div class="col-md-4">
                                    <label class="control-label">Account Type</label>
                                    <?php
                                    if (isset($session['account_type'])) {
                                        $model7->account_type = $session['account_type'];
                                    }
                                    echo $form->textField($model7, 'account_type', array("class" => "form-control"));
                                    echo $form->error($model7, 'account_type');
                                    ?> 

                                </div>
                                <div class="col-md-4">
                                    <label class="control-label">IFSC Code</label>
                                    <?php
                                    if (isset($session['ifsc_code'])) {
                                        $model7->ifsc_code = $session['ifsc_code'];
                                    }
                                    echo $form->textField($model7, 'ifsc_code', array("class" => "form-control"));
                                    echo $form->error($model7, 'ifsc_code');
                                    ?> 

                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group clearfix">
                                <input type="checkbox" name="acceptcondition"  class="agree required"/> Agree to Terms & Conditions
                                <p><span id="agree1" class="error1"></span></p>
                                <div class="clearfix"></div>
                            </div> 

                            <div class="clearfix"></div>

                            <div class="clearfix"></div><br>
                            <div class="button-arrow">
                                <button class="w3-button w3-black w3-display-left" onClick="showPrevSlide('slide3', 'tab_c')" type="button">&#10094;</button>

                            </div>

                        


                        <div class="clearfix">&nbsp;</div>

                        <div class="textdetails text-center clearfix">
                            <?php
                            echo CHtml::submitButton("Submit", array('class' => 'btn btn-info'));
                            ?>
                        </div> 
                       
                        </div>
                </div>
            </div>
        </div>
            <div class="modal" id="myModal" role="dialog" >
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" onclick="uncheckday();">&times;</button>
                            <h4 class="modal-title">Visit Details</h4>
                        </div>
                        <div class="modal-body">

                            <div class="col-md-12">

                                <div class="col-md-6">

                                    <div class="col-sm-2" style="z-index:2;position: relative">
                                        <label>Morning</label>
                                        <?php echo $form->textField($model6, 'clinic_open_time[]', array('class' => 'clinictime open_time ', "data-rule-required" => "true", "data-msg-required" => "Please enter time")); ?>
                                        <label class='text-center'>TO</label>
                                        <?php echo $form->textField($model6, 'clinic_close_time[]', array('class' => 'clinictime close_time ', "data-msg-required" => "Please enter time")); ?>
                                    </div>
                                </div>


                                <div class="col-md-6">

                                    <div class="col-sm-2" style="z-index:2;position: relative">
                                        <label>Evening</label> 
                                        <?php echo $form->textField($model6, 'clinic_eve_open_time[]', array('class' => 'clinictime eve_open_time ', "data-msg-required" => "Please enter time")); ?>
                                        <label class='text-center'>TO</label>
                                        <?php echo $form->textField($model6, 'clinic_eve_close_time[]', array('class' => 'clinictime eve_close_time ', "data-rule-required" => "true", "data-msg-required" => "Please enter time")); ?>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="clinic_time()">save</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php $this->endWidget(); ?>
    </div>
    
    <script type="text/javascript">
                            var dayhtml;
                            $(function () {

                                //$('#pathology-admin-form').validate();
                                $('.day:checkbox').on('click', function (e) {
                                    if (e.target.checked) {
                                        dayhtml = $(this);

                                        var day = $('.day:checked').val();

					$('#myModal').modal({
                                        backdrop: 'static',
                                        keyboard: false
					});

                                    } else {
					$(this).closest('li').find('.timeing').remove();
                                        $(this).closest('li').find('span').remove();
                                    }

                                });
                                $("#myTab li:eq(0) a").tab('show');

                                $(".countryId").change(function () {
                                    var country = 1;

                                    var country1 = "india";
                                    $(".country-id-class").val(country1);

                                    jQuery.ajax({
                                        type: 'POST',
                                        dataType: 'json',
                                        cache: false,
                                        url: '<?php echo Yii::app()->createUrl("UserDetails/getStateName"); ?> ',
                                        data: {country: country},
                                        success: function (data) {

                                            var dataobj = data.data;

                                            var statename = "<option value=''>Select State</option>";
                                            $.each(dataobj, function (key, value) {

                                                statename += "<option value='" + value.state_id + "'>" + value.state_name + "</option>";
                                            });
                                            $(".stateId").html(statename);
                                        }
                                    });
                                });


                                var user = "";
                                $('.selectopenday').on('click', function () {
                                    user = $('.selectopenday:checked').val();
                                    if (user === 'Y')
                                    {
                                        $(".hospitaltime").hide();
                                    }
                                    if (user === 'N')
                                    {
                                        $(".hospitaltime").show();
                                    }
                                });

                               

                            });
                            function addMoreServices(htmlObj) {
        var str = "";
        var servicename = $('.servicename').html();
            var twentyfour = $('.twentyfour').html();
        var serviceoption = $(".serviceoption:first").html();
        str += "<div class=\"servicename\"><div class=\"col-md-3 \"><select class=\"form-control serviceoption\" data-rule-required=\"true\" name=\"service[]\" style=\"width:100%;\">" + servicename + "</select></div>";
        str += "<div class=\"col-md-2\"><input class=\"form-control\" name=\"service_discount[]\" type=\"text\"></div>";
        str += "<div class=\"col-md-3\"><input class=\"form-control\" name=\"corporate_discount[]\" type=\"text\"></div>";
        str += "<div class='col-sm-2'><select class='form-control twentyfour' name='twentyfour[]'>" + twentyfour + "</select></div>";
        str += "<i class=\"fa fa-times\" aria-hidden=\"true\"  onclick='remove_service_details(this)'></i><div class=\"clearfix\">&nbsp;</div></div>";
        $(htmlObj).parents(".btnaddservice").before(str);
        // console.log("tabid",$(htmlObj).parents(".btnaddservice").html(),str);
    }

    function remove_service_details(htmlobj)
    {

        $(htmlobj).parents('.servicename').remove();
    }
                            
                            function remove_service(htmlobj)
                            {
                                $('.serviceclone:last').remove();
                            }

                            
                            function showHospTime() {
                                if ($(".isopenallday:checked").val() == "N") {
                                    $(".hospitaltime").show();
                                } else {
                                    $(".hospitaltime").hide();
                                }
                            }
                            function getCity()
                            {
                                var state = $(".state-class option:selected").val();
                                var state1 = $(".state-class option:selected").text();
                                $(".state-id-class").val(state1);

                                jQuery.ajax({
                                    type: "POST",
                                    dataType: "json",
                                    cache: false,
                                    url: '<?php echo Yii::app()->createUrl("UserDetails/getCityName"); ?>',
                                    data: {state: state},
                                    success: function (data) {
                                        var dataobj = data.data;

                                        var cityname = "<option value=\"\">Select City</option>";
                                        $.each(dataobj, function (key, value) {

                                            cityname += "<option value=\"" + value.city_id + " \">" + value.city_name + "</option>";
                                        });
                                        $(".cityId").html(cityname);
                                    }
                                });
                            }
                            function getArea()
                            {
                                var area = $(".city-class option:selected").val();
                                var area1 = $(".city-class option:selected").text();

                                $(".city-id-class").val(area1);
                                jQuery.ajax({
                                    type: "POST", dataType: "json", cache: false,
                                    url: '<?php echo Yii::app()->createUrl("UserDetails/getAreaName"); ?>',
                                    data: {area: area},
                                    success: function (data) {
                                        var dataobj = data.data;
                                        var areaname = "<option value=\"\">Select Area</option>";
                                        pinarray = [];
                                        $.each(dataobj, function (key, value) {
                                            pinarray["" + value.area_id] = value.pincode;
                                            areaname += "<option value=\"" + value.area_id + " \">" + value.area_name + "</option>";
                                        });
                                        $(".areaId").html(areaname);
                                    }
                                });
                            }
                            function getAreaid() {
                                var area1 = $(".area-class option:selected").val();
                                var area = $(".area-class option:selected").text();

                                $(".area-id-class").val(area);
                                var pincode = pinarray[parseInt(area1)];
                                $(".pincode-id-class").val(pincode);
                            }

                            function clinic_time() {
        var open_time = $('.open_time').val();
        var close_time = $('.close_time').val();
        var eve_open_time = $('.eve_open_time').val();
        var eve_close_time = $('.eve_close_time').val();
        
        var hiddenhtml = "";
        hiddenhtml = "<span><input type='hidden'  name='ClinicVisitingDetails[clinic_open_time][]' value='" + open_time + "' class='clinic_open_time'><input type='hidden'  name='ClinicVisitingDetails[clinic_close_time][]' value='" + close_time + "' class='clinic_close_time'><input type='hidden'  name='ClinicVisitingDetails[clinic_eve_open_time][]' value='" + eve_open_time + "' class='clinic_eve_open_time'><input type='hidden'  name='ClinicVisitingDetails[clinic_eve_close_time][]' value='" + eve_close_time + "' class='clinic_eve_close_time'></span><div class='timing-list timeing'>Mon:" + open_time + " - "+ close_time +"<br>Evn:" + eve_open_time + " - "+ eve_close_time +"</div>"
        $(dayhtml).closest(".weekday").find('.day').before(hiddenhtml);

    
    }


                            function isalldayopen(htmlobj) {
                                // var aa= $(".isall" ).attr( "checked" ) ;
                                if ($(htmlobj).prop("checked")) {
                                    $(".day").attr("disabled", true);
                                    $(".day").attr("checked", false);
                                } else {
                                    $(".day").attr("disabled", false);
                                }
                            }

                            function showscontact(htmlobj, currentHtml)
                            {
                                $(htmlobj).show();
                                $(currentHtml).hide();
                            }


                            function chk_mobile() {

                                var mobile = $('.mobileclass').val();
                                jQuery.ajax({
                                    type: 'POST',
                                    dataType: 'json',
                                    cache: false,
                                    url: '<?php echo Yii::app()->createUrl("site/check_Mobile"); ?> ',
                                    data: {mobile: mobile},
                                    success: function (data) {
                                        var dataobj = data.data;

                                        if (dataobj > 0) {
                                            var error_msg = 'Invalid Mobile';
                                            $("#mobileno").html(error_msg);
                                        } else {
                                            $("#mobileno").html('');
                                        }
                                    }
                                });

                            }

                            function typeestablishment()
                            {

                                var user1 = $('.selecttype:checked').val();

                                if (user1 == 'others')
                                {

                                    $(".hospitaltype").show();
                                }
                                else
                                {
                                    $(".hospitaltype").hide();
                                }

                            }

                            function extra_charge()
                            {
                                var takehome = $(".take_home").val();
                                if (takehome == "Yes")
                                {
                                    $(".excharges").show();
                                }
                                else
                                {
                                    $(".excharges").hide();
                                }
                            }
								function uncheckday()
	{
		var day = $(".day:checked").val();
		  $('input:checkbox[value="' + day + '"]').attr('checked', false);
	}

    </script>
