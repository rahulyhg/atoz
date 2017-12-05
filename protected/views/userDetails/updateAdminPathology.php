<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyA1vr2RVgKBydJQhSo1LUsP3pUcKh4IFGI"></script>
<?php
$clientScriptObj = Yii::app()->clientScript;
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/admin/select2.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/admin/multiple-select.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/admin/bootstrap-datetimepicker.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/admin/jquery.timepicker.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/admin/radio_style.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/admin/bootstrap-datepicker.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/croppie.css');

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/croppie.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/bootstrap.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/jquery.timepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/moment-with-locales.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/jquery.validate.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/bootstrap-datepicker.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/bootstrap-datetimepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/select2.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/multiple-select.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/bootstrap-fileupload.min.js', CClientScript::POS_END);

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
    $("#pathology-update-form").validate({
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

$(".datepick").datepicker({
        autoclose : true

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
         $(".multipleselect4").multipleSelect({
            filter: true,
            multiple: true,
            placeholder: "Select Days",
            width: "100%",
            multipleWidth: 500
        });

     $(".from").datepicker({
            autoclose: true,
            maxDate: new Date(),
            minViewMode: 1,
            format: "mm-yyyy"
        });




 $(".clinictime").datetimepicker({
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
    'id' => 'pathology-update-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>

<section class="content-header">
    <?php if ($role == 6) { ?>
        <h3>Update Pathology</h3>
    <?php } ?>
    <?php if ($role == 7) { ?>
        <h3>Update Diagnostic</h3>
    <?php } ?>


</section>
<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row"><!-- row start-->
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                    <div class="box-header with-border"><!-- box header start -->
                      <?php if($login_role_id != 5){    ?>
                        
                        <div class="text-right"><!--link div-->

                            <?php if ($role == 6) { ?>

                                <?php echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> Manage Pathology ', array('userDetails/managePathology'), array("style" => "color: white;", 'class' => 'btn btn-info')); ?>

                            <?php } ?>
                            <?php if ($role == 7) { ?>

                                <?php echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> Manage Diagnostic ', array('users/manageDiagnostic'), array("style" => "color: white;", 'class' => 'btn btn-info')); ?>

                            <?php } ?>

                        </div><!--link End-->

                      <?php  }  ?>

                        <div class="bs-example">
                            <ul class="nav nav-tabs" id="myTab">
                                <?php if ($role == 6) { ?>
                                    <li><a data-toggle="tab" href="#sectionA">Pathology Details</a></li>
                                <?php } ?>
                                <?php if ($role == 7) { ?>
                                    <li><a data-toggle="tab" href="#sectionA">Diagnostic Details</a></li>
                                <?php } ?>
                                <li ><a data-toggle="tab" href="#sectionB">Services</a></li>
                                <li ><a data-toggle="tab" href="#sectionC">Upload Documents</a></li>
                                <li><a data-toggle="tab" href="#sectionD">Bank Details</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="sectionA" class="tab-pane fade in active">
                                    <h3 class="title text-center">Enter Your Details </h3>
                                    <div class="underline"></div>
                                    <?php if ($role == 6) { ?>
                                        <h4 class="title-details">Pathology Details  </h4>
                                    <?php } ?>
                                    <?php if ($role == 7) { ?>
                                        <h4 class="title-details">Diagnostic Details  </h4>
                                    <?php } ?>
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
                                             <div class="col-sm-3">
                                <div class="fileinput fileinput-new" data-provides="fileinput" style="position: relative;">
                                    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="background: transparent;width:140px;height:140px;text-align: center; margin: auto;border-radius: 50%;overflow: hidden;">
                                        <?php
                                        if (empty($model->profile_image)) {
                                            if ($role == 6) { 
                                                         echo CHtml::image(Yii::app()->request->baseUrl . "/images/icons/icon06.png", "Pathology Photo", array("class" => "img-circle", "width" => "150"));
                                                  } if ($role == 7) {
                                                       echo CHtml::image(Yii::app()->request->baseUrl . "/images/icons/icon03.png", "Diagnostic Photo", array("class" => "img-circle", "width" => "150"));
                                                    } 
                                        } else {
                                            echo CHtml::image(Yii::app()->request->baseUrl . "/uploads/$model->profile_image", "Profile Photo", array("class" => "img-circle", "width" => "150"));
                                            
                                                
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

                                                <?php
                                                
                                                if ($role == 6) {
                                                    echo $form->labelEx($model, 'Pathology Name');
                                                }
                                                if ($role == 7) {
                                                    echo $form->labelEx($model, 'Diagnostic Name');
                                                }

                                                echo $form->textField($model, 'hospital_name', array('maxlength' => 60, 'class' => 'form-control ', "data-rule-required" => "true", "data-msg-required" => "Please Enter Pathology Name"));
                                                echo $form->error($model, 'hospital_name');
                                                ?>
                                            </div>


                                        </div>

                                        <div class="textdetails clearfix">
                                            <div class="col-md-8">
                                                <span style="padding-left:15px">Types Of Company</span>
                                                <?php
                                                if (empty($model->type_of_hospital)) {
                                                    $model->type_of_hospital = 'Franchise';
                                                }
                                                echo $form->radioButtonList($model, 'type_of_hospital', array('Franchise' => 'Franchise', 'Self Own' => 'Self Own', 'Collection Center' => 'Collection Center','Proprietor' =>  'Proprietor', 'Partnership' => 'Partnership', 'LLP' => 'LLP', 'Company' => 'Company' , 'Other' => 'Other'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '&nbsp;&nbsp;&nbsp;', 'class' => 'selecttype', 'container' => 'div class="ui-radio ui-radio-pink"', 'onclick' => 'typeestablishment();'));
                                                ?>
                                                <?php echo $form->error($model, 'type_of_hospital'); ?>                                                
                                            </div>
                                            <div class="col-sm-3 otherrelation" style="display:none">
                                                <b><span>Other</span></b>
                                                <?php echo $form->textField($model, 'other_est_type', array("class" => "form-control")); ?>
                                                <?php echo $form->error($model, 'other_est_type'); ?>   
                                            </div>
                                        </div>


                                        <div class="form-group clearfix">
                                            <div class="col-sm-4">
                                                <b><span>Mobile</span></b>
                                                <?php
                                                echo $form->numberField($model, 'mobile', array("class" => "form-control", "data-rule-required" => "true", "data-msg-required" => "Please Enter Mobile", "maxlength" => 10,"disabled"=>"disable"));
                                                echo $form->error($model, 'mobile');
                                                ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <b><span>Password</span></b>
                                                <?php
                                                $model->password = '';
                                                echo $form->passwordField($model, 'password', array("class" => "form-control", "data-rule-required" => "true", "data-msg-required" => "Please Enter Password","id" => "pass"));
                                                echo $form->error($model, 'password');
                                                ?>
                                            </div>
                                              <div class="col-sm-4">
                                                    <b><span>   Confirm Password<strong class="mandatory">*</strong></span></b>

                                                    <?php echo $form->passwordField($model, 'confirm_password', array('size' => 20, 'maxlength' => 30, "class" => "form-control password", "data-rule-required" => "true", "data-rule-equalTo" => "#pass", "data-rule-regexp" => "^[\w.,-\s\/\']+$")); ?> 
                                                </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="col-sm-4">
                                                <?php if ($role == 6) { ?><b><span>Pathology Registration No</span></b><?php } ?>
                                                <?php if ($role == 7) { ?><b><span>Diagnostic Registration</span></b> <?php } ?>
                                                <?php
                                                echo $form->textField($model, 'hospital_registration_no', array('maxlength' => 60, 'class' => 'form-control ', "data-rule-required" => "true", "data-msg-required" => "Please Enter Registration Number"));
                                                echo $form->error($model, 'hospital_registration_no');
                                                ?>
                                            </div>

                                            <div class="col-sm-4">

                                                <?php if ($role == 6) { ?><b><span>Pathology Establishment</span></b> <?php } ?>
                                                <?php if ($role == 7) { ?><b><span>Diagnostic Establishment</span></b> <?php } ?>
                                                <?php
                                               if(!empty($model->hos_establishment)){
                                                  $model->hos_establishment = date('m-Y',strtotime($model->hos_establishment));
                                              }
                                                echo $form->textField($model, 'hos_establishment', array("class" => "form-control datepick", "data-date-min-view-mode" => "1","data-rule-required" => "true", "data-msg-required" => "Please Select Year of Establishment","data-date-format" => "mm-yyyy"));
                                                echo $form->error($model, 'hos_establishment');
                                                ?>
                                            </div>
                                        </div>
<!--                                        <div class="form-group clearfix">
                                            <div>  <b><span>Authorised Person Name</span></b> </div>
                                            <div class="col-sm-4">
                                                <b><span>First Name</span></b>
                                                <?php
//                                                if (isset($session['first_name'])) {
//                                                    $model->first_name = $session['first_name'];
//                                                }
                                                ?>
                                                <?php //echo $form->textField($model, 'first_name', array("class" => "form-control", "data-rule-required" => "true", "data-msg-required" => "Please Enter Name", "data-rule-regexp" => "^[\w.,-\s\n\/\']+$")); ?>
                                                <?php //echo $form->error($model, 'first_name'); ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <b><span>Last Name</span></b>
                                                <?php
//                                                if (isset($session['last_name'])) {
//                                                    $model->last_name = $session['last_name'];
//                                                }
                                                ?>

                                                <?php //echo $form->textField($model, 'last_name', array("class" => "form-control", "data-rule-required" => "true", "data-msg-required" => "Please Enter L Name", "data-rule-regexp" => "^[\w.,-\s\n\/\']+$")); ?>
                                                <?php //echo $form->error($model, 'last_name'); ?>
                                            </div>


                                        </div>-->






                                        <div class="form-group clearfix">
                                            <div>  <b><span>Contact Details</span></b> </div>
                                            <div class="col-sm-4">

                                                <div class="">
                                                    <b><span> Book You Appointment Contact Number</span></b>
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
                                                    <b><span> Book You Appointment Contact Number</span></b>
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
                                                <div class="email_2 "<?php
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
                                                Your Services Facilitator
                                            </div>
                                            <div class="col-sm-4">
                                                <b><span>1. Name</span></b>
                                                <?php
                                                echo $form->textField($model, 'coordinator_name_1', array("class" => "form-control"));
                                                echo $form->error($model, 'coordinator_name_1');
                                                ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <b><span> Mobile</span></b>
                                                <?php
                                                echo $form->numberField($model, 'coordinator_mobile_1', array("class" => "form-control", "maxlength" => 10));
                                                echo $form->error($model, 'coordinator_mobile_1');
                                                ?>
                                            </div>
                                            <div class="col-sm-4">

                                                <b><span>  Email</span></b>
                                                <?php
                                                echo $form->textField($model, 'coordinator_email_1', array("class" => "form-control"));
                                                echo $form->error($model, 'coordinator_email_1');
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="col-sm-4">
                                                <b><span>2. Name</span></b>
                                                <?php
                                                echo $form->textField($model, 'coordinator_name_2', array("class" => "form-control"));
                                                echo $form->error($model, 'coordinator_name_2');
                                                ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <b><span> Mobile</span></b>
                                                <?php
                                                echo $form->numberField($model, 'coordinator_mobile_2', array("class" => "form-control", "maxlength" => 10));
                                                echo $form->error($model, 'coordinator_mobile_2');
                                                ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <b><span> Email</span></b>
                                                <?php
                                                echo $form->textField($model, 'coordinator_email_2', array("class" => "form-control"));
                                                echo $form->error($model, 'coordinator_email_2');
                                                ?>
                                            </div>

                                        </div>
                                        <div class="form-group clearfix">
                                            <!-- Timing start here -->
                                            <div class="textdetails">
                                                <h4 class="title-details">Timings</h4>
                                                <div class="col-md-12" style="">
                                                    <?php
                                                    $alldaychecked = "";
                                                    if ($model->is_open_allday == 'Y') {
                                                        $alldaychecked = " checked ";
                                                    }
                                                    ?>

                                                    <label><input  type="checkbox" name="UserDetails[is_open_allday]" value="Y" onclick="isalldayopen(this)" class="isall" <?php echo $alldaychecked; ?>> 24x7</label>



                                                </div>
                                                <?php
                                               $dayarr = array("Monday" => "Monday", "Tuesday" => "Tuesday", "Wednesday" => "Wednesday", "Thursday" => "Thursday", "Friday" => "Friday", "Saturday" => "Saturday", "Sunday" => "Sunday");
                                                $userSelectedDay = array();
                                                $uservisit = Yii::app()->db->createCommand()
                                                        ->select('clinic_id,day,clinic_open_time,clinic_close_time,clinic_eve_open_time,clinic_eve_close_time')
                                                        ->from('az_clinic_visiting_details ')
                                                        ->where('doctor_id=:id', array(':id' => $id))
                                                        ->queryAll();
                                                foreach ($uservisit as $row) {
                                                    $userSelectedDay[$row['day']] = array('clinic_open_time' => $row['clinic_open_time'], 'clinic_close_time' => $row['clinic_close_time'], 'clinic_eve_open_time' => $row['clinic_eve_open_time'], 'clinic_eve_close_time' => $row['clinic_eve_close_time']);
                                                }
                                              //  print_r($userSelectedDay);
                                                ?>
                                                <div class="col-md-12 day" style="">
                                                    <ul class="list-inline">
                                                        <?php
                                                       foreach ($dayarr as $key => $value) {
                                $check = '';
                                $hiddenField = '';
                                if (array_key_exists($key, $userSelectedDay)) {
                                    $check = 'checked';
                                       if(empty($userSelectedDay[$value]['clinic_open_time'])){
                                       $userSelectedDay[$value]['clinic_open_time'] = NULL; 
                                    }else{
                                        $userSelectedDay[$value]['clinic_open_time'] = date("h:i A", strtotime($userSelectedDay[$key]['clinic_open_time']));
                                    }
                                    if(empty($userSelectedDay[$value]['clinic_close_time'])){
                                       $userSelectedDay[$value]['clinic_close_time'] = NULL; 
                                     }else{
                                        $userSelectedDay[$value]['clinic_close_time'] = date("h:i A", strtotime($userSelectedDay[$key]['clinic_close_time']));
                                    }
                                    if(empty($userSelectedDay[$value]['clinic_eve_open_time'])){
                                       $userSelectedDay[$value]['clinic_eve_open_time'] = NULL; 
                                    }else{
                                        $userSelectedDay[$value]['clinic_eve_open_time'] = date("h:i A", strtotime($userSelectedDay[$key]['clinic_eve_open_time']));
                                    }
                                    if(empty($userSelectedDay[$value]['clinic_eve_close_time'])){
                                       $userSelectedDay[$value]['clinic_eve_close_time'] = NULL; 
                                     }else{
                                        $userSelectedDay[$value]['clinic_eve_close_time'] = date("h:i A", strtotime($userSelectedDay[$key]['clinic_eve_close_time']));
                                    }
                                    
                                    
                                    $hiddenField = '<span><input type="hidden" name="ClinicVisitingDetails[clinic_open_time][]" value="' . $userSelectedDay[$key]['clinic_open_time'] . '" class="clinic_open_time">
<input type="hidden" name="ClinicVisitingDetails[clinic_close_time][]" value="' . $userSelectedDay[$key]['clinic_close_time'] . '" class="clinic_close_time">'
                                            . '<input type="hidden" name="ClinicVisitingDetails[clinic_eve_open_time][]" value="' . $userSelectedDay[$key]['clinic_eve_open_time'] . '" class="clinic_eve_open_time">'
                                            . '<input type="hidden" name="ClinicVisitingDetails[clinic_eve_close_time][]" value="' . $userSelectedDay[$key]['clinic_eve_close_time'] . '" class="clinic_eve_close_time"></span><br><span>Mon: ' . $userSelectedDay[$value]['clinic_open_time'] . '- ' . $userSelectedDay[$value]['clinic_close_time'] . '<br>Eve:' . ($userSelectedDay[$value]['clinic_eve_open_time']) . ' - ' . ($userSelectedDay[$value]['clinic_eve_close_time']) . '</span>';
                                    
                                }
                                $disabled = "";
                                if (!empty($alldaychecked)) {
                                    $disabled = " disabled ";
                                }
                                echo '<li id="$key" class="weekday"><input type="checkbox" class="day noday" name="ClinicVisitingDetails[day][]" value=' . $key . ' ' . $check . ' ' . $disabled . '>' . $value . $hiddenField . '</li>';
                            }
                                                        ?>
                                                    </ul>

                                                </div>

                                                <div class="modal" id="myModal" role="dialog">
                                                    <div class="modal-dialog modal-md">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title">Visit Details</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="col-md-12">

                    <div class="col-md-6">
                        <div class="col-sm-2" style="z-index:2;position: relative">
                            <label>Morning</label>
                            <input class="clinictime open_time" value="" type="text" />  

                            <label class='text-center'>TO</label>
                            <input class="clinictime close_time" value="" type="text" /> 
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="col-sm-2" style="z-index:2;position: relative">
                            <label>Evening</label> 
                            <input class="clinictime eve_open_time" value="" type="text" />  

                            <label class='text-center'>TO</label>
                            <input class="clinictime eve_close_time" value="" type="text" /> 
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>  
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="clinic_time()">save</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Timing end here -->

                                        </div>
                                        <div class="form-group clearfix">

                                            <div class="col-sm-4">
                                                <b><span>Description</span></b>

                                                <?php echo $form->textArea($model, 'description', array('class' => ' form-control')); ?>
                                                <?php echo $form->error($model, 'description'); ?>
                                            </div>

                                        </div>


                                        <h4 class="title-details">Free OPD</h4>
                                        <div class="form-group clearfix">
                                            <div class="col-md-4"> 
                                                <b><span>Per Day</span></b>
                                                <?php
                                                echo $form->textField($model, 'free_opd_perday', array("class" => "form-control input-group"));
                                                echo $form->error($model, 'free_opd_perday');
                                                ?>
                                            </div>

                                            <div class="col-md-4"><b><span>Preferred Days</span></b>
                                                <?php
// DAY_STR is constant which contains array of Days
                                                $DayArr = explode(";", Constants:: DAY_STR);
                                                $DayFinalArr = array_combine($DayArr, $DayArr);

                                                $DayGroupArr = Yii::app()->db->createCommand()
                                                        ->select('free_opd_preferdays')
                                                        ->from('az_user_details')
                                                        ->where('user_id=:id', array(':id' => $id))
                                                        ->queryColumn();

                                                $DayArr = implode(" ", $DayGroupArr);

                                                $DayArr = explode(",", $DayArr);
                                                ?>

                                                <select multiple="multiple"  class=" input-group multipleselect4" name="UserDetails[free_opd_preferdays][]" style="width:80%;">
                                                    <?php
                                                    foreach ($DayFinalArr as $day) {
                                                        echo "<option value='$day' ";
                                                        if (in_array($day, $DayArr)) {
                                                            echo " selected ";
                                                        }
                                                        echo ">$day</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            
                                            
                                            <div class="col-md-4">
                                                <b><span>Payment Modes</span></b>
                                        <?php
                                        // PAYMENT_TYPE is constant which contains array of payment type
                                        $paymenttypeArr = explode(";", Constants:: PAYMENT_TYPE);
                                        $paymenttypeFinalArr = array_combine($paymenttypeArr, $paymenttypeArr);

                                        $paymentGroupArr = Yii::app()->db->createCommand()
                                                ->select('payment_type')
                                                ->from('az_user_details')
                                                ->where('user_id=:id', array(':id' => $id))
                                                ->queryColumn();

                                        $paymentArr = implode(" ", $paymentGroupArr);

                                        $paymentArr = explode(",", $paymentArr);
                                        ?>

                                        <select multiple="multiple"  class="form-control2 multipleselect3" name="UserDetails[payment_type][]" style="width:80%;">
                                            <?php
                                            foreach ($paymenttypeFinalArr as $payment) {
                                                echo "<option value='$payment' ";
                                                if (in_array($payment, $paymentArr)) {
                                                    echo " selected ";
                                                }
                                                echo ">$payment</option>";
                                            }
                                            ?>
                                        </select>

                                    </div>
                                            
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="col-md-4">
                                                <b><span>Zip Code</span></b>
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
                                                echo $form->dropDownList($model, 'state_id', $stateArr, array("class" => "form-control state-class", "style" => "width:100%;", "prompt" => "Select State", "data-rule-required" => "true", "data-msg-required" => "Please Select State", 'onchange' => 'getCity()'));
                                                echo $form->error($model, 'state_id');
                                                if (isset($session['state_name'])) {
                                                    $model->state_name = $session['state_name'];
                                                }
                                                echo $form->hiddenField($model, "state_name", array("class" => "state-id-class"));
                                                ?>

                                            </div>
                                            <div class="col-md-4">
                                                <b><span>City</span></b>
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
                                                echo $form->dropDownList($model, 'area_id', $areaArr, array("class" => "form-control area-class areaId", "style" => "width:100%;", "prompt" => "Select Area", "data-rule-required" => "true", "data-msg-required" => "Please Select Area", 'onchange' => 'getAreaid()'));
                                                echo $form->error($model, 'area_id');
                                                if (isset($session['area_name'])) {
                                                    $model->area_name = $session['area_name'];
                                                }
                                                echo $form->hiddenField($model, "area_name", array("class" => "area-id-class"));
                                                ?>

                                            </div>
                                            <div class="col-md-4">
                                                <b><span>Landmark</span></b>
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
                                                <b><span>Map Address</span></b>
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
                                    </div>
                                </div>
                                <div id="sectionB" class="tab-pane fade">


                                    <div class=" form-group serviceclone clearfix" id="serviceclone">

                                        <?php $rindex = 0;
                                        ?>
                                        <div class=" form-group serviceclone clearfix" id="serviceclone">

                                            <?php
                                            if (count($serviceUserMapping) > 0) {
                                                $sindex = 0;
                                                $service = Yii::app()->db->createCommand()->select("service_id,service_name")->from("az_service_master")->where('role_id=:roleid', array(':roleid' => $role))->queryAll();
                                                $servicenameArr = CHtml::listData($service, 'service_id', 'service_name');
//                                        echo"<pre>";
//                                        print_r($serviceUserMapping);exit;
                                                foreach ($serviceUserMapping as $key => $serviceDetailObj) {
                                                    ?>

                                                    <div class=" form-group serviceclone clearfix" id="serviceclone">

                                                        <div class="col-sm-3">
                                                            <b><span>Service</span></b>
                                                            <select class="form-control servicename col-sm-2" name="service[]">
                                                                <?php foreach ($servicenameArr as $servicekey => $value) {
                                                                    ?>

                                                                    <option value='<?php echo $servicekey; ?>' <?php echo $serviceDetailObj->service_id == $servicekey ? "selected" : ""; ?>> <?php echo $value; ?></option>
                                                                <?php }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <?php echo $form->error($model, 'service_id'); ?>
                                                        <div class="col-md-2 clearfix">
                                                            <b><span>Discount</span></b>
                                                            <input type="text" name="service_discount[]" value='<?php echo $serviceDetailObj->service_discount ?>' class="form-control" >
                                                            <?php echo $form->error($model, 'service_discount', array('class' => 'col-sm-2 control-label')); ?>
                                                        </div>
                                                        <div class="col-md-2 clearfix">
                                                            <b><span>Corporate Discount</span></b>
                                                            <input type="text" name="corporate_discount[]" value='<?php echo $serviceDetailObj->corporate_discount ?>' class="form-control" >
                                                            <?php echo $form->error($model, 'corporate_discount', array('class' => 'col-sm-2 control-label')); ?>
                                                        </div>
                                                        <?php
                                                       $isallday = array( 'No' => "No",'Yes' => "Yes");
                                                        ?>

                                                        <div class ="col-md-2">
                                                            <b><span>24x7</span></b>
                                                            <select class="form-control twentyfour" name="twentyfour[]">
                                                                <?php foreach ($isallday as $key => $value) { ?>
                                                                    <option value='<?php echo $key; ?>' <?php echo $serviceDetailObj->is_available_allday == $key ? "selected" : ""; ?>> <?php echo $value; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-2 clearfix">
                                                            <?php
                                                            if ($sindex == 0) {
                                                                echo CHtml::link('ADD', 'javascript:', array('class' => 'addservice'));
                                                                $sindex++;
                                                            } else {
                                                                //echo CHtml::link('Remove', 'javascript:', array('class' => 'removeservice'));
                                                                ?>  <i class="fa fa-times" aria-hidden="true" onclick='remove_service(this)'></i>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>

                                                    </div>

                                                    <?php
                                                }
                                            }
                                            ?>


                                        </div>


                                    </div>

                                    <div class="col-md-3 takeHome">
                                            <b><span>Take Home Service</span></b>

<?php echo $form->dropDownList($model, 'take_home', array("No" => "No", "Yes" => "Yes"), array("class" => "form-control"));
?>
                                        </div>

                                        <div class="col-md-3">
                                            <b><span>24x7 Emergency</span></b>
<?php echo $form->dropDownList($model, 'emergency', array("No" => "No", "Yes" => "Yes"), array("class" => "form-control"));
?>
                                        </div>
                                        <div class="clearfix"></div>

                                        <div class="textdetails clearfix freeCharge" style="display:none">
                                            <div class="col-md-3 freeSelection">
                                                <b><span>Free/Charge</span></b>

<?php echo $form->dropDownList($model, 'blood_bank_no', array("Free" => "Free", "Charge" => "Charge"), array("class" => "form-control"));
?>
                                            </div>

                                            <div class="col-md-3 chargeSelection" style="display:none"> 
                                                <b><span>Charge</span></b>
<?php echo $form->textField($model, 'extra_charges', array("class" => "form-control", "data-msg-required" => "Please Check Your Input", "data-rule-regexp" => "^[\d]+$", "value" => "")); ?>
                                            </div>

                                        </div>


<!--                                        <div class="textdetails clearfix">
                                            <br><h4 class="title-details">Discount</h4>
                                            <div class="col-md-4"> 
                                                <b><span>Corporate </span></b>
                                                <?php
                                                // echo $form->textField($model, 'opd_no', array("class" => "form-control", "data-msg-required" => "Please Check Your Input", "data-rule-regexp" => "^[\d]+$"));
                                                ?>
                                            </div>

                                        </div>-->

                                </div>
                                <div id="sectionC" class="tab-pane fade">
                                    <h3 class="title">Documents / Certificates</h3>

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



                                </div>
                                <div id="sectionD" class="tab-pane fade">

                                    <div class="mySlides"  id="slide4">
                                        <h3 class="title">Bank A/C Details</h3>

                                        <div class="textdetails">
                                            <div class="col-md-4">
                                                <b><span>Acount Holder Name</span></b>
                                                <?php
                                                if (isset($session['acc_holder_name'])) {
                                                    $model7->acc_holder_name = $session['acc_holder_name'];
                                                }
                                                echo $form->textField($model7, 'acc_holder_name', array("class" => "form-control"));
                                                echo $form->error($model7, 'acc_holder_name');
                                                ?>
                                            </div>
                                            <div class="col-md-4">
                                                <b><span>Bank Name</span></b>
                                                <?php
                                                if (isset($session['bank_name'])) {
                                                    $model7->bank_name = $session['bank_name'];
                                                }
                                                echo $form->textField($model7, 'bank_name', array("class" => "form-control"));
                                                echo $form->error($model7, 'bank_name');
                                                ?>
                                            </div>
                                            <div class="col-md-4">
                                                <b><span>Branch Name</span></b>
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
                                                <b><span>Acount No</span></b>
                                                <?php
                                                if (isset($session['account_no'])) {
                                                    $model7->account_no = $session['account_no'];
                                                }
                                                echo $form->textField($model7, 'account_no', array("class" => "form-control"));
                                                echo $form->error($model7, 'account_no');
                                                ?>

                                            </div>
                                            <div class="col-md-4">
                                                <b><span>Account Type</span></b>
                                                <?php
                                                if (isset($session['account_type'])) {
                                                    $model7->account_type = $session['account_type'];
                                                }
                                                echo $form->textField($model7, 'account_type', array("class" => "form-control"));
                                                echo $form->error($model7, 'account_type');
                                                ?>

                                            </div>
                                            <div class="col-md-4">
                                                <b><span>IFSC Code</span></b>
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
                                            <input type="checkbox" name="acceptcondition"  class="agree required"> Agree to Terms & Conditions
                                            <p><span id="agree1" class="error1"></span></p>
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="clearfix"></div>



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
                        <?php $this->endWidget(); ?>
                    </div><!-- box header end -->
                </div><!-- box end -->
            </div><!-- column col-lg-12 end -->


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
<script>
    var dayhtml;
    $(function () {


//        $('.day:checkbox').on('click', function (e) {
//            if (e.target.checked) {
//                dayhtml = $(this);
//                var day = $('.day:checked').val();
//                console.log(dayhtml);
//                $('#myModal1').modal();
//
//            }
//        });

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

        $('.addservice').click(function () {
            var htmlstr = "";
            var servicename = $('.servicename').html();
            var twentyfour = $('.twentyfour').html();

            // var dayname = $('.dayname').html();
            htmlstr = "<div class='form-group servicename clearfix'><div class='col-sm-3'><b><span>Service</span></b><select class='form-control servicename' name='service[]'>" + servicename + "</select></div><div class='col-sm-2'><b><span>Discount</span></b><input type=text name='service_discount[]' class='form-control'></div><div class='col-sm-2'><b><span>Corporate Discount</span></b><input type=text name='corporate_discount[]' class='form-control'></div><div class='col-sm-2'><b><span>24x7</span></b><select class='form-control twentyfour' name='twentyfour[]'>" + twentyfour + "</select></div><div class='col-sm-2'><i class=\"fa fa-times\" aria-hidden=\"true\" onclick='remove_service_details(this)'></i></div></div>";
            $('#serviceclone').after(htmlstr);
        });
        $('.removeservice').click(function () {
            $('.serviceclone:last').remove();
        });


        
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
        

$('.takeHome').change(function () {
                                    var takeHome = $('.takeHome option:selected').val();


                                    if (takeHome == 'Yes') {
                                        $('.freeCharge').show();
                                    } else {
                                        $('.freeCharge').hide();
                                    }
                                });

                                $('.freeSelection').change(function () {
                                    var chargeselection = $('.freeSelection option:selected').val();
                                    if (chargeselection == 'Charge') {
                                        $('.chargeSelection').show();
                                    } else {
                                        $('.chargeSelection').hide();
                                    }

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

     function showimg()
    {
        $('#myimg').modal('show');
    }

    function remove_service(htmlobj)
    {
        $('.serviceclone:last').remove();
    }

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
         hiddenhtml = "<span ><input type='hidden'  name='ClinicVisitingDetails[clinic_open_time][]' value='" + open_time + "' class='clinic_open_time'><input type='hidden'  name='ClinicVisitingDetails[clinic_close_time][]' value='" + close_time + "' class='clinic_close_time'><input type='hidden'  name='ClinicVisitingDetails[clinic_eve_open_time][]' value='" + eve_open_time + "' class='clinic_eve_open_time'><input type='hidden'  name='ClinicVisitingDetails[clinic_eve_close_time][]' value='" + eve_close_time + "' class='clinic_eve_close_time'></span><div class='timing-list timeing'>Mon:" + open_time + " - " + close_time + "<br>Evn:" + eve_open_time + " - " + eve_close_time + "</div><br>"
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
        function typeestablishment()
{

    var user1 = $('.selecttype:checked').val();

    if (user1 == 'Other')
    {

        $(".otherrelation").show();
    }
    else
    {
        $(".otherrelation").hide();
    }

}
</script>
