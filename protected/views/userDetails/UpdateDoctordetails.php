<?php
/* @var $this ClinicDetailsController */
/* @var $model ClinicDetails */
/* @var $form CActiveForm */

$session = new CHttpSession;
$session->open();
$baseDir = Yii::app()->basePath . "/../uploads/";
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
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery-2.2.3.min.js', CClientScript::POS_END);

$this->renderPartial('commonAjax');

//$setDataLink = Yii::app()->createUrl("userDetails/DoctorDetails");
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


    function showNextSlide(nextslideid,tab){
        
        $(".mySlides").hide();
        $("#"+tab).show();
        $("#"+nextslideid).show();
    }
    function showPrevSlide(prevslideid, tabid){
        
        $(".mySlides").hide();
        $("#"+prevslideid).show();
        $("#myTabs a[href=\"#"+tabid+"\"]").tab("show");
        $(".fa-angle-double-right").remove();
        $("#myTabs a[href=\"#"+tabid+"\"]").append("<i class=\"fa fa-angle-double-right\" aria-hidden=\"true\"></i>");
       
    }

      $(".multipleselect").multipleSelect({
            filter: true,
            multiple: true,
            placeholder: "Select service",
            width: "100%",
            multipleWidth: 500
        });
        $(".speciality-class").multipleSelect({
            filter: true,
            multiple: true,
            placeholder: "Select Speciality",
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
<script>
    $(document).ready(function () {
<?php if ($tab == "tab_b") { ?>
            showNextSlide('slide2', 'tab_b');
<?php } ?>
    });
</script>
<!-- Start intro section -->
<section id="intro" class="section-details">
    <div class="overlay">
        <div class="container">
            <div class="main-text">

                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'user-details-form1',
                    'htmlOptions' => array('enctype' => 'multipart/form-data', "class" => "w3-container"),
                    'enableAjaxValidation' => false,
                ));
                ?>
                <?php //echo $form->errorSummary($model); ?>

                <!-- Start Search box -->
                <div class="row">

                    <?php
                    $enc_key = Yii::app()->params->enc_key;
                    $baseUrl = Yii::app()->baseUrl;
                    $path = $baseUrl . "/uploads/" . $model->profile_image;
                    if (empty($model->profile_image)) {
                        $path = $baseUrl . "/images/icons/icon01.png";
                    }
                    ?>
                     
                    <div class="col-md-3" style="background-image:url(<?= $baseUrl; ?>/images/icon46.png);height: 990px;background-size: 100% auto;background-position: center ;">
                          <div class="fileinput fileinput-new" data-provides="fileinput" style="position: relative;">
                                    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="background: transparent;width:140px;height:140px;text-align: center; margin: auto;border-radius: 50%;overflow: hidden;">
                                        <?php
                                        if (empty($model->profile_image)) {
                                            echo CHtml::image(Yii::app()->request->baseUrl . "/images/icons/icon01.png", "Profile Photo", array("class" => "img-circle", "width" => "150"));
                                        }else {  ?>
                                            <img src="<?php echo $path; ?>" class="img-circle img-responsive" style="margin-bottom:15px">
                                     <?php   }
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
                                    <h3 class="title">Enter Your Details </h3>
                                    <div class="underline"></div>
                                    <h4 class="title-details">Personal Details  </h4>
                                    <div class="textdetails">
                                        <div class="col-md-4">
                                            <span>First Name</span>
                                            <?php
                                            if (isset($session['first_name']) && !empty($session['first_name'])) {
                                                $model->first_name = $session['first_name'];
                                            }
                                            ?>
                                            <?php echo $form->textField($model, 'first_name', array("class" => "w3-input input-group", "data-rule-required" => "true", "data-msg-required" => "Please Enter Name")); ?>
                                            <?php echo $form->error($model, 'first_name'); ?>
                                        </div>
                                        <div class="col-md-4">
                                            <span>Last Name</span>
                                            <?php
                                            if (isset($session['last_name']) && !empty($session['last_name'])) {
                                                $model->last_name = $session['last_name'];
                                            }
                                            ?>

                                            <?php echo $form->textField($model, 'last_name', array("class" => "w3-input input-group", "data-rule-required" => "true", "data-msg-required" => "Please Enter L Name", "data-rule-regexp" => "^[\w.,-\s\n\/\']+$")); ?>
                                            <?php echo $form->error($model, 'last_name'); ?>                                             
                                        </div>
                                        <div class="col-md-4">
                                            <span style="padding-left:15px">Gender</span>
                                            <?php
                                            if (empty($model->gender)) {
                                                $model->gender = 'Male';
                                            }
                                            echo $form->radioButtonList($model, 'gender', array('Male' => 'Male', 'Female' => 'Female'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '&nbsp;&nbsp;&nbsp;', 'container' => 'div class="ui-radio ui-radio-pink"'));
                                            echo $form->error($model, 'gender');
                                            ?>                                                
                                        </div>
                                    </div> <!--end textdetails-->
                                    <div class="clearfix"></div>
                                    <div class="textdetails">                                                    	
                                        <div class="col-md-3" style="">
                                            <?php
                                            echo $form->labelEx($model, 'birth_date');
                                            if(!empty($model->birth_date)){
                                                $model->birth_date = date("d-m-Y",  strtotime($model->birth_date));
                                            }
                                            echo $form->textField($model, 'birth_date', array("data-format" => "DD-MM-YYYY", "class" => "birth_date w3-input input-group", "data-rule-required" => "true", "data-msg-required" => "Please Enter Birth Date"));
                                            echo $form->error($model, 'birth_date');
                                            ?> 
                                        </div>

                                        <div class="col-md-3" style="">
                                            <?php
                                            echo $form->labelEx($model, 'blood_group');
                                            echo $form->dropDownList($model, 'blood_group', array('O+' => 'O+', 'O-' => 'O-', 'A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'AB+' => 'AB+', 'AB-' => 'AB-'), array('class' => 'otherselect form-control w3-input input-group', "data-rule-required" => "true", 'prompt' => 'Select Blood Group', "data-msg-required" => "Please select Blood Group"));
                                            echo $form->error($model, 'blood_group');
                                            echo $form->hiddenField($model, 'age', array("class" => "form-control age1"));
                                            ?>
                                        </div>
                                        <div class="col-md-3">
                                            <span>Dr. Registation Number </span>   
                                            <?php
                                            if (isset($session['doctor_registration_no']) && !empty($session['doctor_registration_no'])) {
                                                $model->doctor_registration_no = $session['doctor_registration_no'];
                                            }
                                            ?>

                                            <?php echo $form->textField($model, 'doctor_registration_no', array("class" => "w3-input input-group", "data-rule-required" => "true", "data-msg-required" => "Please Enter registration no", "data-rule-regexp" => "^[\w.,-\s\/\']+$")); ?>
                                            <?php echo $form->error($model, 'doctor_registration_no'); ?>                                             
                                        </div>                                                    
                                        <div class="col-md-3">
                                            <span>Add Photo</span>
                                            <?php
//                                         
                                            echo $form->fileField($model3, 'doc_photo[]', array("class" => "w3-input input-group", "multiple" => "multiple"));
                                            echo $form->error($model3, 'doc_photo');
                                            ?> 
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>

                                    <h4 class="title-details">Login Details  </h4>
                                    <div class="textdetails">
                                        <div class="col-md-4">
                                            <span>Mobile Number</span> 
                                            <?php
                                            if (isset($session['mobile'])) {
                                                $model->mobile = $session['mobile'];
                                            }
                                            echo $form->textField($model, 'mobile', array('maxlength' => 10, "class" => "w3-input input-group", "data-msg-required" => "Please Enter Mobile", "data-rule-required" => "true", "data-rule-regexp" => "^[\d]+$","disabled"=>"true"));
                                            ?> 

                                            <?php echo $form->error($model, 'mobile'); ?>
                                        </div>
                                        <div class="col-md-4">
                                            <span>Change Password</span>
                                            <?php
                                            $model->password = '';
                                            echo $form->passwordField($model, 'password', array('size' => 20, 'maxlength' => 30, "class" => "w3-input input-group","id"=>"pass", "data-rule-regexp" => "^[\w.,-\s\/\']+$"));
                                            echo $form->error($model, 'password');
                                            ?>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <span>Confirm Password</span>
                                            <?php
                                           
                                            echo $form->passwordField($model, 'confirm_password', array('size' => 20, 'maxlength' => 30, "class" => "w3-input input-group", "data-rule-regexp" => "^[\w.,-\s\/\']+$","data-rule-equalTo" => "#pass"));
                                            echo $form->error($model, 'confirm_password');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <h4 class="title-details">Contact Details  </h4>
                                    <div class="textdetails">
                                        <div class="col-md-5 contacts">
                                            <span>Book You Appointment Contact Number</span>
                                            <?php
                                            echo $form->textField($model, 'apt_contact_no_1', array("class" => "w3-input input-group", "data-rule-required" => "true", "data-msg-required" => "Please Enter contact no", "data-rule-regexp" => "^[7-9]{1}[0-9]{9,29}$"));
                                            echo $form->error($model, 'apt_contact_no_1');
                                            ?>
                                            <a class="btn-block" href="javascript:" onclick="$('.contact_no_2').show();
                                                    $(this).hide();"><i class="fa fa-plus" aria-hidden="true"></i> Add Contact Number </a>
                                            <!--                                            <button type="button" onclick="contact()">+</button>-->
                                            <div class="contact_no_2 " hidden="">
                                                <?php
                                                echo $form->textField($model, 'apt_contact_no_2', array("class" => "w3-input input-group", "data-rule-required" => "true", "data-msg-required" => "Please Enter contact no", "data-rule-regexp" => "^[7-9]{1}[0-9]{9,29}$"));
                                                echo $form->error($model, 'apt_contact_no_2');
                                                ?>
                                            </div>
                                        </div>


                                        <div class="col-md-4 emails">
                                            <span>Email Address</span>
                                            <?php
                                            echo $form->textField($model, 'email_1', array('maxlength' => 100, "class" => "form-control", "data-rule-regexp" => "[/^.{1,}@.{2,}\..{2,}/]"));
                                            echo $form->error($model, 'email_1');
                                            ?>
                                            <a class="btn-block" href="javascript:" onclick="$('.email_2').show();
                                                    $(this).hide();"><i class="fa fa-plus" aria-hidden="true"></i> Add Email Address </a>
                                            <!--                                            
                                                                                        <button type="button" onclick="email();">+</button>-->
                                            <div class="email_2" hidden="">
                                                <?php
                                                if (isset($session['email_2'])) {
                                                    $model->email_2 = $session['email_2'];
                                                }
                                                echo $form->textField($model, 'email_2', array('size' => 30, 'maxlength' => 200, "class" => "w3-input input-group", "data-rule-required" => "true", "data-msg-required" => "Please Enter email"));
                                                echo $form->error($model, 'email_2');
                                                ?>
                                            </div>    
                                        </div>
                                    </div> <!--end textdetails-->
                                    <div class="clearfix"></div>
                                    <div class="textdetails">
                                        <div class="col-sm-4">
                                            <span><b> Add Specialty</b></span>
                                            <?php
                                            $speciality = SpecialityMaster::model()->findAll();
                                            $specialitynameArr = CHtml::listData($speciality, 'speciality_id', 'speciality_name');
                                            $selectedSpecialityArr = Yii::app()->db->createCommand()
                                                    ->select('speciality_id')
                                                    ->from('az_speciality_user_mapping')
                                                    ->where('user_id=:id', array(':id' => $model->user_id))
                                                    ->queryColumn();
                                            ?>
                                            <select multiple="multiple"  class=" multipleselect speciality-class" name="UserDetails[speciality][]" >

                                                <?php
                                                foreach ($specialitynameArr as $specialityid => $speciality) {
                                                    echo "<option value='$specialityid' ";
                                                    if (in_array($specialityid, $selectedSpecialityArr)) {
                                                        echo " selected ";
                                                    }
                                                    echo ">$speciality</option>";
                                                }
                                                ?>
                                            </select>
                                            <?php echo $form->error($model, 'speciality');
                                            ?>                                   
                                        </div>
                                        <div class="col-md-4">
                                            <span>Sub-Specialty</span> 
                                            <?php
                                            
                                            $specStr = 0;
                                            if (!empty($selectedSpecialityArr))
                                                $specStr = implode(',', $selectedSpecialityArr);

                                            $Criteria = new CDbCriteria();
                                            $Criteria->condition = "speciality_id in($specStr)";

                                            $subspeciality = SubSpeciality::model()->findAll($Criteria);
                                            $subspecialitynameArr = CHtml::listData($subspeciality, 'sub_speciality_id', 'sub_speciality_name');

                                            $sub_speciality = $model->sub_speciality;
                                            $selectedSubSpecialityArr = explode(",", $sub_speciality);
                                            ?>
                                            <select multiple="multiple"  class=" multipleselect specialClass" name="UserDetails[sub_speciality][]" id="UserDetails_sub_speciality" >
                                                <?php
                                                foreach ($subspecialitynameArr as $specialityid => $speciality) {
                                                    echo "<option value='$specialityid' ";
                                                    if (in_array($specialityid, $selectedSubSpecialityArr)) {
                                                        echo " selected ";
                                                    }
                                                    echo ">$speciality</option>";
                                                }
                                                ?>
                                            </select>
                                            <?php echo $form->error($model, 'sub_speciality'); ?>                                                  
                                        </div>


                                        <div class="col-md-4">
                                            <span>Degree</span>
                                            <?php
                                            $userdegreeGroupArr = Yii::app()->db->createCommand()
                                                    ->select('degree_name')
                                                    ->from('az_doctor_degree_mapping')
                                                    ->where('doctor_id=:id', array(':id' => $id))
                                                    ->queryColumn();
                                            // print_r($userdegreeGroupArr);
                                            ?>

                                            <?php
                                            $degree = DegreeMaster::model()->findAll();
                                            $degreenameArr = CHtml::listData($degree, 'degree_id', 'degree_name');
                                            ?>
                                            <select multiple="multiple"  class="form-control2 multipleselect2" name="UserDetails[degree][]" style="width:80%;">
                                                <?php
                                                foreach ($degreenameArr as $degree) {
                                                    echo "<option value='$degree' ";
                                                    if (in_array($degree, $userdegreeGroupArr)) {
                                                        echo " selected ";
                                                    }
                                                    echo ">$degree</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div> <!--end textdetails-->
                                    <div class="clearfix">&nbsp;</div>

                                    <h4 class="title-details">Experience  </h4>
                                    <?php
                                    $expGroupArr = Yii::app()->db->createCommand()
                                            ->select('work_from,work_to')
                                            ->from(' az_doctor_experience')
                                            ->where('doctor_id=:id', array(':id' => $id))
                                            ->queryRow();
                                    if(!empty($expGroupArr)){
                                    ?>
                                        
                                            <div class="textdetails">
                                                


                                                <div class="col-md-8">
                                                    <span>Select Year & Month</span>
                                                    
                                                        <div class="col-md-4">

                                                            <?php
                                                            if (isset($session['work_from'])) {
                                                                $model1->work_from = $session['work_from'];
                                                            }
                                                            ?>
                                                            <select name="DoctorExperience[work_from]" class="expyear w3-input">
                                                                <?php
                                                                for($i=0;$i<=30;$i++){
                                                                    
                                                                   if($expGroupArr['work_from'] == $i) {
                                                                       ?><option value="<?php echo $expGroupArr['work_from']?>"selected><?php echo $expGroupArr['work_from'].' Year' ?></option> <?php  
                                                                   }else{ ?>
                                                                       <option value="<?php echo $i;?>"><?php echo $i.' Year'; ?></option>
                                                                 <?php  }
                                                                }
                                                                ?>
                                                               
                                                            </select>
                                                            <?php
                                                        
                                                            echo $form->error($model1, 'work_from');
                                                            ?>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <?php
                                                            if (isset($session['work_to'])) {
                                                                $model1->work_to = $session['work_to'];
                                                            }?>
                                                           <select name="DoctorExperience[work_to]" class="expyear w3-input">
                                                                <?php
                                                                for($i=0;$i<=12;$i++){
                                                                    
                                                                   if($expGroupArr['work_to'] == $i) {
                                                                       ?><option value="<?php echo $expGroupArr['work_to']?>"selected><?php echo $expGroupArr['work_to'].' Month' ?></option> <?php  
                                                                   }else{ ?>
                                                                       <option value="<?php echo $i;?>"><?php echo $i.' Month'; ?></option>
                                                                 <?php  }
                                                                }
                                                                ?>
                                                               
                                                            </select>
                                                          <?php  echo $form->error($model1, 'work_to');
                                                            ?>

                                                        </div>
                                                             
                                                </div>

                                                
                                               
                                            </div> <!--end textdetails-->
                                            <div class="clearfix"></div>
                                    <?php  } else{?>
                                            
                                            <div class="col-md-8">
                                                <span> Select Year & Month</span>
                                                <div class="">
                                                    <div class="col-md-4">
                                                       
                                                       <select name="DoctorExperience[work_from]" class="expyear w3-input"></select>
                                                  <?php    //  echo $form->error($model1, 'work_from');
                                                        ?>
                                                    </div>
                                                    <div class="col-md-4">
                                                      
                                                        <select name="DoctorExperience[work_to]" class="expmonth w3-input"></select>
                                                        <?php
                                                       // echo $form->error($model1, 'work_to');
                                                        ?>

                                                    </div>
                                                </div>           
                                            </div>
                                            
                                    <?php   }  ?>
                                            


                                        

                                       
                                    <div class="clearfix"></div>
                                   
                                    <!--                                    <div class="col-md-6">
                                                                            <span class="btn-block">* Complete your previous experience details </span>
                                                                        </div> -->

                                    <div class="clearfix"></div>
                                    <div class="button-arrow">

                                        <button class="w3-button w3-black w3-display-right" onClick="showNextSlide('slide2', 'tab_b')" type="button">&#10095;</button>
                                    </div>
                                </div> <!--end mySlides-->
                            </div> <!--end w3-display-container-->
                        </div><!--end tab_a -->                    
                        <div class="clearfix"></div>
                        <div class="tab-pane" id="tab_b">
                            <div class="w3-content w3-display-container">
                                <div class="mySlides" id="slide2">   <!--    id="slide4"-->
                                    <h3 class="title">Clinic Details </h3>
                                    <div class="underline"></div> 
                                    <div class="profile-note text-right">

                                        <a href="<?php echo $this->createUrl('userDetails/clinicDetails', array('id' => Yii::app()->getSecurityManager()->encrypt($id, $enc_key))); ?>" ><i class="fa fa-plus" aria-hidden="true"></i>Add Clinic</a></div>
                                    <?php
                                    $clinicNameArray = Yii::app()->db->createCommand()
                                            ->select('clinic_name,clinic_id')
                                            ->from(' az_clinic_details ')
                                            ->where('doctor_id=:id', array(':id' => $id))
                                            ->queryAll();
// print_r($clinicNameArray);
                                    $firstClinicid = 0;
                                    $clinicname = array();
                                    foreach ($clinicNameArray as $clinickey => $row) {
                                        if ($clinickey == 0) {
                                            $firstClinicid = $row['clinic_id'];
                                        }
                                        $clinicname[$row['clinic_id']] = array('clinic_name' => $row['clinic_name']);
                                    }
                                    foreach ($clinicname as $key => $value) {
                                        ?>
                                        <a href="<?php echo $this->createUrl('userDetails/updateClinicDetails', array('c_id' => Yii::app()->getSecurityManager()->encrypt($key, $enc_key), 'u_id' => Yii::app()->getSecurityManager()->encrypt($id, $enc_key))); ?>" ><i class="fa fa-plus" aria-hidden="true"></i><?php echo $clinicname[$key]['clinic_name']; ?></a>
                                    <?php } ?>
                                    <div class="textdetails">
                                        <div class="col-md-10">
                                            <span>Clinic Name</span>

                                            <?php
                                            echo $form->textField($model2, 'clinic_name', array('size' => 60, 'maxlength' => 200, "data-rule-required" => "true", "data-msg-required" => "Please enter Clinic Name"));
                                            echo $form->error($model2, 'clinic_name');
                                            ?>
                                        </div>                                                	
                                    </div>

                                    <div class="clearfix"></div>

                                    <?php
                                 
                                    if (count($serviceUserMapping) > 0 && isset($serviceUserMapping)) {
                                        $sindex = 0;
                                        $service = Yii::app()->db->createCommand()->select("service_id,service_name")->from("az_service_master")->where('role_id=:roleid', array(':roleid' => $roleid))->queryAll();
                                        $servicenameArr = CHtml::listData($service, 'service_id', 'service_name');
                                     //   exit;
                                        if(!empty($serviceUserMapping['is_available_allday'])){
                                        foreach ($serviceUserMapping as $key => $serviceDetailObj) {
                                            ?>

                                            <div class=" form-group serviceclone clearfix" id="serviceclone">

                                                <div class="col-sm-3">
                                                    <span>Service</span>
                                                    <select class="form-control servicename col-sm-2" name="service[]">
                                                        <?php foreach ($servicenameArr as $servicekey => $value) {
                                                            ?>

                                                            <option value='<?php echo $servicekey; ?>' <?php echo $serviceDetailObj->service_id == $servicekey ? "selected" : ""; ?>> <?php echo $value; ?></option>
                                                        <?php }
                                                        ?>
                                                    </select>
                                                </div>
                                                <?php echo $form->error($model, 'service_id'); ?>
                                                <div class="col-md-3 clearfix">
                                                    <span>Discount</span>
                                                    <input type="text" name="service_discount[]" value='<?php echo $serviceDetailObj->service_discount ?>' class="form-control" >
                                                    <?php echo $form->error($model, 'service_discount', array('class' => 'col-sm-2 control-label')); ?>
                                                </div>
                                                <div class="col-md-3 clearfix">
                                                    <span>Corporate Discount</span>
                                                    <input type="text" name="corporate_discount[]" value='<?php echo $serviceDetailObj->corporate_discount ?>' class="form-control" >
                                                    <?php echo $form->error($model, 'corporate_discount', array('class' => 'col-sm-2 control-label')); ?>
                                                </div>
                                                <?php
                                                $isallday = array('Yes' => "Yes", 'No' => "No");
                                                ?> 

                                                <div class ="col-md-2">
                                                    <span>24x7</span>
                                                    <select class="form-control twentyfour" name="twentyfour[]">
                                                        <?php foreach ($isallday as $key => $value) { ?>
                                                            <option value='<?php echo $key; ?>' <?php echo $serviceDetailObj->is_available_allday == $key ? "selected" : ""; ?>> <?php echo $value; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-1 clearfix">
                                                    <?php
                                                    if ($sindex == 0) {
                                                        echo CHtml::link('ADD', 'javascript:', array('class' => 'addservice'));
                                                        $sindex++;
                                                    } else {
                                                        echo CHtml::link('X', 'javascript:', array('class' => 'removeservice'));
                                                        //echo "<i class='fa fa-times delete' aria-hidden='true' onclick='remove_service_details(this)'></i>";
                                                    }
                                                    ?>
                                                </div>

                                            </div>

                                            <?php
                                        }}
                                    }   
                                    ?>
                                    <div class="clearfix"></div>
                                    <!-- Timing start here -->
                                    <div class="textdetails">
                                        <h4 class="title-details">Timings</h4>
                                        <div class="col-md-12" style=""> 
                                            <?php
                                            $alldaychecked = "";
                                            if ($model2->alldayopen == 'Y') {
                                                $alldaychecked = " checked ";
                                            }
                                            ?>

                                            <label><input  type="checkbox" name="ClinicDetails[alldayopen]" value="Y" onclick="isalldayopen(this)" class="isall" <?php echo $alldaychecked; ?>> 24x7</label>



                                        </div>
                                        <?php
                                        $dayarr = array("Monday" => "Monday", "Tuesday" => "Tuesday", "Wednesday" => "Wednesday", "Thursday" => "Thursday", "Friday" => "Friday", "Saturday" => "Saturday", "Sunday" => "Sunday");
                                        $userSelectedDay = array();
                                        $uservisit = Yii::app()->db->createCommand()
                                                ->select('clinic_id,day,clinic_open_time,clinic_close_time,clinic_eve_open_time,clinic_eve_close_time')
                                                ->from('az_clinic_visiting_details ')
                                                ->where('clinic_id=:id', array(':id' => $firstClinicid))
                                                ->queryAll();
                                        //print_r($uservisit);
                                        foreach ($uservisit as $row) {
                                            $userSelectedDay[$row['day']] = array('clinic_open_time' => $row['clinic_open_time'], 'clinic_close_time' => $row['clinic_close_time'], 'clinic_eve_open_time' => $row['clinic_eve_open_time'], 'clinic_eve_close_time' => $row['clinic_eve_close_time']);
                                        }
                                        ?>
                                        <div class="col-md-12 day" style="">
                                            <ul class="list-inline">
                                                <?php
                                                foreach ($dayarr as $key => $value) {
                                                    $check = '';
                                                    $hiddenField = '';
                                                    if (array_key_exists($key, $userSelectedDay)) {
                                                        $check = 'checked';
                                                        $hiddenField = '<span><input type="hidden" name="ClinicVisitingDetails[clinic_open_time][]" value="' . $userSelectedDay[$key]['clinic_open_time'] . '" class="clinic_open_time">
                        <input type="hidden" name="ClinicVisitingDetails[clinic_close_time][]" value="' . $userSelectedDay[$key]['clinic_close_time'] . '" class="clinic_close_time">'
                                                                . '<input type="hidden" name="ClinicVisitingDetails[clinic_eve_open_time][]" value="' . $userSelectedDay[$key]['clinic_eve_open_time'] . '" class="clinic_eve_open_time">'
                                                                . '<input type="hidden" name="ClinicVisitingDetails[clinic_eve_close_time][]" value="' . $userSelectedDay[$key]['clinic_eve_close_time'] . '" class="clinic_eve_close_time"></span>';
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
                                        <?php ?>
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
                                    <div class="clearfix"></div>
                                    <div class="textdetails">
                                        <h4 class="title-details">Location</h4>
                                        <div class="col-md-4">
                                            <span>Zip Code</span>
                                            
                                            <?php
                                           // print_r($session['pincode']);
                                            if (isset($session['pincode'])) {
                                                $model2->pincode = $session['pincode'];
                                            }
                                            echo $form->textField($model2, 'pincode', array("class" => "w3-input input-group pincode-id-class"));
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
                                            echo $form->dropDownList($model2, 'state_id', $stateArr, array("class" => "w3-input state-class", "style" => "width:100%;", "prompt" => "Select State", "data-rule-required" => "true", "data-msg-required" => "Please Select State", 'onchange' => 'getCity()'));
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
                                            //print_r($model2);
                                            $cityArr = array();
                                           // echo  $model2->city_id ;
//                                            if (isset($session['city_id'])) {
//                                                $model2->city_id = $session['city_id'];
//                                            }
                                            echo $form->dropDownList($model2, 'city_id', $cityArr, array("class" => "w3-input cityId city-class", "style" => "width:100%;", "prompt" => "Select City", "data-rule-required" => "true", "data-msg-required" => "Please Select City", 'onchange' => 'getArea()'));
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
                                            if(!empty($model2->city_id)) {
                                                $stateType = Yii::app()->db->createCommand()->select("area_id,area_name")->from("az_area_master")->where("city_id = :cityid", array(":cityid" => $model2->city_id))->queryAll();
                                                foreach ($stateType as $row) {
                                                    $areaArr[$row['area_id']] = $row['area_name'];
                                                }
                                            }
                                            
                                            if (isset($session['area_id'])) {
                                                $model2->area_id = $session['area_id'];
                                            }
                                            echo $form->dropDownList($model2, 'area_id', $areaArr, array("class" => "w3-input area-class areaId", "style" => "width:100%;", "prompt" => "Select Area", "data-rule-required" => "true", "data-msg-required" => "Please Select Area", 'onchange' => 'getAreaid()'));
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
                                                $model->landmark = $session['c_landmark'];
                                            }
                                            echo $form->textField($model2, 'landmark', array("class" => "w3-input input-group", "data-rule-required" => "true", "data-msg-required" => "Please enter Landmark"));
                                            echo $form->error($model2, 'landmark');
                                            ?>
                                        </div>
                                        <div class="col-md-4">
                                            <span>Street Address</span>
                                            <?php
                                            if (isset($session['address'])) {
                                                $model2->address = $session['c_address'];
                                            }
                                            echo $form->textField($model2, 'address', array("class" => "w3-input input-group", "data-rule-required" => "true", "data-msg-required" => "Please enter Address"));
                                            echo $form->error($model2, 'address');
                                            ?>

                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-md-4">
                                        <span>Payment Modes</span>
                                        <?php
                                        // PAYMENT_TYPE is constant which contains array of payment type
                                        $paymenttypeArr = explode(";", Constants:: PAYMENT_TYPE);
                                        $paymenttypeFinalArr = array_combine($paymenttypeArr, $paymenttypeArr);

                                        $paymentGroupArr = Yii::app()->db->createCommand()
                                                ->select('payment_type')
                                                ->from('az_clinic_details')
                                                ->where('doctor_id=:id', array(':id' => $id))
                                                ->queryColumn();

                                        $paymentArr = implode(" ", $paymentGroupArr);

                                        $paymentArr = explode(",", $paymentArr);
                                        ?>

                                        <select multiple="multiple"  class="form-control2 multipleselect3" name="ClinicDetails[payment_type][]" style="width:80%;">
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
                                    <div class="clearfix"></div>
                                    <div class="col-md-10">
                                        <div class="col-md-5"> 
                                            <span>OPD Consultation Fees</span>
                                            <?php
                                            echo $form->textField($model2, 'opd_consultation_fee', array("class" => "w3-input input-group", "data-rule-required" => "true", "data-msg-required" => "Please Consultation Fee"));
                                            echo $form->error($model2, 'opd_consultation_fee');
                                            ?>
                                        </div>
                                        <div class="col-md-5"> 
<!--                                            <span>Discount %</span>-->
                                            <?php
                                            echo $form->hiddenField($model2, 'opd_consultation_discount', array("class" => "w3-input input-group"));
                                            echo $form->error($model2, 'opd_consultation_discount');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <h4 class="title-details">Free OPD</h4>
                                    <div class="col-md-10">
                                        <div class="col-md-5"> 
                                            <span>Per Day</span>
                                            <?php
                                            echo $form->textField($model2, 'free_opd_perday', array("class" => "w3-input input-group"));
                                            echo $form->error($model2, 'free_opd_perday');
                                            ?>
                                        </div>

                                        <div class="col-md-5"><span>Preferred Days</span>
                                            <?php
// DAY_STR is constant which contains array of Days
                                            $DayArr = explode(";", Constants:: DAY_STR);
                                            $DayFinalArr = array_combine($DayArr, $DayArr);

                                            $DayGroupArr = Yii::app()->db->createCommand()
                                                    ->select('free_opd_preferdays')
                                                    ->from('az_clinic_details')
                                                    ->where('doctor_id=:id', array(':id' => $id))
                                                    ->queryColumn();

                                            $DayArr = implode(" ", $DayGroupArr);

                                            $DayArr = explode(",", $DayArr);
                                            ?>

                                            <select multiple="multiple"  class="form-control2 multipleselect3" name="ClinicDetails[free_opd_preferdays][]" style="width:80%;">
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
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-md-4"> 
                                        <span>About You</span>
                                        <?php
                                        echo $form->textArea($model, 'description', array('maxlength' => 500, 'rows' => 5, 'cols' => 50, "data-rule-required" => "true", "data-msg-required" => "Please Enter Description"));
                                        echo $form->error($model, 'description');
                                        ?>
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
                                            echo $form->fileField($model3, 'document', array("class" => "w3-input input-group"));
                                            echo $form->error($model, 'document');
                                            ?> 
                                        </div>
                                        <div class="col-md-4">
                                            <span>Clinic Certificate</span>
                                            <?php
                                            echo $form->fileField($model2, 'clinic_reg_certificate', array("class" => "w3-input input-group"));
                                            echo $form->error($model2, 'clinic_reg_certificate');
                                            ?>
                                        </div>
                                        <div class="col-md-4">
                                            <span>Other Certificate</span>
                                            <?php
                                            echo $form->fileField($model3, 'otherdoc', array("class" => "w3-input input-group"));
                                            echo $form->error($model3, 'otherdoc');
                                            ?> 
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="textdetails text-center">
                                        <?php
                                        echo CHtml::submitButton("Save  ", array('class' => 'btn'));
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
    var pinarray = [];
    var opentimearray = [];
    var closetimearray = [];
    var slideIndex = 1;
    var dayhtml;
    showDivs(slideIndex);
    $(function () {

        $(".speciality-class").change(function () {
            getSubSpeciality();
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


        $(".specialityid").change(function () {
            var speciality = $('.specialityid option:selected').val();
            var speciality1 = $('.specialityid option:selected').text();
            $(".specialitynameid").val(speciality);
            $(".specialityname").val(speciality1);

        });
        $(".degreeid").change(function () {
            var degree = $('.degreeid option:selected').val();
            $(".degreenameid").val(degree);


        });


//         $('.remove_exp').click(function () {
//        $('.addexper').remove();
//    });
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
    
    var $select = $(".expyear");
    for (i=0;i<=30;i++){
        $select.append($('<option></option>').val(i).html(i+' Year'))
    }
var $select1 = $(".expmonth");
    for (i=0;i<=12;i++){
        $select1.append($('<option></option>').val(i).html(i+' Month'))
    }
    
    });

    function isalldayopen(htmlobj) {
        // var aa= $(".isall" ).attr( "checked" ) ;
        if ($(htmlobj).prop("checked")) {
            $(".noday").attr("disabled", true);
            $(".noday").attr("checked", false);
        } else {
            $(".noday").attr("disabled", false);
        }

    }

function clinic_time() {
    var open_time = $('.open_time').val();
    var close_time = $('.close_time').val();
    var eve_open_time = $('.eve_open_time').val();
    var eve_close_time = $('.eve_close_time').val();
    var hiddenhtml = "";
    hiddenhtml = "<span ><input type='hidden'  name='ClinicVisitingDetails[clinic_open_time][]' value='" + open_time + "' class='clinic_open_time'><input type='hidden'  name='ClinicVisitingDetails[clinic_close_time][]' value='" + close_time + "' class='clinic_close_time'><input type='hidden'  name='ClinicVisitingDetails[clinic_eve_open_time][]' value='" + eve_open_time + "' class='clinic_eve_open_time'><input type='hidden'  name='ClinicVisitingDetails[clinic_eve_close_time][]' value='" + eve_close_time + "' class='clinic_eve_close_time'></span><div class='timing-list timeing'>Mor:" + open_time + " - " + close_time + "<br>Evn:" + eve_open_time + " - " + eve_close_time + "</div><br>"
    $(dayhtml).closest(".weekday").find('.day').before(hiddenhtml);


}




    $('.addservice').click(function () {
        var htmlstr = "";
        var servicename = $('.servicename').html();
        var twentyfour = $('.twentyfour').html();

        // var dayname = $('.dayname').html();
        htmlstr = "<div class='form-group servicename clearfix'><div class='col-sm-3'><span>Service</span><select class='form-control servicename' name='service[]'>" + servicename + "</select></div><div class='col-md-3 clearfix'><span>Discount</span><input type=text name=service_discount[] class='form-control'></div><div class='col-md-3 clearfix'><span>Corporate Discount</span><input type=text name=corporate_discount[] class='form-control'></div><div class='col-md-2'><span>24x7</span><select class='form-control twentyfour' name='twentyfour[]'>" + twentyfour + "</select></div><i class='fa fa-times delete' aria-hidden='true' onclick='remove_service_details(this)'></i></div> ";
        $('#serviceclone').after(htmlstr);
    });
    $('.removeservice').click(function () {
        $('.serviceclone:last').remove();
    });
    function remove_service_details(htmlobj)
    {

        $(htmlobj).parents('.servicename').remove();
    }

    function addMoreExperience(obj) {

        var experience = "  <div class='textdetails exp'><div class='col-md-4'><span>Clinic / Hospital Name</span><input type=text name='DoctorExperience[ex_clinic_name][]' class=' w3-input input-group'></div><div class='col-md-4'><span>Duration (Select Year & Month)</span><div class=''><div class='col-md-6'><input type=text name='DoctorExperience[work_from][]' class='from w3-input input-group ' id='TextBox1' onclick='work_from(this)'></div><div class='col-md-6'> <input type=text name='DoctorExperience[work_to][]' class='from w3-input input-group' id='TextBox2' onclick='work_from(this)'>  </div></div></div> <div class='col-md-3'> <span>Role</span><input type=text name='DoctorExperience[doctor_role][]' class=' w3-input input-group'  > </div>  <i class='fa fa-times  delete' aria-hidden='true' onclick='remove_experience_details(this)'></i><div class=\"clearfix\">&nbsp;</div></div>";

        //   $('.addexper').after(experience);
        $(obj).after(experience);
    }
    function remove_experience_details(htmlobj)
    {

        $(htmlobj).parents('.exp').remove();
    }

    function remove_experience(htmlobj)
    {
        $(htmlobj).parents('.addexper').remove();
    }

    function work_from(obj) {

        $(".from").datepicker({
            autoclose: true,
            maxDate: new Date(),
            minViewMode: 1,
            format: "mm-yyyy"
        });
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
        alert(state);
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
                alert(cityname);
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


</script>
