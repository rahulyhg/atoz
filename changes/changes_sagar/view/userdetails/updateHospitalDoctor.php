<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyA1vr2RVgKBydJQhSo1LUsP3pUcKh4IFGI"></script>
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/select2.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/multiple-select.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/bootstrap-datetimepicker.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jquery.timepicker.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/radio_style.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/croppie.css');

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/croppie.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/moment-with-locales.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-datetimepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/select2.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/multiple-select.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.timepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.validate.min.js', CClientScript::POS_END);

Yii::app()->clientScript->registerScript('myjavascript', '
    $("#user-details-form").validate({
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
    $(".clinictime").datetimepicker({
                    format: "LT"
                });

     $(".multipleselect").multipleSelect({
            filter: true,
            multiple: true,
           // placeholder: "Select speciality Type",
            width: "100%",
            multipleWidth: 500
        });
            $(".multipleselect3").multipleSelect({
            filter: true,
            multiple: true,
            placeholder: "Select Degree",
            width: "100%",
            multipleWidth: 500
        });
         $(".multipleselect4").multipleSelect({
            filter: true,
            multiple: true,
            placeholder: "Select Day",
            width: "100%",
            multipleWidth: 500
        });
     $("#UserDetails_birth_date").datetimepicker({
                
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down"
                },
              format:"YYYY-MM-DD",
              maxDate :new Date(),
            });
$("#UserDetails_birth_date").on("dp.change",function(e){
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
            console.log(diffyear + " years, " + diffmonth + " month");
            });', CClientScript::POS_END);
?> 

<section class="content-header">

    <h3>Update Hospital Doctor</h3>

</section>
<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row"><!-- row start-->
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                    <div class="box-header with-border"><!-- box header start -->
                        <div class="text-right"><!--link div-->


                            <?php echo CHtml::link('<i class = "fa fa-gear fa-fw"></i> Manage Hospital Doctors', array('userDetails/manageHospitalDoctor', "param1" => base64_encode($model->parent_hosp_id)), array("style" => "color: white;", 'class' => 'btn btn-info')) ?>
                        </div><!--link End-->    


                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'user-details-form',
                            'enableAjaxValidation' => false,
                            'htmlOptions' => array('enctype' => 'multipart/form-data', "class" => "form-horizontal"),
                        ));
                        ?>
                        <p class="note">Fields with <span class="required">*</span> are required.</p>

                        <?php echo $form->errorSummary($model); ?>



                        <div class="form-group">
                            <div class=" col-offset-1 col-sm-4">
                                <?php echo $form->labelEx($model, 'first_name', array("class" => "control-label")); ?>

                                <?php
                                echo $form->textField($model, 'first_name', array('maxlength' => 60, 'class' => 'form-control ', "data-rule-required" => "true", "data-msg-required" => "Please Enter First Name"));
                                echo $form->error($model, 'first_name');
                                ?>
                            </div> 

                            <div class="col-sm-4">
                                <?php echo $form->labelEx($model, 'last_name', array("class" => "control-label")); ?>
                                <?php
                                echo $form->textField($model, 'last_name', array('maxlength' => 60, 'class' => 'form-control ', "data-rule-required" => "true", "data-msg-required" => "Please Enter Last Name"));
                                echo $form->error($model, 'last_name');
                                ?>
                            </div>

                            <div class="col-sm-3">
                                <div class="fileinput fileinput-new" data-provides="fileinput" style="position: relative;">
                                    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="background: transparent;width:140px;height:140px;text-align: center; margin: auto;border-radius: 50%;overflow: hidden;">
                                        <?php
                                        if (empty($model->profile_image)) {
                                            echo CHtml::image(Yii::app()->request->baseUrl . "/images/icons/icon01.png", "Profile Photo", array("class" => "img-circle", "width" => "150"));
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
                        </div>


                        <div class="form-group clearfix">
                            <div class="col-sm-4">
                                <span>Change Password</span>
<?php
$model->password = '';
echo $form->passwordField($model, 'password', array('size' => 20, 'maxlength' => 30, "class" => "form-control", "id" => "pass", "data-rule-regexp" => "^[\w.,-\s\/\']+$"));
echo $form->error($model, 'password');
?>
                            </div>

                            <div class="col-sm-4">
                                <span>Confirm Password</span>
<?php
echo $form->passwordField($model, 'confirm_password', array('size' => 20, 'maxlength' => 30, "class" => "form-control", "data-rule-regexp" => "^[\w.,-\s\/\']+$", "data-rule-equalTo" => "#pass"));
echo $form->error($model, 'confirm_password');
?>
                            </div>
                        </div>

                        <div class="form-group clearfix">

                            <div class="col-sm-4">
<?php echo $form->labelEx($model, 'gender', array("class" => "control-label")); ?>
<?php
if (empty($model->gender)) {
    $model->gender = 'Male';
}
echo $form->radioButtonList($model, 'gender', array('Male' => 'Male', 'Female' => 'Female'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '&nbsp;&nbsp;&nbsp;', 'container' => 'div class="ui-radio ui-radio-pink"'));
echo $form->error($model, 'gender');
?>
                            </div> 

                            <div class="col-sm-4">
<?php echo $form->labelEx($model, 'birth_date', array("class" => "control-label")); ?>
<?php
echo $form->textField($model, 'birth_date', array("data-format" => "dd-MM-yyyy", "class" => "birth_date form-control", "data-rule-required" => "true", "data-msg-required" => "Please Enter Birth Date"));
echo $form->error($model, 'birth_date');
?>
                            </div> 

                            <div class="col-sm-4">
<?php echo $form->labelEx($model, 'blood_group', array("class" => "control-label")); ?>
<?php echo $form->dropDownList($model, 'blood_group', array('O+' => 'O+', 'O-' => 'O-', 'A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'AB+' => 'AB+', 'AB-' => 'AB-'), array('class' => 'otherselect form-control', "data-rule-required" => "true", 'prompt' => 'Select Blood Group', "data-msg-required" => "Please select Blood Group")); ?>
                                <?php echo $form->error($model, 'blood_group'); ?> 
                            </div>
                        </div>
                        <div class="form-group clearfix">

                            <div class="col-sm-4">
<?php echo $form->labelEx($model, 'doctor_registration_no', array("class" => "control-label")); ?>
<?php
echo $form->textField($model, 'doctor_registration_no', array("class" => "form-control", "data-rule-required" => "true", "data-msg-required" => "Please Enter Registration No"));
echo $form->error($model, 'doctor_registration_no');
?>
                            </div> 

                            <div class="col-sm-4">
<?php echo $form->labelEx($model, 'doctor_fees', array("class" => " control-label")); ?>
<?php
echo $form->textField($model, 'doctor_fees', array("class" => "form-control", "data-rule-required" => "true", "data-msg-required" => "Please Enter Registration No"));
echo $form->error($model, 'doctor_fees');
?>
                            </div> 
                        </div>
                        <div class="form-group clearfix">



                            <div class="col-sm-4">
                                <label class="control-label">Book Your Appointment Contact No</label>
<?php
echo $form->textField($model, 'apt_contact_no_1', array("class" => "form-control", "data-rule-required" => "false", "data-msg-required" => "Please Enter Contact No", "data-rule-regexp" => "^[7-9]{1}[0-9]{9,29}$"));
echo $form->error($model, 'apt_contact_no_1');
?>
                            </div> 

                            <div class="col-sm-4">
                                <label class="control-label">Email Address</label>
<?php echo $form->textField($model, 'email_1', array('maxlength' => 200, "class" => "form-control", "data-rule-required" => "true", "data-msg-required" => "Please Enter email")); ?>
<?php echo $form->error($model, 'email_1'); ?>
                            </div> 
                            <div class="col-sm-4">
                                <label class="control-label">OPD No</label>
<?php echo $form->textField($model, 'opd_no', array('maxlength' => 200, "class" => "form-control", "data-rule-required" => "true", "data-msg-required" => "Please Enter OPD No")); ?>
<?php echo $form->error($model, 'opd_no'); ?>
                            </div>
                        </div>



                        <div class="form-group clearfix">

                            <div class="col-sm-4">
                                <span><b>Add Specialty</b></span>
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

                            <div class="col-sm-4">
                                <span><b>Sub-Specialty</b></span> 
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
                                    echo "<option value='$speciality' ";
                                    if (in_array($speciality, $selectedSubSpecialityArr)) {
                                        echo " selected ";
                                    }
                                    echo ">$speciality</option>";
                                }
                                ?>
                                </select>
                                    <?php echo $form->error($model, 'sub_speciality'); ?>                                                  
                            </div>

                            <div class="col-sm-4">

                                <label class="control-label">Degree</label> 
<?php
$degree = DegreeMaster::model()->findAll();
$degreenameArr = CHtml::listData($degree, 'degree_id', 'degree_name');
$selectedDegreeArr = Yii::app()->db->createCommand()
        ->select('degree_id')
        ->from('az_doctor_degree_mapping')
        ->where('doctor_id=:id', array(':id' => $model->user_id))
        ->queryColumn();
?>
                                <select multiple="multiple"  class=" multipleselect3" name="UserDetails[degree][]" >
                                <?php
                                foreach ($degreenameArr as $degreeid => $degree) {
                                    echo "<option value='$degreeid' ";
                                    if (in_array($degreeid, $selectedDegreeArr)) {
                                        echo " selected ";
                                    }
                                    echo ">$degree</option>";
                                }
                                ?>
                                    <?php echo $form->error($model, 'degree'); ?>

                                </select>


                            </div>
                        </div>
                        <h4 class="title-details">Free OPD</h4>
                        <div class="form-group clearfix">
                            <div class="col-sm-4">
                                <span>Per Day</span>
<?php
echo $form->textField($model, 'free_opd_perday', array("class" => "form-control"));
echo $form->error($model, 'free_opd_perday');
?>
                            </div>

                            <div class="col-sm-4"><span>Preferred Days</span>
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

                                <select multiple="multiple"  class="form-control2 multipleselect4" name="UserDetails[free_opd_preferdays][]" style="width:80%;">
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
        ->from(' az_clinic_visiting_details')
        ->where('doctor_id =:id', array(':id' => $id))
        ->queryAll();

foreach ($uservisit as $row) {
    $userSelectedDay[$row['day']] = array('clinic_open_time' => $row['clinic_open_time'], 'clinic_close_time' => $row['clinic_close_time'], 'clinic_eve_open_time' => $row['clinic_eve_open_time'], 'clinic_eve_close_time' => $row['clinic_eve_close_time']);
}
?>
                            <div class="col-md-12 day" style="">
                                <ul class="list-inline timing-list">
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
                                                        <input type="text" class="clinictime open_time">
                                                        <label class='text-center'>TO</label>
                                                        <input type="text" class="clinictime close_time">
                                                </div>
                                                </div>
                                                <div class="col-md-6">
                                                <div class="col-sm-2" style="z-index:2;position: relative">
                                                        <label>Evening</label> 
                                                        <input type="text" class="clinictime eve_open_time">
                                                        <label class='text-center'>TO</label>
                                                        <input type="text" class="clinictime eve_close_time">
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
                        <div class="clearfix">&nbsp;</div>
                        <h4 class="title-details">Experience  </h4>
<?php
$expGroupArr = Yii::app()->db->createCommand()
        ->select('work_from,work_to')
        ->from(' az_doctor_experience')
        ->where('doctor_id=:id', array(':id' => $id))
        ->queryRow();
if (!empty($expGroupArr)) {
    ?>
                            <span>Select Year & Month</span>
                            <div class="textdetails">



                                <div class="col-md-8">


                                    <div class="col-md-4">


                                        <select name="DoctorExperience[work_from]" class="expyear form-control">
    <?php
    for ($i = 0; $i <= 30; $i++) {

        if ($expGroupArr['work_from'] == $i) {
            ?><option value="<?php echo $expGroupArr['work_from'] ?>"selected><?php echo $expGroupArr['work_from'] . ' Year' ?></option> <?php } else {
            ?>
                                                    <option value="<?php echo $i; ?>"><?php echo $i . ' Year'; ?></option>
                                                <?php
                                                }
                                            }
                                            ?>

                                        </select>

                                    </div>
                                    <div class="col-md-4">

                                        <select name="DoctorExperience[work_to]" class="expmonth form-control">
    <?php
    for ($i = 0; $i <= 12; $i++) {

        if ($expGroupArr['work_to'] == $i) {
            ?><option value="<?php echo $expGroupArr['work_to'] ?>"selected><?php echo $expGroupArr['work_to'] . ' Month' ?></option> <?php } else {
            ?>
                                                    <option value="<?php echo $i; ?>"><?php echo $i . ' Month'; ?></option>
                                                <?php
                                                }
                                            }
                                            ?>

                                        </select>


                                    </div>

                                </div>



                            </div> <!--end textdetails-->
                            <div class="clearfix"></div>
<?php } else { ?>
                            <span> Select Year & Month</span>
                            <div class="textdetails">
                                <div class="col-md-8">

                                    <div class="">

                                        <div class="col-md-4">

                                            <select name="DoctorExperience[work_from]" class="expyear form-control"></select>
    <?php //  echo $form->error($model1, 'work_from');
    ?>
                                        </div>
                                        <div class="col-md-4">

                                            <select name="DoctorExperience[work_to]" class="expmonth form-control"></select>
    <?php
    // echo $form->error($model1, 'work_to');
    ?>

                                        </div>
                                    </div>           
                                </div>
                            </div>
                            <div class="clearfix"></div>
<?php } ?>


                        <div class="clearfix"></div>

                        <div class="form-group clearfix  text-center">
<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array("class" => "btn btn-primary text-center ")); ?>
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
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.validate.min.js"></script>

<script type="text/javascript">
                                                var dayhtml;
                                                $(function () {

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
                                                            $(".thumbnail").html(html);
                                                            $(".imgname").val(resp);
                                                        });

                                                    });

                                                    var $select = $(".expyear");
                                                    for (i = 0; i <= 30; i++) {
                                                        $select.append($('<option></option>').val(i).html(i + ' Year'))
                                                    }
                                                    var $select1 = $(".expmonth");
                                                    for (i = 0; i <= 12; i++) {
                                                        $select1.append($('<option></option>').val(i).html(i + ' Month'))
                                                    }

                                                });

                                                function clinic_time() {
                                                    var open_time = $('.open_time').val();
                                                    var close_time = $('.close_time').val();
                                                    var eve_open_time = $('.eve_open_time').val();
                                                    var eve_close_time = $('.eve_close_time').val();

                                                    var hiddenhtml = "";
                                                    hiddenhtml = "<div ><input type='hidden'  name='ClinicVisitingDetails[clinic_open_time][]' value='" + open_time + "' class='clinic_open_time'><input type='hidden'  name='ClinicVisitingDetails[clinic_close_time][]' value='" + close_time + "' class='clinic_close_time'><input type='hidden'  name='ClinicVisitingDetails[clinic_eve_open_time][]' value='" + eve_open_time + "' class='clinic_eve_open_time'><input type='hidden'  name='ClinicVisitingDetails[clinic_eve_close_time][]' value='" + eve_close_time + "' class='clinic_eve_close_time'></span><div class='timing-list timeing'>Mon:" + open_time + " - " + close_time + "<br>Evn:" + eve_open_time + " - " + eve_close_time + "</div>"
                                                    $(dayhtml).closest(".weekday").find('.day').before(hiddenhtml);


                                                }
                                                function uncheckday()
                                                {
                                                    var day = $(".day:checked").val();
                                                    $('input:checkbox[value="' + day + '"]').attr('checked', false);
                                                }
                                                function showimg()
                                                {

                                                    $('#myimg').modal('show');
                                                }
                                                function initialize() {
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
                                                }


</script>