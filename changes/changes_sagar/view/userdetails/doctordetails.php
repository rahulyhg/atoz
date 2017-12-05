<?php
/* @var $this ClinicDetailsController */
/* @var $model ClinicDetails */
/* @var $form CActiveForm */

$session = new CHttpSession;
$session->open();

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/select2.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/multiple-select.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/bootstrap-datetimepicker.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jquery.timepicker.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/radio_style.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/bootstrap-datepicker.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/croppie.css');

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/croppie.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/moment-with-locales.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.validate.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-datepicker.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-datetimepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/select2.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/multiple-select.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.timepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-fileupload.min.js', CClientScript::POS_END);
$setDataLink = Yii::app()->createUrl("userDetails/doctorDetails");
Yii::app()->clientScript->registerScript('myjavascript', '
    
  $.validator.addMethod(
        "regexp",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Please check your input."
    );
    $("#user-details-form1").validate({
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

 function showNextSlide(nextslideid, tabid){
        
       if($("#user-details-form1").valid()){
       
            $.ajax({
                type: "POST",
                url: "' . $setDataLink . '",
                data: $("#user-details-form1").serialize(),
                //dataType: "json",
                success: function (result)
                {
                    $(".mySlides").hide();
                    $("#"+nextslideid).show();
                    $("html, body").animate({ scrollTop: $(".tab-content").offset().top }, 1500);
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
           // placeholder: "Select Speciality",
            width: "100%",
            multipleWidth: 500
        });
        $(".multipleselect2").multipleSelect({
            filter: true,
            multiple: true,
            placeholder: "Select Degree",
            width: "100%",
            multipleWidth: 500
        });
         $(".multipleselect3").multipleSelect({
            filter: true,
            multiple: true,
      //placeholder: "Select payment type",
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
        
  $(".clinictime").datetimepicker({
                    format: "LT"
                });
              
$(".from").datepicker({
    autoclose: true,
    maxDate :new Date(),
    minViewMode: 1,
    format: "mm-yyyy"
    });

$(".to").datepicker({
    autoclose: true,
    maxDate :new Date(),
    minViewMode: 1,
    format: "mm-yyyy"

});

$(".birth_date").datetimepicker({
        //inline: true,
        sideBySide: true,
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
        },
        stepping : 5,
      format:"DD-MM-YYYY",
      maxDate :new Date(),
    });
    $(".birth_date").on("dp.change",function(e){
    var birth_date_str=$("#UserDetails_birth_date").data("DateTimePicker").date();
    var birth_date=new Date(birth_date_str);
    var birth_year=birth_date.getFullYear();
     var birth_month=birth_date.getMonth();
    var date=new Date();
    var current_year=date.getFullYear();
    var current_month=date.getMonth();
    var diffyear = current_year-birth_year;
   var diffmonth=current_month-birth_month;
   if(diffmonth<0)
    {
    diffyear=diffyear-1;
    diffmonth=12+diffmonth;
    }
   $(".age1").val(diffyear + " years, " + diffmonth + " month");

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

', CClientScript::POS_END);
?>

<!-- Start intro section -->
<section id="intro" class="section-details">
    <div class="overlay">
        <div class="container">
            <div class="main-text">

                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'user-details-form1',
                    'action' => array('userDetails/sessionDoctorDetails'),
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
                                    echo CHtml::image(Yii::app()->request->baseUrl . "/images/icons/icon01.png", "Profile Photo", array("class" => "img-circle", "width" => "150"));
                                }
                                ?>

                            </div>
                            <span class=" btn-file" style="position: absolute;top: 60%;right: 26px;border: 1px solid #888;padding:0px;">

                                <button type="button" onclick="showimg();" class="fileinput-new">Add</button>

                                <input type ="hidden" class="imgname" name="profile">
                                <?php echo $form->error($model, 'profile_image');
                                ?>

                            </span>
                        </div>
                        <ul class="nav nav-pills nav-stacked "  id="myTabs">
                            <li class="active"><a href="#tab_a" data-toggle="pill">Personal Details &nbsp; <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                                </a></li>
                            <li><a href="#tab_b" data-toggle="pill">Clinics </a></li>
                            <li><a href="#tab_c" data-toggle="pill">Upload Documents </a></li>                                  
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
                                    <h4 class="title-details">Personal Details  </h4>
                                    <div class="textdetails">
                                        <div class="col-md-4">
                                            <span>First Name</span>
                                            <?php
                                            if (isset($session['first_name'])) {
                                                $model->first_name = $session['first_name'];
                                            }
                                            ?>
                                            <?php
                                            echo"<div class=col-md-2>Dr.</div>";
                                            echo "<div class=col-md-10>";
                                            echo $form->textField($model, 'first_name', array("class" => "w3-input input-group", "data-msg-required" => "Please Enter Name", "data-rule-regexp" => "^[\w.,-\s\n\/\ ']+$"));
                                            echo"</div><div class=clearfix>&nbsp;</div>";
                                            ?>
                                            <?php echo $form->error($model, 'first_name'); ?>
                                        </div>
                                        <div class="col-md-4">
                                            <span>Last Name</span>
                                            <?php
                                            if (isset($session['last_name'])) {
                                                $model->last_name = $session['last_name'];
                                            }
                                            ?>

                                            <?php echo $form->textField($model, 'last_name', array("class" => "w3-input input-group", "data-msg-required" => "Please Enter Last Name", "data-rule-regexp" => "^[\w.,-\s\n\/\ ']+$")); ?>
                                            <?php echo $form->error($model, 'last_name'); ?>                                             
                                        </div>
                                        <div class="col-md-4">
                                            <span style="padding-left:15px; ">Gender</span>
                                            <?php
                                            if (empty($model->gender)) {
                                                $model->gender = 'Male';
                                            }
                                            echo $form->radioButtonList($model, 'gender', array('Male' => 'Male', 'Female' => 'Female'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '&nbsp;&nbsp;&nbsp;', 'container' => 'div class="ui-radio ui-radio-pink"'));
                                            ?>
                                            <?php echo $form->error($model, 'gender'); ?>                                                
                                        </div>
                                    </div> <!--end textdetails-->
                                    <div class="clearfix"></div>
                                    <div class="textdetails">
                                        <div class="col-md-3" >
                                            <span>Date of Birth</span>                                                                <?php echo $form->textField($model, 'birth_date', array("data-format" => "dd-MM-yyyy", "class" => "birth_date w3-input input-group")); ?>
                                            <?php echo $form->error($model, 'birth_date'); ?> 
                                        </div>

                                        <div class="col-md-3" >
                                            <span>Blood Group</span>
                                            <?php echo $form->dropDownList($model, 'blood_group', array('O+' => 'O+', 'O-' => 'O-', 'A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'AB+' => 'AB+', 'AB-' => 'AB-'), array('class' => 'otherselect form-control w3-input input-group', 'prompt' => 'Select Blood Group', "data-msg-required" => "Please select Blood Group")); ?>
                                            <?php echo $form->error($model, 'blood_group'); ?>                                                                  <?php echo $form->hiddenField($model, 'age', array("class" => "form-control age1")); ?>
                                        </div>
                                        <div class="col-md-3">
                                            <span>Dr. Registration Number</span>   
                                            <?php
                                            if (isset($session['doctor_registration_no'])) {
                                                $model->doctor_registration_no = $session['doctor_registration_no'];
                                            }
                                            ?>

                                            <?php echo $form->textField($model, 'doctor_registration_no', array("class" => "w3-input input-group", "data-msg-required" => "Please Enter registration no", "data-rule-regexp" => "^[\w.,-\s\/\']+$")); ?>
                                            <?php echo $form->error($model, 'doctor_registration_no'); ?>                                             
                                        </div> 
                                        <div class="col-md-3">
                                            <span>Add Photo</span>
                                            <?php
                                            echo $form->fileField($model3, 'doc_photo[]', array("class" => "w3-input input-group", "multiple" => "multiple"));
                                            echo $form->error($model3, 'doc_photo');
                                            ?> 
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>

                                    <h4 class="title-details">Login Details  </h4>
                                    <div class="textdetails">
                                        <div class="col-md-4">
                                            <span>Mobile Number<strong class="mandatory">*</strong></span> 
                                            <?php
                                            if (isset($session['mobile'])) {
                                                $model->mobile = $session['mobile'];
                                            }
                                            echo $form->numberField($model, 'mobile', array('maxlength' => 10, "class" => "w3-input input-group mobileclass ", "data-msg-required" => "Please Enter Mobile", "data-rule-required" => "true", "onblur" => "chk_mobile(this)"));
                                            ?> 
                                            <span id="mobileno" style="color: red;"></span>
                                            <?php echo $form->error($model, 'mobile'); ?>

                                        </div>
                                        <div class="col-md-4">
                                            <span>Password<strong class="mandatory">*</strong></span>
                                            <?php
                                            if (isset($session['password'])) {
                                                $model->password = $session['password'];
                                            }
                                            echo $form->passwordField($model, 'password', array('size' => 20, 'maxlength' => 30, "class" => "w3-input input-group password", "data-rule-required" => "true", "data-msg-required" => "Please Enter Password", "data-rule-regexp" => "^[\w.,-\s\/\']+$","id"=>"pass"));
                                            ?> 

                                            <?php echo $form->error($model, 'password'); ?>
                                            
                                            

                                        </div>
                                        <div class="col-md-4">
                                            <span>   Confirm Password<strong class="mandatory">*</strong></span>

    <?php  echo $form->passwordField($model, 'confirm_password', array('size' => 20, 'maxlength' => 30, "class" => "w3-input input-group password", "data-rule-required" => "true", "data-rule-equalTo" => "#pass", "data-rule-regexp" => "^[\w.,-\s\/\']+$"));?> 
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <h4 class="title-details">Contact Details  </h4>
                                    <div class="textdetails">
                                        <div class="col-md-5 contacts">
                                            <span>Book Your Appointment Mobile Number</span>
                                            <?php
                                            if (isset($session['apt_contact_no_1'])) {
                                                $model->apt_contact_no_1 = $session['apt_contact_no_1'];
                                            }
                                            echo $form->textField($model, 'apt_contact_no_1', array('maxlength' => 30, "class" => "w3-input input-group", "data-msg-required" => "Please Enter contact no", "data-rule-regexp" => "^[7-9]{1}[0-9]{9,29}$"));
                                            echo $form->error($model, 'apt_contact_no_1');
                                            ?>
                                            <a class="btn-block" href="javascript:" onclick="$('.contact_no_2').show();
                                                    $(this).hide();"><i class="fa fa-plus" aria-hidden="true"></i> Add Contact Number </a>
                                            <div class="contact_no_2 " hidden="">
                                                <br>
                                                <?php
                                                if (isset($session['apt_contact_no_2'])) {
                                                    $model->apt_contact_no_2 = $session['apt_contact_no_2'];
                                                }
                                                echo $form->textField($model, 'apt_contact_no_2', array('maxlength' => 30,"class" => "w3-input input-group", "data-msg-required" => "Please Enter contact no", "data-rule-regexp" => "^[7-9]{1}[0-9]{9,29}$"));
                                                echo $form->error($model, 'apt_contact_no_2');
                                                ?>
                                            </div>
                                        </div>


                                        <div class="col-md-4 emails">
                                            <span>Email Address</span>
                                            <?php
                                            if (isset($session['email_1'])) {
                                                $model->email_1 = $session['email_1'];
                                            }
                                            echo $form->textField($model, 'email_1', array('maxlength' => 100, "class" => "form-control", "data-rule-regexp" => "[/^.{1,}@.{2,}\..{2,}/]"));
                                            echo $form->error($model, 'email_1');
                                            ?>
                                            <a class="btn-block" href="javascript:" onclick="$('.email_2').show();
                                                    $(this).hide();"><i class="fa fa-plus" aria-hidden="true"></i> Add Email Address </a>

                                            <div class="email_2" style="display:none;">
                                                <br>
                                                <?php
                                                if (isset($session['email_2'])) {
                                                    $model->email_2 = $session['email_2'];
                                                }
                                                echo $form->textField($model, 'email_2', array('size' => 30, 'maxlength' => 200, "class" => "w3-input input-group", "data-msg-required" => "Please Enter email"));
                                                echo $form->error($model, 'email_2');
                                                ?>
                                            </div>    
                                        </div>
                                    </div> <!--end textdetails-->
                                    <div class="clearfix"></div>
                                    <div class="textdetails">

                                        <div class="col-md-4">
                                            <span>Specialty</span>
                                            <?php
                                            $speArr = array();
                                            $selected = array();
                                            $sepeType = Yii::app()->db->createCommand()->select("speciality_id,speciality_name")->from("az_speciality_master")->where("is_active=1")->queryAll();
                                            foreach ($sepeType as $row) {
                                                $speArr[$row['speciality_id']] = $row['speciality_name'];
                                            }

                                            if (isset($session['speciality']) && is_array($session['speciality'])) {
                                                foreach ($session['speciality'] as $speciality) {
                                                    $selected[$speciality] = array('selected' => 'selected');
                                                }
                                            }
                                            echo $form->dropDownList($model, 'speciality[]', $speArr, array("class" => "w3-input multipleselect1 speciality-class", "id" => "speciality_id", "style" => "width:100%;", "multiple" => true, 'options' => $selected, 'onchange' => 'getSubSpeciality()'));
                                            echo $form->error($model, 'speciality');
                                            ?>                                                   
                                        </div>

                                        <div class="col-md-4">
                                            <span>Sub-Specialty</span> 
                                            <?php
                                            $speArr = array();
                                            $subSpeciality = Yii::app()->db->createCommand()->select("sub_speciality_id,sub_speciality_name")->from("az_sub_speciality")->queryAll();
                                            foreach ($subSpeciality as $row) {
                                                $subArr[$row['sub_speciality_id']] = $row['sub_speciality_name'];
                                            }

                                            if (isset($session['sub_speciality']) && is_array($session['sub_speciality'])) {
                                                foreach ($session['sub_speciality'] as $subspeciality) {
                                                    $selected[$subspeciality] = array('selected' => 'selected');
                                                }
                                            }

                                            echo $form->dropDownList($model, 'sub_speciality[]', $speArr, array("class" => "w3-input multipleselect1 specialClass", "multiple" => true, "style" => "width:100%;", "data-msg-required" => "Please Select sub_Specialty", 'options' => $selected));
                                            echo $form->error($model, 'sub_speciality');
                                            ?>                                                   
                                        </div>

                                        <div class="col-md-4">
                                            <span>Degree</span>
                                            <?php
                                            $degreeArr = array();
                                            $selected = array();
                                            $degreeType = Yii::app()->db->createCommand()->select("degree_id,degree_name")->from("az_degree_master")->queryAll();
                                            foreach ($degreeType as $row) {
                                                $degreeArr[$row['degree_id']] = $row['degree_name'];
                                            }

                                            if (isset($session['degree']) && is_array($session['degree'])) {
                                                foreach ($session['degree'] as $degree) {
                                                    $selected[$degree] = array('selected' => 'selected');
                                                }
                                            }
                                            echo $form->dropDownList($model, 'degree[]', $degreeArr, array("class" => "w3-input multipleselect2", "style" => "width:100%;", "multiple" => true, "data-msg-required" => "Please Select Degree", 'options' => $selected));
                                            echo $form->error($model, 'degree');
                                            ?>                                                   
                                        </div>


                                    </div> <!--end textdetails-->
                                    <div class="clearfix">&nbsp;</div>
                                    <div class="clearfix">&nbsp;</div>
                                    <h4 class="title-details">Experience</h4>
                                    <div class="textdetails">
                                        <div class="addexper">

                                            

                                            <div class="col-md-8">
                                                <span> Select Year & Month</span>
                                                <div class="">
                                                    <div class="col-md-4">
                                                        <?php
                                                        if (isset($session['work_from'])) {
                                                            $model1->work_from = $session['work_from'];
                                                        }  ?>
                                                       <select name="DoctorExperience[work_from]" class="expyear w3-input"></select>
                                                  <?php      echo $form->error($model1, 'work_from');
                                                        ?>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <?php
                                                        if (isset($session['work_to'])) {
                                                            $model1->work_to = $session['work_to'];
                                                        }
                                                        ?>
                                                        <select name="DoctorExperience[work_to]" class="expmonth w3-input"></select>
                                                        <?php
                                                        echo $form->error($model1, 'work_to');
                                                        ?>

                                                    </div>
                                                </div>           
                                            </div>

                                            



                                            
                                        </div> <!--end textdetails-->
                                        <div class="clearfix"></div>

                                    </div>
                                    <div class="clearfix"></div>
                                    
                                   

                                    <div class="clearfix"></div>

<!--                                    <a href="<?php echo $this->createUrl('UserDetails/clinicDetails', array('id' => 3)); ?>"><i class="fa fa-plus" aria-hidden="true"></i>Add Clinic</a>-->
                                    <div class="button-arrow">
                                        <button class="w3-button w3-black w3-display-right" onClick="showNextSlide('slide2', 'tab_b')" type="button">&#10095;</button>
                                    </div>
                                </div> <!--end mySlides-->
                            </div> <!--end w3-display-container-->
                        </div><!--end tab_a -->                    
                        <div class="clearfix"></div>
                        <div class="tab-pane" id="tab_b">
                            <div class="w3-content w3-display-container">
                                <div class="mySlides"  id="slide2">   <!--    id="slide2"-->

                                    <h3 class="title">Clinic Details </h3>
                                    <div class="underline"></div>                                            	

                                    <div class="textdetails">
                                        <div class="col-md-10">
                                            <span>Clinic Name</span>
                                            <?php
                                            if (isset($session['clinic_name'])) {
                                                $model2->clinic_name = $session['clinic_name'];
                                            }
                                            echo $form->textField($model2, 'clinic_name', array('size' => 60, 'maxlength' => 200, "data-msg-required" => "Please enter Clinic Name"));
                                            echo $form->error($model2, 'clinic_name');
                                            ?>
                                        </div>                                                	
                                    </div>

                                    <div class="clearfix"></div>
                                    <div class="textdetails">
                                        <div class="col-md-3">
                                            <span>Services</span>
                                            <?php
                                            $serviceArr = array();
                                            $selected = array();
                                            $serviceType = Yii::app()->db->createCommand()->select("service_id,service_name")->from("az_service_master")->where('role_id=:roleid', array(':roleid' => $roleid))->queryAll();

                                            foreach ($serviceType as $row) {
                                                $serviceArr[$row['service_id']] = $row['service_name'];
                                            }
                                            echo $form->dropDownList($model4, 'service_id[]', $serviceArr, array("class" => "w3-input serviceoption", "style" => "width:100%;", "prompt" => "Select Services", "data-msg-required" => "Please Select Services"));
                                            echo $form->error($model, 'service_id');
                                            ?>   
                                        </div>   

                                        <div class="col-md-3">
                                            <span>Discount %</span>
                                            <?php
                                            if (isset($session['service_discount'])) {
                                                $model4->service_discount = $session['service_discount'];
                                            }
                                            echo $form->textField($model4, 'service_discount[]', array("class" => "w3-input input-group", "data-rule-regexp" => "^0*(?:[1-9][0-9]?|100)$", "data-msg-required" => "Invalid Discount Fee"));
                                            echo $form->error($model4, 'service_discount');
                                            ?> 
                                        </div>
                                         <div class="col-md-3">
                                            <span>Corporate Discount %</span>
                                            <?php
                                            if (isset($session['corporate_discount'])) {
                                                $model4->corporate_discount = $session['corporate_discount'];
                                            }
                                            echo $form->textField($model4, 'corporate_discount[]', array("class" => "w3-input input-group", "data-rule-regexp" => "^0*(?:[1-9][0-9]?|100)$", "data-msg-required" => "Invalid Discount Fee"));
                                            echo $form->error($model4, 'corporate_discount');
                                            ?> 
                                        </div>
                                        <div class="col-md-2">
                                            <span>24x7</span>
                                            <?php
                                            if (isset($session['twentyfour'])) {
                                                $model4->is_available_allday = $session['twentyfour'];
                                            }
                                            echo $form->dropDownList($model4, 'twentyfour[]', array("No" => "No", "Yes" => "Yes"), array("class" => "w3-input input-group"));
                                            echo $form->error($model4, 'twentyfour');
                                            ?> 
                                        </div>
                                        <div class="clearfix">&nbsp;</div>
                                        <div class="col-md-12 btnaddservice">
                                            <a class="" href="javascript:" onclick="addMoreServices(this);"><i class="fa fa-plus" aria-hidden="true"></i> Add Services </a>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <!-- Timing start here -->
                                    <div class="textdetails">
                                        <h4 class="title-details">Timings</h4>
                                        <div class="col-md-12" style=""> 
                                            <label><input  type="checkbox" name="ClinicDetails[alldayopen]" value="Y" onclick="isalldayopen(this)" class="isall"> 24x7</label>
                                        </div>

                                        <div class="col-md-12 day" style="">
                                            <ul class="list-inline">
                                                <li id="mon" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="Monday"> Monday</li>
                                                <li id="tue" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="Tuesday"> Tuesday</li>
                                                <li id="wed" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="Wednesday"> Wednesday</li>
                                                <li id="thur" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="Thursday"> Thursday</li>
                                                <li id="fri" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="Friday"> Friday</li>
                                                <li id="sat" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="Saturday"> Saturday</li>
                                                <li id="sun" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="Sunday"> Sunday</li>
                                            </ul>

                                        </div>




                                    </div>
                                    <!-- Timing end here -->
                                    <div class="clearfix"></div>
                                    <div class="textdetails clearfix">
                                        <h4 class="title-details">Location</h4>
                                        <div class="col-md-4">
                                            <span>Zip Code</span>
                                            <?php
                                            if (isset($session['pincode'])) {
                                                $model2->pincode = $session['pincode'];
                                            }
                                            echo $form->textField($model2, 'pincode', array("class" => "w3-input input-group pincode-id-class","maxlength" => 6));
                                            echo $form->error($model2, 'pincode');
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
                                                $model2->state_id = $session['state_id'];
                                            }
                                            echo $form->dropDownList($model2, 'state_id', $stateArr, array("class" => "w3-input state-class", "style" => "width:100%;", "prompt" => "Select State", "data-msg-required" => "Please Select State", 'onchange' => 'getCity()'));
                                            echo $form->error($model2, 'state_id');
                                            if (isset($session['state_name'])) {
                                                $model2->state_name = $session['state_name'];
                                            }
                                            echo $form->hiddenField($model2, "state_name", array("class" => "state-id-class"));
                                            ?>   

                                        </div>
                                        <div class="col-md-4">
                                            <span>City</span>
                                            <?php
                                            $cityArr = array();

                                            if (isset($session['city_id'])) {
                                                $model2->city_id = $session['city_id'];
                                            }
                                            echo $form->dropDownList($model2, 'city_id', $cityArr, array("class" => "w3-input cityId city-class", "style" => "width:100%;", "prompt" => "Select City", "data-msg-required" => "Please Select City", 'onchange' => 'getArea()'));
                                            echo $form->error($model2, 'city_id');
                                            if (isset($session['city_name'])) {
                                                $model2->city_name = $session['city_name'];
                                            }
                                            echo $form->hiddenField($model2, "city_name", array("class" => "city-id-class"));
                                            ?>

                                        </div>
                                    </div>
                                    <div class="textdetails">

                                        <div class="col-md-4">
                                            <span>Area</span>
                                            <?php
                                            $areaArr = array();
                                            $selected = array();
                                            $stateType = Yii::app()->db->createCommand()->select("area_id,area_name")->from("az_area_master")->queryAll();
                                            foreach ($stateType as $row) {
                                                $areaArr[$row['area_id']] = $row['area_name'];
                                            }
                                            if (isset($session['area_id'])) {
                                                $model2->area_id = $session['area_id'];
                                            }
                                            echo $form->dropDownList($model2, 'area_id', $areaArr, array("class" => "w3-input area-class areaId", "style" => "width:100%;", "prompt" => "Select Area", "data-msg-required" => "Please Select Area", 'onchange' => 'getAreaid()'));
                                            echo $form->error($model2, 'area_id');
                                            if (isset($session['area_name'])) {
                                                $model2->area_name = $session['area_name'];
                                            }
                                            echo $form->hiddenField($model2, "area_name", array("class" => "area-id-class"));
                                            ?>   
                                        </div>
                                        <div class="col-md-4">
                                            <span>Landmark</span>
                                            <?php
                                            if (isset($session['landmark'])) {
                                                $model2->landmark = $session['c_landmark'];
                                            }
                                            echo $form->textField($model2, 'landmark', array("class" => "w3-input input-group", "data-msg-required" => "Please enter Landmark"));
                                            echo $form->error($model2, 'landmark');
                                            ?>
                                        </div>
                                        <div class="col-md-4">
                                            <span>Street Address</span>
                                            <?php
                                            if (isset($session['address'])) {
                                                $model2->address = $session['c_address'];
                                            }
                                            echo $form->textField($model2, 'address', array("class" => "w3-input input-group", "data-msg-required" => "Please enter Address"));
                                            echo $form->error($model2, 'address');
                                            ?>

                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="textdetails">
                                        <span>Payment Modes</span>
                                        <div class="col-md-4">
                                            <?php
                                            // PAYMENT_TYPE is constant which contains array of payment type
                                            $paymenttypeArr = explode(";", Constants:: PAYMENT_TYPE);
                                            $paymenttypeFinalArr = array_combine($paymenttypeArr, $paymenttypeArr);
                                            $selected = array("A2Z E-money" => array('selected' => 'selected', "disabled" => true));
                                            echo $form->dropDownList($model2, 'payment_type[]', $paymenttypeFinalArr, array("class" => "multipleselect3 form-control2", 'multiple' => 'multiple', "data-msg-required" => "Please Select Payent Type", 'options' => $selected));

                                            echo $form->error($model2, 'payment_type');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="textdetails">
                                        <div class="col-md-4"> 
                                            <span>OPD Consultation Fees</span>
                                            <?php
                                            echo $form->textField($model2, 'opd_consultation_fee', array("class" => "w3-input input-group", "data-msg-required" => "Please Consultation Fee", "data-rule-regexp" => "^[\d]+$"));
                                            echo $form->error($model2, 'opd_consultation_fee');
                                            ?>
                                        </div>
                                        <div class="col-md-4"> 
<!--                                            <span>Discount %</span>-->
                                            <?php
                                            echo $form->hiddenField($model2, 'opd_consultation_discount', array("class" => "w3-input input-group", "data-rule-regexp" => "^0*(?:[1-9][0-9]?|100)$"));
                                            echo $form->error($model2, 'opd_consultation_discount');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="clearfix">&nbsp;</div>

                                    <div class="textdetails">
                                        <br><h4 class="title-details">Free OPD</h4>
                                        <div class="col-md-4"> 
                                            <span>Per Day</span>
                                            <?php
                                            echo $form->textField($model2, 'free_opd_perday', array("class" => "w3-input input-group", "data-msg-required" => "Please Check Your Input", "data-rule-regexp" => "^[\d]+$"));
                                            echo $form->error($model2, 'free_opd_perday');
                                            ?>
                                        </div>
                                        <div class="col-md-4"><span>Preferred Days</span>
                                            <?php
                                            // DAY_STR is constant which contains array of Days
                                            $DayArr = explode(";", Constants:: DAY_STR);
                                            $DayFinalArr = array_combine($DayArr, $DayArr);
                                            echo $form->dropDownList($model2, 'free_opd_preferdays[]', $DayFinalArr, array("class" => "multipleselect4 form-control2", 'multiple' => 'multiple', "data-msg-required" => "Please Select Days"));

                                            echo $form->error($model2, 'free_opd_preferdays');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="textdetails">
                                        <div class="col-md-4"> 
                                            <span>About You</span>
                                            <?php
                                            echo $form->textArea($model, 'description', array('maxlength' => 500, 'rows' => 5, 'cols' => 50, "data-msg-required" => "Please Enter Description"));
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

                            </div> <!--end w3-display-container-->
                        </div> <!--end tab_b id-->

                        <div class="clearfix"></div>

                        <div class="tab-pane" id="tab_c">
                            <div class="w3-content w3-display-container">
                                <div class="mySlides" id="slide3">
                                    <h3 class="title">Documents / Certificates</h3>
                                    <div class="textdetails">
                                        <div class="col-md-4">
                                            <span>Registration Certificate</span>
                                            <?php
                                            echo $form->fileField($model3, 'document', array("class" => "w3-input input-group","data-rule-regexp" => "([a-zA-Z0-9\s_\\.\-:])+(.doc|.docx|.pdf|.png|.jpg|.gif|.txt)$",));
                                            echo $form->error($model, 'document');
                                            ?> 
                                            
                                        </div>
                                        <div class="col-md-4">
                                            <span>Clinic Certificate</span>
                                            <?php
                                            echo $form->fileField($model2, 'clinic_reg_certificate', array("class" => "w3-input input-group","data-rule-regexp" => "([a-zA-Z0-9\s_\\.\-:])+(.doc|.docx|.pdf|.png|.jpg|.gif|.txt)$"));
                                            echo $form->error($model2, 'clinic_reg_certificate');
                                            ?>
                                        </div>
                                        <div class="col-md-4">
                                            <span>Other Certificate</span>
                                            <?php
                                            echo $form->fileField($model3, 'otherdoc', array("class" => "w3-input input-group","data-rule-regexp" => "([a-zA-Z0-9\s_\\.\-:])+(.doc|.docx|.pdf|.png|.jpg|.gif|.txt)$"));
                                            echo $form->error($model3, 'otherdoc');
                                            ?> 
                                        </div>
                                        
                                        
                                    </div>
                                    <div class="clearfix"></div>
                                    <div><span style="color:red">Please Select png ,gif ,jpg ,pdf ,doc ,docx ,txt Files Only</span></div>
                                    
                                    <div class="form-group clearfix">
                                <input type="checkbox" name="acceptcondition"  class="agree required"/> Agree to Terms & Conditions
                                <p><span id="agree1" class="error1"></span></p>
                                <div class="clearfix"></div>
                            </div> 
                                    <div class="textdetails text-center">
                                        <?php
                                        echo CHtml::submitButton("Submit  ", array('class' => 'btn'));
                                        ?>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="button-arrow">
                                        <button class="w3-button w3-black w3-display-left" onClick="showPrevSlide('slide2', 'tab_b')" type="button">&#10094;</button>


                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>  
                        </div><!--end tab_c id-->

                    </div>
                    <!-- End Search box -->

                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
</section>
<!-- end intro section -->
<!-- end intro section -->
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

<div class="modal" id="myModal" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="uncheckday(this);">&times;</button>
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
                <div class="clearfix" ></div>
                <div class="model-backdrop">&nbsp;</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="clinic_time()">save</button>
            </div>
        </div>
    </div>
</div>  


<script type="text/javascript">
var pinarray = [];
var opentimearray = [];
var closetimearray = [];
var slideIndex = 1;
var dayhtml;
showDivs(slideIndex);
$(function () {
    
    $(window).keydown(function(e){
    if (e.which == 13) {
        var $targ = $(e.target);

        if (!$targ.is("textarea") && !$targ.is(":button,:submit")) {
            var focusNext = false;
            $(this).find(":input:visible:not([disabled],[readonly]), a").each(function(){
                if (this === e.target) {
                    focusNext = true;
                }
                else if (focusNext){
                    $(this).focus();
                    return false;
                }
            });

            return false;
        }
    }
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

    $('.specialityid').change(function () {
        var sname = $('.specialityid option:selected').text();
        $('.specialityname').val(sname);
    });

    $('.removeservice').click(function () {
        $('.serviceclone:last').remove();
    });

    
//    $('.chk_password').blur(function(){
//        var password = $('.password').val();
//        var cpassword = $('.chk_password').val();
//        var str ="";
//        
//        if(password != cpassword){
//            
//            $('.pass').html("Please chk Password");
//        }else{
//            $('.pass').html(str)
//        }
//    });
//     $('.password').blur(function(){
//         $('.chk_password').val('');
//      });

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

var $select = $(".expyear");
    for (i=0;i<=30;i++){
        $select.append($('<option></option>').val(i).html(i+' Year'))
    }
var $select1 = $(".expmonth");
    for (i=0;i<=12;i++){
        $select1.append($('<option></option>').val(i).html(i+' Month'))
    }

});

function clinic_time() {

    var open_time = $('.open_time').val();
    var close_time = $('.close_time').val();
    var eve_open_time = $('.eve_open_time').val();
    var eve_close_time = $('.eve_close_time').val();

    var hiddenhtml = "";
    hiddenhtml = "<span ><input type='hidden'  name='ClinicVisitingDetails[clinic_open_time][]' value='" + open_time + "' class='clinic_open_time'><input type='hidden'  name='ClinicVisitingDetails[clinic_close_time][]' value='" + close_time + "' class='clinic_close_time'><input type='hidden'  name='ClinicVisitingDetails[clinic_eve_open_time][]' value='" + eve_open_time + "' class='clinic_eve_open_time'><input type='hidden'  name='ClinicVisitingDetails[clinic_eve_close_time][]' value='" + eve_close_time + "' class='clinic_eve_close_time'></span><div class='timing-list timeing'>Mon:" + open_time + " - " + close_time + "<br>Evn:" + eve_open_time + " - " + eve_close_time + "</div>"

    $(dayhtml).closest(".weekday").find('.day').before(hiddenhtml);


}

function addMoreServices(htmlObj) {
    var str = "";
    var serviceoption = $(".serviceoption:first").html();
    str += "<br><div class=\"servicename\"><div class=\"col-md-3\"><select class=\"w3-input serviceoption\" data-rule-required=\"true\" name=\"ServiceUserMapping[service_id][]\" style=\"width:100%;\">" + serviceoption + "</select></div>";
    str += "<div class=\"col-md-3\"><input class=\"w3-input input-group\" name=\"ServiceUserMapping[service_discount][]\" type=\"text\"></div>";  
    str += "<div class=\"col-md-3\"><input class=\"w3-input input-group\" name=\"ServiceUserMapping[corporate_discount][]\" type=\"text\"></div>";
    str += "<div class=\"col-md-2\"><select class=\"w3-input serviceoption\" data-rule-required=\"true\" name=\"ServiceUserMapping[twentyfour][]\"  style=\"width:100%;\"><option value=\"No\">No</option><option value=\"Yes\">Yes</option></select></div>";
    str += "<i class=\'fa fa-times delete\' aria-hidden=\'true\' onclick=\'remove_service_details(this)\'></i><div class=\"clearfix\">&nbsp;</div></div>";
    $(htmlObj).parents(".btnaddservice").before(str);
    // console.log("tabid",$(htmlObj).parents(".btnaddservice").html(),str);
}

function remove_service_details(htmlobj)
{

    $(htmlobj).parents('.servicename').remove();
}

//function addMoreExperience(obj) {
//
//    var experience = "  <div class='textdetails exp'><div class='textdetails'><div class='col-md-4'><span>Clinic / Hospital Name</span><input type=text name='DoctorExperience[ex_clinic_name][]' class=' w3-input input-group'></div><div class='col-md-4'><span>Duration (Select Year & Month)</span><div class=''><div class='col-md-6'><input type=text name='DoctorExperience[work_from][]' class='from w3-input input-group ' id='TextBox1' onclick='work_from(this)'></div><div class='col-md-6'> <input type=text name='DoctorExperience[work_to][]' class='from w3-input input-group' id='TextBox2' onclick='work_from(this)'>  </div></div></div> <div class='col-md-3'> <span>Role</span><input type=text name='DoctorExperience[doctor_role][]' class=' w3-input input-group'  > </div>  <i class='fa fa-times  delete' aria-hidden='true' onclick='remove_experience_details(this)'></i></div><div class=\"clearfix\">&nbsp;</div></div>";
//
//    $(".addexper").after(experience);
//}

//function remove_experience_details(htmlobj)
//{
//
//    $(htmlobj).parents('.exp').remove();
//}
//function work_from(obj) {
//
//    $(".from").datepicker({
//        autoclose: true,
//        maxDate: new Date(),
//        minViewMode: 1,
//        format: "mm-yyyy"
//    });
//}

function isalldayopen(htmlobj) {
    // var aa= $(".isall" ).attr( "checked" ) ;
    if ($(htmlobj).prop("checked")) {
        $(".day").attr("disabled", true);
        $(".day").attr("checked", false);
    } else {
        $(".day").attr("disabled", false);
    }

}


function remove_doctor_details(htmlobj)
{
    $(htmlobj).parents('.visitdetail').remove();
}
// Specify the visiting time timepick for clone 


function contact() {
    $('.contact_no_2').show();
}
function email() {
    $('.email_2').show();
}


function getCity()
{
    var state = $('.state-class option:selected').val();
    var state1 = $('.state-class option:selected').text();
    $(".state-id-class").val(state1);
    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        cache: false,
        url: '<?php echo Yii::app()->createUrl("UserDetails/getCityName"); ?> ',
        data: {state: state},
        success: function (data) {
            var dataobj = data.data;

            var cityname = "<option value=''>Select City</option>";
            $.each(dataobj, function (key, value) {

                cityname += "<option value='" + value.city_id + "'>" + value.city_name + "</option>";
            });
            $(".cityId").html(cityname);
        }
    });
}

function getAreaid() {
    var area1 = $('.area-class option:selected').val();
    var area = $('.area-class option:selected').text();

    $(".area-id-class").val(area);
    var pincode = pinarray[area1];

    $(".pincode-id-class").val(pincode);
}

function getArea()
{
    var area = $('.city-class option:selected').val();
    var area1 = $('.city-class option:selected').text();

    $(".city-id-class").val(area1);
    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        cache: false,
        url: '<?php echo Yii::app()->createUrl("UserDetails/getAreaName"); ?> ',
        data: {area: area},
        success: function (data) {
            var dataobj = data.data;
            var areaname = "<option value=''>Select Area</option>";
            $.each(dataobj, function (key, value) {
                pinarray[value.area_id] = value.pincode;
                areaname += "<option value='" + value.area_id + "'>" + value.area_name + "</option>";
            });
            $(".areaId").html(areaname);

        }
    });
}


function getSubSpeciality() {
    // var spe = [];
    var speciality = $('.speciality-class').val();
    if (speciality != null) {
        var aa = speciality.toString();

        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            cache: false,
            url: '<?php echo Yii::app()->createUrl("users/getSubSpeciality"); ?> ',
            data: {speciality: aa},
            success: function (data) {

                var dataobj = data.data;

                var specialityname = "";
                $.each(dataobj, function (key, value) {

                    specialityname += "<option value='" + value.sub_speciality_name + "'>" + value.sub_speciality_name + "</option>";
                });
                specialityname += "";

                $("#UserDetails_sub_speciality").html(specialityname);
                $("#UserDetails_sub_speciality").multipleSelect({
                    filter: true,
                    multiple: true,
                    // placeholder: "Select Speciality",
                    width: "100%",
                    multipleWidth: 500
                });
                //  $('.specialityId').multiselect( 'refresh' );
            }
        });
    }
}

function chk_mobile(obj) {

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
                var error_msg = 'Mobile No is Already Registered';
                $("#mobileno").html(error_msg);
            } else {
                $("#mobileno").html('');
            }
        }
    });

}

function showDivs(n) {
    var i;
    var x = document.getElementsByClassName("mySlides");

    if (n > x.length) {
        slideIndex = 1;
    }
    if (n < 1) {
        slideIndex = x.length;
    }
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }
    x[slideIndex - 1].style.display = "block";
}
function showimg()
{

    $('#myimg').modal('show');
}
function uncheckday(obj)
{

    var dayhtml = $(this);
    var day = $(dayhtml).find(".day:checked").val();
    //alert($(this.html()));
   
    $('input:checkbox[value="' + day + '"]').last().attr('checked', false);
}


</script>


