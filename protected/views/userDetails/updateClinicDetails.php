<?php
/* @var $this ClinicDetailsController */
/* @var $model ClinicDetails */
/* @var $form CActiveForm */
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/admin/select2.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/admin/main.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/admin/multiple-select.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/admin/bootstrap-datetimepicker.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/admin/jquery.timepicker.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/admin/radio_style.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/moment-with-locales.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/bootstrap-datetimepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/select2.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/multiple-select.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/jquery.timepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/jquery.validate.min.js', CClientScript::POS_END);

Yii::app()->clientScript->registerScript('myjavascript', '
      $(".multipleselect").multipleSelect({
            filter: true,
            multiple: true,
            placeholder: "Select service",
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
            'id' => 'update-clinic-details-form',
            'htmlOptions' => array('enctype' => 'multipart/form-data', "class" => "w3-container"),
            'enableAjaxValidation' => false,
        ));
        ?>
<?php $baseUrl = Yii::app()->request->baseUrl; ?>
        <div class="row">  
            <?php
            $enc_key = Yii::app()->params->enc_key;
            
            $path = $baseUrl . "/uploads/" . $model->profile_image;
           //echo $path.'hiii';
            if (empty($model->profile_image)) {
                $path = $baseUrl . "/images/icons/icon01.png";
            }
            ?>
            <div class="col-md-3" style="background-image:url(<?= $baseUrl; ?>/images/icon46.png);height: 900px;background-size: 100% auto;background-position: center center;">
                <div class="fileinput fileinput-new" data-provides="fileinput" style="position: relative;">
                    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="background: transparent;width:140px;height:140px;text-align: center; margin: auto;border-radius: 50%;overflow: hidden;">
                        <img src="<?php echo $path; ?>" class="img-circle img-responsive" style="margin-bottom:15px">
                    </div>
                    <span class=" btn-file" style="position: absolute;top: 60%;right: 20px;border: 1px solid #888;    padding: 3px 8px;">
                        <span class="fileinput-new">Edit</span>
                        <?php
                        echo $form->fileField($model, 'profile_image', array("class" => ""));
                        echo $form->error($model, 'profile_image');
                        ?>
                    </span>
                </div>
                <ul class="nav nav-pills nav-stacked "  id="myTabs">

                    <li class="active"><a href="#tab_a" data-toggle="pill">Personal Details </a></li>
                    <li><a href="#tab_b" data-toggle="pill">Clinics &nbsp; <i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                    <li><a href="#tab_c" data-toggle="pill">Upload Documents </a></li>                                  
                </ul>
            </div>
            <div class="tab-content col-md-9">   
                <h3 class="title center">Clinic Details </h3>
                    <div class="underline"></div>                                            	

                <div class="textdetails">
                                        <div class="col-md-10">
                                            <span>Clinic Name</span>
                                            
                                            <?php
                                            
                                            echo $form->textField($model2, 'clinic_name', array('size' => 60, 'maxlength' => 200, "data-rule-required" => "true", "data-msg-required" => "Please enter Clinic Name"));
                                           // echo $form->error($model2, 'clinic_name');
                                            ?>
                                        </div>                                                	
                                    </div>

                <div class="clearfix"></div>
                <div class="textdetails">
                      <?php  
              if (count($serviceUserMapping) > 0) {
                    $sindex = 0;
                    //echo"<pre>";print_r($serviceUserMapping);exit;
                    foreach ($serviceUserMapping as $key => $serviceDetailObj) {
                        ?>
<div class=" form-group serviceclone clearfix" id="serviceclone">
                        <?php
                            $service = ServiceMaster::model()->findAll();
                            $servicenameArr = CHtml::listData($service, 'service_id', 'service_name');
                            ?>
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

                            <div class="col-md-2 clearfix">
                                 <span>Discount</span>
                                <input type="text" name="service_discount[]" value='<?php echo $serviceDetailObj->service_discount ?>' class="form-control" >
                                <?php echo $form->error($model, 'service_discount', array('class' => 'col-sm-2 control-label')); ?>
                            </div>
    
                            <div class="col-md-3 clearfix">
                                 <span>Corporate Discount</span>
                                <input type="text" name="corporate_discount[]" value='<?php echo $serviceDetailObj->corporate_discount ?>' class="form-control" >
                                <?php echo $form->error($model, 'corporate_discount', array('class' => 'col-sm-2 control-label')); ?>
                            </div>
                            <?php    $isallday=  array('Yes'=>"Yes",'No'=>"No");    ?> 
                           
                            <div class ="col-md-2">
                                 <span>24x7</span>
                                            <select class="form-control twentyfour" name="twentyfour[]">
                                    <?php foreach ($isallday as $key => $value) {   ?>
                                            <option value='<?php echo $key; ?>' <?php echo $serviceDetailObj->is_available_allday == $key ? "selected" : ""; ?>> <?php echo $value; ?></option>
                                    <?php }    ?>
                                            </select>
                                </div>
                            <div class="col-sm-2 clearfix">
                                <?php
                                if ($sindex == 0) {
                                    echo CHtml::link('ADD', 'javascript:', array('class' => 'addservice'));
                                    $sindex++;
                                } else {
                                    echo CHtml::link('X', 'javascript:', array('class' => 'removeservice'));
                                }
                                ?>
                            </div>
                          
                        </div>

                        <?php
                    }
                   
                }
                else{
                     $rindex = 0;
                    ?>
                       <div class=" form-group serviceclone clearfix" id="serviceclone">
                        
                        <?php
                        $service = ServiceMaster::model()->findAll();
                        $servicenameArr = CHtml::listData($service, 'service_id', 'service_name');
                        ?>
                        <div class="col-sm-3">
                            <span>Service</span>
                            <select class="form-control servicename" name="service[]" >
                                <?php foreach ($servicenameArr as $servicekey => $value) {
                                    ?>

                                    <option value='<?php echo $servicekey; ?>'> <?php echo $value; ?></option>
                                <?php }
                                ?>
                            </select>
                        </div>
                        <?php echo $form->error($model, 'service_id'); ?>
                       
                        <div class="col-sm-2  clearfix">
                            <span>Discount</span>
                            <input type="text" name="service_discount[]" value=''  class='form-control'>
                            <?php echo $form->error($model, 'service_discount', array('class' => 'col-sm-1 control-label')); ?>
                        </div>
                           
                           <div class="col-sm-3  clearfix">
                            <span>Corporator Discount</span>
                            <input type="text" name="corporator_discount[]" value=''  class='form-control'>
                            <?php echo $form->error($model, 'corporator_discount', array('class' => 'col-sm-1 control-label')); ?>
                        </div>


                                            <?php
                                            $isallday=  array('Yes'=>"Yes",'No'=>"No");
                                            ?>
                            
                            <div class ="col-sm-4">
                               <span>24x7</span>
                                            <select class="form-control twentyfour" name="twentyfour[]">
                                    <?php foreach ($isallday as $key => $value) {   ?>
                                            <option value='<?php echo $key; ?>' > <?php echo $value; ?></option>
                                    <?php }    ?>
                                            </select>
                                </div>

                        <div class="col-sm-2 clearfix">
                            <?php
                            if ($rindex == 0) {
                                echo CHtml::link('ADD', 'javascript:', array('class' => 'addservice'));
                                $rindex++;
                            } else {
                                echo CHtml::link('X', 'javascript:', array('class' => 'removeservice'));
                            }
                            ?>
                        </div>

                    </div>
                        
                        
                        
                        <?php
                    
                }
                
                
                ?>

                    
                    
                   
                    
                </div>
                <div class="clearfix"></div>
                <!-- Timing start here -->
                <?php //   if (1){   ?>
                <div class="textdetails">
                                        <h4 class="title-details">Timings</h4>
                                        <div class="col-md-12" style=""> 
                                             <?php
                                            $alldaychecked = "";
                                            if($model2->alldayopen=='Y')
                                            {
                                                $alldaychecked = " checked ";
                                            }
                                            ?>
                                            
                                            <label><input  type="checkbox" name="ClinicDetails[alldayopen]" value="Y" onclick="isalldayopen(this)" class="isall" <?php echo $alldaychecked;?>> 24x7</label>
                                            
                                            
                                            
                                        
                                        </div>
                                        <?php
                                  
                                        $dayarr = array("mon"=>"Monday","tue"=>"Tuesday","wed"=>"Wednesday","thur"=>"Thursday","fri"=>"Friday","sat"=>"Saturday","sun"=>"Sunday");
                                        $userSelectedDay=array();
                                        $uservisit =Yii::app()->db->createCommand()
                                                    ->select('clinic_id,day,clinic_open_time,clinic_close_time,clinic_eve_open_time,clinic_eve_close_time')
                                                ->from('az_clinic_visiting_details ')
                                                    ->where('clinic_id=:id', array(':id' => $c_id))
                                                    ->queryAll();
                                        foreach($uservisit as $row){
                                            $userSelectedDay[$row['day']] = array('clinic_open_time' => $row['clinic_open_time'], 'clinic_close_time' => $row['clinic_close_time'], 'clinic_eve_open_time' => $row['clinic_eve_open_time'], 'clinic_eve_close_time' => $row['clinic_eve_close_time']);
                                        }
                                          //  print_r($userSelectedDay);
                                            ?>
                                        <div class="col-md-12 day" style="">
                                            <ul class="list-inline">
                                                <?php foreach ($dayarr as $key=> $value){
                                                    $check='';
                                                    $hiddenField='';
                                                    if (array_key_exists($key, $userSelectedDay)) {
                                                        $check = 'checked';
                                                        $hiddenField = '<span><input type="hidden" name="ClinicVisitingDetails[clinic_open_time][]" value="' . $userSelectedDay[$key]['clinic_open_time'] . '" class="clinic_open_time">
                        <input type="hidden" name="ClinicVisitingDetails[clinic_close_time][]" value="' . $userSelectedDay[$key]['clinic_close_time'] . '" class="clinic_close_time">'
                                                                . '<input type="hidden" name="ClinicVisitingDetails[clinic_eve_open_time][]" value="' . $userSelectedDay[$key]['clinic_eve_open_time'] . '" class="clinic_eve_open_time">'
                                                                . '<input type="hidden" name="ClinicVisitingDetails[clinic_eve_close_time][]" value="' . $userSelectedDay[$key]['clinic_eve_close_time'] . '" class="clinic_eve_close_time"></span>';
                                                    }
                                                   $disabled = "";
                                                    if(!empty($alldaychecked)){
                                                        $disabled = " disabled ";
                                                    }
                                                   
                                                    echo '<li id="$key" class="weekday"><input type="checkbox" class="day noday" name="ClinicVisitingDetails[day][]" value='.$key.' '.$check.' '.$disabled.'>'.$hiddenField. $value.'</li>';
                                                
                                                        } ?>
                                            </ul>

                                        </div>
                                        <?php  echo $hiddenField;       ?>
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
                <?php // }  else{?>
                

                
                <?php
               // }
                ?>
                
                
                
                                    <!-- Timing end here -->
                <!-- Timing end here -->
                		<div class="textdetails">
				 <h4 class="title-details">Location</h4>
					<div class="col-md-4">
						<span>Zip Code</span>
						<?php
						if (isset($session['pincode'])) {
							$model->pincode = $session['pincode'];
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
						$cityArr = array();
						if(!empty($model2->state_id)){
							$citycmd = Yii::app()->db->createCommand()->select('city_id,city_name')->from('az_city_master')->where('state_id=:id', array(':id' => $model2->state_id))->queryAll();
							foreach($citycmd as $row) {
								$cityArr[$row['city_id']] = $row['city_name'];
							}
						}
						if (isset($session['city_id'])) {
							$model2->city_id = $session['city_id'];
						}
						echo $form->dropDownList($model2, 'city_id', $cityArr, array("class" => "w3-input cityId city-class", "style" => "width:100%;", "prompt" => "Select City", "data-rule-required" => "true", "data-msg-required" => "Please Select City", 'onchange' => 'getArea()'));
						echo $form->error($model2, 'city_id');
						if (isset($session['city_name'])) {
							$model2->city_name = $session['city_name'];
						}
						echo $form->hiddenField($model2, "city_name", array("class" => "city-id-class"));
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
						if(!empty($model2->city_id)){
							$stateType = Yii::app()->db->createCommand()->select("area_id,area_name")->from("az_area_master")->where('city_id=:id', array(':id' => $model2->city_id))->queryAll();
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
							$model2->landmark = $session['landmark'];
						}
						echo $form->textField($model2, 'landmark', array("class" => "w3-input input-group"));
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
                                                ->where('clinic_id=:id', array(':id' => $c_id))
                                                ->queryColumn();
                                        //print_r($paymentGroupArr);
                                        $paymentArr = implode(" ", $paymentGroupArr);

                                        $paymentArr = explode(",", $paymentArr);
                                        //print_r($paymentArr);
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
                        <?php echo $form->textField($model2, 'opd_consultation_fee', array("class" => "w3-input input-group", "data-rule-required" => "true", "data-msg-required" => "Please Consultation Fee"));
                        echo $form->error($model2, 'opd_consultation_fee');
                        ?>
                    </div>
                    <div class="col-md-5"> 
                        <span>Discount %</span>
                        <?php echo $form->textField($model2, 'opd_consultation_discount', array("class" => "w3-input input-group"));
                        echo $form->error($model2, 'opd_consultation_discount');
                        ?>
                    </div>
                </div>
                <div class="clearfix"></div>
                <h4 class="title-details">Free OPD</h4>
                <div class="col-md-10">
                    <div class="col-md-5"> 
                        <span>Per Day</span>
<?php echo $form->textField($model2, 'free_opd_perday', array("class" => "w3-input input-group"));
echo $form->error($model2, 'free_opd_perday');
?>
                    </div>
                    <div class="col-md-5">
                        <span>Preferred Days</span>
                                            <?php
                                            // DAY_STR is constant which contains array of Days
                                            $DayArr = explode(";", Constants:: DAY_STR);
                                            $DayFinalArr = array_combine($DayArr, $DayArr);
                                            
                                            $DayGroupArr = Yii::app()->db->createCommand()
                                                    ->select('free_opd_preferdays')
                                                    ->from('az_clinic_details')
                                                    ->where('clinic_id=:id', array(':id' => $c_id))
                                                    ->queryColumn();
//print_r($paymentGroupArr);
                                            $DayArr = implode(" ", $DayGroupArr);

                                            $DayArr = explode(",", $DayArr);
//print_r($paymentArr);
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
                                            <span>Clinic Certificate</span>
                                            <?php
                                            
                                          //   echo CHtml::image($baseDir . $model2->clinic_reg_certificate, "icon_image", array('width' => 75, 'height' => 75));
                                            echo $form->fileField($model2, 'clinic_reg_certificate', array("class" => "w3-input input-group"));
                                            echo $form->error($model2, 'clinic_reg_certificate');
                                            ?>
                                        </div>
               <div class="clearfix"></div>

                <div class="center buttons">
                    <?php echo CHtml::submitButton("Save  ", array('class' => 'btn btn-info')); ?>
                  

                </div>

<?php $this->endWidget(); ?>

            </div>

        </div><!--         row-->
    </div>
</div>
</section>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.validate.min.js"></script>

<script type="text/javascript">
            var pinarray = [];
            var dayhtml;
            $(function () {
                // $('.contact_no_2').hide();
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

        $('.day:checkbox').on('click', function (e) {
            if (e.target.checked) {
                dayhtml = $(this);
               
                var day = $('.day:checked').val();
                console.log(dayhtml);
                $('#myModal').modal();

            }else{
                $(this).closest('li').find('span').remove();
        }
            
        });

         
    
  
    
    
     $('.addservice').click(function () {
        var htmlstr = "";
        var servicename = $('.servicename').html();
        var twentyfour = $('.twentyfour').html();
        
        // var dayname = $('.dayname').html();
        htmlstr = "<div class='form-group servicename clearfix'><div class='col-sm-3'><span>Service</span><select class='form-control servicename' name='service[]'>" + servicename + "</select></div><div class='col-md-2 clearfix'><span>Discount</span><input type=text name=service_discount[] class='form-control'></div><div class='col-md-3 clearfix'><span>Corporate Discount</span><input type=text name=corporate_discount[] class='form-control'></div><div class='col-md-2'><span>24x7</span><select class='form-control twentyfour' name='twentyfour[]'>" + twentyfour + "</select></div><i class='fa fa-times delete' aria-hidden='true' onclick='remove_service_details(this)'></i></div> ";
        $('#serviceclone').after(htmlstr);
    });
    $('.removeservice').click(function () {
        $('.serviceclone:last').remove();
    });
    
    
      });   
    function remove_service_details(htmlobj)
    {

        $(htmlobj).parents('.servicename').remove();
    }
    
    function isalldayopen(htmlobj){
        // var aa= $(".isall" ).attr( "checked" ) ;
         if($(htmlobj).prop("checked")){
             $(".noday").attr("disabled",true);
             $(".noday").attr("checked",false);
         }else{
             $(".noday").attr("disabled",false);
         }
      
    }
                                               
            function addMoreServices(htmlObj){
        var str = "";
        var serviceoption = $(".serviceoption:first").html();
        str += "<div class=\"servicename\"><div class=\"col-md-3\"><select class=\"w3-input serviceoption\" data-rule-required=\"true\" name=\"ServiceUserMapping[service_id][]\" style=\"width:100%;\">"+serviceoption+"</select></div>";
        str += "<div class=\"col-md-3\"><input class=\"w3-input input-group\" name=\"ServiceUserMapping[service_discount][]\" type=\"text\"></div>";
        str += "<div class=\"col-md-3\"><select class=\"w3-input serviceoption\" data-rule-required=\"true\" name=\"ServiceUserMapping[twentyfour][]\"  style=\"width:100%;\"><option value=\"Yes\">Yes</option><option value=\"No\">No</option></select></div>";
        str += "<button type='button' class='delete' onclick='remove_service_details(this)'>Remove</button><div class=\"clearfix\">&nbsp;</div></div>";
        $(htmlObj).parents(".btnaddservice").before(str);
       // console.log("tabid",$(htmlObj).parents(".btnaddservice").html(),str);
    }
    
    function remove_service_details(htmlobj)
    {

        $(htmlobj).parents('.servicename').remove();
    }                                            
                                                        
                                                        
                                                        
function clinic_time() {
    var open_time = $('.open_time').val();
    var close_time = $('.close_time').val();
    var eve_open_time = $('.eve_open_time').val();
    var eve_close_time = $('.eve_close_time').val();
    var hiddenhtml = "";
    
     hiddenhtml = "<span ><input type='hidden'  name='ClinicVisitingDetails[clinic_open_time][]' value='" + open_time + "' class='clinic_open_time'><input type='hidden'  name='ClinicVisitingDetails[clinic_close_time][]' value='" + close_time + "' class='clinic_close_time'><input type='hidden'  name='ClinicVisitingDetails[clinic_eve_open_time][]' value='" + eve_open_time + "' class='clinic_eve_open_time'><input type='hidden'  name='ClinicVisitingDetails[clinic_eve_close_time][]' value='" + eve_close_time + "' class='clinic_eve_close_time'></span><div class='timing-list timeing'>Mon:" + open_time + " - " + close_time + "<br>Evn:" + eve_open_time + " - " + eve_close_time + "</div><br>"
    
    console.log($(dayhtml).closest(".weekday").find('.day').html());
    var a=$(dayhtml).closest(".weekday").find('.day');
  
 $(dayhtml).closest(".weekday").find('.day').before(hiddenhtml);

}


       // Specify the visiting time timepick for clone 
    function timepick(htmlobj)
    {
        $(".clinictime").timepicker({
            sideBySide: true,
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            },
            stepping: 5,
            format: "h:mm A",
        });
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





</script>

