


<?php
//$this->renderpartial('labTestBook');
?>


<?php
$session = new CHttpSession;
$session->open();
$clientScriptObj = Yii::app()->clientScript;
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/admin/select2.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/admin/multiple-select.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/admin/bootstrap-datetimepicker.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/admin/jquery.timepicker.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/admin/radio_style.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/admin/bootstrap-datepicker.css');

//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/bootstrap.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/jquery.timepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/moment-with-locales.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/jquery.validate.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/bootstrap-datepicker.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/bootstrap-datetimepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/select2.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/multiple-select.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/bootstrap-fileupload.min.js', CClientScript::POS_END);

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
    ', CClientScript::POS_END);
?>
<div class="form section-details ">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'lab-testbook-form',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        'enableAjaxValidation' => false,
    ));
    ?>
    <?php
    $clientScriptObj = Yii::app()->clientScript;
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
    ?>
    <div class="container">

        <section id="intro">
           
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


            <?php echo $form->errorSummary($model); ?>
            <?php
//            $patientInfoArr = Yii::app()->db->createCommand()
//                    ->select('first_name,last_name,mobile')
//                    ->from(' az_user_details')
//                    ->where('user_id=:id', array(':id' => $patient_id))
//                    ->queryRow();
            //print_r($patientInfoArr);
            ?>

          <?php if($role != 9){ ?>
            <div class="form-grop clearfix">
                <div class="col-sm-9">
                    <span>Relation</span>
<?php echo $form->radioButtonList($model, 'relation', array('SELF' => 'SELF', 'SPO_USE' => 'SPO_USE', 'FATHER' => 'FATHER', 'MOTHER' => 'MOTHER', 'CHILDREN' => 'CHILDREN', 'OTHERS' => 'OTHERS'), array('labelOptions' => array('style' => ''), 'separator' => '&nbsp;&nbsp;&nbsp;', "class" => "selecttype", 'template' => '<label class="ui-radio-inline">{input} <span>{label}</span></label>', 'container' => 'div class="ui-radio ui-radio-pink"', 'onClick' => 'typeestablishment();')); ?>
<?php echo $form->error($model, 'nature_of_visit'); ?>

                </div>
                <div class="col-sm-3 otherrelation" style="display:none">
                    <span>Relation</span>
<?php echo $form->textField($model, 'other_relation_dis', array("class" => "form-control")); ?>
<?php echo $form->error($model, 'other_relation_dis'); ?>   
                </div>
            </div>
          <?php  } ?>
          
            <div class="form-grop clearfix">
                <div class="col-sm-4" <?php if($role == 9){ ?> disabled="true" <?php  } ?>>
                    <span>Full Name</span>

<?php echo $form->textField($model, 'full_name', array('class' => 'form-control fullname', "data-rule-required" => "true", "data-msg-required" => "Please Eenter Your full Name")); ?>
<?php echo $form->error($model, 'full_name'); ?>
                </div>


                <div class="col-sm-4">
                    <span>Patient Mobile No</span>
<?php echo $form->textField($model, 'mobile_no', array('maxlength' => '10', 'class' => 'form-control mobile', "data-rule-required" => "true", "data-rule-regexp" => "^[\d]+$", "data-msg-required" => "Please Enter Mobile Number")); ?>
                    <?php echo $form->error($model, 'mobile_no'); ?>
                </div>
                <div class="col-sm-4">
                    <?php echo $form->labelEx($model, 'patient_age'); ?>
<?php echo $form->textField($model, 'patient_age', array('class' => 'form-control', "data-rule-required" => "true", "data-msg-required" => "Please Enter Age")); ?>
<?php echo $form->error($model, 'patient_age'); ?>
                </div>

            </div>
            <div class="clearfix">&nbsp;</div>
            <div class="form-grop clearfix">
<?php

// $service_name = ServiceMaster::model()->findByAttributes(array('service_id' => $model->service_name));
// print_r($service_name['service_name']);
?>
<!--                    <div class="col-sm-4">  
                        <span>Services</span>
                    <?php //echo $form->textField($model, 'service_name', array('class' => 'form-control')); ?>
                    <?php //echo $form->error($model, 'service_name'); ?>
                    </div>-->
                
                
                <div class="form-grop clearfix">
               <?php if($role == 6 || $role == 7 || $role == 8)
               {
                   
                   ?>
                <div class="col-sm-4">   
                    <span>Services</span>
                    <?php
                    $services = array();
                    $servicename = Yii::app()->db->createCommand()
                            ->select('t.service_id,sm.service_name')
                            ->from('az_service_user_mapping t')
                            ->join('az_service_master sm', 't.service_id = sm.service_id')
                            ->where('t.user_id=:id', array(':id' => $center_id))
                            ->queryAll();
                    
                   //echo $model->service_name.'ggg'.$center_id;
                foreach ($servicename as $key => $value) {
                        $services[$value['service_id']] = $value['service_name'];
                    }
                    ?>  
                    <select  name="LabBookDetails[service_name]" class="form-control">
                        <?php
                        foreach ($services as $key => $value) {
                           ?>
                            <option value='<?php echo $key; ?>' <?php echo $model->service_name == $key ? "selected" : ""; ?>> <?php echo $value; ?></option>
                       <?php     
                        }
                        ?>

                    </select>

<?php echo $form->error($model, 'service_name'); ?>
                </div>
                <?php } ?>
                <?php if($role == 9)
                { ?>
                    
                     <div class="col-sm-4">  
                          <span>Services</span>
                     <?php echo $form->textField($model, 'service_name', array('class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'service_name'); ?>
                     </div>
                <?php } ?>
                
                
                   
                <div class="col-md-4">
                    <span>Provided Doctor discription</span>
                    <?php
                    echo $form->fileField($model, 'discription_doc', array("class" => "w3-input input-group"));
                    echo $form->error($model, 'discription_doc');
                    ?> 
                </div>
                <div class="col-md-4">
                    <label>At Home Service </label>
                    <div class="clearfix"></div>
                    <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">Collect @ Home </button>
                </div>
            </div>
            <div class="dropdown keep-open col-sm-6 form-group">

                     <span>Status</span>
<?php 
if($role == 9){
    echo $form->radioButtonList($model, 'status', array('Available' => 'Available', 'Not Available' => 'Not Available'), array('labelOptions' => array('style' => ''), 'separator' => '&nbsp;&nbsp;&nbsp;', "class" => "selecttype", 'template' => '<label class="ui-radio-inline">{input} <span>{label}</span></label>', 'container' => 'div class="ui-radio ui-radio-pink"', 'onClick' => 'typeestablishment();')); 
    
}else{

echo $form->radioButtonList($model, 'status', array('Pending' => 'Pending', 'Confirm' => 'Confirm'), array('labelOptions' => array('style' => ''), 'separator' => '&nbsp;&nbsp;&nbsp;', "class" => "selecttype", 'template' => '<label class="ui-radio-inline">{input} <span>{label}</span></label>', 'container' => 'div class="ui-radio ui-radio-pink"', 'onClick' => 'typeestablishment();')); 
}
?>
               

            </div>
            <div class="dropdown keep-open col-sm-6">
                <!-- Dropdown Button -->


                <div id="demo" class="collapse">
                    <div class="dorp-form" style="background-color:#eee; display:inline-block;border:1px solid #ddd;">

                        <h4 class="title-details" style="padding:15px">Address </h4>
                        <div class="form-group clearfix">
                            <div class="input-pfn col-md-4">
                                <label> Zip Code </label> 
                                <?php
                                if (isset($session['pincode'])) {
                                    $model->pincode = $session['pincode'];
                                }
                                echo $form->textField($model, 'pincode', array("class" => "form-control input-group pincode-id-class"));
                                echo $form->error($model, 'pincode');
                                ?>
                            </div>

                            <div class="input-pfn col-md-4">
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
                            <div class="input-pfn col-md-4">

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
                            <div class="input-pfn col-md-4">

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
                            <div class="input-pfn col-md-4">

                                <b><span>Landmark<strong class="mandatory">*</strong></span></b>
                                <?php
                                if (isset($session['landmark'])) {
                                    $model->landmark = $session['landmark'];
                                }
                                echo $form->textField($model, 'landmark', array("class" => "form-control input-group"));
                                echo $form->error($model, 'landmark');
                                ?>


                            </div>                                       
                            <div class="input-pfn col-md-4">

                                <b><span>Address<strong class="mandatory">*</strong></span></b>
                                <?php
                                if (isset($session['address'])) {
                                    $model->landmark = $session['address'];
                                }
                                echo $form->textField($model, 'address', array("class" => "form-control input-group"));
                                echo $form->error($model, 'address');
                                ?>


                            </div>       
                        </div>

                           
                        
                        <div class="input-pfn col-md-12 text-center"> 
                            <button type="button" class="btn btn-info" onclick="get_address_details();">save </button>
                        </div>


                    </div>
                </div>
            </div>    
          

           
    </div>                   

    <div class="clearfix text-center">
<?php echo CHtml::submitButton('Confirm', array("class" => "btn btn- confirm")); ?>
    </div>



    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Patient Information</h4>
                </div>
                <div class="modal-body tablecontent" >

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" onclick="patientname()">Select</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

<?php $this->endWidget(); ?>


    <input type ="hidden" id="pincode">
</div>


<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.validate.min.js"></script>
<script type="text/javascript">
                        //          
                        var pname = "";
                        var pmobile = "";
                 
                      
                        var pid = "";
                        
                        $(function () {
                           $.validator.addMethod(
                                    "regexp",
                                    function (value, element, regexp) {
                                        var re = new RegExp(regexp);
                                        return this.optional(element) || re.test(value);
                                    },
                                    "Please check your input."
                                    );
                            $("#patient-secondopinion-form").validate({
                            });

//                            $(".pmobile").blur(function () {
//                                var mobile = $('.pmobile').val()
//                                if (mobile === '')
//                                {
//                                    $(".pserch").hide();
//                                    $(".confirm").hide();
//                                }
//                                else
//                                {
//                                    $(".pserch").show();
//                                    $(".confirm").show();
//                                }
//                            });


                            $(".pserch").click(function () {//check patient is authorized or not

                                var mobile = $('.pmobile').val();
                                var userid = '<?php echo $session['user_id']; ?>';
                                var roleid = '<?php echo $session['role_id']; ?>';
                                $.ajax({
                                    type: 'POST',
                                    dataType: 'json',
                                    cache: false,
                                    url: '<?php echo Yii::app()->createUrl("site/getPatientDetails"); ?> ',
                                    data: {mobile: mobile, userid: userid},
                                    success: function (data) {
                                        var str = "";
                                        var dataobj = data.data;
                                        if ($.isEmptyObject(data)) {
                                            $(".tablecontent").after("This is Not Register user");
                                            //return;
                                        }
                                        else {
                                            str += "<table class='table table-bordered selectpatient'> <thead><th>selection</th><th>Patient Name</th> <th>Patient Mobile</th></thead> <tbody>";
                                            $.each(dataobj, function (key, value) {

                                                str += "<tr><td><input type='radio' name='patientlist' class='pradio' id='radio1' onclick=test(this);><td class='pid hidden'> " + value.id + "</td></td><td class='fname'> " + value.first_name + " " + value.last_name + " </td><td class='mobile'> " + value.mobile + "</td></tr>";
                                            });
                                            str += "</table> </tbody>";
                                           
                                            $(".tablecontent").html(str);
                                             
                                            
                                        }
                                        
                                    }
                                });
                            });


                        });
                          function test(htmlobj)
                    {
                        pid = $(htmlobj).closest("tr").find(".pid").text();
                        pname = $(htmlobj).closest("tr").find(".fname").text();
                        pmobile = $(htmlobj).closest("tr").find(".mobile").text();
                        
                    }
                        function patientname()
                        {
                            $(".fullname").val(pname);
                           $(".mobile").val(pmobile);
                            $("#pid").val(pid);
                            
                            
                         
                            
                            $("#myModal").modal("hide");
                        }

                        function typeestablishment()
                        {
                            var user1 = $('.selecttype:checked').val();
                            if (user1 == 'OTHERS')
                            {

                                $(".otherrelation").show();
                            }
                            else
                            {
                                $(".otherrelation").hide();
                            }

                        }
                        function address_info()
                        {
                            alert("hello");
                            $('#modeladdress').modal();
                        }
                        function get_address_details()
                        {
                            $(".dropdown").toggle();
                        }



</script>


