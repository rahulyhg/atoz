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

Yii::app()->clientScript->registerScript('myjavascript', '
    
  $.validator.addMethod(
        "regexp",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Please check your input."
    );
    $("#create-admin-patient-form").validate({
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

<section class="content-header">

    <h3>Create Patients</h3>

</section>
<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row"><!-- row start-->
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                    <div class="box-header with-border"><!-- box header start -->
                        <div class="text-right"><!--link div-->

                            <?php echo CHtml::link('<i class = "fa fa-gear fa-fw"></i> Manage Patients', array('userDetails/adminpatient'), array("style" => "color: white;", 'class' => 'btn btn-')) ?>

                        </div><!--link End-->    
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'create-admin-patient-form',
                            'htmlOptions' => array('enctype' => 'multipart/form-data', "class" => "w3-container"),
                            'enableAjaxValidation' => false,
                        ));
                        ?>



                        <?php
                        $enc_key = Yii::app()->params->enc_key;

                        $path = $baseUrl . "/uploads/" . $model->profile_image;
                        ?>
                        <div class="form-group clearfix">
                          
                            <div class="col-sm-8 patient_type clearfix">
                                <div class="loginheadingmargin">
                                    <label style="display: inline;"><input type="radio" name="UserDetails[patient_type]" value="Individual" checked class="selectuser" > Individual</label>
                                    <label style="display: inline;"><input type="radio" name="UserDetails[patient_type]" value="Premium member" class="selectuser" > Premium member</label>
                                    <label style="display: inline;"><input type="radio" name="UserDetails[patient_type]" value="Corporate" class="selectuser" > Corporate </label>
                                </div>




                            </div><div  class="clearfix"></div>
                        </div>
                        <div class="form-group company_name clearfix">
                            <label class="col-md-2 nopadding">Company Name</label>
                            <div class="col-md-4 nopadding">
                                <input type="text" name="UserDetails[company_name]" maxlength="10" class="form-control company_name1" placeholder="Company Name" value=""><span id="company_name" class="error1"></span>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                        <div  class="clearfix"></div>
                        <div class="form-group clearfix role">
                            <label class="nopadding">VVIP</label>
                            <div class="col-md-4" style="">
                                <input type="text" name="UserDetails[vip_role]" class="form-control col-sm-6 role1" placeholder="VVIP" value=""><span id="role" class="error1" ></span>
                            </div>
                            <div class="clearfix"></div>
                        </div> 
                        <div  class="clearfix"></div>
                        <div class="form-group fullname">
                            <label class="col-md-12 nopadding fullnamelbl" >Full Name</label>
                            <div class="col-md-4 nopadding">
                                <input type="text" name="UserDetails[first_name]" class="form-control firstname1" placeholder="First Name" value=""><span id="firstname" class="error1"></span>
                            </div>
                            <div class="col-md-4" style="padding-right: 0;">
                                <input type="text" name="UserDetails[last_name]" class="form-control col-sm-6 lastname1" placeholder="Last Name" value="" ><span id="lastname" class="error1"></span>
                            </div>
                            <div class="col-md-4 fileinput fileinput-new" data-provides="fileinput" style="position: relative;">
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
                            
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group">                                                    	
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
                                <?php echo $form->labelEx($model, 'birth_date'); ?>                                                                                                      <?php echo $form->textField($model, 'birth_date', array("data-format" => "dd-MM-yyyy", "class" => "birth_date form-control", "data-rule-required" => "true", "data-msg-required" => "Please Enter Birth Date")); ?>
                                <?php echo $form->error($model, 'birth_date'); ?> 
                            </div>

                            <div class="col-md-4" style="">
                                <?php echo $form->labelEx($model, 'blood_group'); ?>
                                <?php echo $form->dropDownList($model, 'blood_group', array('O+' => 'O+', 'O-' => 'O-', 'A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'AB+' => 'AB+', 'AB-' => 'AB-'), array('class' => 'otherselect form-control w3-input input-group', "data-rule-required" => "true", 'prompt' => 'Select Blood Group', "data-msg-required" => "Please select Blood Group")); ?>
                                <?php echo $form->error($model, 'blood_group'); ?>                                                                  <?php echo $form->hiddenField($model, 'age', array("class" => "form-control age1")); ?>
                            </div>
                            <div class="clearfix">&nbsp;</div>
                        </div>  

                        <div class="form-group clearfix">
                            <div class="col-md-4 ">
                                <?php echo $form->labelEx($model, 'Mobile'); ?>
                                <?php echo $form->numberField($model, 'mobile', array('maxlength' => 10, "class" => "w3-input input-group mobileclass form-control", "data-msg-required" => "Please Enter Mobile", "data-rule-required" => "true", "data-rule-regexp" => "^[\d]+$", "onblur" => "chk_mobile()")); ?>
                                <span id="mobileno" style="color: red;"></span>
                                <?php echo $form->error($model, 'mobile'); ?>  
                            </div>
                            <div class="col-md-4 ">
                                <?php echo $form->labelEx($model, 'Password'); ?>  
                                <?php echo $form->passwordfield($model, 'password', array('maxlength' => 10, "class" => "form-control", "data-rule-required" => "true", "data-msg-required" => "Please Enter password")); ?>
                            </div>

                        </div>  

                        <div class="form-group clearfix">
                            <div class="col-md-4 contacts">
                                <?php echo $form->labelEx($model, 'Contact Number'); ?> 
                                <?php
                                echo $form->numberField($model, 'apt_contact_no_1', array( "class" => "form-control", "data-rule-required" => "false", "data-msg-required" => "Please Enter contact no", "data-rule-regexp" => "^[7-9]{1}[0-9]{9,29}$"));
                                echo $form->error($model, 'apt_contact_no_1');
                                ?>
                                <a class="btn-block" href="javascript:" onclick="$('.contact_no_2').show();
                                        $(this).hide();"><i class="fa fa-plus" aria-hidden="true"></i> Add Contact Number </a>
                                <!--                                            <button type="button" onclick="contact()">+</button>-->
                                <div class="contact_no_2 "hidden="">
                                    <?php
                                    echo $form->numberField($model, 'apt_contact_no_2', array("class" => "form-control", "data-rule-required" => "false", "data-msg-required" => "Please Enter contact no","data-rule-regexp" => "^[7-9]{1}[0-9]{9,29}$"));
                                    echo $form->error($model, 'apt_contact_no_2');
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-4 emails">
                                <?php echo $form->labelEx($model, 'Email Address'); ?> 
                                <?php
                                echo $form->textField($model, 'email_1', array('maxlength' => 100, "class" => "form-control", "data-rule-regexp" => "[/^.{1,}@.{2,}\..{2,}/]"));
                                echo $form->error($model, 'email_1');
                                ?>
                                <a class="btn-block" href="javascript:" onclick="$('.email_2').show();
                                        $(this).hide();"><i class="fa fa-plus" aria-hidden="true"></i> Add Email Address </a>
                                <!--                                            
                                                                            <button type="button" onclick="email();">+</button>-->
                                <div class="email_2"hidden="">
                                    <?php
                                    echo $form->textField($model, 'email_2', array('maxlength' => 200, "class" => "form-control", "data-rule-required" => "true", "data-msg-required" => "Please Enter email"));
                                    echo $form->error($model, 'email_2');
                                    ?>
                                </div>    
                            </div>
                        </div> <!--end textdetails-->
                        <div class="clearfix"></div>
                        <div class="form-group clearfix">
                            <h4 class="title-details">Location</h4>
                            <div class="col-md-4">
                                <?php echo $form->labelEx($model, 'Zip Code'); ?>  
                                <?php
                                echo $form->textField($model, 'pincode', array("class" => "form-control input-group pincode-id-class"));
                                echo $form->error($model, 'pincode');
                                ?>
                            </div>  
                            <div class="col-md-4">
                                <?php echo $form->labelEx($model, 'State'); ?> 
                                <?php
                                $stateArr = array();
                                $selected = array();
                                $stateType = Yii::app()->db->createCommand()->select("state_id,state_name")->from("az_state_master")->queryAll();
                                foreach ($stateType as $row) {
                                    $stateArr[$row['state_id']] = $row['state_name'];
                                }

                                echo $form->dropDownList($model, 'state_id', $stateArr, array("class" => "form-control state-class", "style" => "width:100%;", "prompt" => "Select State", "data-rule-required" => "true", "data-msg-required" => "Please Select State", 'onchange' => 'getCity()'));
                                echo $form->error($model, 'state_id');

                                echo $form->hiddenField($model, "state_name", array("class" => "state-id-class"));
                                ?>   

                            </div>
                            <div class="col-md-4">
                                <?php echo $form->labelEx($model, 'City'); ?>
                                <?php
                                $cityArr = array();
                                echo $form->dropDownList($model, 'city_id', $cityArr, array("class" => "form-control cityId city-class", "style" => "width:100%;", "prompt" => "Select City", "data-rule-required" => "true", "data-msg-required" => "Please Select City", 'onchange' => 'getArea()'));
                                echo $form->error($model, 'city_id');

                                echo $form->hiddenField($model, "city_name", array("class" => "city-id-class"));
                                ?>

                            </div>
                        </div>
                        <div class="form-group clearfix">

                            <div class="col-md-4">
                                <?php echo $form->labelEx($model, 'Area'); ?> 
                                <?php
                                $areaArr = array();
                                $selected = array();
                                $stateType = Yii::app()->db->createCommand()->select("area_id,area_name")->from("az_area_master")->queryAll();
                                foreach ($stateType as $row) {
                                    $areaArr[$row['area_id']] = $row['area_name'];
                                }

                                echo $form->dropDownList($model, 'area_id', $areaArr, array("class" => "form-control area-class areaId", "style" => "width:100%;", "prompt" => "Select Area", "data-rule-required" => "true", "data-msg-required" => "Please Select Area", 'onchange' => 'getAreaid()'));
                                echo $form->error($model, 'area_id');

                                echo $form->hiddenField($model, "area_name", array("class" => "area-id-class"));
                                ?>   
                            </div>
                            <div class="col-md-4">
                                <?php echo $form->labelEx($model, 'Landmark'); ?>  
                                <?php
                                echo $form->textField($model, 'landmark', array("class" => "form-control input-group", "data-rule-required" => "true", "data-msg-required" => "Please enter Landmark"));
                                echo $form->error($model, 'landmark');
                                ?>
                            </div>
                            <div class="col-md-4">
                                <?php echo $form->labelEx($model, 'Street Address'); ?> 
                                <?php
                                echo $form->textField($model, 'address', array("class" => "form-control", "data-rule-required" => "true", "data-msg-required" => "Please enter Address"));
                                echo $form->error($model, 'address');
                                ?>

                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12 text-center">
                            <?php
                            echo CHtml::submitButton("Save  ", array('class' => 'btn btn-primary'));
                            ?>
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
                                    $(function () {

                                        $(".company_name").hide();
                                        $(".role").hide();
                                        $(".selectuser").on('click', function () {

                                            user = $('.selectuser:checked').val();
                                            if (user == "Premium member") {
                                                $(".role").show();
                                                $(".company_name").hide();
                                                $(".fullname").show();
                                                $(".fullnamelbl").text("Full Name");
                                            }
                                            if (user == "Corporate") {
                                                $(".role").hide();
                                                $(".company_name").show();
                                                $(".fullnamelbl").text("Authorized Person Name");
                                            }
                                            if (user == "Individual") {
                                                $(".role").hide();
                                                $(".company_name").hide();
                                                $(".fullname").show();
                                                $(".fullnamelbl").text("Full Name");
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
                                        
                                        

                                    });
                                    
                                    function showimg()
                                    {

                                        $('#myimg').modal('show');
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
</script>
