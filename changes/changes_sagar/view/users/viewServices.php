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
      
  return $(\'input[name="\' + element.name + \'"]:checked\').length > 0;
}, "Atleast 1 must be selected");
//    $("#bloodbank-update-admin-form").validate({
//        errorElement: "label",
//        ignore:":not(:visible)",
//        errorClass: "help-block has-error",
//        errorPlacement: function (error, element) {
//            if (element.parents("label").length > 0) {
//                element.parents("label").after(error);
//            } else {
//                element.after(error);
//            }
//        },
//        highlight: function (label) {
//            $(label).closest("div").removeClass("has-error has-success").addClass("has-error");
//        },
//        success: function (label) {
//            label.addClass("valid").closest("div").removeClass("has-error has-success").addClass("has-success");
//        },
//        onkeyup: function (element) {
//            $(element).valid();
//        },
//        onfocusout: function (element) {
//            $(element).valid();
//        }
//    });
$(".datepick").datepicker({
        
        autoclose : true
    });
    

  $(".multipleselect3").multipleSelect({
            filter: true,
            multiple: true,
            placeholder: "Select payment type",
            width: "100%",
            multipleWidth: 500
        });
    
 $(".clinictime").datetimepicker({
                    format: "LT"
                });

 function showNextSlide(nextslideid, tabid){
        if(1){
            $.ajax({
                //type: "POST",
               
                //data: $("#bloodbank-update-admin-form").serialize(),
                //dataType: "json",
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


<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row"><!-- row start-->
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                    <div class="box-header with-border"><!-- box header start -->
                        <div class="text-right clearfix"><!--link div-->
                        <?php if ($login_role_id != 5) { ?>
                            
                                <?php
                                if ($role == 8) {
                                    echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> Manage Blood-Bank ', array('Users/manageBloodBank', 'roleid' => 8), array("style" => "color: white;", 'class' => 'btn btn-info'));
                                } if ($role == 9) {
                                    echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> Manage Medical Store ', array('Users/manageBloodBank', 'roleid' => 9), array("style" => "color: white;", 'class' => 'btn btn-info'));
                                }
                            } else {
                                echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> Manage Services ', array('users/manageHospitalServices'), array("style" => "color: white;", 'class' => 'btn btn-info'));
                            }
                            ?>
                        </div><!--link End--> 
                        <div class="bs-example">
                            <ul class="nav nav-tabs" id="myTabs">

                                <li class="active" ><a data-toggle="pill" href="#tab_a" onClick="showNextSlide('slide1', 'tab_a')">Personal Details</a></li>
                                <li><a  href="#tab_b" onClick="showNextSlide('slide2', 'tab_b')">Services</a></li>
                                <li><a  href="#tab_c" onClick="showNextSlide('slide3', 'tab_c')">Upload Documents</a></li>
                                <li><a  href="#tab_d" onClick="showNextSlide('slide4', 'tab_d')">Bank Details</a></li>

                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_a" style="padding: 0px;">                                         

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
                                        <div class="box box-primary">
                                            <h3 class="title text-center">Enter Your Details </h3>
                                            <div class="underline"></div>
                                            <div class="form-group clearfix">
                                                <div class="col-sm-4">
                                                    <?php if ($role == 6) { ?>
                                                        <label class="control-label">Pathology Name</label>
                                                    <?php }
                                                    if ($role == 7) {
                                                        ?>
                                                        <label class="control-label">Diagnostc Name</label>
                                                    <?php }
                                                    if ($role == 8) {
                                                        ?>
                                                        <label class="control-label">Blood Bank Name</label>
                                                    <?php } if ($role == 9) { ?>
                                                        <label class="control-label">Medical Store Name</label>
<?php
}
echo '<br>' . $model->hospital_name;
?>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="control-label">Profile Image</label>

                                                    <?php
                                                    if (!empty($model->profile_image)) {
                                                        $baseDir = Yii::app()->baseUrl . "/uploads/";

                                                        echo CHtml::image($baseDir . $model->profile_image, "icon_image", array('width' => 75, 'height' => 75, 'class' => 'img-circle'));
                                                    }else{
                                                                                                                                                                    if ($role == 6) { 
                                                         echo CHtml::image(Yii::app()->request->baseUrl . "/images/icons/icon06.png", "Pathology Photo", array("class" => "img-circle", "width" => "75"));
                                                  } if ($role == 7) {
                                                       echo CHtml::image(Yii::app()->request->baseUrl . "/images/icons/icon03.png", "Diagnostic Photo", array("class" => "img-circle", "width" => "75"));
                                                    } 
                                                    if ($role == 8) {  
                                                        echo CHtml::image(Yii::app()->request->baseUrl . "/images/icons/icon05.png", "Blood Bank Photo", array("class" => "img-circle", "width" => "75")); 
                                                        
                                                    } if ($role == 9) {  
                                                            echo CHtml::image(Yii::app()->request->baseUrl . "/images/icons/icon04.png", "Medical Photo", array("class" => "img-circle", "width" => "75"));
                                                    }
                                                    }
                                                    ?>
                                                </div>


                                            </div>

                                            <div class="form-group clearfix">
                                                <div class="col-md-12">

                                                    <?php if ($role == 6) { ?>
                                                        <label class="control-label">Type of Establishment</label>
                                                    <?php } if ($role == 7) { ?>
                                                        <label class="control-label">Type of Establishment</label>
                                                    <?php } if ($role == 8) { ?>
                                                        <label class="control-label">Type of Establishment</label>
                                                    <?php } if ($role == 9) { ?>
                                                        <label class="control-label">Type of Center </label>
<?php
}
echo '<br>' . $model->type_of_establishment;
?>


                                                </div>

                                            </div>
                                            <!--                        <div class="form-group clearfix">
                                                                        <div class="col-md-4 clearfix">
                                                                                        <label class="control-label" style="padding-left:15px">Company Name</label>
<?php
//echo '<br>'.$model->type_of_establishment;
?>                                              
                                                                                    </div>
                                                                    </div>-->

                                            <div class="form-group clearfix">
                                                <?php if ($role == 6) { ?>
                                                    <h4 class="title-details" style="padding: 15px;">Pathology Establishment  </h4>
                                                <?php }
                                                if ($role == 7) {
                                                    ?>
                                                    <h4 class="title-details" style="padding: 15px;">Diagnostic Establishment  </h4>
                                                <?php }

                                                if ($role == 8) {
                                                    ?>
                                                    <h4 class="title-details" style="padding: 15px;">Blood-Bank Establishment  </h4>
<?php }
if ($role == 9) {
    ?>
                                                    <h4 class="title-details" style="padding: 15px;">Medical Store Establishment  </h4>
                                                    <?php } ?>

                                                <div class="col-md-4">

                                                    <?php if ($role == 6) { ?>
                                                        <label class="control-label">Pathology Registration Number</label>
                                                    <?php }
                                                    if ($role == 7) {
                                                        ?>
                                                        <label class="control-label">Diagnostic Registration Number</label>
                                                    <?php }

                                                    if ($role == 8) {
                                                        ?>
                                                        <label class="control-label">Blood Bank Registration Number</label>
                                                    <?php }
                                                    if ($role == 9) {
                                                        ?>
                                                        <label class="control-label">Medical Store Registration Number</label>
                                                    <?php } ?>



                                                <?php
                                                if (isset($session['hospital_registration_no'])) {
                                                    $model->hospital_registration_no = $session['hospital_registration_no'];
                                                }
                                                // echo $form->textField($model, 'hospital_registration_no', array("class" => "form-control input-group", "data-rule-required" => "true", "data-msg-required" => "Please Enter Registration Number"));
                                                // // echo $form->error($model, 'hospital_registration_no');
                                                echo '<br>' . $model->hospital_registration_no;
                                                ?>
                                                </div>
                                                    <?php if ($role == 6 || $role == 7 || $role == 8) { ?>
                                                    <div class="col-md-4">
                                                        <label class="control-label">Year of Establishment</label>

    <?php
    if (isset($session['hos_establishment'])) {
        $model->hos_establishment = $session['hos_establishment'];
    }
    echo '<br>' . $model->hos_establishment;
    ?>                                                   
                                                    </div>
                                                    <?php } ?>
                                            </div>

                                            <span>Contact Details</span>
                                            <div class="form-group clearfix">

                                                <div class="col-md-4 contacts">
                                                    <span>Book You Appointment Contact Number </span>   
<?php
if (isset($session['apt_contact_no_1'])) {
    $model->apt_contact_no_1 = $session['apt_contact_no_1'];
}
// echo $form->textField($model, 'apt_contact_no_1', array("class" => "form-control input-group","data-rule-regexp" => "^[7-9]{1}[0-9]{9,29}$"));
// echo $form->error($model, 'apt_contact_no_1');
echo '<br>' . $model->apt_contact_no_1;
?>

                                                    <a class="btn-block" href="javascript:" onclick="$('.contact2').show();
                                                    $(this).hide();"><i class="fa fa-plus" aria-hidden="true"></i> Add Contact Number </a>
                                                    <div class="textdetails contact2" style="display: none;">

                                                        <span>Book You Appointment Contact Number </span>                                                                                                                            <?php
                                                        if (isset($session['apt_contact_no_2'])) {
                                                            $model->apt_contact_no_2 = $session['apt_contact_no_2'];
                                                        }
                                                        // echo $form->textField($model, 'apt_contact_no_2', array("class" => "form-control input-group","data-rule-regexp" => "^[7-9]{1}[0-9]{9,29}$"));
                                                        // echo $form->error($model, 'apt_contact_no_2');
                                                        echo '<br>' . $model->apt_contact_no_2;
?>
                                                    </div>

                                                </div>
                                                <div class="col-md-4 contacts">
                                                    <span>Email Address </span>   
<?php
if (isset($session['email_1'])) {
    $model->coordinator_email_1 = $session['email_1'];
}
echo '<br>' . $model->coordinator_email_1;
// echo $form->textField($model, 'email_1', array("class" => "form-control input-group"));
// echo $form->error($model, 'email_1');
?>

                                                    <a class="btn-block" href="javascript:" onclick="$('.mail2').show();
                                                    $(this).hide();"><i class="fa fa-plus" aria-hidden="true"></i> Add Email Address </a>
                                                    <div class="textdetails mail2" style="display: none;">

                                                        <span>Email Address </span>                                                                                                       <?php
                                                        if (isset($session['email_2'])) {
                                                            $model->coordinator_email_2 = $session['email_2'];
                                                        }
                                                        echo '<br>' . $model->coordinator_email_2;
                                                        // echo $form->textField($model, 'email_2', array("class" => "form-control input-group"));
                                                        // echo $form->error($model, 'email_2');
?>
                                                    </div>
                                                </div>



                                            </div>
                                            <div class="form-group clearfix">
                                                <h4 class="title-details"><span> Your Services Facilitator</span></h4>
                                                <div class="col-md-4">
                                                    <div class="contacts">
                                                        <span>1. Name</span>                                                        
<?php
if (isset($session['coordinator_name_1'])) {
    $model->coordinator_name_1 = $session['coordinator_name_1'];
}
echo '<br>' . $model->coordinator_name_1;
// echo $form->textField($model, 'coordinator_name_1', array("class" => "form-control input-group", "data-rule-required" => "true"));
// echo $form->error($model, 'coordinator_name_1');
?>
                                                    </div>           
                                                </div>
                                                <div class="col-md-4">                                                    	
                                                    <span>Contact Number </span>                                                        
<?php
if (isset($session['coordinator_mobile_1'])) {
    $model->coordinator_mobile_1 = $session['coordinator_mobile_1'];
}
echo '<br>' . $model->coordinator_mobile_1;
// echo $form->textfield($model, 'coordinator_mobile_1', array('maxlength' => 10, "class" => "form-control input-group", "data-rule-required" => "true", "data-msg-required" => "Please Enter Mobile No", "data-rule-regexp" => "^[\d]+$"));
// echo $form->error($model, 'coordinator_mobile_1');
?>
                                                </div>  

                                            </div>

                                            <div class="form-group clearfix">

                                                <div class="col-md-4">
                                                    <div class="contacts">
                                                        <span>2. Name</span>                                                        
<?php
if (isset($session['coordinator_name_2'])) {
    $model->coordinator_name_2 = $session['coordinator_name_2'];
}
echo '<br>' . $model->coordinator_name_2;
// echo $form->textField($model, 'coordinator_name_2', array("class" => "form-control input-group"));
// echo $form->error($model, 'coordinator_name_2');
?>
                                                    </div>           
                                                </div>
                                                <div class="col-md-4">                                                    	
                                                    <span>Contact Number </span>                                                        
<?php
if (isset($session['coordinator_mobile_2'])) {
    $model->coordinator_mobile_2 = $session['coordinator_mobile_2'];
}
echo '<br>' . $model->coordinator_mobile_2;
// echo $form->textfield($model, 'coordinator_mobile_2', array('maxlength' => 10, "class" => "form-control input-group", "data-msg-required" => "Please Enter Mobile no", "data-rule-regexp" => "^[\d]+$"));
// echo $form->error($model, 'coordinator_mobile_2');
?>
                                                </div> 

                                            </div>
                                            <div class="form-group clearfix">


                                            </div>
                                            <div class="form-group clearfix">
                                                <!-- Timing start here -->
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
                                    
                                    
                                    $hiddenField = '<span>Mon: ' . $userSelectedDay[$value]['clinic_open_time'] . '- ' . $userSelectedDay[$value]['clinic_close_time'] . '<br>Eve:' . ($userSelectedDay[$value]['clinic_eve_open_time']) . ' - ' . ($userSelectedDay[$value]['clinic_eve_close_time']) . '</span>';
                                    
                                }
                                $disabled = "";
                                if (!empty($alldaychecked)) {
                                    $disabled = " disabled ";
                                }
                               
                                 if (!empty($hiddenField)) {
                                                                echo '<li id="$key" class="weekday"> ' . $value . '<br> &nbsp;' . $hiddenField . '</li>';
                                                            } else {
                                                                echo '<li id="$key" class="weekday"> ' . $value . '<br><br> &nbsp;&nbsp;' . $hiddenField . '</li>';
                                                            }
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
                                                <!-- Timing end here -->

                                            </div>
                                            <div class="form-group clearfix">

                                                <!--                                     <h4 class="title-details">Registration</h4>-->
                                                <!--                                        <div class="col-sm-4">
                                                                                              <span>Registration Fees </span>
                                                <?php //// echo $form->textField($model,'registration_Fees', array("class" => "form-control input-group"));?>
                                                                                        </div>-->
<?php //if($role == 9){ ?>      
                                                <!--                                      <div class="col-sm-4">
                                                                                              <span>Discount </span>
                                                    <?php //// echo $form->textField($model,'discount', array("class" => "form-control input-group"));?>
                                                                                        </div>-->

                                                    <?php // }  ?>

                                                <div class="col-md-4">
                                                    <span>Payment Modes</span><br>
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


                                                    <?php
                                                    foreach ($paymenttypeFinalArr as $payment) {

                                                        if (in_array($payment, $paymentArr)) {
                                                            echo $payment . ', ';
                                                        }
                                                    }
                                                    ?>


                                                </div>

                                            </div>
                                            <div class="form-group clearfix">

                                                <div class="col-md-6">
                                                    <?php if ($role == 6) { ?>
                                                        <span>About Pathology</span>
                                                    <?php }
                                                    if ($role == 7) {
                                                        ?>
                                                        <span>About Diagnostic</span>
                                                    <?php }

                                                    if ($role == 8) {
                                                        ?>
                                                        <span>About Blood Bank</span>
                                                    <?php }
                                                    if ($role == 9) {
                                                        ?>
                                                        <span>About Medical Store</span>
                                                    <?php } ?>



<?php
if (isset($session['description'])) {
    $model->description = $session['description'];
}
echo '<br>' . $model->description;
?>

                                                </div>

                                            </div>
                                            <div class="form-group clearfix">
                                                <h4 class="title-details clearfix">Location</h4>

                                                <div class="col-md-4">
                                                    <span>Zip Code</span>
<?php
if (isset($session['pincode'])) {
    $model->pincode = $session['pincode'];
}
echo '<br>' . $model->pincode;
// echo $form->textField($model, 'pincode', array("class" => "form-control input-group pincode-id-class"));
// echo $form->error($model, 'pincode');
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
                                                    echo '<br>' . $model->state_name;
                                                    // echo $form->dropDownList($model, 'state_id', $stateArr, array("class" => "form-control state-class", "style" => "width:100%;", "prompt" => "Select State", "data-rule-required" => "true", "data-msg-required" => "Please Select State", 'onchange' => 'getCity()'));
                                                    // echo $form->error($model, 'state_id');
                                                    if (isset($session['state_name'])) {
                                                        $model->state_name = $session['state_name'];
                                                    }
                                                    // echo $form->hiddenField($model, "state_name", array("class" => "state-id-class"));
                                                    ?>   

                                                </div>
                                                <div class="col-md-4">
                                                    <span>City</span>
                                                    <?php
                                                    $cityArr = array();

                                                    if (isset($session['city_id'])) {
                                                        $model->city_id = $session['city_id'];
                                                    }
                                                    echo '<br>' . $model->city_name;
                                                    // echo $form->dropDownList($model, 'city_id', $cityArr, array("class" => "form-control cityId city-class", "style" => "width:100%;", "prompt" => "Select City", "data-rule-required" => "true", "data-msg-required" => "Please Select City", 'onchange' => 'getArea()'));
                                                    // echo $form->error($model, 'city_id');
                                                    if (isset($session['city_name'])) {
                                                        $model->city_name = $session['city_name'];
                                                    }
                                                    // echo $form->hiddenField($model, "city_name", array("class" => "city-id-class"));
                                                    ?>

                                                </div>

                                            </div>

                                            <div class="form-group clearfix">
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
                                                    echo '<br>' . $model->area_name;
                                                    // echo $form->dropDownList($model, 'area_id', $areaArr, array("class" => "form-control area-class areaId", "style" => "width:100%;", "prompt" => "Select Area", "data-rule-required" => "true", "data-msg-required" => "Please Select Area", 'onchange' => 'getAreaid()'));
                                                    // echo $form->error($model, 'area_id');
                                                    if (isset($session['area_name'])) {
                                                        $model->area_name = $session['area_name'];
                                                    }
                                                    // echo $form->hiddenField($model, "area_name", array("class" => "area-id-class"));
                                                    ?>   

                                                </div>
                                                <div class="col-md-4">
                                                    <span>Landmark</span>
<?php
if (isset($session['landmark'])) {
    $model->landmark = $session['landmark'];
}
echo '<br>' . $model->landmark;
// echo $form->textField($model, 'landmark', array("class" => "form-control input-group"));
// echo $form->error($model, 'landmark');
?>

                                                </div>
                                                <div class="col-md-4">
                                                    <span>Address</span>
<?php
if (isset($session['address'])) {
    $model->address = $session['address'];
}
echo '<br>' . $model->address;
// echo $form->textField($model, 'address', array("class" => "form-control input-group"));
// echo $form->error($model, 'address');
?>

                                                </div>

                                            </div>

                                            <div class="button-arrow clearfix">
                                                <button class="w3-button w3-black w3-display-right" onClick="showNextSlide('slide2', 'tab_b')" type="button">&#10095;</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab_b" class="tab-pane fade">
                                    <div class="box box-primary">
                                        <div class="mySlides"  id="slide2">

                                            <div class=" form-group">

                                                    <?php $rindex = 0;
                                                    ?>
                                                <div class=" form-group serviceclone clearfix" id="serviceclone">

<?php
if (count($serviceUserMapping) > 0) {
    $sindex = 0;
    $service = ServiceMaster::model()->findAll();
    $servicenameArr = CHtml::listData($service, 'service_id', 'service_name');
    if (!empty($serviceUserMapping)) {
        foreach ($serviceUserMapping as $key => $serviceDetailObj) {
            ?>

                                                                <div class=" form-group serviceclone clearfix" id="serviceclone">

                                                                    <div class="col-sm-3">
                                                                        <b><span>Service</span></b>
                                                                        <?php
                                                                        foreach ($servicenameArr as $servicekey => $value) {
                                                                            echo $serviceDetailObj->service_id == $servicekey ? '<br>' . $value : "";
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <?php // echo $form->error($model, 'service_id');  ?>
                                                                    <div class="col-md-2 clearfix">
                                                                        <b><span>Discount</span></b>
                                                                    <?php echo '<br>' . $serviceDetailObj->service_discount ?>
            <?php // echo $form->error($model, 'service_discount', array('class' => 'col-sm-2 control-label'));  ?>
                                                                    </div>
                                                                    <div class="col-md-2 clearfix">
                                                                        <b><span>Corporate Discount</span></b>
                                                                        <?php echo '<br>' . $serviceDetailObj->corporate_discount ?>
                                                                        <?php // echo $form->error($model, 'corporate_discount', array('class' => 'col-sm-2 control-label')); ?>
                                                                    </div>
            <?php
            $isallday = array('Yes' => "Yes", 'No' => "No");
            ?>

                                                                    <div class ="col-md-2">
                                                                        <b><span>24x7</span></b>

                                                                        <?php
                                                                        foreach ($isallday as $key => $value) {
                                                                            echo $serviceDetailObj->is_available_allday == $key ? '<br>' . $value : "";
                                                                        }
                                                                        ?>

                                                                    </div>
                                                                

                                                                </div>

                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    ?>


                                                </div>
                                                <div class="col-md-3">
                                                    <label class="control-label">Take Home Service</label>
                                                    <?php
                                                    // echo $form->dropDownList($model, 'take_home', array("Yes" => "Yes", "No" => "No"), array("class" => "form-control input-group take_home", "onchange" => "extra_charge ();"));
                                                    echo '<br>' . $model->take_home;
                                                    ?>
                                                </div>
                                                <div class="col-md-3 excharges" style="display:none">
                                                    <label class="control-label">Extra charges</label>
<?php
// echo $form->dropDownList($model, 'extra_charges', array("Yes" => "Yes", "No" => "No"), array("class" => "form-control input-group take_home"));
echo '<br>' . $model->extra_charges;
?>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="control-label">24x7 Emergency</label>

<?php
// echo $form->dropDownList($model, 'emergency', array("Yes" => "Yes", "No" => "No"), array("class" => "form-control input-group"));
echo '<br>' . $model->emergency;
?>
                                                </div>


                                            </div>

                                            <div class="clearfix"></div><br>
                                            <div class="button-arrow">
                                                <button class="w3-button w3-black w3-display-left" onClick="showPrevSlide('slide1', 'tab_a')" type="button">&#10094;</button>
                                                <button class="w3-button w3-black w3-display-right" onClick="showNextSlide('slide3', 'tab_c')" type="button">&#10095;</button>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_c">
                                    <div class="box box-primary">
                                        <div class="mySlides"  id="slide3">   <!--    id="slide3"-->
                                            <h3>Documents / Certificates</h3>
                                            <div class="textdetails">


                                                <?php
                                                $docArr = Yii::app()->db->createCommand()
                                                        ->select('*')
                                                        ->from(' az_document_details t')
                                                        ->where('user_id =:phosid', array(':phosid' => $id))
                                                        ->queryAll();
                                                $imgarr = array();
                                                foreach ($docArr as $row) {

                                                    $imgarr[$row['doc_type']][] = $row['document'];
                                                }
                                                ?>  <div class="col-md-4">
                                                    <?php if ($role == 6) { ?>
                                                        <label class="control-label">Pathology Certificate</label><br>
                                                    <?php } ?>
                                                    <?php if ($role == 7) { ?>
                                                        <label class="control-label">Diagnostic Certificate</label><br>
                                                    <?php } ?>

                                                    <?php if ($role == 8) { ?>
                                                        <label class="control-label">Blood-Bank Certificate</label><br>
                                                    <?php } ?>
                                                    <?php if ($role == 9) { ?>
                                                        <label class="control-label">Medical Store  Certificate</label><br>
                                                    <?php
                                                    }
                                                    $baseDir = Yii::app()->baseUrl . "/uploads/";
                                                    if (isset($imgarr['Pathology_Registration'])) {
                                                        foreach ($imgarr['Pathology_Registration'] as $key => $val) {
                                                            echo CHtml::image($baseDir . $val, "icon_image", array('width' => 75, 'height' => 75, 'class' => 'img-circle'));
                                                        }
                                                    }


                                                    if (isset($imgarr['Diagnostic_Registration'])) {
                                                        foreach ($imgarr['Diagnostic_Registration'] as $key => $val) {
                                                            echo CHtml::image($baseDir . $val, "icon_image", array('width' => 75, 'height' => 75, 'class' => 'img-circle'));
                                                        }
                                                    }

                                                    if (isset($imgarr['Blood-Bank_Registration'])) {
                                                        foreach ($imgarr['Blood-Bank_Registration'] as $key => $val) {
                                                            echo CHtml::image($baseDir . $val, "icon_image", array('width' => 75, 'height' => 75, 'class' => 'img-circle'));
                                                        }
                                                    }
                                                    ?></div>
                                                    <?php if ($role == 6 || $role == 7) { ?>
                                                    <div class="col-md-4">  
                                                        <label class="control-label">  Other Certificates</label><br>
                                                        <?php
                                                        if (isset($imgarr['Pathology_Oth_Registration'])) {
                                                            foreach ($imgarr['Pathology_Oth_Registration'] as $key => $val) {

                                                                echo CHtml::image($baseDir . $val, "icon_image", array('width' => 75, 'height' => 75, 'class' => 'img-circle'));
                                                            }
                                                        }


                                                        if (isset($imgarr['Diagnostic_Oth_Registration'])) {
                                                            foreach ($imgarr['Diagnostic_Oth_Registration'] as $key => $val) {

                                                                echo CHtml::image($baseDir . $val, "icon_image", array('width' => 75, 'height' => 75, 'class' => 'img-circle'));
                                                            }
                                                        }
                                                        ?></div>
                                                    <div class="col-md-4">
                                                        <label class="control-label">  Other Photos</label><br>
    <?php
    if (isset($imgarr['Gallery_photos'])) {
        foreach ($imgarr['Gallery_photos'] as $key => $val) {

            echo CHtml::image($baseDir . $val, "icon_image", array('width' => 75, 'height' => 75, 'class' => 'img-circle'));
        }
    }
    ?></div>
<?php } ?>

                                            </div>
                                            <div class="clearfix"></div>
                                            <br>
                                            <div class="button-arrow">
                                                <button class="w3-button w3-black w3-display-left" onClick="showPrevSlide('slide2', 'tab_b')" type="button">&#10094;</button>
                                                <button class="w3-button w3-black w3-display-right" onClick="showNextSlide('slide4', 'tab_d')" type="button">&#10095;</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_d">
                                    <div class="box box-primary">
                                        <div class="mySlides"  id="slide4">   <!--    id="slide4"-->
                                            <h3 class="title">Bank A/C Details</h3>

                                            <div class="textdetails">
                                                <div class="col-md-4">
                                                    <label class="control-label">Account Holder Name</label>

                                                    <?php
                                                    if (isset($session['acc_holder_name'])) {
                                                        $model7->acc_holder_name = $session['acc_holder_name'];
                                                    }
                                                    echo '<br>' . $model7->acc_holder_name;
                                                    // echo $form->textField($model7, 'acc_holder_name', array("class" => "form-control"));
                                                    // echo $form->error($model7, 'acc_holder_name');
                                                    ?> 
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="control-label">Bank Name</label>

                                                    <?php
                                                    if (isset($session['bank_name'])) {
                                                        $model7->bank_name = $session['bank_name'];
                                                    }
                                                    echo '<br>' . $model7->bank_name;
                                                    // echo $form->textField($model7, 'bank_name', array("class" => "form-control"));
                                                    // echo $form->error($model7, 'bank_name');
                                                    ?> 
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="control-label">Branch Name</label>

<?php
if (isset($session['branch_name'])) {
    $model7->branch_name = $session['branch_name'];
}
echo '<br>' . $model7->branch_name;
// echo $form->textField($model7, 'branch_name', array("class" => "form-control"));
// echo $form->error($model7, 'branch_name');
?> 


                                                </div>

                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="textdetails">
                                                <div class="col-md-4">

                                                    <label class="control-label">Acount No</label>

<?php
if (isset($session['account_no'])) {
    $model7->account_no = $session['account_no'];
}
echo '<br>' . $model7->account_no;
// echo $form->textField($model7, 'account_no', array("class" => "form-control"));
// echo $form->error($model7, 'account_no');
?> 
                                                </div>
                                                <div class="col-md-4">

                                                    <label class="control-label">Account Type</label>

<?php
if (isset($session['account_type'])) {
    $model7->account_type = $session['account_type'];
}
echo '<br>' . $model7->account_type;
// echo $form->textField($model7, 'account_type', array("class" => "form-control"));
// echo $form->error($model7, 'account_type');
?> 

                                                </div>
                                                <div class="col-md-4">
                                                    <label class="control-label">IFSC Code</label>

<?php
if (isset($session['ifsc_code'])) {
    $model7->ifsc_code = $session['ifsc_code'];
}
echo '<br>' . $model7->ifsc_code;
// echo $form->textField($model7, 'ifsc_code', array("class" => "form-control"));
// echo $form->error($model7, 'ifsc_code');
?> 

                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="clearfix"></div>


                                            <div class="clearfix"></div>

                                            <div class="clearfix"></div><br>
                                            <div class="button-arrow">
                                                <button class="w3-button w3-black w3-display-left" onClick="showPrevSlide('slide3', 'tab_c')" type="button">&#10094;</button>

                                            </div>

                                        </div>


                                        <div class="clearfix">&nbsp;</div>


                                    </div>
                                </div>
                            </div>       <!--  tab-content-->
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
