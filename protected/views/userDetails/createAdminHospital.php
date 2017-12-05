<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyA1vr2RVgKBydJQhSo1LUsP3pUcKh4IFGI"></script>
<?php
$clientScriptObj = Yii::app()->clientScript;
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/select2.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/multiple-select.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/bootstrap-datetimepicker.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jquery.timepicker.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/radio_style.css');

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.timepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/moment-with-locales.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.validate.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-datepicker.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-datetimepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/select2.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/multiple-select.js', CClientScript::POS_END);
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
    $("#hospital-update-form").validate({
        errorElement: "span",
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
 $(".datepick").datetimepicker({
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down"
                },
                stepping : 5,
              format:"YYYY-MM-DD",
              maxDate :new Date(),
                //defaultDate : new Date()
            });
    $(".timepick").datetimepicker({
        format: "LT"
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

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'hospital-update-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>

<section class="content-header">

    <h3>Create Hospital</h3>

</section>
<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row"><!-- row start-->
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                    <div class="box-header with-border"><!-- box header start -->

                        <div class="text-right"><!--link div-->
                            <?php echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> Manage Hospital ', array('UserDetails/manageHospital'), array("style" => "color: white;", 'class' => 'btn btn-info')); ?>
                        </div><!--link End-->   




                        <div class="bs-example">
                            <ul class="nav nav-tabs" id="myTab">
                                <li><a data-toggle="tab" href="#sectionA">Hospital Details</a></li>
                                <li><a data-toggle="tab" href="#sectionB">Services</a></li>
                                <li><a data-toggle="tab" href="#dropdown">Upload Documents</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="sectionA" class="tab-pane fade in active">
                                    <h3 class="title text-center">Enter Your Details </h3>
                                    <div class="underline"></div>
                                    <h4 class="title-details">Hospital Details  </h4>
                                    <?php echo $form->errorSummary($model); ?>
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
                                    <div class="box box-primary">
                                        <div class="form-group clearfix">
                                            <div class="col-sm-4">
                                  <label class="control-label">Profile Image</label>
                                <div class="fileinput fileinput-new" data-provides="fileinput" style="position: relative;">
                                    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="background: transparent;width:140px;height:140px;text-align: center; margin: auto;border-radius: 50%;overflow: hidden;">
                                        <?php
                                        if (empty($model->profile_image)) {
                                            echo CHtml::image(Yii::app()->request->baseUrl . "/images/icons/icon02.png", "Profile Photo", array("class" => "img-circle", "width" => "150"));
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

                            </div>
                                            <div class="col-sm-4">
                                                <b><span>Hospital Name<strong class="mandatory">*</strong></span></b>
                                                <?php
                                                echo $form->textField($model, 'hospital_name', array('maxlength' => 60, 'class' => 'form-control ', "data-rule-required" => "true", "data-msg-required" => "Please Enter Hospital Name"));
                                                echo $form->error($model, 'hospital_name');
                                                ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <b><span>Type Of Hospital<strong class="mandatory">*</strong></span></b>
                                                <?php
                                                //HOSPITAL_CATEGORY is constant which contain hospital category
                                                $hospCat = Constants::HOSPITAL_CATEGORY;
                                                $hospCateArr = explode(";", $hospCat);
                                                $cateArr = array_combine($hospCateArr, $hospCateArr);
                                                echo $form->dropDownList($model, 'type_of_hospital', $cateArr, array("class" => "form-control", "style" => "width:100%;", "prompt" => "Select Type Of Hospital", "data-rule-required" => "true", "data-msg-required" => "Please Select Type"));
                                                echo $form->error($model, 'type_of_hospital');
                                                ?>
                                            </div>

                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="col-sm-4">
                                                <b><span>Mobile<strong class="mandatory">*</strong></span></b>
                                                <?php echo $form->textField($model, 'mobile', array('maxlength' => 10, "class" => "form-control input-group mobileclass ", "data-msg-required" => "Please Enter Mobile", "data-rule-required" => "true", "data-rule-regexp" => "^[\d]+$", "onblur" => "chk_mobile()")); ?>
                                                <span id="mobileno" style="color: red;"></span>
                                                <?php echo $form->error($model, 'mobile'); ?>  

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
                                                <b><span>Hospital Registration No<strong class="mandatory">*</strong></span></b>
                                                <?php
                                                echo $form->textField($model, 'hospital_registration_no', array('maxlength' => 60, 'class' => 'form-control ', "data-rule-required" => "true", "data-msg-required" => "Please Enter Hospital Registration Number"));
                                                echo $form->error($model, 'hospital_registration_no');
                                                ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <b><span>Payment Mode<strong class="mandatory">*</strong></span></b>
                                                <?php
                                                //echo "<pre>";print_r($doctorDegreeDetails);
                                                //DEGREE_STR is constant which contains array of degree

                                                $paymenttypeArr = explode(";", Constants::PAYMENT_TYPE);
                                                $paymenttypeFinalArr = array_combine($paymenttypeArr, $paymenttypeArr);

                                                echo $form->dropDownList($model, 'payment_type', $paymenttypeFinalArr, array("class" => " multipleselect1", "style" => "width:100%;", "multiple" => "multiple", "data-rule-required" => "true", "data-msg-required" => "Please Select Payment Type"));
                                                echo $form->error($model, 'payment_type');
                                                ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <b><span>Hospital Establishment<strong class="mandatory">*</strong></span></b>
                                                <?php
                                                echo $form->textField($model, 'hos_establishment', array('maxlength' => 60, 'class' => 'form-control datepick', "data-rule-required" => "true", "data-date-min-view-mode" => "1", "data-msg-required" => "Please Select Hospital Establishment"));
                                                echo $form->error($model, 'hos_establishment');
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="col-sm-8">
                                                <b><span>Type of Establishment<strong class="mandatory">*</strong></span></b>
                                                <?php
                                                echo $form->radioButtonList($model, 'type_of_establishment', array("privateltd" => "Private Ltd", "partnership" => "Partnership", "publicltd" => "Public Ltd", "individual" => "Individual", "trust" => "Trust", "others" => "Others"), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '&nbsp;&nbsp;&nbsp;', "class" => "selecttype", 'template' => '<label class="ui-radio-inline">{input} <span>{label}</span></label>', 'container' => 'div class="ui-radio ui-radio-pink"', 'onClick' => 'typeestablishment();'));
                                                ?>
                                                <?php echo $form->error($model, 'type_of_establishment'); ?>
                                            </div>
                                            <div class="col-sm-4 hospitaltype" hidden="">
                                                <?php echo $form->labelEx($model, 'Type of Establishment'); ?>
                                                <?php echo $form->textField($model, 'other_est_type', array("class" => "form-control")); ?>
                                                <?php echo $form->error($model, 'other_est_type'); ?>   
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class ="col-sm-4">
                                                <b><span>Speciality<strong class="mandatory">*</strong></span></b>
                                                <?php
                                                $speciality = SpecialityMaster::model()->findAll();
                                                $specialitynameArr = CHtml::listData($speciality, 'speciality_id', 'speciality_name');
                                                echo $form->dropDownList($model, 'speciality', $specialitynameArr, array("class" => "multipleselect2", "multiple" => "multiple", "data-rule-required" => "true", "data-msg-required" => "Please Select Speciality Name"));
                                                echo $form->error($model, 'speciality');
                                                ?>
                                            </div>
                                            <div class="col-sm-4">

                                                <div class="">
                                                    <b><span>Landline No<strong class="mandatory">*</strong></span></b>

                                                    <?php echo $form->textField($model, 'landline_1', array('maxlength' => 11, "class" => "form-control", "data-rule-required" => "true", "data-msg-required" => "Please Enter Landline")); ?>
                                                    <?php echo $form->error($model, 'landline_1'); ?>
                                                </div>
                                                <?php if (empty($model->landline_2)) {
                                                    ?>
                                                    <button type="button" onclick="showscontact('.landline_2', this);">+</button>
                                                <?php }
                                                ?>
                                                <div class="clearfix">&nbsp;</div>
                                                <div class="landline_2 " <?php
                                                if (!empty($model->landline_2)) {
                                                    echo "";
                                                } else {
                                                    echo 'style="display:none;"';
                                                }
                                                ?>>
                                                         <?php echo $form->labelEx($model, 'Landline No'); ?>
                                                         <?php echo $form->textField($model, 'landline_2', array('maxlength' => 11, "class" => "form-control", "data-rule-required" => "true", "data-msg-required" => "Please Enter Landline")); ?>
                                                         <?php echo $form->error($model, 'landline_2'); ?>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">

                                                <div class="">
                                                    <?php echo $form->labelEx($model, 'Email'); ?>
                                                    <?php echo $form->textField($model, 'email_1', array('size' => 60, 'maxlength' => 200, "class" => "form-control")); ?>
                                                    <?php echo $form->error($model, 'email_1'); ?>
                                                </div>
                                                <?php if (empty($model->email_2)) {
                                                    ?>
                                                    <button type="button" onclick="showscontact('.email_2', this);">+</button>
                                                <?php }
                                                ?>
                                                <div class="clearfix">&nbsp;</div>
                                                <div class="email_2 "<?php
                                                if (!empty($model->email_2)) {
                                                    echo "";
                                                } else {
                                                    echo 'style="display:none;"';
                                                }
                                                ?>>
                                                         <?php echo $form->labelEx($model, 'Email'); ?>
                                                         <?php echo $form->textField($model, 'email_2', array('size' => 60, 'maxlength' => 200, "class" => "form-control")); ?>
                                                         <?php echo $form->error($model, 'email_2'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="col-sm-4">

                                                <div class="">
                                                    <?php echo $form->labelEx($model, ' Emergency No'); ?>
                                                    <?php echo $form->textField($model, 'emergency_no_1', array('maxlength' => 11, 'maxlength' => 11, "class" => "form-control")); ?>
                                                    <?php echo $form->error($model, 'emergency_no_1'); ?>
                                                </div>
                                                <?php if (empty($model->emergency_no_2)) {
                                                    ?>
                                                    <button type="button" onclick="showscontact('.emergency_no_2', this);">+</button>
                                                <?php }
                                                ?>
                                                <div class="clearfix">&nbsp;</div>
                                                <div class="emergency_no_2 "<?php
                                                if (!empty($model->emergency_no_2)) {
                                                    echo "";
                                                } else {
                                                    echo 'style="display:none;"';
                                                }
                                                ?>>
                                                         <?php echo $form->labelEx($model, ' Emergency No'); ?>
                                                         <?php echo $form->textField($model, 'emergency_no_2', array('maxlength' => 11, "class" => "form-control")); ?>
                                                         <?php echo $form->error($model, 'emergency_no_2'); ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">

                                                <div class="">
                                                    <?php echo $form->labelEx($model, '  Ambulance No'); ?>
                                                    <?php echo $form->textField($model, 'ambulance_no_1', array('maxlength' => 11, "class" => "form-control")); ?>
                                                    <?php echo $form->error($model, 'ambulance_no_1'); ?>
                                                </div>
                                                <?php if (empty($model->emergency_no_2)) {
                                                    ?>
                                                    <button type="button" onclick="showscontact('.ambulance_no_2', this);">+</button>
                                                <?php }
                                                ?>
                                                <div class="clearfix">&nbsp;</div>
                                                <div class="ambulance_no_2 "<?php
                                                if (!empty($model->ambulance_no_2)) {
                                                    echo "";
                                                } else {
                                                    echo 'style="display:none;"';
                                                }
                                                ?>>
                                                         <?php echo $form->labelEx($model, '  Ambulance No'); ?>
                                                         <?php echo $form->textField($model, 'ambulance_no_2', array('maxlength' => 11, "class" => "form-control")); ?>
                                                         <?php echo $form->error($model, 'ambulance_no_2'); ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">

                                                <div class="">
                                                    <?php echo $form->labelEx($model, '   Toll Free NO'); ?>
                                                    <?php echo $form->textField($model, 'tollfree_no_1', array('maxlength' => 11, "class" => "form-control")); ?>
                                                    <?php echo $form->error($model, 'tollfree_no_1'); ?>
                                                </div>
                                                <?php if (empty($model->emergency_no_2)) {
                                                    ?>
                                                    <button type="button" onclick="showscontact('.tollfree_no_2', this);">+</button>
                                                <?php }
                                                ?>
                                                <div class="clearfix">&nbsp;</div>
                                                <div class="tollfree_no_2 "<?php
                                                if (!empty($model->tollfree_no_2)) {
                                                    echo "";
                                                } else {
                                                    echo 'style="display:none;"';
                                                }
                                                ?>>
                                                         <?php echo $form->labelEx($model, '   Toll Free NO'); ?>
                                                         <?php echo $form->textField($model, 'tollfree_no_2', array('maxlength' => 11, "class" => "form-control")); ?>
                                                         <?php echo $form->error($model, 'tollfree_no_2'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="col-sm-12">
                                                <h4> A-Z Health+ coordinator from Hospital</h4>
                                            </div>
                                            <div class="col-sm-4">
                                                <b><span>Coordinator Name<strong class="mandatory">*</strong></span></b>

                                                <?php
                                                echo $form->textField($model, 'coordinator_name_1', array("class" => "form-control"));
                                                echo $form->error($model, 'coordinator_name_1');
                                                ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <b><span>Coordinator Mobile<strong class="mandatory">*</strong></span></b>
                                                <?php
                                                echo $form->textField($model, 'coordinator_mobile_1', array('maxlength' => 10, "class" => "form-control", "maxlength" => 10));
                                                echo $form->error($model, 'coordinator_mobile_1');
                                                ?>
                                            </div>
                                            <div class="col-sm-4">

                                                <?php
                                                echo $form->labelEx($model, 'Coordinator Email');
                                                echo $form->textField($model, 'coordinator_email_1', array("class" => "form-control"));
                                                echo $form->error($model, 'coordinator_email_1');
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="col-sm-4">
                                                <?php
                                                echo $form->labelEx($model, '  Coordinator Name');
                                                echo $form->textField($model, 'coordinator_name_2', array("class" => "form-control"));
                                                echo $form->error($model, 'coordinator_name_2');
                                                ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <?php
                                                echo $form->labelEx($model, 'Coordinator Mobile');
                                                echo $form->textField($model, 'coordinator_mobile_2', array('maxlength' => 10, "class" => "form-control", "maxlength" => 10));
                                                echo $form->error($model, 'coordinator_mobile_2');
                                                ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <?php
                                                echo $form->labelEx($model, 'Coordinator Email');
                                                echo $form->textField($model, 'coordinator_email_2', array("class" => "form-control"));
                                                echo $form->error($model, 'coordinator_email_2');
                                                ?>
                                            </div>

                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="col-sm-4">

                                                <b><span>Timing<strong class="mandatory">*</strong></span></b>
                                                <?php
                                                echo $form->radioButtonList($model, 'is_open_allday', array("Y" => "24x7", "N" => "Day-Care"), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '&nbsp;&nbsp;&nbsp;', "class" => "selectopenday", 'template' => '<label class="ui-radio-inline">{input} <span>{label}</span></label>', 'container' => 'div class="ui-radio ui-radio-pink"'));
                                                ?>

                                            </div>
                                            <div class="col-sm-8 hospitaltime" <?php echo $model->is_open_allday == "N" ? "" : 'style="display:none;"'; ?>>

                                                <div class="col-md-6" >
                                                    <?php
                                                    echo $form->labelEx($model, 'Hospital Open Time');
                                                    echo $form->textField($model, 'hospital_open_time', array("class" => "form-control input-group timepick"));
                                                    echo $form->error($model, 'hospital_open_time');
                                                    ?>
                                                </div>
                                                <div class="col-md-6" >
                                                    <?php
                                                    echo $form->labelEx($model, 'Hospital  Close Time');
                                                    echo $form->textField($model, 'hospital_close_time', array("class" => "form-control input-group timepick"));
                                                    echo $form->error($model, 'hospital_close_time');
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">

                                            <div class="col-sm-4">
                                                <b><span>Description<strong class="mandatory">*</strong></span></b>
                                                <?php
                                                echo $form->textArea($model, 'description', array('class' => ' form-control'));
                                                echo $form->error($model, 'description');
                                                ?>
                                            </div>
                                            <div class="col-sm-4">

                                                <b><span>Total No Of Bed<strong class="mandatory">*</strong></span></b>
                                                <?php echo $form->textField($model, 'total_no_of_bed', array('class' => ' form-control')); ?>
                                                <?php echo $form->error($model, 'total_no_of_bed'); ?>
                                            </div>
                                        </div>
                                        <div class="amenities_1 clearfix">
                                            <label class="col-sm-2 control-label">Amenities</label>
                                            <?php $aindex = 0 ?> 
                                            <div class="col-sm-2 amenities_name">
                                                <input type="text" name="UserDetails[amenities][]" class="form-control">
                                            </div>
                                            <div class="col-sm-2 clearfix">
                                                <?php
                                                if ($aindex == 0) {
                                                    echo CHtml::link('ADD', 'javascript:', array('class' => 'addamenities'));
                                                    $aindex++;
                                                } else {
                                                    echo CHtml::link('Remove', 'javascript:', array('class' => 'removeamenities'));
                                                }
                                                ?>

                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="col-md-4">
                                                <b><span>Zip Code<strong class="mandatory">*</strong></span></b>
                                                <?php
                                                if (isset($session['pincode'])) {
                                                    $model->pincode = $session['pincode'];
                                                }
                                                echo $form->textField($model, 'pincode', array("class" => "form-control input-group pincode-id-class"));
                                                echo $form->error($model, 'pincode');
                                                ?>
                                            </div>  
                                            <div class="col-md-4">
                                                <?php
                                                echo $form->labelEx($model, 'State');
                                                $stateArr = array();
                                                $selected = array();
                                                $stateType = Yii::app()->db->createCommand()->select("state_id,state_name")->from("az_state_master")->queryAll();
                                                foreach ($stateType as $row) {
                                                    $stateArr[$row['state_id']] = $row['state_name'];
                                                }
                                                if (isset($session['state_id'])) {
                                                    $model->state_id = $session['state_id'];
                                                }
                                                echo $form->dropDownList($model, 'state_id', $stateArr, array("class" => "form-control state-class", "style" => "width:100%;", "prompt" => "Select State", "data-rule-required" => "true", "data-msg-required" => "Please Select State", 'onchange' => 'getCity()'));
                                                echo $form->error($model, 'state_id');
                                                if (isset($session['state_name'])) {
                                                    $model->state_name = $session['state_name'];
                                                }
                                                echo $form->hiddenField($model, "state_name", array("class" => "state-id-class"));
                                                ?>   

                                            </div>
                                            <div class="col-md-4">
                                                <b><span>City<strong class="mandatory">*</strong></span></b>
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
                                                echo $form->dropDownList($model, 'city_id', $cityArr, array("class" => "form-control cityId city-class", "style" => "width:100%;", "prompt" => "Select City", "data-rule-required" => "true", "data-msg-required" => "Please Select City", 'onchange' => 'getArea()'));
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
                                                <?php
                                                echo $form->labelEx($model, 'Area');
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
                                                echo $form->dropDownList($model, 'area_id', $areaArr, array("class" => "form-control area-class areaId", "style" => "width:100%;", "prompt" => "Select Area", "data-rule-required" => "true", "data-msg-required" => "Please Select Area", 'onchange' => 'getAreaid()'));
                                                echo $form->error($model, 'area_id');
                                                if (isset($session['area_name'])) {
                                                    $model->area_name = $session['area_name'];
                                                }
                                                echo $form->hiddenField($model, "area_name", array("class" => "area-id-class"));
                                                ?>   

                                            </div>
                                            <div class="col-md-4">
                                                <b><span>LandMark<strong class="mandatory">*</strong></span></b>
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
                                                <b><span> Map Address<strong class="mandatory">*</strong></span></b>
                                                <?php
                                                echo $form->textField($model, 'address', array("class" => "form-control input-group"));
                                                echo $form->error($model, 'address');
                                                ?>
                                            </div>


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
                                            <div class="clearfix">&nbsp;</div>
                                            <div class="col-sm-12 clearfix">
                                                <div id="p-map" style="height: 340px;width: 100%;border:1px solid #533223;"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div id="sectionB" class="tab-pane fade">
                                    <div class="col-md-12">
                                        <h4 class="box-title">Service Information</h4>
                                    </div>
                                    <div class="box box-primary">
                                        <div class=" form-group serviceclone clearfix" id="serviceclone">

                                            <?php $rindex = 0;
                                            ?>

                                            <div class=" form-group serviceclone clearfix" id="serviceclone">

                                                <?php
                                                $service = Yii::app()->db->createCommand()->select("service_id,service_name")->from("az_service_master")->where('role_id=:roleid', array(':roleid' => $roleid))->queryAll();
                                                $servicenameArr = CHtml::listData($service, 'service_id', 'service_name');
                                                ?>


                                                
                                                <div class="col-sm-3">
<span class="control-label ">Service</span>
                                                    <select class="form-control servicename" name="UserDetails[userservice][]" data-rule-required = "true" data-msg-required= "Please Select Services">
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
                                                    <span >Discount</span>
                                                    <input type="text" name="UserDetails[discount][]" value=''  class='form-control'>
                                                    <?php echo $form->error($model1, 'service_discount', array('class' => 'col-sm-1 control-label')); ?>
                                                </div>
                                                <div class="col-sm-2  clearfix">
                                                    <span>Corporate Discount</span>
                                                    <input type="text" name="UserDetails[corporate_discount][]" value=''  class='form-control'>
                                                    <?php echo $form->error($model1, 'corporate_discount', array('class' => 'col-sm-1 control-label')); ?>
                                                </div>
                                                <?php
                                                $isallday = array('Yes' => "Yes", 'No' => "No");
                                                ?> 
                                                
                                                <div class ="col-md-2">
                                                    <span class="col-sm-1 control-label">24x7</span>
                                                    <select class="form-control twentyfour" name="UserDetails[twentyfour][]">
                                                        <?php foreach ($isallday as $key => $value) { ?>
                                                            <option value='<?php echo $key; ?>' > <?php echo $value; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <div class="col-sm-2 clearfix">
                                                    <?php
                                                    if ($rindex == 0) {
                                                        echo CHtml::link('ADD', 'javascript:', array('class' => 'addservice'));
                                                        $rindex++;
                                                    } else {

                                                        echo CHtml::link('Remove', 'javascript:', array('class' => 'removeservice'));
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="dropdown" class="tab-pane fade">
                                    <h3>Documents / Certificates</h3>

                                    <div class="col-md-4">
                                        <?php
                                        echo $form->labelEx($model, 'Hospital Registration');
                                        // echo CHtml::image($baseDir . $model3->document, "icon_image", array('width' => 75, 'height' => 75));
                                        echo $form->fileField($model3, 'document', array("class" => "form-control input-group"));
                                        //echo $form->error($model, 'registraiondoc');
                                        ?> 
                                    </div>

                                    <div class="col-md-4">
                                        <?php
                                        echo $form->labelEx($model, 'Other Registration');
                                        echo $form->fileField($model3, 'otherdoc', array("class" => "form-control input-group"));
// echo $form->error($model3, 'otherdoc');
                                        ?> 
                                    </div>
                                    <div class="clearfix">&nbsp;</div>

                                    <div class="textdetails text-center  box-footer clearfix">
                                        <?php
                                        echo CHtml::submitButton("Submit", array('class' => 'btn btn-primary'));
                                        ?>
                                    </div>  

                                </div>

                            </div>
                        </div>
                        <?php $this->endWidget(); ?>


                    </div><!-- box header end -->
                </div><!-- box end -->
            </div> <!-- column col-lg-12 end -->
        </div><!--row end-->
    </section> <!-- section content End -->
</div><!-- tab-content end-->
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
<script>
    $(document).ready(function () {

        $(document).ready(function () {
            $("#myTab li:eq(0) a").tab('show');

        });
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
        $('.addamenities').click(function () {

            var htmlstr = "<br><div class='amentiesname clearfix'><label class ='col-sm-2 control-label clearfix'>Amenities</label><div class='col-sm-2 amenities_name clearfix'> <input type='text' name='UserDetails[amenities][]' class='form-control'></div><i class='fa fa-times delete' aria-hidden='true' onclick='remove_amenities_details(this)'></i> </div>";
            $('.amenities_1:last').after(htmlstr);
        });

        $('.removeamenities').click(function () {
            $('.amenities_1:last').remove();
        });
        $('.addservice').click(function () {
            var htmlstr = "";
            var servicename = $('.servicename').html();
            var twentyfour = $('.twentyfour').html();

            // var dayname = $('.dayname').html();
            htmlstr = "<div class='form-group servicename clearfix'><div class='col-sm-3'><span class='control-label col-sm-1'>Service</span><select class='form-control servicename' name='UserDetails[userservice][]'>" + servicename + "</select></div><div class='col-sm-2'><span class ='col-sm-1 control-label'>Discount</span><input type=text name=UserDetails[discount][] class='form-control'></div><div class='col-sm-2'><span class =' control-label'>Corporate Discount</span><input type=text name=UserDetails[corporate_discount][] class='form-control'></div><div class='col-sm-2'><span class='col-sm-1 control-label'>24x7</span><select class='form-control twentyfour' name='UserDetails[twentyfour][]'>" + twentyfour + "</select></div><i class='fa fa-times delete' aria-hidden='true' onclick='remove_service_details(this)'></i></div>";
            $('#serviceclone').after(htmlstr);
        });
        
        
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
$(".thumbnail").html(html);
$(".imgname").val(resp);
});

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
    function showscontact(htmlobj, currentHtml)
    {
        $(htmlobj).show();
        $(currentHtml).hide();
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

    $('.removeservice').click(function () {
        $('.serviceclone:last').remove();
    });
    function remove_service_details(htmlobj)
    {

        $(htmlobj).parents('.servicename').remove();
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
        alert("hello city");
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
    function showimg()
{

$('#myimg').modal('show');
}

    function remove_amenities_details(htmlobj)
    {

        $(htmlobj).parent('.amentiesname').remove();
    }
</script>
