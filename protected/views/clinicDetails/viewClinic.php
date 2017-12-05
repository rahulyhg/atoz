

<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* @var $this UserDetailsController */
/* @var $model UserDetails */
$enc_key = Yii::app()->params->enc_key;
?>
<section class="content-header">

    <h3>View Clinic</h3>

</section>
<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row"><!-- row start-->
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                    <div class="box-header with-border"><!-- box header start -->
                        <div class="text-right"><!--link div-->

                            <?php
                              echo CHtml::link('<i class = "fa fa-edit "></i>Update Clinic', array('ClinicDetails/UpdateAdminClinic', 'id' => Yii::app()->getSecurityManager()->encrypt($model->clinic_id, $enc_key)), array("style" => "color: white;", 'class' => 'btn btn-info'));
            ?>
        
        <?php echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> Manage Clinic', array('clinicDetails/adminClinic', 'id' => Yii::app()->getSecurityManager()->encrypt($model->doctor_id, $enc_key)), array("style" => "color: white;", 'class' => 'btn btn-info')); ?>
  
                        </div><!--link End-->    

                        <div class="col-sm-4">
                                        <label class="control-label">Clinic Name</label>
                                        <?php echo '<br>'.$model->clinic_name ;    ?>
                                        
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="control-label">Register No</label>
                                        <?php echo '<br>'.$model->register_no ;   ?>
                                       
                                    </div>
                                    <div class="col-sm-4">

                                        <?php
//                                        // echo $form->labelEx($model, 'Clinic Certificate');
//                                        // echo $form->fileField($model, 'clinic_reg_certificate', array("class" => "w3-input input-group"));
//                                        // echo $form->error($model, 'clinic_reg_certificate');
                                        ?>
                                    </div>   
                                    <div class="clearfix" style="padding:15px"></div>
                                    <div class="col-md-12">
                                        <h4 class="box-title">Payment Details</h4>
                                    </div>  

                                    <div class="form-group clearfix">
                                        <div class="col-sm-4">
                                            <label class="control-label">Payment Type</label><br> 
                                            <?php 
                                           
                                          
                                            $selected = "false";
                                            $paymenttypeArr = explode(";", Constants::PAYMENT_TYPE);
                                            $paymenttypeFinalArr = array_combine($paymenttypeArr, $paymenttypeArr);

                                            $userpaymentGroupArr = Yii::app()->db->createCommand()
                                                    ->select('payment_type')
                                                    ->from('az_clinic_details')
                                                    ->where('clinic_id=:id', array(':id' => $model->clinic_id))
                                                    ->queryColumn();
                                            $paymentstr = NULL;
                                            foreach ($userpaymentGroupArr as $key => $value) {
                                                $paymentstr.=$value . ",";
                                            }
                                            $paymentarr = explode(",", $paymentstr);
                                            foreach ($paymenttypeFinalArr as $paymenttype => $value) {
                                                  if (in_array($value, $paymentarr)) {
                                                        echo $value.', ';
                                                    }
                                                }
                                               ?>
                                         </div>

                                        <div class="col-sm-4">
                                            <label class="control-label">OPD Consultation Fee</label>  

                                            <?php  echo '<br>'.$model->opd_consultation_fee;  ?>
                                            
                                        </div>
                                        <div class="col-sm-4">
                                           <label class="control-label">OPD Consultation Discount</label>  
                                            <?php  echo '<br>'.$model->opd_consultation_discount ?>
                                        </div>  
                                    </div>
                                        <div class="clearfix" style="padding:15px"></div>
                                        <div class="col-md-12">
                                            <h4 class="box-title">OPD</h4>
                                        </div>
                                        <div class="col-sm-4">
                                           <label class="control-label">Free OPD Preferdays</label><br>

                                            <?php
                                            $dayArr = explode(";", Constants:: DAY_STR);
                                            $dayFinalArr = array_combine($dayArr, $dayArr);

                                            $selected = "false";
                                            $dayArr = explode(";", Constants:: DAY_STR);
                                            $dayFinalArr = array_combine($dayArr, $dayArr);

                                            $userdayGroupArr = Yii::app()->db->createCommand()
                                                    ->select('free_opd_preferdays')
                                                    ->from('az_clinic_details')
                                                    ->where('doctor_id=:id', array(':id' => $model->doctor_id))
                                                    ->queryColumn();
                                            $daystr = NULL;
                                            foreach ($userdayGroupArr as $key => $value) {
                                                $daystr.=$value . ",";
                                            }
                                            $dayarr = explode(",", $daystr);

                                           
                                                foreach ($dayFinalArr as $daytype => $value) {
                                                   if (in_array($value, $dayarr)) {
                                                        echo $value.', ';
                                                    }
                                                }
                                                ?>
                                        </div>

                                        <div class="col-sm-4">
                                            <label class="control-label">Free OPD Perday</label>  
                                            
                                            <?php  echo "<br>".$model->free_opd_perday; ?>
                                            <?php // echo $form->error($model, 'free_opd_perday'); ?>
                                        </div>

                                        <div class="clearfix" style="padding:15px"></div>
                                        <div class="col-md-12">
                                            <h4 class="box-title">Service Information</h4>
                                        </div>
                                        <?php
                                      // echo'<pre>'; print_r($serviceUserMapping);exit;
                                        if (count($serviceUserMapping[0]) > 0) {
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
                                                        <span>Service</span><br>
<!--                                                        <select class="form-control servicename" name="ClinicDetails[service][]" >-->
                                                            <?php foreach ($servicenameArr as $servicekey => $value) {
                                                                ?>

                                           <?php echo $serviceDetailObj->service_id == $servicekey ? $value : ""; ?>
                                                                   
                                                            <?php }
                                                            ?>

                                                    </div>
                                                  


                                                    
                                                    <div class="col-md-2 clearfix">
                                                    <span> Discount</span><br>
                                                    <?php echo $serviceDetailObj->service_discount ?>
                                                   
                                                    </div>
                                                    
                                                     <div class="col-md-2 clearfix">
                                                    <span>Corporate Discount</span><br>
                                                    <?php echo $serviceDetailObj->corporate_discount ?>
                                                    
                                                    </div>
                                                    
                                                    
                                                    <?php
                                                    $isallday = array('Yes' => "Yes", 'No' => "No");
                                                    ?> 
                                                    
                                                    <div class ="col-sm-2">
                                                        <span>24x7</span>
                                                        
                                                            <?php foreach ($isallday as $key => $value) { 
                                                               echo $serviceDetailObj->is_available_allday == $key ? '<br>' . $value : "";
                                                                
                                                                 } ?>
                                                       
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
                                        } else {
                                            $rindex = 0;
                                            ?>
                                            <div class=" form-group serviceclone clearfix" id="serviceclone">
                                               
                                                <?php
                                                $service = ServiceMaster::model()->findAll();
                                                $servicenameArr = CHtml::listData($service, 'service_id', 'service_name');
                                                ?>
                                                <div class="col-sm-3">
                                                        <span>Service</span>
                                                        <select class="form-control servicename" name="ClinicDetails[service][]" >
                                                            <?php foreach ($servicenameArr as $servicekey => $value) {
                                                                ?>

                                                                <option value='<?php echo $servicekey; ?>' <?php echo $serviceDetailObj->service_id == $servicekey ? "selected" : ""; ?>> <?php echo $value; ?></option>
                                                            <?php }
                                                            ?>
                                                        </select>
                                                    </div>
                                                <?php // echo $form->error($model, 'service_id'); ?>
                                                <div class="col-md-2 clearfix">
                                                    <span> Discount</span>
                                                    <input type="text" name="ClinicDetails[service_discount][]" value='<?php echo $serviceDetailObj->service_discount ?>' class="form-control" >
                                                    <?php // echo $form->error($model, 'service_discount', array('class' => 'col-sm-2 control-label')); ?>
                                                    </div>
                                                    
                                                     <div class="col-md-2 clearfix">
                                                    <span>Corporate Discount</span>
                                                    <input type="text" name="ClinicDetails[corporate_discount][]" value='<?php echo $serviceDetailObj->corporate_discount ?>' class="form-control" >
                                                    <?php // echo $form->error($model, 'corporate_discount', array('class' => 'col-sm-2 control-label')); ?>
                                                    </div>
                                                <?php
                                                $isallday = array('Yes' => "Yes", 'No' => "No");
                                                ?> 
                                                <label class="col-sm-1 control-label">24x7</label>
                                                <div class ="col-sm-2">
                                                    <select class="form-control twentyfour" name="ClinicDetails[twentyfour][]">
                                                        <?php foreach ($isallday as $key => $value) { ?>
                                                            <option value='<?php echo $key; ?>' > <?php echo $value; ?></option>
                                                        <?php } ?>
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
                                        <div class="clearfix" style="padding:15px"></div>
                                        <div class="textdetails">
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
                                                        ->where('clinic_id=:id', array(':id' => $id))
                                                        ->queryAll();
                                                foreach ($uservisit as $row) {
                                                    $userSelectedDay[$row['day']] = array('clinic_open_time' => $row['clinic_open_time'], 'clinic_close_time' => $row['clinic_close_time'], 'clinic_eve_open_time' => $row['clinic_eve_open_time'], 'clinic_eve_close_time' => $row['clinic_eve_close_time']);
                                                }
                                              //  print_r($userSelectedDay);
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
                                            </div>
                                            <!-- Timing end here -->
                                        <div class="clearfix" style="padding:15px"></div>
                                        <div class="col-md-12">
                                            <h4 class="box-title">Location</h4>
                                        </div>  
                                        <div class="form-group clearfix">
                                            <div class="col-md-4">
                                                <?php
                                                // echo $form->labelEx($model, 'Zip Code');

                                                if (isset($session['pincode'])) {
                                                    $model->pincode = $session['pincode'];
                                                }
                                                 echo '<br>'.$model->pincode;
                                                
                                                ?>
                                            </div>  
                                            <div class="col-md-4">
                                                <?php
                                                // echo $form->labelEx($model, 'State');
                                                $stateArr = array();
                                                $selected = array();
                                                $stateType = Yii::app()->db->createCommand()->select("state_id,state_name")->from("az_state_master")->queryAll();
                                                foreach ($stateType as $row) {
                                                    $stateArr[$row['state_id']] = $row['state_name'];
                                                }
                                                if (isset($session['state_id'])) {
                                                    $model->state_id = $session['state_id'];
                                                }
                                                // echo $form->dropDownList($model, 'state_id', $stateArr, array("class" => "form-control state-class", "style" => "width:100%;", "prompt" => "Select State", "data-rule-required" => "true", "data-msg-required" => "Please Select State", 'onchange' => 'getCity()'));
                                                // echo $form->error($model, 'state_id');
                                                if (isset($session['state_name'])) {
                                                    $model->state_name = $session['state_name'];
                                                }
                                                // echo $form->hiddenField($model, "state_name", array("class" => "state-id-class"));
                                                ?>   

                                            </div>
                                            <div class="col-md-4">
                                                <?php
                                                // echo $form->labelEx($model, 'City');
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
                                                // echo $form->dropDownList($model, 'city_id', $cityArr, array("class" => "form-control cityId city-class", "style" => "width:100%;", "prompt" => "Select City", "data-rule-required" => "true", "data-msg-required" => "Please Select City", 'onchange' => 'getArea()'));
                                                // echo $form->error($model, 'city_id');
                                                if (isset($session['city_name'])) {
                                                    $model->city_name = $session['city_name'];
                                                }
                                                // echo $form->hiddenField($model, "city_name", array("class" => "city-id-class"));
                                                ?>

                                            </div>
                                        </div>
                                        <div class="form-group">

                                            <div class="col-md-4">
                                                <?php
                                                   // echo $form->labelEx($model, 'Area');
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
                                                // echo $form->dropDownList($model, 'area_id', $areaArr, array("class" => "form-control area-class areaId", "style" => "width:100%;", "prompt" => "Select Area", "data-rule-required" => "true", "data-msg-required" => "Please Select Area", 'onchange' => 'getAreaid()'));
                                                // echo $form->error($model, 'area_id');
                                                if (isset($session['area_name'])) {
                                                    $model->area_name = $session['area_name'];
                                                }
                                                // echo $form->hiddenField($model, "area_name", array("class" => "area-id-class"));
                                                ?>   

                                            </div>
                                            <div class="col-md-4">
                                               <?php // echo $form->labelEx($model, 'Landmark');
                                                if (isset($session['landmark'])) {
                                                    $model->landmark = $session['landmark'];
                                                }
                                                // echo $form->textField($model, 'landmark', array("class" => "form-control input-group"));
                                                // echo $form->error($model, 'landmark');
                                                ?>


                                            </div>
                                        </div>
                                            <div class="clearfix"></div>

                                            <div class="form-group clearfix">
                                                <div class="col-sm-4">
                                                  <?php
                                                    // echo $form->labelEx($model, 'Address');
                                                    if (isset($session['address'])) {
                                                        $model->address = $session['address'];
                                                    }
                                                    // echo $form->textField($model, 'address', array("class" => "form-control input-group"));
                                                    // echo $form->error($model, 'address');
                                                    ?>
                                                    </div>
                                                    
                                                     <div class="col-sm-4">
                                                    <?php // echo $form->labelEx($model, 'Latitude');
                                                    if (isset($session['latitude'])) {
                                                        $model->latitude = $session['latitude'];
                                                    }
                                                    // echo $form->textField($model, 'latitude', array("class" => "form-control input-group"));
                                                    // echo $form->error($model, 'latitude');
                                                    ?>
                                                     </div>
                                                    <div class="col-sm-4">
                                                    <?php
                                                     // echo $form->labelEx($model, 'Longitude');
                                                    if (isset($session['longitude'])) {
                                                        $model->longitude = $session['longitude'];
                                                    }
                                                    // echo $form->textField($model, 'longitude', array("class" => "form-control input-group"));
                                                    // echo $form->error($model, 'longitude');
                                                    ?>
                                                </div>
                                                <div class="col-sm-12 clearfix">
                                                    <div id="p-map" style="height: 340px;width: 100%;border:1px solid #533223;"></div>
                                                </div>
                                            </div>

                    </div><!-- box header end -->
                </div><!-- box end -->
            </div> <!-- column col-lg-12 end -->
        </div><!--row end-->
    </section> <!-- section content End -->
</div><!-- tab-content end-->













