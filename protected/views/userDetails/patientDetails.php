<?php
/* @var $this ClinicDetailsController */
/* @var $model ClinicDetails */
/* @var $form CActiveForm */

$session = new CHttpSession;
$session->open();
$baseUrl = Yii::app()->request->baseUrl;
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

Yii::app()->clientScript->registerScript('myjavascript', '
    
  $.validator.addMethod(
        "regexp",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Please check your input."
    );
    $("#update-patient-details-form").validate({
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
<section id="intro" class="section-details">


    <div class="overlay">
        <div  class="container">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'update-patient-details-form',
                'htmlOptions' => array('enctype' => 'multipart/form-data', "class" => "w3-container"),
                'enableAjaxValidation' => false,
            ));
            ?>

            <div class="row">
                <?php
                $enc_key = Yii::app()->params->enc_key;

                $path = $baseUrl . "/uploads/" . $model->profile_image;
                // echo $path.'hiii';
                if (empty($model->profile_image)) {
                    $path = $baseUrl . "/images/icons/icon01.png";
                }
                ?>
                <div class="col-md-3" style="background-image:url(images/icon46.png);height: 700px;background-size: 100% auto;background-position: center center;">

                    <div class="fileinput fileinput-new" data-provides="fileinput" style="position: relative;">
                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="background: transparent;width:140px;height:140px;text-align: center; margin: auto;border-radius: 50%;overflow: hidden;">
                            <?php
                            if (empty($model->profile_image)) {
                                echo CHtml::image(Yii::app()->request->baseUrl . "/images/icons/icon01.png", "Profile Photo", array("class" => "img-circle", "width" => "150"));
                            } else {
                                ?>
                                <img alt="shortcut icon" src="<?php echo $path ?>" class="img-circle" width="137px" border="1px solid #dfdfdf" height="137px"/>  
                            <?php }
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
                <div class="tab-content col-md-9"> 

                    <div class="profile-note text-right" style="color:black;">
                        <a href="<?php echo $this->createUrl('userDetails/patientAppointments'); ?>" style="color:#0db7a8;">Appointments</a> 
                    </div>
                    <h3 class="title">Patient Details </h3>
                    <div class="textdetails">
                        <div class="col-md-4">
                            <span>first Name</span>
                            <?php
                            if (isset($session['first_name'])) {
                                $model->first_name = $session['first_name'];
                            }
                            ?>
                            <?php echo $form->textField($model, 'first_name', array("class" => "w3-input input-group", "data-rule-required" => "true", "data-msg-required" => "Please Enter Name", "data-rule-regexp" => "^[\w.,-\s\n\/\']+$")); ?>
                            <?php echo $form->error($model, 'first_name'); ?>
                        </div>
                        <div class="col-md-4">
                            <span>last Name</span>
                            <?php
                            if (isset($session['last_name'])) {
                                $model->last_name = $session['last_name'];
                            }
                            ?>

                            <?php echo $form->textField($model, 'last_name', array("class" => "w3-input input-group", "data-rule-required" => "true", "data-msg-required" => "Please Enter L Name", "data-rule-regexp" => "^[\w.,-\s\n\/\']+$")); ?>
                            <?php echo $form->error($model, 'last_name'); ?>                                             
                        </div>
                    </div> <!--end textdetails-->
                    <div class="clearfix"></div>
                    <div class="textdetails">                                                    	
                        <?php echo $form->labelEx($model, 'gender'); ?>
                        <div class="clearfix"></div>
                        <div class="col-md-4">
                            <?php
                            if (empty($model->gender)) {
                                $model->gender = 'Male';
                            }
                            echo $form->radioButtonList($model, 'gender', array('Male' => 'Male', 'Female' => 'Female'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '&nbsp;&nbsp;&nbsp;', 'template' => '<label class="ui-radio-inline">{input} <span>{label}</span></label>', 'container' => 'div class="ui-radio ui-radio-pink"'));
                            ?>
                            <?php echo $form->error($model, 'gender'); ?>                                                
                        </div>
                        <div class="col-md-4" style="">
                            <?php echo $form->labelEx($model, 'birth_date'); ?>                                                                                                    <?php
                            if (!empty($model->birth_date)) {
                                $model->birth_date = date("d-m-Y", strtotime($model->birth_date));
                            }
                            echo $form->textField($model, 'birth_date', array("data-format" => "dd-MM-yyyy", "class" => "birth_date w3-input input-group", "data-rule-required" => "true", "data-msg-required" => "Please Enter Birth Date"));
                            ?>
                            <?php echo $form->error($model, 'birth_date'); ?> 
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="textdetails">
                        <div class="col-md-4" style="">
                            <?php echo $form->labelEx($model, 'blood_group'); ?>
                            <?php echo $form->dropDownList($model, 'blood_group', array('O+' => 'O+', 'O-' => 'O-', 'A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'AB+' => 'AB+', 'AB-' => 'AB-'), array('class' => 'otherselect form-control w3-input input-group', "data-rule-required" => "true", 'prompt' => 'Select Blood Group', "data-msg-required" => "Please select Blood Group")); ?>
                            <?php echo $form->error($model, 'blood_group'); ?>                                                                  <?php echo $form->hiddenField($model, 'age', array("class" => "form-control age1")); ?>
                        </div>
                        
                         <div class="col-md-4">
                                <label class="">Blood Donor Consent</label>
                                <?php
                                echo $form->dropDownList($model, 'bld_donor_consent', array("Yes" => "Yes", "No" => "No"), array("class" => "form-control w3-input input-group"));
                                ?>
                            </div>

                    </div>  
                    <div class="clearfix"></div>
                    <div class="textdetails">
                        <div class="col-md-5 contacts">
                            <span>Contact Number</span>
                            <?php
                            echo $form->numberField($model, 'apt_contact_no_1', array("class" => "w3-input input-group", "data-msg-required" => "Please Enter contact no", "data-rule-regexp" => "^[7-9]{1}[0-9]{9,29}$"));
                            echo $form->error($model, 'apt_contact_no_1');
                            ?>
                            <a class="btn-block" href="javascript:" onclick="$('.contact_no_2').show();
                                    $(this).hide();"><i class="fa fa-plus" aria-hidden="true"></i> Add Contact Number </a>

                            <br>
                            <div class="contact_no_2" hidden="">
                                <?php
                                echo $form->numberField($model, 'apt_contact_no_2', array("class" => "w3-input input-group", "data-msg-required" => "Please Enter contact no", "data-rule-regexp" => "^[7-9]{1}[0-9]{9,29}$"));
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
                            echo $form->textField($model, 'email_1', array('maxlength' => 100, "class" => "w3-input input-group", "data-rule-regexp" => "[/^.{1,}@.{2,}\..{2,}/]"));
                            echo $form->error($model, 'email_1');
                            ?>
                            <a class="btn-block" href="javascript:" onclick="$('.email_2').show();
                                    $(this).hide();"><i class="fa fa-plus" aria-hidden="true"></i> Add Email Address </a>
                            <br>
                            <!--                                            
                                                                        <button type="button" onclick="email();">+</button>-->
                            <div class="email_2" hidden="">
                                <?php
                                if (isset($session['email_2'])) {
                                    $model->email_2 = $session['email_2'];
                                }
                                echo $form->textField($model, 'email_2', array('maxlength' => 200, "class" => "w3-input input-group", "data-rule-required" => "true", "data-msg-required" => "Please Enter email"));
                                echo $form->error($model, 'email_2');
                                ?>
                            </div>    
                        </div>
                    </div> <!--end textdetails-->
                    <div class="clearfix">&nbsp;</div>

                    <div class="textdetails">
                        <h4 class="title-details">Address</h4>
                        <div class="col-md-4">
                            <span>Zip Code</span>
                            <?php
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
                            echo $form->dropDownList($model, 'state_id', $stateArr, array("class" => "w3-input state-class", "style" => "width:100%;", "prompt" => "Select State", "data-rule-required" => "true", "data-msg-required" => "Please Select State", 'onchange' => 'getCity()'));
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
                            if (!empty($model->state_id)) {
                                $citycmd = Yii::app()->db->createCommand()->select('city_id,city_name')->from('az_city_master')->where('state_id=:id', array(':id' => $model->state_id))->queryAll();
                                foreach ($citycmd as $row) {
                                    $cityArr[$row['city_id']] = $row['city_name'];
                                }
                            }

                            echo $form->dropDownList($model, 'city_id', $cityArr, array("class" => "w3-input cityId city-class", "style" => "width:100%;", "prompt" => "Select City", "data-rule-required" => "true", "data-msg-required" => "Please Select City", 'onchange' => 'getArea()'));
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

                            echo $form->dropDownList($model, 'area_id', $areaArr, array("class" => "w3-input area-class areaId", "style" => "width:100%;", "prompt" => "Select Area", "data-rule-required" => "true", "data-msg-required" => "Please Select Area", 'onchange' => 'getAreaid()'));
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
                            echo $form->textField($model, 'landmark', array("class" => "w3-input input-group"));
                            echo $form->error($model, 'landmark');
                            ?>

                        </div>
                        <div class="col-md-4">
                            <span>Street Address</span>
                            <?php
                            echo $form->textField($model, 'address', array("class" => "w3-input input-group", "data-rule-required" => "true", "data-msg-required" => "Please enter Address"));
                            echo $form->error($model, 'address');
                            ?>

                        </div>

                    </div>

                    <div class="clearfix">&nbsp;</div>

                    <div class="w3-content w3-display-container">
                        <div class="mySlides"  id="slide4">
                            <h4 class="title">Bank A/C Details</h4>

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


                        </div>
                    </div>


                    <div class="text-center">
                        <?php
                        echo CHtml::submitButton("Save  ", array('class' => 'btn center'));
                        ?>
                    </div>
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
                                var pinarray = [];
                                var opentimearray = [];
                                var closetimearray = [];
                                var slideIndex = 1;
                                var dayhtml;

                                $(function () {

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
                                function showimg()
                                {

                                    $('#myimg').modal('show');
                                }

</script>