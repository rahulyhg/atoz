<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$enc_key = Yii::app()->params->enc_key;
?>


<section class="content-header">

    <h3>View Hospital</h3>


</section>
<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row"><!-- row start-->
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                    <div class="box-header with-border"><!-- box header start -->
                        <div class="text-right"><!--link div-->

                            <?php echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> Manage Hospital ', array('UserDetails/manageHospital'), array("style" => "color: white;", 'class' => 'btn btn-info')); ?>

                            </div><!--link End-->
                             <div class="bs-example">
                            <ul class="nav nav-tabs" id="myTab">
                                <li><a data-toggle="tab" href="#sectionA">Hospital Details</a></li>
                                <li><a data-toggle="tab" href="#sectionB">Services</a></li>
                                <li><a data-toggle="tab" href="#dropdown">Upload Documents</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="sectionA" class="tab-pane fade in active">
                                    
                                    <div class="underline"></div>
                                    <h4 class="title-details">Hospital Details  </h4>
                                  
                                    <div class="box box-primary">
                                        <div class="form-group clearfix">
                                            <div class="col-sm-4">
                                                <span><b>Profile image<br></b></span>
                                                <?php
                                               

                                                if (!empty($model->profile_image)) {
                                                    $baseDir = Yii::app()->baseUrl . "/uploads/";
                                                    echo CHtml::image($baseDir . $model->profile_image, "icon_image",array("class" => "img-circle", "width" => "75","height"=>'75'));
                                                }else{
                                                    
                                               echo CHtml::image(Yii::app()->request->baseUrl . "/images/icons/icon02.png", "Hospital Photo", array("class" => "img-circle", "width" => "75"));    
                                                }
                                               
                                                ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <span><b>Hospital Name<br></b></span>
                                                <?php
                                              echo   $model->hospital_name;
                                                ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <span><b>Type of Hospital<br></b></span>
                                                <?php
                                             echo $model->type_of_hospital;
                                                ?>
                                            </div>

                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="col-sm-4">
                                                <span><b>Hospital Reg.No<br></b></span>
                                                <?php
                                                echo $model->hospital_registration_no;
                                           ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <span><b>Payment Type<br></b></span>
                                                <?php
                                                echo $model->payment_type;
                                                ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <span><b>Hospital Establishment<br></b></span>
                                                <?php
                                                echo $model->hos_establishment;
                                                ?>
                                            </div>
                                        </div>
                                      
                                        <div class="form-group clearfix">
                                            <div class ="col-sm-4">
                                                <span><b>Speciality<br></b></span>
                                                <?php
                                                echo $model->speciality;
                                                ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <span><b>Land Line 1<br></b></span>
                                                <?php 
                                                    echo $model->landline_1;
                                               ?>
      
                                               
                                            </div>
                                              <div class="col-sm-4">
                                                <span><b>Land Line 2<br></b></span>
                                                <?php 
                                                    echo $model->landline_2;
                                               ?>
                                          </div>

                                            <div class="col-sm-4">
                                             <span><b>Email 1<br></b></span>
                                                <?php 
                                                    echo $model->email_1;
                                               ?>
                                             
                                            </div>
                                               <div class="col-sm-4">
                                             <span><b>Email 2<br></b></span>
                                                <?php 
                                                    echo $model->email_2;
                                               ?>
                                             
                                            </div>
                                        
                                        
                                            <div class="col-sm-4">
                                                <span><b>Emergency No 1<br></b></span>
                                                <?php echo $model->emergency_no_1;?>
                                              
                                                </div>
                                        
                                            <div class="col-sm-4">
                                                <span><b>Emergency No 2<br></b></span>
                                                <?php echo $model->emergency_no_2;?>
                                              
                                               
                                            </div>
                                            <div class="col-sm-4">
                                               <span><b>Toll Free 1<br></b></span>
                                                <?php echo $model->tollfree_no_1;?> 
                                              
                                            </div>
                                            <div class="col-sm-4">
                                               <span><b>Toll Free 2<br></b></span>
                                                <?php echo $model->tollfree_no_2;?> 
                                              
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="col-sm-12">
                                                <span><b>  A-Z Health+ coordinator from Hospital</b></span>
                                            </div>
                                            <div class="col-sm-4">
                                                <span><b>Coordinator Name<br></b></span>
                                                <?php echo $model->coordinator_name_1;  ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <span><b>Coordinator Mobile<br></b></span>
                                                <?php echo $model->coordinator_mobile_1; ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <span><b>Coordinator Email<br></b></span>
                                                <?php echo $model->coordinator_email_1;  ?>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                             <div class="col-sm-4">
                                                <span><b>Coordinator Name<br></b></span>
                                                <?php echo $model->coordinator_name_2;  ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <span><b>Coordinator Mobile<br></b></span>
                                                <?php echo $model->coordinator_mobile_2; ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <span><b>Coordinator Email<br></b></span>
                                                <?php echo $model->coordinator_email_2;  ?>
                                            </div>

                                        </div>
                                        <div class="form-group clearfix">
                                             <div class="col-sm-12">
                                                <span><b>Hospital Timing</b></span>
                                            </div>
                                            <div class="col-sm-4">
                                                <span><b>Open Time<br></b></span>
                                             <?php echo !empty($model->hospital_open_time) ? date("g:i a",strtotime($model->hospital_open_time)):'';?>

                                            </div>
                                            <div class="col-sm-4">
                                                <span><b>Close Time<br></b></span>
                                             <?php echo !empty($model->hospital_close_time) ? date("g:i a",strtotime($model->hospital_close_time)):'';?>

                                            </div>
                                           
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="col-sm-12">
                                                <span><b>Total No Of.Bed</b></span>
                                            </div>
                                            <div class="col-sm-4">
                                                <?php echo $model->total_no_of_bed;?>
                                            </div>
                                       

                                        </div>
                                          <div class="form-group clearfix">
                                            <div class="col-sm-12">
                                                <span><b>Amenities</b></span>
                                            </div>
   
                                            <div class="col-sm-4">
                                                <?php
                                                if(!empty($amenities)){
                                                foreach ($amenities as $row) {

                                                    echo $row->amenities.', ';
                                                }
                                                }
                                                ?>
                                            </div>
                                       

                                        </div>
                                       

                                    </div>
                                </div>

                                <div id="sectionB" class="tab-pane fade">
                                    <div class="col-md-12">
                                        <h4 class="box-title">Service Information</h4>
                                    </div>
                                    <div>
                                        <?php
                                        if (count($serviceUserMapping) > 0 && is_array($serviceUserMapping)) {
                                            $sindex = 0;
                                            //echo"<pre>";print_r($serviceUserMapping);exit;
                                            foreach ($serviceUserMapping as $key => $serviceDetailObj) {
                                                ?>

                                                <div class=" form-group serviceclone clearfix" id="serviceclone">

                                                    
                                                    <?php
                                                    $service = Yii::app()->db->createCommand()->select("service_id,service_name")->from("az_service_master")->where('role_id=:roleid', array(':roleid' => $roleid))->queryAll();
                                                    $servicenameArr = CHtml::listData($service, 'service_id', 'service_name');
                                                    ?>
                                                    <div class="col-sm-3">
                                                        <span class="col-sm-1 control-label">Service</span><br>
                                                    
                                                            <?php foreach ($servicenameArr as $servicekey => $value) {
                                                                ?>

                                                                <?php echo $serviceDetailObj->service_id == $servicekey ? $value : ""; ?>
                                                            <?php }
                                                            ?>
                                                    
                                                    </div>
                                                    <?php // echo $form->error($model, 'service_id'); ?>

                                                   
                                                    <div class="col-sm-2 clearfix">
                                                         <span class=" control-label">Discount</span><br>
                                                        <?php echo $serviceDetailObj->service_discount ?>
                                                        <?php // echo $form->error($model, 'service_discount', array('class' => 'col-sm-1 control-label')); ?>
                                                    </div>
                                                    
                                                    <div class="col-sm-2 clearfix">
                                                         <span class=" control-label">Corporate Discount</span><br>
                                                      <?php echo $serviceDetailObj->corporate_discount ?>
                                                        <?php // echo $form->error($model, 'corporate_discount', array('class' => 'col-sm-1 control-label')); ?>
                                                    </div>



                                                    <?php
                                                    $isallday = array('Yes' => "Yes", 'No' => "No");
                                                    ?>
                                                   
                                                    <div class ="col-md-2">
                                                                <span class="col-sm-1 control-label">24x7</span><br>

                                                                <?php foreach ($isallday as $key => $value) { ?>
                                                                    <?php echo $serviceDetailObj->is_available_allday == $key ? $value : ""; ?>
                                                                <?php } ?>

                                                    </div>
                                                    

                                                </div>

                                                <?php
                                            }
                                        } else {
                                            $rindex = 0;
                                            ?>
                                            <div class=" form-group serviceclone clearfix" id="serviceclone">
                                                <label class="col-sm-1 control-label">Service</label>
                                                <?php
                                                $service = ServiceMaster::model()->findAll();
                                                $servicenameArr = CHtml::listData($service, 'service_id', 'service_name');
                                                ?>
                                                <div class="col-sm-2">
                                                    <select class="form-control servicename" name="service[]" >
                                                        <?php foreach ($servicenameArr as $servicekey => $value) {
                                                            ?>

                                                            <option value='<?php echo $servicekey; ?>'> <?php echo $value; ?></option>
                                                        <?php }
                                                        ?>
                                                    </select>
                                                </div>
                                                <?php // echo $form->error($model, 'service_id'); ?>
                                                <label class="col-sm-1 control-label">Discount</label>
                                                <div class="col-sm-2  clearfix">
                                                    <input type="text" name="service_discount[]" value=''  class='form-control'>
                                                    <?php // echo $form->error($model, 'service_discount', array('class' => 'col-sm-1 control-label')); ?>
                                                </div>


                                                <?php
                                                $isallday = array('Yes' => "Yes", 'No' => "No");
                                                ?>
                                                <label class="col-sm-1 control-label">24x7</label>
                                                <div class ="col-md-2">
                                                    <select class="form-control twentyfour" name="twentyfour[]">
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
                                                        ?>
                                                        <i class="fa fa-times" aria-hidden="true" onclick='remove_service(this)'></i>
                                                    <?php }
                                                    ?>
                                                </div>

                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class =takehome">
                                    </div>
                                </div>
                                <div id="dropdown" class="tab-pane fade">
                                    <h3>Documents / Certificates</h3>
                                    <div class="col-md-4">

                                        <?php
                                        $baseDir = Yii::app()->baseUrl . "/uploads";
                                                    echo CHtml::image($baseDir . $model3->document, "icon_image",array("class" => "img-circle", "width" => "75","height"=>'75'));
                                        ?> 
                                    </div>

                                    <div class="col-md-4">
                                        <?php
                                        // echo $form->labelEx($model, 'Other Registration');

// echo CHtml::image($baseDir . $model3->otherdoc, "icon_image", array('width' => 75, 'height' => 75));
                                        // echo $form->fileField($model3, 'otherdoc', array("class" => "form-control input-group"));
// // echo $form->error($model3, 'otherdoc');
                                        ?> 
                                    </div>
                                    <div class="clearfix">&nbsp;</div>
                                    <div class="box-footer text-center clearfix">
                                        <?php
                                        echo CHtml::submitButton("Submit", array('class' => 'btn btn-primary'));
                                        ?>
                                    </div>
                                </div>

                            </div>
                        </div>



                    </div><!-- box header end -->
                </div><!-- box end -->
            </div> <!-- column col-lg-12 end -->
        </div><!--row end-->
    </section> <!-- section content End -->
</div><!-- tab-content end-->














