<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyA1vr2RVgKBydJQhSo1LUsP3pUcKh4IFGI"></script>
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

$this->renderPartial('commonAjax');

Yii::app()->clientScript->registerScript('myjavascript', '
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
    $(".multipleselect").multipleSelect({
            filter: true,
            multiple: true,
            
            width: "100%",
            multipleWidth: 500
        });
         $(".clinictime").datetimepicker({
                    format: "LT"
                });

     $("#UserDetails_birth_date").datetimepicker({
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
            });'
        , CClientScript::POS_END);
?>
<section class="content-header">

    <h3>Update Doctor</h3>

</section>
<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row"><!-- row start-->
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                    <div class="box-header with-border"><!-- box header start -->
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'update-doctor-details-form',
                            // Please note: When you enable ajax validation, make sure the corresponding
                            // controller action is handling ajax validation correctly.
                            // There is a call to performAjaxValidation() commented in generated controller code.
                            // See class documentation of CActiveForm for details on this.
                            'enableAjaxValidation' => false,
                            'htmlOptions' => array('enctype' => 'multipart/form-data', "class" => "form-horizontal"),
                        ));
                        ?>
                        <div class="text-right"><!--link div-->


                            <?php echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> Manage Doctor ', array('UserDetails/admindoctor'), array("style" => "color: white;", 'class' => 'btn btn-info')); ?>
                        </div><!--link End-->   


                        <div class="box-body">
                            <div class="form-group">
                            <?php echo $form->errorSummary($model); ?>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <span><b> First Name</b></span>
                                    <?php echo $form->textField($model, 'first_name', array('maxlength' => 50, "class" => "form-control", "placeholder" => "e.g xy")); ?>
                                    <?php echo $form->error($model, 'first_name'); ?>
                                </div>
                                <div class="col-sm-4">
                                    <span><b>Last Name</b></span>
                                    <?php echo $form->textField($model, 'last_name', array('maxlength' => 50, "class" => "form-control", "placeholder" => "e.g xy")); ?>
                                    <?php echo $form->error($model, 'last_name'); ?>
                                </div>
                                <div class="col-sm-4">
                                    <span><b>Gender</b></span>
                                    <?php
                                    if (empty($model->gender)) {
                                        $model->gender = 'Male';
                                    }
                                    echo $form->radioButtonList($model, 'gender', array('Male' => 'Male', 'Female' => 'Female'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '&nbsp;&nbsp;&nbsp;', 'container' => 'div class="ui-radio ui-radio-pink"'));
                                    echo $form->error($model, 'gender');
                                    ?>
                                </div> 
                            </div>
                            <div class="form-group">

                                <div class="col-sm-3">
                                    <span><b>Blood Group</b></span>
                                    <?php echo $form->dropDownList($model, 'blood_group', array('O+' => 'O+', 'O-' => 'O-', 'A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'AB+' => 'AB+', 'AB-' => 'AB-'), array('class' => 'otherselect form-control', "data-rule-required" => "false", 'prompt' => 'Select Blood Group', "data-msg-required" => "Please select Blood Group")); ?>
                                    <?php echo $form->error($model, 'blood_group'); ?> 
                                </div>
                                <div class="col-sm-3">
                                    <span><b>Registation Number</b></span> 
                                    <?php
                                    echo $form->textField($model, 'doctor_registration_no', array("class" => "form-control", "data-rule-required" => "false", "data-msg-required" => "Please Enter Registration No"));
                                    echo $form->error($model, 'doctor_registration_no');
                                    ?>
                                </div>
                                <div class="col-sm-3">
                                    <span><b>Date Of Birth</b></span>
                                    <?php
                                    if (!empty($model->birth_date)) {
                                        $model->birth_date = date("d-m-Y",  strtotime($model->birth_date));
                                    }
                                    echo $form->textField($model, 'birth_date', array("data-format" => "dd-MM-yyyy", "class" => "birth_date form-control", "data-rule-required" => "false", "data-msg-required" => "Please Enter Birth Date"));
                                    echo $form->error($model, 'birth_date');
                                    ?>
                                </div>  
                                <div class="col-sm-3">
                                    <label class="control-label">Profile Image</label>
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
                            <div class="clearfix" style="padding:15px"></div>
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <span><b>Specialty</b></span>
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
                                    <span><b>Sub-Specialty</b></span> 
                                    <?php
                                    $specStr = 0;
                                    if (!empty($selectedSpecialityArr))
                                        $specStr = implode(',', $selectedSpecialityArr);


                                    $Criteria = new CDbCriteria();
                                    $Criteria->condition = "speciality_id in($specStr)";

                                    $subspeciality = SubSpeciality::model()->findAll($Criteria);
                                    $subspecialitynameArr = CHtml::listData($subspeciality, 'sub_speciality_id', 'sub_speciality_name');

                                    // print_r($subspecialitynameArr);
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
                                    <span><b> Degree</b> </span>
                                    <?php
                                    $degree = DegreeMaster::model()->findAll();
                                    $degreenameArr = CHtml::listData($degree, 'degree_id', 'degree_name');
                                    $selectedDegreeArr = Yii::app()->db->createCommand()
                                            ->select('degree_id')
                                            ->from('az_doctor_degree_mapping')
                                            ->where('doctor_id=:id', array(':id' => $model->user_id))
                                            ->queryColumn();
                                    ?>
                                    <select multiple="multiple"  class=" multipleselect" name="UserDetails[degree][]" >

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

                            <div class="clearfix" style="padding:15px"></div>

                            <div class="col-sm-4">


                                <span><b>Appointment Contact No 1.</b></span>
                                <?php echo $form->textField($model, 'apt_contact_no_1', array('maxlength' => 30, "class" => "form-control", "data-rule-regexp" => "^[7-9]{1}[0-9]{9,29}$")); ?>
                                <?php echo $form->error($model, 'apt_contact_no_1'); ?>

                                <?php if (empty($model->apt_contact_no_2)) {
                                    ?>
                                    <button type="button" onclick="contactshow('.contact_no_2', this);">+</button>
                                <?php } ?>

                                <div class="clearfix">&nbsp;</div>
                                <div class="contact_no_2"<?php
                                if (!empty($model->apt_contact_no_2)) {
                                    echo "";
                                } else {
                                    echo'hidden=""';
                                }
                                ?>>


                                    <span><b>Appointment Contact No 2.</b></span>
                                    <?php echo $form->textField($model, 'apt_contact_no_2', array('size' => 30, 'maxlength' => 30, "class" => "form-control")); ?> 
                                    <?php echo $form->error($model, 'apt_contact_no_2'); ?>


                                </div>
                            </div>
                            <div class="col-sm-4">


                                <span><b>Email 1.</b></span>
                                <?php echo $form->textField($model, 'email_1', array('size' => 60, 'maxlength' => 200, "class" => "form-control")); ?>
                                <?php echo $form->error($model, 'email_1'); ?>

                                <?php if (empty($model->email_2)) {
                                    ?>
                                    <button type="button" onclick="contactshow('.email_2', this);">+</button>
                                <?php }
                                ?>

                                <div class="clearfix">&nbsp;</div>
                                <div class="email_2"<?php
                                if (!empty($model->email_2)) {
                                    echo "";
                                } else {
                                    echo'hidden=""';
                                }
                                ?>>


                                    <span><b>Email 2.</b></span>
                                    <?php echo $form->textField($model, 'email_2', array('size' => 60, 'maxlength' => 200, "class" => "form-control")); ?> 
                                    <?php echo $form->error($model, 'email_2'); ?>

                                </div>
                            </div>
                            <div class="clearfix" style="padding:15px"></div>
                            <div class="col-md-12">
                                <h4 class="box-title">About You</h4>
                            </div>  
                            <div class="col-sm-8">

                                <?php echo $form->textArea($model, 'description', array('class' => 'form-control', 'size' => 60, 'maxlength' => 250)); ?>
                                <?php echo $form->error($model, 'description'); ?>
                            </div>

                            <div class="clearfix" style="padding:15px"></div>
                            <div class="col-md-12">
                                <h4 class="box-title">Location</h4>
                            </div>  
                            <div class="col-md-4">
                                <span><b>Zip Code</b></span>
                                <?php
                                if (isset($session['pincode'])) {
                                    $model->pincode = $session['pincode'];
                                }
                                echo $form->textField($model, 'pincode', array("class" => "form-control input-group pincode-id-class"));
                                echo $form->error($model, 'pincode');
                                ?>
                            </div> 
                            <div class="col-md-4">
                                <span><b>State</b></span>
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
                                <span><b>City</b></span>
                                <?php
                                $cityArr = array();

                                if (isset($session['city_id'])) {
                                    $model->city_id = $session['city_id'];
                                }
                                $cityType = Yii::app()->db->createCommand()->select("city_id,city_name")->from("az_city_master")->where("state_id = :state_id", array(":state_id" => $model->state_id))->queryAll();
                                foreach ($cityType as $row) {
                                    $cityArr[$row['city_id']] = $row['city_name'];
                                }
                                echo $form->dropDownList($model, 'city_id', $cityArr, array("class" => "form-control cityId city-class", "style" => "width:100%;", "prompt" => "Select City", "data-rule-required" => "true", "data-msg-required" => "Please Select City", 'onchange' => 'getArea()'));
                                echo $form->error($model, 'city_id');
                                if (isset($session['city_name'])) {
                                    $model->city_name = $session['city_name'];
                                }
                                echo $form->hiddenField($model, "city_name", array("class" => "city-id-class"));
                                ?>

                            </div>
                            <div class="col-md-4">
                                <span><b>Area</b></span>
                                <?php
                                $areaArr = array();
                                $selected = array();
                                $stateType = Yii::app()->db->createCommand()->select("area_id,area_name")->from("az_area_master")->where("city_id = :cityid", array(":cityid" => $model->city_id))->queryAll();
                                foreach ($stateType as $row) {
                                    $areaArr[$row['area_id']] = $row['area_name'];
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
                                <span><b>Landmark</b></span>
                                <?php
                                if (isset($session['landmark'])) {
                                    $model->landmark = $session['landmark'];
                                }
                                echo $form->textField($model, 'landmark', array("class" => "form-control input-group"));
                                echo $form->error($model, 'landmark');
                                ?>
                            </div>  
                            <div class="col-sm-4">
                                <b><span>Address</span></b>  
                                <?php
                                echo $form->textField($model, 'address', array("class" => "form-control input-group", "onclick" => "initialize();"));
                                echo $form->error($model, 'address');
                                ?>
                            </div>
                        </div>

                        <div class="textdetails">
                            <div class="col-md-12" > 
                                <h4 class="title-details">Experience</h4>
                                <div class="addexper">
                                    <div class="col-md-8">
                                        <span> Select Year & Month</span>
                                        <div class="">
                                            <div class="col-md-4">
                                                <?php
                                                $expyeararr = range(0, 30);
                                                echo $form->dropDownList($doctorexp, 'work_from', $expyeararr, array("class" => "form-control", "style" => "width:100%;"));
                                                ?>
                                            </div>
                                            <div class="col-md-4">
                                                <?php
                                                $expmontharr = range(0, 12);
                                                echo $form->dropDownList($doctorexp, 'work_to', $expmontharr, array("class" => "form-control", "style" => "width:100%;"));
                                                ?>
                                            </div>
                                        </div>           
                                    </div>
                                </div> <!--end textdetails-->
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        
                        <div class=" text-center">


                            <?php echo CHtml::submitButton("Submit", array('class' => 'btn btn-info')); ?>
                        </div>


                    </div><!-- box header end -->
                    <?php $this->endWidget(); ?>
                </div><!-- box end -->
            </div> <!-- column col-lg-12 end -->
        </div><!--row end-->
    </section> <!-- section content End -->
</div><!-- tab-content end-->
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
                    var pinarray = [];
                    var dayhtml;
                    $(function () {
                        $(".speciality-class").change(function () {
                            getSubSpeciality();
                        });
                        // $('.contact_no_2').hide();
                        $(".countryId").change(function () {
                            var country = 1;
                            // alert(country);
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
                        $.validator.addMethod(
                                "regexp",
                                function (value, element, regexp) {
                                    var re = new RegExp(regexp);
                                    return this.optional(element) || re.test(value);
                                },
                                "Please check your input."
                                );
                        $("#update-doctor-details-form").validate({
                            rules: {
                                "UserDetails[first_name]": {
                                    required: true,
                                    maxlength: 50,
                                    regexp: /^[a-zA-Z]+$/,
                                }, "UserDetails[last_name]": {
                                    required: true,
                                    maxlength: 50,
                                    regexp: /^[a-zA-Z]+$/,
                                },
                                "UserDetails[mobile]": {
                                    required: true,
                                    maxlength: 10,
                                    regexp: /^[7-9]{1}[0-9]{9}$/,
                                },
                                "UserDetails[apt_contact_no_1]": {
                                    required: true,
                                    // maxlength: 30,
                                    regexp: /^[7-9]{1}[0-9]{9,29}$/,
                                },
                                "UserDetails[apt_contact_no_2]": {
                                    // maxlength: 30,
                                    regexp: /^[7-9]{1}[0-9]{9,29}$/,
                                },
                                "UserDetails[email_1]": {
                                    required: true,
                                    email: true,
                                    //regexp: /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/,
                                    maxlength: 100
                                },
                                "UserDetails[email_2]": {
                                    email: true,
                                    //regexp: /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/,
                                    maxlength: 100
                                },
                                "UserDetails[country_id]": {
                                    required: true
                                },
                                "UserDetails[state_id]": {
                                    required: true
                                },
                                "UserDetails[city_id]": {
                                    required: true
                                },
                                "UserDetails[area_id]": {
                                    required: true
                                },
                                "UserDetails[pincode]": {
                                    required: true,
                                    maxlength: 6,
                                    // regexp: /^[1-9]{1}[0-9]{5}$/
                                },
                                "UserDetails[description]": {
                                    required: true,
                                    maxlength: 250,
                                    regexp: /^[a-zA-Z0-9_,.'/\n/ ]*$/},
                            },
                            // Specify the validation error messages
                            messages: {
                                "UserDetails[first_name]": {
                                    required: "Please Enter First Name",
                                    regexp: "Invalid First Name"
                                },
                                "UserDetails[last_name]": {
                                    required: "Please Enter Last Name",
                                    regexp: "Invalid Last Name"
                                },
                                "UserDetails[apt_contact_no_1]": {
                                    required: "Please Select Appointment Contact No",
                                    regexp: "Invalid  Appointment Contact No",
                                    maxlength: "Invalid  Appointment Contact No"
                                },
                                "UserDetails[apt_contact_no_2]": {
                                    regexp: "Invalid  Appointment Contact No",
                                    maxlength: "Invalid  Appointment Contact No"
                                },
                                "UserDetails[mobile]": {
                                    required: "Please Select Mobile Number",
                                    regexp: "Invalid Mobile Number",
                                    maxlength: "Invalid Mobile Number"
                                },
                                "UserDetails[email_1]": {
                                    maxlength: "Invalid Email-address",
                                    regexp: "Invalid Email-address",
                                    required: "Please Enter Email-ID",
                                    email: "Invalid Email-ID"},
                                "UserDetails[email_2]": {
                                    maxlength: "Invalid Email-address",
                                    regexp: "Invalid Email-address",
                                    required: "Please Enter Email-ID",
                                    email: "Invalid Email-ID"},
                                "UserDetails[country_id]": {
                                    required: "Please select Country",
                                },
                                "UserDetails[state_id]": {
                                    required: "Please select State",
                                },
                                "UserDetails[city_id]": {
                                    required: "Please select City",
                                },
                                "UserDetails[area_id]": {
                                    required: "Please select Area",
                                },
                                "UserDetails[pincode]": {
                                    required: "Please Enter Pincode",
                                    //regexp: "Invalid Pincode",
                                },
                                "UserDetails[description]": {
                                    required: "Please Enter About Yourself",
                                    regexp: "Invalid description",
                                },
                            }
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
                    });
                    function clinic_time() {
                        var open_time = $('.open_time').val();
                        var close_time = $('.close_time').val();
                        var eve_open_time = $('.eve_open_time').val();
                        var eve_close_time = $('.eve_close_time').val();
                        var hiddenhtml = "";
                        hiddenhtml = "<span ><input type='hidden'  name='ClinicVisitingDetails[clinic_open_time][]' value='" + open_time + "' class='clinic_open_time'><input type='hidden'  name='ClinicVisitingDetails[clinic_close_time][]' value='" + close_time + "' class='clinic_close_time'><input type='hidden'  name='ClinicVisitingDetails[clinic_eve_open_time][]' value='" + eve_open_time + "' class='clinic_eve_open_time'><input type='hidden'  name='ClinicVisitingDetails[clinic_eve_close_time][]' value='" + eve_close_time + "' class='clinic_eve_close_time'></span><div class='timing-list timeing'>Mon:" + open_time + " - " + close_time + "<br>Evn:" + eve_open_time + " - " + eve_close_time + "</div><br>"
                        $(dayhtml).closest(".weekday").find('.day').before(hiddenhtml);


                    }

                    function contactshow(htmlobj, currentHtml)
                    {
                        $(htmlobj).show();
                        $(currentHtml).hide();
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
//  var pinarray =[];
                    function getAreaid() {
                        var area1 = $('.area-class option:selected').val();
                        var area = $('.area-class option:selected').text();
                        //  alert(area1);
                        $(".area-id-class").val(area);
                        var pincode = pinarray[area1];                                             //  alert(pincode);
                        // alert(area1);
                        //alert(pincode);
                        $(".pincode-id-class").val(pincode);
                    }
                    function initialize() {

                        if (jQuery("#UserDetails_address").length > 0) {
                            var input = document.getElementById("UserDetails_address");
                            var autocomplete = new google.maps.places.Autocomplete(input);
                            google.maps.event.addListener(autocomplete, "place_changed", function () {
                                var place = autocomplete.getPlace();

                            });
                        }
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

                    function getArea()
                    {
                        var area = $('.city-class option:selected').val();
                        var area1 = $('.city-class option:selected').text();
                        //   var pinarray=[];
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
                                    // var pincode=value.pincode;
                                    //  alert(pincode);
                                    pinarray[value.area_id] = value.pincode;
                                    areaname += "<option value='" + value.area_id + "'>" + value.area_name + "</option>";
                                });
                                $(".areaId").html(areaname);
                                //  alert(areaname);
                                //  alert(pinarray);
                            }
                        });
                    }
                    function showimg()
                    {

                        $('#myimg').modal('show');
                    }
                    function uncheckday()
                    {
                        var day = $(".day:checked").val();
                        $('input:checkbox[value="' + day + '"]').attr('checked', false);
                    }

</script>