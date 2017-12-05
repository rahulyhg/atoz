<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/select2.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/multiple-select.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/bootstrap-datetimepicker.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jquery.timepicker.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/radio_style.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/moment-with-locales.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-datetimepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/select2.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/multiple-select.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.timepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.validate.min.js', CClientScript::POS_END);

Yii::app()->clientScript->registerScript('myjavascript', '
    $("#hospital-doctor-details-form").validate({
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

      $(".multipleselect1").multipleSelect({
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
            placeholder: "Select Days",
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
              format:"DD-MM-YYYY",
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

    <h3>Create Hospital Doctor</h3>

</section>
<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row"><!-- row start-->
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                    <div class="box-header with-border"><!-- box header start -->
                        <div class="text-right"><!--link div-->


                            <?php echo CHtml::link('<i class = "fa fa-gear fa-fw"></i> Manage Hospital Doctors', array('userDetails/manageHospitalDoctor', "param1" => base64_encode($param1)), array("style" => "color: white;", 'class' => 'btn btn-info')) ?>


                        </div><!--link End-->    
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'hospital-doctor-details-form',
                            'enableAjaxValidation' => false,
                            'htmlOptions' => array('enctype' => 'multipart/form-data', "class" => "form-horizontal"),
                        ));
                        ?>


                        <?php echo $form->errorSummary($model); ?>
                        <div class="form-group clearfix">
                            <div class="col-sm-4">
                                <label class="control-label" style="color:red">OPD NUMBER</label>
                                <?php echo $form->textField($model, 'opd_no', array('maxlength' => 200, "class" => "form-control", "data-rule-required" => "true", "data-msg-required" => "Please Enter OPD No")); ?>
                                <?php echo $form->error($model, 'opd_no'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class=" col-offset-1 col-sm-4">
                                <?php echo $form->labelEx($model, 'first_name', array("class" => "control-label")); ?>
                                <strong class="mandatory">*</strong>
                                <?php
                                echo $form->textField($model, 'first_name', array('maxlength' => 60, 'class' => 'form-control ', "data-rule-required" => "true", "data-msg-required" => "Please Enter First Name"));
                                echo $form->error($model, 'first_name');
                                ?>
                            </div> 

                            <div class="col-sm-4">
                                <?php echo $form->labelEx($model, 'last_name', array("class" => "control-label")); ?><strong class="mandatory">*</strong>
                                <?php
                                echo $form->textField($model, 'last_name', array('maxlength' => 60, 'class' => 'form-control ', "data-rule-required" => "true", "data-msg-required" => "Please Enter Last Name"));
                                echo $form->error($model, 'last_name');
                                ?>
                            </div>

                            <div class="col-sm-3">
                                <label class="control-label">Profile Image</label>
                                <div class="fileinput fileinput-new" data-provides="fileinput" style="position: relative;">
                                    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="background: transparent;width:140px;height:140px;text-align: center; margin: auto;border-radius: 50%;overflow: hidden;">
                                        <?php
                                        if (empty($model->profile_image)) {
                                            echo CHtml::image(Yii::app()->request->baseUrl . "/images/icons/icon01.png", "Profile Photo", array("class" => "img-circle", "width" => "150"));
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
                                echo $form->textField($model, 'birth_date', array("data-format" => "dd-MM-yyyy", "class" => "birth_date form-control"));
                                echo $form->error($model, 'birth_date');
                                ?>
                            </div> 

                            <div class="col-sm-4">
                                <?php echo $form->labelEx($model, 'blood_group', array("class" => "control-label")); ?>
                                <?php echo $form->dropDownList($model, 'blood_group', array('O+' => 'O+', 'O-' => 'O-', 'A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'AB+' => 'AB+', 'AB-' => 'AB-'), array('class' => 'otherselect form-control')); ?>
                                <?php echo $form->error($model, 'blood_group'); ?> 
                            </div>
                        </div>

                        <div class="form-group">
                            <h4>Login Details</h4>
                            <div class="col-sm-4">
                                <?php echo $form->labelEx($model, 'mobile', array("class" => "control-label")); ?>
                                <?php
                                echo $form->textField($model, 'mobile', array('maxlength' => 10, "class" => "form-control mobileclass ", "data-msg-required" => "Please Enter Mobile", "data-rule-required" => "true", "onblur" => "chk_mobile(this)"));
                                ?> 
                                <span id="mobileno" style="color: red;"></span>
                                <?php echo $form->error($model, 'mobile'); ?>
                            </div> 
                            <div class="col-sm-4">
                                <?php echo $form->labelEx($model, 'password', array("class" => "control-label")); ?>
                                <?php
                                echo $form->passwordField($model, 'password', array("class" => "birth_date form-control", "data-rule-required" => "true", "data-msg-required" => "Please Enter Password"));
                                echo $form->error($model, 'password');
                                ?>
                            </div> 
                        </div>
                        <div class="form-group">


                            <div class="col-sm-4">
                                <?php echo $form->labelEx($model, 'doctor_registration_no', array("class" => "control-label")); ?>
                                <?php
                                echo $form->textField($model, 'doctor_registration_no', array("class" => "form-control"));
                                echo $form->error($model, 'doctor_registration_no');
                                ?>
                            </div> 
                            <div class="col-sm-3">

                                <?php echo $form->labelEx($model, 'doctor_fees', array("class" => "control-label")); ?>
                                <?php
                                echo $form->textField($model, 'doctor_fees', array("class" => "form-control"));
                                echo $form->error($model, 'doctor_fees');
                                ?>
                            </div> 
                            <!--                                  <div class="col-sm-4">
                            <?php //echo $form->labelEx($model, 'experience', array("class" => "control-label")); ?>
                            <?php
                            //echo $form->textField($model, 'experience', array("class" => "form-control"));
                            //echo $form->error($model, 'experience');
                            ?>
                                                        </div>-->
                        </div>
                        <div class="form-group clearfix">
                            <h4>Other Details</h4>
                            <div class="form-group clearfix">

                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Specialty</label>
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
                                <label class="control-label">Sub-Specialty</label> 
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

                            <div class="col-sm-4">
                                <label class="control-label">Degree</label> 
                                <?php
                                $degree = DegreeMaster::model()->findAll();
                                $degreenameArr = CHtml::listData($degree, 'degree_id', 'degree_name');
                                ?>
                                <select multiple="multiple"  class="multipleselect3" name="UserDetails[degree][]" data-rule-required = "true"  data-msg-required = "Please Select Degree" >
                                    <?php
                                    foreach ($degreenameArr as $degreeid => $degree) {
                                        echo "<option value='$degreeid' ";

                                        echo ">$degree</option>";
                                    }
                                    ?>
                                </select>


                                <?php echo $form->error($model, 'degree'); ?>
                            </div> 



                        </div>
                        <div class="form-group clearfix">


                            <div class="col-sm-4">
                                <label class="control-label">Book Your Appointment Contact No</label>  
                                <?php
                                echo $form->textField($model, 'apt_contact_no_1', array("class" => "form-control", "data-rule-regexp" => "^[7-9]{1}[0-9]{9,29}$"));
                                echo $form->error($model, 'apt_contact_no_1');
                                ?>
                            </div> 

                            <div class="col-sm-4">
                                <label class="control-label">Email Address</label>
                                <?php echo $form->textField($model, 'email_1', array("data-rule-regexp" => "^[7-9]{1}[0-9]{9,29}$", "class" => "form-control")); ?>
                                <?php echo $form->error($model, 'email_1'); ?>
                            </div>


                        </div>

                        <div class="form-group clearfix">
                            <br><h4 class="title-details">Free OPD</h4>
                            <div class="col-sm-4"> 
                                <span>Per Day</span>
                                <?php
                                echo $form->textField($model, 'free_opd_perday', array("class" => "form-control", "data-rule-regexp" => "^[\d]+$"));
                                echo $form->error($model, 'free_opd_perday');
                                ?>
                            </div>
                            <div class="col-md-4"><span>Preferred Days</span>
                                <?php
                                // DAY_STR is constant which contains array of Days
                                $DayArr = explode(";", Constants:: DAY_STR);
                                $DayFinalArr = array_combine($DayArr, $DayArr);
                                echo $form->dropDownList($model, 'free_opd_preferdays[]', $DayFinalArr, array("class" => "multipleselect4 form-control1", 'multiple' => 'multiple'));

                                echo $form->error($model, 'free_opd_preferdays');
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <b><span>About You</span></b> 
                            <?php echo $form->textArea($model, 'description', array('class' => 'form-control', 'maxlength' => 250)); ?>
                            <?php echo $form->error($model, 'description'); ?>
                        </div>

                        <div class="textdetails">
                            <h4 class="title-details">Timings</h4>
                            <div class="col-md-12" style=""> 
                                <label><input  type="checkbox" name="ClinicDetails[alldayopen]" value="Y" onclick="isalldayopen(this)" class="isall"> 24x7</label>
                            </div>

                            <div class="col-md-12 day" style="">
                                <ul class="list-inline ">
                                    <li id="mon" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="Monday"> Monday</li>
                                    <li id="tue" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="Tuesday"> Tuesday</li>
                                    <li id="wed" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="Wednesday"> Wednesday</li>
                                    <li id="thur" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="Thursday"> Thursday</li>
                                    <li id="fri" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="Friday"> Friday</li>
                                    <li id="sat" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="Saturday"> Saturday</li>
                                    <li id="sun" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="Sunday"> Sunday</li>
                                </ul>

                            </div>

                            <div class="clearfix"></div>

                            <h4 class="title-details">Experience</h4>
                            <div class="textdetails">
                                <div class="addexper">
                                    <div class="col-md-8">
                                        <span> Select Year & Month</span>
                                        <div class="">
                                            <div class="col-md-4">
                                                <select name="DoctorExperience[work_from]" class="expyear form-control"></select>
                                            </div>
                                            <div class="col-md-4">
                                                <select name="DoctorExperience[work_to]" class="expmonth form-control"></select>
                                            </div>
                                        </div>           
                                    </div>
                                </div> <!--end textdetails-->
                                <div class="clearfix"></div>

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
                        <div class="row buttons text-center">
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
<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/css/croppie.css">
<script src="<?php echo Yii::app()->baseUrl; ?>/js/croppie.js"></script>
<script type="text/javascript">
                                                var dayhtml;
                                                $(function () {
                                                    $(".specialityid").change(function () {
                                                        var speciality = $('.specialityid option:selected').val();
                                                        var speciality1 = $('.specialityid option:selected').text();
                                                        $(".specialityname").val(speciality1);

                                                    });

                                                    var $select = $(".expyear");
                                                    for (i = 0; i <= 30; i++) {
                                                        $select.append($('<option></option>').val(i).html(i + ' Year'))
                                                    }
                                                    var $select1 = $(".expmonth");
                                                    for (i = 0; i <= 12; i++) {
                                                        $select1.append($('<option></option>').val(i).html(i + ' Month'))
                                                    }


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
                                                function uncheckday()
                                                {
                                                    var selected_day = new Array();
                                                    $('input[name="ClinicVisitingDetails[day][]"]:checked').each(function () {
                                                        selected_day.push($(this).val());

                                                    });
                                                    var lastEl = selected_day[selected_day.length - 1];
                                                    $('input:checkbox[value="' + lastEl + '"]').attr('checked', false);
                                                }
                                                function showimg()
                                                {

                                                    $('#myimg').modal('show');
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
</script>