

<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* @var $this UserDetailsController */
/* @var $model UserDetails */
$enc_key = Yii::app()->params->enc_key;
//echo "<pre>";print_r($model);
?>
<section class="content-header">

    <h3>View Doctor</h3>

</section>
<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row"><!-- row start-->
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                    <div class="box-header with-border"><!-- box header start -->
                        <div class="text-right"><!--link div-->

                            <?php
                            echo CHtml::link('<i class = "fa fa-edit "></i>Update Doctor', array('UserDetails/updateAdminDoctor', 'id' => Yii::app()->getSecurityManager()->encrypt($model->user_id, $enc_key)), array("style" => "color: white;", 'class' => 'btn btn-info'));
                            ?>
                            <?php echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> Manage Doctor ', array('UserDetails/admindoctor'), array("style" => "color: white;", 'class' => 'btn btn-info')); ?>
                        </div><!--link End-->    

                        <div class="box-body">
                            <div class="form-group">
                                <?php // echo $form->errorSummary($model); ?>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <span><b> First Name</b></span>
                                    <?php echo '<br>'.$model->first_name; ?>

                                </div>
                                <div class="col-sm-4">
                                    <span><b>Last Name</b></span>
                                    <?php echo '<br>'.$model->last_name; ?>
                                    <?php // echo $form->error($model, 'last_name'); ?>
                                </div>
                                
                                 <div class="col-sm-3">
                                    <label class="control-label">Profile Image</label>
                                    <div class="fileinput fileinput-new" data-provides="fileinput" style="position: relative;">
                                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="background: transparent;width:75px;height:75px;text-align: center; margin: auto;border-radius: 50%;overflow: hidden;">
                                            <?php
                                            if (empty($model->profile_image)) {
                                                echo CHtml::image(Yii::app()->request->baseUrl . "/images/icons/icon01.png", "Profile Photo", array("class" => "img-circle", "width" => "75"));
                                            } else {
                                                echo CHtml::image(Yii::app()->request->baseUrl . "/uploads/$model->profile_image", "Profile Photo", array("class" => "img-circle", "width" => "75"));
                                            }
                                            ?>

                                        </div>
                                      
                                    </div>

                                </div>
                                
                            </div>
                            <div class="form-group">

                                <div class="col-sm-3">
                                    <span><b>Blood Group</b></span>
                                    <?php echo '<br>'.$model->blood_group; ?>

                                </div>
                                 <div class="col-sm-3">
                                    <span><b>Gender</b></span>
                                    <?php echo '<br>'.$model->gender; ?>
                                </div> 
                               
                            </div>
                            <div class="form-group">
                                
                                <div class="col-sm-3">
                                    <span><b>Registation Number</b></span> 
                                    <?php
                                    echo '<br>'.$model->doctor_registration_no;
                                    ?>
                                </div>
                                <div class="col-sm-3">
                                    <span><b>Date Of Birth</b></span>
                                    <?php echo '<br>'.$model->birth_date; ?>

                                </div> 
                                
                                
                            </div>
                            
                            <div class="clearfix" style="padding:15px"></div>
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <span><b>Specialty<br></b></span>
                                    <?php
                                    $speciality = SpecialityMaster::model()->findAll();
                                    $specialitynameArr = CHtml::listData($speciality, 'speciality_id', 'speciality_name');
                                    $selectedSpecialityArr = Yii::app()->db->createCommand()
                                            ->select('speciality_id')
                                            ->from('az_speciality_user_mapping')
                                            ->where('user_id=:id', array(':id' => $model->user_id))
                                            ->queryColumn();
                                    ?>
                 

                                        <?php
                                        foreach ($specialitynameArr as $specialityid => $speciality) {
                                          
                                            if (in_array($specialityid, $selectedSpecialityArr)) {
                                                echo $speciality.', ';
                                            }
                                        
                                        }
                                        ?>
                               
                                    <?php // echo $form->error($model, 'speciality');
                                    ?>                                   
                                </div>
                                <div class="col-md-4">
                                    <span><b>Sub-Specialty<br></b></span> 
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
                        
                                        <?php
                                        foreach ($subspecialitynameArr as $specialityid => $speciality) {
                                            
                                            if (in_array($speciality, $selectedSubSpecialityArr)) {
                                                echo $speciality.', ';
                                            }
                                            
                                        }
                                        ?>
                               
                                    <?php // echo $form->error($model, 'sub_speciality'); ?>                                                  
                                </div>
                                <div class="col-sm-4">
                                    <span><b> Degree<br></b> </span>
                                    <?php
                                    $degree = DegreeMaster::model()->findAll();
                                    $degreenameArr = CHtml::listData($degree, 'degree_id', 'degree_name');
                                    $selectedDegreeArr = Yii::app()->db->createCommand()
                                            ->select('degree_id')
                                            ->from('az_doctor_degree_mapping')
                                            ->where('doctor_id=:id', array(':id' => $model->user_id))
                                            ->queryColumn();
                                    ?>
                                    

                                        <?php
                                        foreach ($degreenameArr as $degreeid => $degree) {
                                         
                                            if (in_array($degreeid, $selectedDegreeArr)) {
                                                echo $degree.', ';
                                            }
                                         
                                        }
                                        ?>
                                        <?php // echo $form->error($model, 'degree'); ?>

                             
                                </div>
                            </div>

                            <div class="clearfix" style="padding:15px"></div>

                            <div class="col-sm-4">


                                <span><b>Appointment Contact No 1.<br></b></span>

                                <?php echo $model->apt_contact_no_1; ?>

                                </div>
                            <div class="col-sm-4">
                                <span><b>Appointment Contact No 2.<br></b></span>
                                <?php echo $model->apt_contact_no_2; ?>


                            </div>
                        </div>
                        <div class="col-sm-4">


                            <span><b>Email 1.<br></b></span>
                            <?php echo $model->email_1; ?>
                            </div>
                             <div class="col-sm-4">
                            <span><b>Email 2.<br></b></span>
                            <?php echo $model->email_2; ?>

                        </div>
                    </div>
                    <div class="clearfix" style="padding:15px"></div>
                    <div class="col-md-12">
                        <h4 class="box-title"><b>About You</b></h4>
                        <?php echo $model->description; ?>
                    </div>  


                    <div class="clearfix" style="padding:15px"></div>
                    <div class="col-md-12">
                        <h4 class="box-title"><b>Location</b></h4>
                    </div>  
                    <div class="col-md-4">
                        <span><b>Zip Code<br></b></span>
                        <?php
                        echo $model->pincode;
                        ?>
                    </div> 
                    <div class="col-md-4">
                        <span><b>State<br></b></span>
                        <?php
                        echo $model->state_name;
                        ?>   

                    </div>
                    <div class="col-md-4">
                        <span><b>City<br></b></span>
                        <?php
                        echo $model->city_name;
                        ?>

                    </div>
                    <div class="col-md-4">
                        <span><b>Area<br></b></span>
                        <?php
                        echo $model->area_name;
                        ?>   

                    </div>
                    <div class="col-md-4">
                        <span><b>Landmark<br></b></span>
                        <?php echo $model->landmark; ?>
                    </div>  
                    <div class="col-sm-4">
                        <b><span>Address<br></span></b>  
                        <?php echo $model->address; ?>
                    </div>
                      <div class="col-md-12">
                        <h4 class="box-title"><b>Experience</b></h4>
                    </div> 
                                  <div class="col-md-4">
                                          
                                        <?php
                                            echo CommonFunction::CalculateAge($model->experience);
                                            ?>
                                     

                                    </div>           
                        
                    
                    <div class="clearfix"></div>
                </div>

            </div><!-- box header end -->
        </div><!-- box end -->
</div> <!-- column col-lg-12 end -->
</div><!--row end-->
</section> <!-- section content End -->
</div><!-- tab-content end-->













