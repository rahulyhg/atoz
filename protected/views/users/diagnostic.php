
<?php
$session = new CHttpSession;
$session->open();

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/select2.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/multiple-select.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/bootstrap-datetimepicker.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jquery.timepicker.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/radio_style.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/bootstrap-datepicker.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/moment-with-locales.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.validate.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-datepicker.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-datetimepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/select2.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/multiple-select.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.timepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-fileupload.min.js', CClientScript::POS_END);
$model->latitude = !empty($model->latitude) ? $model->latitude : 18.5204303;
$model->longitude = !empty($model->longitude) ? $model->longitude : 73.8567437;

Yii::app()->clientScript->registerScript('myjavascript', '
    
  $.validator.addMethod(
        "regexp",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Please check your input."
    );
    $.validator.addMethod("oneormorechecked", function(value, element) {
       //  alert("hiii");
       //  console.log("hiiiii");
       //  alert(element.name );
  return $(\'input[name="\' + element.name + \'"]:checked\').length > 0;
}, "Atleast 1 must be selected");
    $("#diagnostic-form").validate({
        errorElement: "label",
        ignore:":not(:visible)",
        errorClass: "help-block has-error",
        errorPlacement: function (error, element) {
            if (element.parents("label").length > 0) {
                element.parents("label").after(error);
            } else {
                element.after(error);
            }
        },
        highlight: function (label) {
            $(label).closest("div").removeClass("has-error has-success").addClass("has-error");
        },
        success: function (label) {
            label.addClass("valid").closest("div").removeClass("has-error has-success").addClass("has-success");
        },
        onkeyup: function (element) {
            $(element).valid();
        },
        onfocusout: function (element) {
            $(element).valid();
        }
    });
$(".datepick").datepicker({
        
        autoclose : true
    });
    
 $(".clinictime").datetimepicker({
                    format: "LT"
                });
function showNextSlide(nextslideid, tabid){
        
        if($("#diagnostic-form").valid()){
            $.ajax({
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
     
     $(".multipleselect4").multipleSelect({
            filter: true,
            multiple: true,
            placeholder: "Select Days",
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
?>

<section id="intro" class="section-details">
    <div class="overlay">
        <div class="container">
            <div class="main-text">

                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'diagnostic-form',
                   'action' => array('users/diagnostic'),
                    'htmlOptions' => array('enctype' => 'multipart/form-data', "class" => "w3-container"),
                    'enableAjaxValidation' => false,
                ));
                ?>
                <?php $baseUrl = Yii::app()->request->baseUrl; ?>

                <!-- Start Search box -->
                <div class="row">
                    <div class="col-md-3" style="background-image:url(<?= $baseUrl; ?>/images/icon46.png);height: 1105px;background-size: 100% auto;background-position: center center;">
                        <div class="fileinput fileinput-new" data-provides="fileinput" style="position: relative;">
                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="background: transparent;width:140px;height:140px;text-align: center; margin: auto;border-radius: 50%;overflow: hidden;">
                                <?php
                                if (empty($model->profile_image)) {
                                    echo CHtml::image(Yii::app()->request->baseUrl . "/images/icons/icon03.png", "Profile Photo", array("class" => "img-circle", "width" => "150"));
                                }
                                ?>

                            </div>
                            <span class=" btn-file" style="position: absolute;top: 60%;right: 26px;border: 1px solid #888;padding:0px;">

                                <button type="button" onclick="showimg();" class="fileinput-new">Edit</button>

                                <input type ="hidden" class="imgname" name="profile">
                                <?php echo $form->error($model, 'profile_image');
                                ?>

                            </span>
                        </div>

                        <ul class="nav nav-pills nav-stacked "  id="myTabs">
                            <li class="active"><a href="#tab_a" data-toggle="pill">Diagnostic Details &nbsp; <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                                </a></li>
                            <li><a href="#tab_b" data-toggle="pill">Services </a></li>
                            <li><a href="#tab_c" data-toggle="pill">Upload Documents </a></li>                                                     
                            <li><a href="#tab_d" data-toggle="pill">Bank Details </a></li> 
                        </ul>
                    </div>
                    <div class="tab-content col-md-9"> 
                        <div class="tab-pane active" id="tab_a">                                         
                            <div class="w3-content w3-display-container">
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

                                    <h3 class="title">Enter Your Details </h3>
                                    <div class="underline"></div>
                                    <h4 class="title-details" style="padding-left: 15px;">Diagnostic Details  </h4>
                                    <div class="textdetails">
                                        <div class="col-md-4">
                                            <span>Diagnostic Name</span>
                                            <?php
                                            if (isset($session['hospital_name'])) {
                                                $model->hospital_name = $session['hospital_name'];
                                            }
                                            ?>
                                            <?php echo $form->textField($model, 'hospital_name', array("class" => "w3-input input-group","data-rule-regexp" => "^[\w.,-\s\n\/\']+$")); ?>
                                            <?php echo $form->error($model, 'hospital_name'); ?>
                                        </div>

                                        <div class="clearfix">&nbsp;</div>
                                        <div class="textdetails">
                                            <div class="col-md-4">
                                                <span style="padding-left:15px">Type of Diagnostic center</span>
                                                <?php
                                                if (empty($model->type_of_hospital)) {
                                                    $model->type_of_hospital = 'Franchise';
                                                }
                                                echo $form->dropDownList($model, 'type_of_hospital', array('Franchise' => 'Franchise', 'Self Own' => 'Self Own', 'Company Outlet' => 'Company Outlet','Proprietor' =>  'Proprietor', 'Partnership' => 'Partnership', 'LLP' => 'LLP', 'Company' => 'Company' , 'Other' => 'Other'), array('class' => 'selecttype', 'onchange' => 'typeestablishment(this.value);'));
                                                ?>
                                                <?php echo $form->error($model, 'type_of_hospital'); ?>                                                
                                            </div>
                                            <div class="col-sm-4 otherrelation" style="display:none">
                                                <span>Other</span>
                                                <?php echo $form->textField($model, 'other_est_type', array("class" => "form-control")); ?>
                                                <?php echo $form->error($model, 'other_est_type'); ?>   
                                            </div>
                                        </div>
                                        <div class="clearfix">&nbsp;</div>
                                        <div class="col-md-4">
                                            <span>Center Registration Number</span>
                                            <?php
                                            if (isset($session['hospital_registration_no'])) {
                                                $model->hospital_registration_no = $session['hospital_registration_no'];
                                            }
                                            echo $form->textField($model, 'hospital_registration_no', array("class" => "w3-input input-group"));
                                            echo $form->error($model, 'hospital_registration_no');
                                            ?>
                                        </div>
                                        <div class="col-md-4">
                                            <span>Year of Establishment</span> 
                                            <?php
                                            if (isset($session['hos_establishment'])) {
                                                $model->hos_establishment = $session['hos_establishment'];
                                            }
                                            echo $form->textField($model, 'hos_establishment', array("class" => "w3-input input-group datepick", "data-date-format" => "mm-yyyy", "data-date-min-view-mode" => "1"));
                                            echo $form->error($model, 'hos_establishment');
                                            ?>                                                   
                                        </div>
                                        <div class="clearfix">&nbsp;</div>
                                        

                                        <div class="textdetails">
                                            <h4 class="title-details">Login Details </h4>
                                            <div class="col-md-4">
                                                <span>Mobile Number<strong class="mandatory">*</strong></span>  
                                                <?php
                                                if (isset($session['mobile'])) {
                                                    $model->mobile = $session['mobile'];
                                                }
                                                echo $form->textField($model, 'mobile', array('maxlength' => 10, "class" => "w3-input input-group mobileclass ", "data-msg-required" => "Please Enter Mobile", "data-rule-required" => "true", "data-rule-regexp" => "^[\d]+$", "onblur" => "chk_mobile()"));
                                                ?>
                                                <span id="mobileno" style="color: red;"></span>
                                                <?php echo $form->error($model, 'mobile'); ?>                        
                                            </div>
                                            <div class="col-md-4">
                                                <span>Password<strong class="mandatory">*</strong></span>
                                                <?php
                                                $model->password = '';
                                                echo $form->passwordField($model, 'password', array("class" => "w3-input input-group", "data-rule-required" => "true", "data-msg-required" => "Please Enter Password","id"=>"pass"));
                                                echo $form->error($model, 'password');
                                                ?>                                                   
                                            </div>
                                            <div class="col-md-4">
                                            <span>   Confirm Password<strong class="mandatory">*</strong></span>

    <?php  echo $form->passwordField($model, 'confirm_password', array('size' => 20, 'maxlength' => 30, "class" => "w3-input input-group password", "data-rule-required" => "true", "data-rule-equalTo" => "#pass", "data-rule-regexp" => "^[\w.,-\s\/\']+$"));?> 
                                        </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <h4 class="title-details">Contact Details </h4>
<!--                                        <div class="textdetails">
                                            <span style="padding: 10px;">Authorised Person Name</span> 
                                            <div class="col-md-4">
                                                <span>First Name<strong class="mandatory">*</strong></span>
                                                <?php
//                                                if (isset($session['first_name'])) {
//                                                    $model->first_name = $session['first_name'];
//                                                }
                                                ?>
                                                <?php //echo $form->textField($model, 'first_name', array("class" => "w3-input input-group","data-rule-regexp" => "^[\w.,-\s\n\/\']+$")); ?>
                                                <?php //echo $form->error($model, 'first_name'); ?>
                                            </div>
                                            <div class="col-md-4">
                                                <span>Last Name</span>
                                                <?php
//                                                if (isset($session['last_name'])) {
//                                                    $model->last_name = $session['last_name'];
//                                                }
                                                ?>

                                                <?php //echo $form->textField($model, 'last_name', array("class" => "w3-input input-group", "data-rule-regexp" => "^[\w.,-\s\n\/\']+$")); ?>
                                                <?php //echo $form->error($model, 'last_name'); ?>                                             
                                            </div>


                                        </div>-->
                                        <div class="clearfix"></div>
                                        <div class="textdetails">
                                            <div class="col-md-4 contacts">
                                                <span>Book You Appointment Contact Number </span>   
                                                <?php
                                                if (isset($session['apt_contact_no_1'])) {
                                                    $model->apt_contact_no_1 = $session['apt_contact_no_1'];
                                                }
                                                echo $form->textField($model, 'apt_contact_no_1', array("class" => "w3-input input-group","data-msg-required" => "Please Enter valid No","data-rule-regexp" => "^[7-9]{1}[0-9]{9,29}$"));
                                                echo $form->error($model, 'apt_contact_no_1');
                                                ?>
                                                <a class="btn-block" href="javascript:" onclick="$('.contact2').show();
                                                        $(this).hide();"><i class="fa fa-plus" aria-hidden="true"></i> Add Contact Number </a>
                                                <div class="textdetails contact2" style="display: none;">
                                                    <span>Book You Appointment Contact Number </span>                                                                                                                            <?php
                                                    if (isset($session['apt_contact_no_2'])) {
                                                        $model->apt_contact_no_2 = $session['apt_contact_no_2'];
                                                    }
                                                    echo $form->textField($model, 'apt_contact_no_2', array("class" => "w3-input input-group"));
                                                    echo $form->error($model, 'apt_contact_no_2');
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-4 contacts">
                                                <span>Email Address </span>   
                                                <?php
                                                if (isset($session['email_1'])) {
                                                    $model->coordinator_email_1 = $session['email_1'];
                                                }
                                                echo $form->textField($model, 'email_1', array("class" => "w3-input input-group"));
                                                echo $form->error($model, 'email_1');
                                                ?>

                                                <a class="btn-block" href="javascript:" onclick="$('.mail2').show();
                                                        $(this).hide();"><i class="fa fa-plus" aria-hidden="true"></i> Add Email Address </a>
                                                <div class="textdetails mail2" style="display: none;">

                                                    <span>Email Address </span>                                                                                                       <?php
                                                    if (isset($session['email_2'])) {
                                                        $model->coordinator_email_2 = $session['email_2'];
                                                    }
                                                    echo $form->textField($model, 'email_2', array("class" => "w3-input input-group"));
                                                    echo $form->error($model, 'email_2');
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="clearfix">&nbsp;</div>                  	
                                        

                                        <div class="textdetails">
                                            <h4 class="title-details" style="padding: 15px;">Your Services Facilitator</h4>
                                            <div class="col-md-4">
                                                <div class="contacts">
                                                    <span>1. Name</span>                                                        
                                                    <?php
                                                    if (isset($session['coordinator_name_1'])) {
                                                        $model->coordinator_name_1 = $session['coordinator_name_1'];
                                                    }
                                                    echo $form->textField($model, 'coordinator_name_1', array("class" => "w3-input input-group"));
                                                    echo $form->error($model, 'coordinator_name_1');
                                                    ?>
                                                </div>           
                                            </div>
                                            <div class="col-md-4">                                                    	
                                                <span>Contact Number </span>                                                        
                                                <?php
                                                if (isset($session['coordinator_mobile_1'])) {
                                                    $model->coordinator_mobile_1 = $session['coordinator_mobile_1'];
                                                }
                                                echo $form->textField($model, 'coordinator_mobile_1', array('maxlength' => 10, "class" => "w3-input input-group","data-rule-regexp" => "^[\d]+$"));
                                                echo $form->error($model, 'coordinator_mobile_1');
                                                ?>
                                            </div>
                                        </div> <!--end textdetails-->

                                        <div class="clearfix"></div>
                                        <div class="textdetails">
                                            <div class="col-md-4">
                                                <div class="contacts">
                                                    <span>2. Name</span>                                                        
                                                    <?php
                                                    if (isset($session['coordinator_name_2'])) {
                                                        $model->coordinator_name_2 = $session['coordinator_name_2'];
                                                    }
                                                    echo $form->textField($model, 'coordinator_name_2', array("class" => "w3-input input-group"));
                                                    echo $form->error($model, 'coordinator_name_2');
                                                    ?>
                                                </div>           
                                            </div>
                                            <div class="col-md-4">                                                    	
                                                <span>Contact Number </span>                                                        
                                                <?php
                                                if (isset($session['coordinator_mobile_2'])) {
                                                    $model->coordinator_mobile_2 = $session['coordinator_mobile_2'];
                                                }
                                                echo $form->textField($model, 'coordinator_mobile_2', array('maxlength' => 10, "class" => "w3-input input-group", "data-msg-required" => "Please Enter Mobile no", "data-rule-regexp" => "^[\d]+$"));
                                                echo $form->error($model, 'coordinator_mobile_2');
                                                ?>
                                            </div>

                                        </div> <!--end textdetails-->

                                        <div class="clearfix"></div>
                                        <div class="textdetails">
                                            <div class="col-md-4">
                                                <div class="contacts">
                                                    <span>Email Address 1</span>                                                        
                                                    <?php
                                                    if (isset($session['coordinator_email_1'])) {
                                                        $model->coordinator_email_1 = $session['coordinator_email_1'];
                                                    }
                                                    echo $form->textField($model, 'coordinator_email_1', array("class" => "w3-input input-group"));
                                                    echo $form->error($model, 'coordinator_email_1');
                                                    ?>
                                                </div>
                                                <a class="btn-block" href="javascript:" onclick="$('.cordemail2').show();
                                                        $(this).hide();"><i class="fa fa-plus" aria-hidden="true"></i> Add Email Address </a>
                                            </div>                               
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="textdetails cordemail2" style="display: none;">
                                            <div class="col-md-4">                                                    	
                                                <span>Email Address 2 </span>                                                        
                                                <?php
                                                if (isset($session['coordinator_email_2'])) {
                                                    $model->coordinator_email_2 = $session['coordinator_email_2'];
                                                }
                                                echo $form->textField($model, 'coordinator_email_2', array("class" => "w3-input input-group"));
                                                echo $form->error($model, 'coordinator_email_2');
                                                ?>
                                            </div>
                                        </div>
                                        <div class="clearfix">&nbsp;</div>
                                        
                                        
                                        <h4 class="title-details clearfix" style="padding: 15px;">Location</h4>
                                        <div class="textdetails">
                                            <div class="col-md-4">
                                                <span>Zip Code</span>
                                                <?php
                                                if (isset($session['pincode'])) {
                                                    $model->pincode = $session['pincode'];
                                                }
                                                echo $form->textField($model, 'pincode', array("class" => "w3-input input-group pincode-id-class"));
                                                echo $form->error($model, 'pincode');
                                                ?>
                                            </div>  
                                            <div class="col-md-4">
                                                <span>State</span>
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
                                                echo $form->dropDownList($model, 'state_id', $stateArr, array("class" => "w3-input state-class", "style" => "width:100%;", "prompt" => "Select State", 'onchange' => 'getCity()'));
                                                echo $form->error($model, 'state_id');
                                                if (isset($session['state_name'])) {
                                                    $model->state_name = $session['state_name'];
                                                }
                                                echo $form->hiddenField($model, "state_name", array("class" => "state-id-class"));
                                                ?>   

                                            </div>
                                            <div class="col-md-4">
                                                <span>City</span>
                                                <?php
                                                $cityArr = array();

                                                if (isset($session['city_id'])) {
                                                    $model->city_id = $session['city_id'];
                                                }
                                                echo $form->dropDownList($model, 'city_id', $cityArr, array("class" => "w3-input cityId city-class", "style" => "width:100%;", "prompt" => "Select City",'onchange' => 'getArea()'));
                                                echo $form->error($model, 'city_id');
                                                if (isset($session['city_name'])) {
                                                    $model->city_name = $session['city_name'];
                                                }
                                                echo $form->hiddenField($model, "city_name", array("class" => "city-id-class"));
                                                ?>

                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="textdetails">

                                            <div class="col-md-4">
                                                <span>Area</span>
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

                                                echo $form->dropDownList($model, 'area_id', $areaArr, array("class" => "w3-input area-class areaId", "style" => "width:100%;", "prompt" => "Select Area", 'onchange' => 'getAreaid()'));
                                                echo $form->error($model, 'area_id');
                                                if (isset($session['area_name'])) {
                                                    $model->area_name = $session['area_name'];
                                                }
                                                echo $form->hiddenField($model, "area_name", array("class" => "area-id-class"));
                                                ?>   

                                            </div>
                                            <div class="col-md-4">
                                                <span>Landmark</span>
                                                <?php
                                                if (isset($session['landmark'])) {
                                                    $model->landmark = $session['landmark'];
                                                }
                                                echo $form->textField($model, 'landmark', array("class" => "w3-input input-group"));
                                                echo $form->error($model, 'landmark');
                                                ?>

                                            </div>
                                            <div class="col-md-4">
                                                <span>Address</span>
                                                <?php
                                                if (isset($session['address'])) {
                                                    $model->address = $session['address'];
                                                }
                                                echo $form->textField($model, 'address', array("class" => "w3-input input-group"));
                                                echo $form->error($model, 'address');
                                                ?>

                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        
                                        <div class="col-sm-4">
                                        <?php
                                        echo $form->labelEx($model, 'Latitude');
                                        echo $form->textField($model, 'latitude', array("class" => "form-control input-group latitude"));
                                        echo $form->error($model, 'latitude');
                                        ?>
                                    </div>
                                    <div class="col-sm-4"> 
                                        <?php
                                        echo $form->labelEx($model, 'Longitude');
                                        echo $form->textField($model, 'longitude', array("class" => "form-control input-group longitude"));
                                        echo $form->error($model, 'longitude');
                                        ?>
                                    </div>
                                    <div class="clearfix">&nbsp;</div><br>
                                    <div class="col-sm-12 clearfix">
                                        <div id="p-map" style="height: 340px;width: 100%;border:1px solid #533223;"></div>
                                    </div>


                                    <div class="clearfix">&nbsp;</div>
                                        

                                        <!-- Timing start here -->
                                        <div class="textdetails">
                                            <h4 class="title-details">Timings<strong class="mandatory">*</strong></h4>
                                            <div class="col-md-12" style=""> 
                                                <label><input  type="checkbox" name="UserDetails[is_open_allday]" value="Y" onclick="isalldayopen(this)" class="isall"> 24x7</label>
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

                                            <div class="modal" id="myModal" role="dialog">
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
                                        </div>
                                        <!-- Timing end here -->



                                    </div> <!--end textdetails-->
                                    <div class="clearfix"></div>
                                    <div class="button-arrow">
                                        <button class="w3-button w3-black w3-display-right" onClick="showNextSlide('slide2', 'tab_b')" type="button">&#10095;</button>
                                    </div>

                                </div>
                            </div> <!--end Container-->
                        </div>  <!--end tab_a-->
                        <div class="tab-pane" id="tab_b">
                            <div class="w3-content w3-display-container">
                                <div class="mySlides"  id="slide2">
                                    <h4 class="title-details" style="padding-left: 15px;">Services</h4>
                                    <div class="textdetails">
                                        <div class="col-md-3">
                                            <span>Services</span>
                                            <?php
                                            $serviceArr = array();
                                            $selected = array();
                                            $serviceType = Yii::app()->db->createCommand()->select("service_id,service_name")->from("az_service_master")->where('role_id=7')->queryAll();
                                            foreach ($serviceType as $row) {
                                                $serviceArr[$row['service_id']] = $row['service_name'];
                                            }
                                            echo $form->dropDownList($model4, 'service_id[]', $serviceArr, array("class" => "w3-input serviceoption", "style" => "width:100%;", "prompt" => "Select Services"));
                                            echo $form->error($model4, 'service_id');
                                            ?>   

                                        </div>    
                                        <div class="col-md-2">
                                            <span>Discount %</span>
                                            <?php
                                            if (isset($session['service_discount'])) {
                                                $model4->service_discount = $session['service_discount'];
                                            }
                                            echo $form->textField($model4, 'service_discount[]', array("class" => "w3-input input-group"));
                                            echo $form->error($model4, 'service_discount');
                                            ?> 
                                        </div>
                                        <div class="col-md-3">
                                            <span>Corporate Discount %</span>
                                            <?php
                                            if (isset($session['corporate_discount'])) {
                                                $model4->corporate_discount = $session['corporate_discount'];
                                            }
                                            echo $form->textField($model4, 'corporate_discount[]', array("class" => "w3-input input-group"));
                                            echo $form->error($model4, 'corporate_discount');
                                            ?> 
                                        </div>
                                        <div class="col-md-3">
                                            <span>24x7</span>
                                            <?php
                                            if (isset($session['twentyfour'])) {
                                                $model4->twentyfour = $session['twentyfour'];
                                            }
                                            echo $form->dropDownList($model4, 'twentyfour[]', array("Yes" => "Yes", "No" => "No"), array("class" => "w3-input input-group"));
                                            echo $form->error($model4, 'twentyfour');
                                            ?> 
                                        </div>
                                        <div class="clearfix">&nbsp;</div><br>
                                        <div class="col-md-12 btnaddservice">
                                            <a class="" href="javascript:" onclick="addMoreServices(this);"><i class="fa fa-plus" aria-hidden="true"></i> Add Services </a>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>

                                    <div class="col-md-3">
                                        <span>Take Home Service</span>

                                        <?php echo $form->dropDownList($model, 'take_home', array("Yes" => "Yes", "No" => "No"), array("class" => "w3-input input-group"));
                                        ?>
                                    </div>

                                    <div class="col-md-3">
                                        <span>24x7 Emergency</span>
                                        <?php echo $form->dropDownList($model, 'emergency', array("Yes" => "Yes", "No" => "No"), array("class" => "w3-input input-group"));
                                        ?>
                                    </div>
                                    <div class="clearfix"></div>
                                    
                                    
                                    <div class="textdetails clearfix">
                                        <br><h4 class="title-details">Free Offering</h4>
                                        <div class="col-md-4"> 
                                            <span>Per Day</span>
                                            <?php
                                            echo $form->textField($model, 'free_opd_perday', array("class" => "w3-input input-group", "data-msg-required" => "Please Check Your Input", "data-rule-regexp" => "^[\d]+$"));
                                            echo $form->error($model, 'free_opd_perday');
                                            ?>
                                        </div>
                                        <div class="col-md-4"><span>Preferred Days</span>
                                            <?php
                                            // DAY_STR is constant which contains array of Days
                                            $DayArr = explode(";", Constants:: DAY_STR);
                                            $DayFinalArr = array_combine($DayArr, $DayArr);
                                            echo $form->dropDownList($model, 'free_opd_preferdays[]', $DayFinalArr, array("class" => "multipleselect4 form-control2", 'multiple' => 'multiple', "data-msg-required" => "Please Select Days"));

                                            echo $form->error($model, 'free_opd_preferdays');
                                            ?>
                                        </div>
                                        
                                         <div class="col-md-4"> 
                                        <span>Payment Modes</span>
                                        <?php
                                            // PAYMENT_TYPE is constant which contains array of payment type
                                            $paymenttypeArr = explode(";", Constants:: PAYMENT_TYPE);
                                            $paymenttypeFinalArr = array_combine($paymenttypeArr, $paymenttypeArr);
                                            $selected = array("A2Z E-money" => array('selected' => 'selected', "disabled" => true));
                                            echo $form->dropDownList($model, 'payment_type[]', $paymenttypeFinalArr, array("class" => "multipleselect3 w3-input input-group", 'multiple' => 'multiple', "data-msg-required" => "Please Select Payent Type", 'options' => $selected));

                                            echo $form->error($model, 'payment_type');
                                            ?>
                                        </div>
                                        
                                    </div>
                                    
                                    
                                    <div class="textdetails">

                                        <div class="col-md-8">
                                            <span>About Center</span>
                                            <?php
                                            if (isset($session['description'])) {
                                                $model->description = $session['description'];
                                            }
                                            echo $form->textArea($model, 'description', array("class" => "w3-input input-group", "rows" => "4"));
                                            echo $form->error($model, 'description');
                                            ?>

                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="button-arrow">
                                        <button class="w3-button w3-black w3-display-left" onClick="showPrevSlide('slide1', 'tab_a')" type="button">&#10094;</button>
                                        <button class="w3-button w3-black w3-display-right" onClick="showNextSlide('slide3', 'tab_c')" type="button">&#10095;</button>
                                    </div>
                                </div> <!--end mySlides-->
                                <!-- </form>-->

                            </div> <!--end w3-display-container-->

                        </div> <!--end tab_b id-->
                        <div class="tab-pane" id="tab_c">
                            <div class="w3-content w3-display-container">
                                <div class="mySlides"  id="slide3">
                                    <h3 class="title">Documents / Certificates</h3>
                                    <h4 class="title">Pathology Registration</h4>
                                    <div class="textdetails">
                                        <div class="col-md-4">
                                            <span>Center Certificate</span>
                                            <?php
                                            echo $form->fileField($model3, 'document', array("class" => "w3-input input-group"));
                                            echo $form->error($model, 'document');
                                            ?> 
                                        </div>
                                        <div class="col-md-4">
                                            <span>Other Certificate</span>
                                            <?php
                                            echo $form->fileField($model3, 'otherdoc', array("class" => "w3-input input-group"));
                                            echo $form->error($model3, 'otherdoc');
                                            ?> 
                                        </div>


                                        <div class="col-md-4">
                                            <span>Add Photo</span>
                                            <?php
                                            echo $form->fileField($model3, 'doc_photo[]', array("class" => "w3-input input-group", "multiple" => "multiple"));
                                            echo $form->error($model3, 'doc_photo');
                                            ?> 
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="clearfix"></div>
                                    <div class="button-arrow">
                                        <button class="w3-button w3-black w3-display-left" onClick="showPrevSlide('slide2', 'tab_b')" type="button">&#10094;</button>
                                        <button class="w3-button w3-black w3-display-right" onClick="showNextSlide('slide4', 'tab_d')" type="button">&#10095;</button>
                                    </div>
                                </div>
                            </div>


                        </div><!--end tab_c id-->


                        <div class="tab-pane" id="tab_d">
                            <div class="w3-content w3-display-container">
                                <div class="mySlides"  id="slide4">
                                    <h3 class="title">Bank A/C Details</h3>

                                    <div class="textdetails">
                                        <div class="col-md-4">
                                            <span>Acount Holder Name</span>
                                            <?php
                                            if (isset($session['acc_holder_name'])) {
                                                $model7->acc_holder_name = $session['acc_holder_name'];
                                            }
                                            echo $form->textField($model7, 'acc_holder_name', array("class" => "w3-input input-group"));
                                            echo $form->error($model7, 'acc_holder_name');
                                            ?> 
                                        </div>
                                        <div class="col-md-4">
                                            <span>Bank Name</span>
                                            <?php
                                            if (isset($session['bank_name'])) {
                                                $model7->bank_name = $session['bank_name'];
                                            }
                                            echo $form->textField($model7, 'bank_name', array("class" => "w3-input input-group"));
                                            echo $form->error($model7, 'bank_name');
                                            ?> 
                                        </div>
                                        <div class="col-md-4">
                                            <span>Branch Name</span>
                                            <?php
                                            if (isset($session['branch_name'])) {
                                                $model7->branch_name = $session['branch_name'];
                                            }
                                            echo $form->textField($model7, 'branch_name', array("class" => "w3-input input-group"));
                                            echo $form->error($model7, 'branch_name');
                                            ?> 

                                        </div>

                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="textdetails">
                                        <div class="col-md-4">
                                            <span>Acount No</span>
                                            <?php
                                            if (isset($session['account_no'])) {
                                                $model7->account_no = $session['account_no'];
                                            }
                                            echo $form->textField($model7, 'account_no', array("class" => "w3-input input-group"));
                                            echo $form->error($model7, 'account_no');
                                            ?> 

                                        </div>
                                        <div class="col-md-4">
                                            <span>Account Type</span>
                                            <?php
                                            if (isset($session['account_type'])) {
                                                $model7->account_type = $session['account_type'];
                                            }
                                            echo $form->textField($model7, 'account_type', array("class" => "w3-input input-group"));
                                            echo $form->error($model7, 'account_type');
                                            ?> 

                                        </div>
                                        <div class="col-md-4">
                                            <span>IFSC Code</span>
                                            <?php
                                            if (isset($session['ifsc_code'])) {
                                                $model7->ifsc_code = $session['ifsc_code'];
                                            }
                                            echo $form->textField($model7, 'ifsc_code', array("class" => "w3-input input-group"));
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
                                    <div class="textdetails text-center">
                                        <?php
                                        echo CHtml::submitButton("Submit", array('class' => 'btn'));
                                        ?>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="button-arrow">
                                        <button class="w3-button w3-black w3-display-left" onClick="showPrevSlide('slide3', 'tab_c')" type="button">&#10094;</button>

                                    </div>
                                </div>
                            </div>


                        </div><!--end tab_d id-->


                    </div>  <!-- tab content -->
                </div>
            </div>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</section>
<div class="modal fade" id="myimg" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Profile Image</h4>
            </div>
            <div class="modal-body">

                <div class="col-md-6" style="padding-top:30px;">

                    <br/>
                    <div class="col-md-12 text-center">
                        <div id="upload-demo" style="width:350px"></div>
                    </div>
                    <div class="col-sm-11">
                        <?php echo $form->fileField($model, 'profile_image', array("class" => "", "id" => "upload")); ?>
                    </div>
                    <div class="col-sm-1">
                        <button class="btn btn-success upload-result" data-dismiss="modal">Upload Image</button>
                    </div>
                </div>
                <div class="col-md-6" style="">
                    <div id="upload-demo-i" style="background:#e1e1e1;width:300px;padding:30px;height:300px;margin-top:82px"></div>
                </div>			
            </div>
            <div class="modal-footer text-center" style="border:0px;">

            </div>
        </div>

    </div>
</div>
<link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/croppie.css">
<script src="http://demo.itsolutionstuff.com/plugin/croppie.js"></script>

<script type="text/javascript">
var dayhtml;
$(function () {

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


//         var terms = $(".agree").prop("checked");
//         var flag = 1;
//         if (terms == false) {
//               document.getElementById("agree1").innerHTML = "*Please Check Terms And Conditions";
//                                                flag = 0;
//              }

                                                $uploadCrop = $('#upload-demo').croppie({
                                                    enableExif: true,
                                                    viewport: {
                                                        width: 200,
                                                        height: 200,
                                                        type: 'circle'
                                                    },
                                                    boundary: {
                                                        width: 300,
                                                        height: 300
                                                    },
                                                    //enableZoom : true

                                                });
                                                $('#upload').on('change', function () {
                                                    var reader = new FileReader();
                                                    reader.onload = function (e) {
                                                        $uploadCrop.croppie('bind', {
                                                            url: e.target.result
                                                        }).then(function () {
                                                            console.log('jQuery bind complete');
                                                        });

                                                    }
                                                    reader.readAsDataURL(this.files[0]);
                                                });

                                                $('.upload-result').on('click', function (ev) {
                                                    $uploadCrop.croppie('result', {
                                                        type: 'canvas',
                                                        size: 'viewport'
                                                    }).then(function (resp) {
                                                        html = '<img src="' + resp + '"/base64 />';
                                                        $("#upload-demo-i").html(html);
                                                        $(".fileinput-preview").html(html);
                                                        $(".imgname").val(resp);
                                                    });

                                                });
                                            });

                                           function clinic_time() {
    var open_time = $('.open_time').val();

    var close_time = $('.close_time').val();
    var eve_open_time = $('.eve_open_time').val();
    var eve_close_time = $('.eve_close_time').val();

    var hiddenhtml = "";
    hiddenhtml = "<span><input type='hidden'  name='ClinicVisitingDetails[clinic_open_time][]' value='" + open_time + "' class='clinic_open_time'><input type='hidden'  name='ClinicVisitingDetails[clinic_close_time][]' value='" + close_time + "' class='clinic_close_time'><input type='hidden'  name='ClinicVisitingDetails[clinic_eve_open_time][]' value='" + eve_open_time + "' class='clinic_eve_open_time'><input type='hidden'  name='ClinicVisitingDetails[clinic_eve_close_time][]' value='" + eve_close_time + "' class='clinic_eve_close_time'></span><div class='timing-list timeing'>Mon:" + open_time + " - " + close_time + "<br>Evn:" + eve_open_time + " - " + eve_close_time + "</div>"
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

function addMoreServices(htmlObj) {
    var str = "";
    var serviceoption = $(".serviceoption:first").html();
    str += "<div class=\"servicename\"><div class=\"col-md-3\"><select class=\"w3-input serviceoption\" data-rule-required=\"true\" name=\"ServiceUserMapping[service_id][]\" style=\"width:100%;\">" + serviceoption + "</select></div>";
    str += "<div class=\"col-md-2\"><input class=\"w3-input input-group\" name=\"ServiceUserMapping[service_discount][]\" type=\"text\"></div>";
     str += "<div class=\"col-md-3\"><input class=\"w3-input input-group\" name=\"ServiceUserMapping[corporate_discount][]\" type=\"text\"></div>";
    str += "<div class=\"col-md-3\"><select class=\"w3-input serviceoption\" data-rule-required=\"true\" name=\"ServiceUserMapping[twentyfour][]\"  style=\"width:100%;\"><option value=\"Yes\">Yes</option><option value=\"No\">No</option></select></div>";
    str += " <i class=\"fa fa-times\" aria-hidden=\"true\" onclick='remove_service_details(this)'></i><div class=\"clearfix\">&nbsp;</div></div>";

    // str += "<button type='button' class='delete' onclick='remove_service_details(this)'>Remove</button><div class=\"clearfix\">&nbsp;</div></div>";
    $(htmlObj).parents(".btnaddservice").before(str);

}

function remove_service_details(htmlobj)
{

    $(htmlobj).parents('.servicename').remove();
}


function chk_mobile() {
 $("#mobileno").html('');
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
                var error_msg = ' Mobile No Is Allready Exists';
                if(!mobile == ''){
                 
                    $("#mobileno").html(error_msg);
            } else {
                $("#mobileno").html('');
            }
        }
    }
});
}
function showimg()
{

    $('#myimg').modal('show');
}
function typeestablishment(type)
{
    if (type == 'Other')
    {

        $(".otherrelation").show();
    }
    else
    {
        $(".otherrelation").hide();
    }

}
  function uncheckday(){
    var selected_day = new Array();
    $('input[name="ClinicVisitingDetails[day][]"]:checked').each(function () {
        selected_day.push($(this).val());

    });
    var lastEl = selected_day[selected_day.length - 1];
    $('input:checkbox[value="' + lastEl + '"]').attr('checked', false);
}
</script>