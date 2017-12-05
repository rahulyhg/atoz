<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* @var $this UserDetailsController */
/* @var $model UserDetails */
//echo "<pre>";
//print_r($model);
$enc_key = Yii::app()->params->enc_key;
?>

<section class="content-header">

    <h3>View Patient</h3>

</section>
<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row"><!-- row start-->
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                    <div class="box-header with-border"><!-- box header start -->
                        <div class="text-right"><!--link div-->

                            <?php
                            echo CHtml::link('<i class = "fa fa-edit "></i>Update Patient', array('UserDetails/updateAdminPatient', 'id' => Yii::app()->getSecurityManager()->encrypt($model->user_id, $enc_key)), array("style" => "color: white;", 'class' => 'btn btn-info'));
                            ?>
                            <?php
                            if ($model->patient_type != 'Corporate') {
                                echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> Manage Patient ', array('UserDetails/adminPatient'), array("style" => "color: white;", 'class' => 'btn btn-info'));
                            } else {
                                echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> Manage Co Users ', array('UserDetails/corporateList'), array("style" => "color: white;", 'class' => 'btn btn-info'));
                            }
                            ?>

                        </div><!--link End-->    

                        <div class="box-header with-border"><!-- box header start -->



                            <?php
                            $enc_key = Yii::app()->params->enc_key;
 $baseUrl = Yii::app()->request->baseUrl; 
                            $path = $baseUrl . "/uploads/" . $model->profile_image;
                            ?>
                            <div class="form-group clearfix">
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
                         

                                    <div class="col-sm-3">
                                        <span><b>Patient Name</b></span>
                                        <?php echo '<br>' . $model->first_name . ' ' . $model->last_name; ?>

                                    </div>
                                    <div class="col-sm-3">
                                        <span><b>Gender</b></span>
                                        <?php echo '<br>' . $model->gender; ?>
                                    </div> 
                                    <div class="col-sm-3">
                                        <span><b>Type</b></span>
                                        <?php echo '<br>' . $model->patient_type; ?>
                                    </div> 

                              </div>
                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <span><b>Date of Birth</b></span>
                                        <?php echo '<br>' . $model->birth_date; ?>
                                    </div> 
                                    <div class="col-sm-3">
                                        <span><b>Age</b></span>
                                        <?php echo '<br>' . $model->age; ?>
                                    </div> 
                               
                                    <div class="col-sm-3">
                                        <span><b>Blood Group</b></span>
                                        <?php echo '<br>' . $model->blood_group; ?>
                                    </div> 
                                    <div class="col-sm-3">
                                        <span><b>Mobile</b></span>
                                        <?php echo '<br>' . $model->mobile; ?>
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <span><b>Contact Number 1</b></span>
                                        <?php echo '<br>' . $model->apt_contact_no_1; ?>
                                    </div> 
                                    <div class="col-sm-3">
                                        <span><b>Contact Number 2</b></span>
                                        <?php echo '<br>' . $model->apt_contact_no_2; ?>
                                    </div> 
                                
                                    <div class="col-sm-3">
                                        <span><b>Email Address 1</b></span>
                                        <?php echo '<br>' . $model->email_1; ?>
                                    </div> 
                                    <div class="col-sm-3">
                                        <span><b>Email Address 2</b></span>
                                        <?php echo '<br>' . $model->email_2; ?>
                                    </div> 
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
                                <b><span>Street Address<br></span></b>  
                                <?php echo $model->address; ?>
                            </div>

                            <div class="clearfix"></div>
                            <div class="textdetails">

                                <div class="col-md-4">
                                    <?php // echo $form->labelEx($model, 'Area');  ?> 
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
                                    // echo $form->dropDownList($model, 'area_id', $areaArr, array("class" => "form-control  area-class areaId", "style" => "width:100%;", "prompt" => "Select Area", "data-rule-required" => "true", "data-msg-required" => "Please Select Area", 'onchange' => 'getAreaid()'));
                                    // echo $form->error($model, 'area_id');
                                    if (isset($session['area_name'])) {
                                        $model->area_name = $session['area_name'];
                                    }
                                    // echo $form->hiddenField($model, "area_name", array("class" => "area-id-class"));
                                    ?>   
                                </div>
                                <div class="col-md-4">
                                    <?php // echo $form->labelEx($model, 'Landmark');  ?> 
                                    <?php
                                    if (isset($session['landmark'])) {
                                        $model->landmark = $session['landmark'];
                                    }
                                    // echo $form->textField($model, 'landmark', array("class" => "form-control  input-group"));
                                    // echo $form->error($model, 'landmark');
                                    ?>
                                </div>
                                <div class="col-md-4">
                                    <?php // echo $form->labelEx($model, 'Street Address');  ?> 
                                    <?php
                                    if (isset($session['address'])) {
                                        $model->address = $session['c_address'];
                                    }
                                    // echo $form->textField($model, 'address', array("class" => "form-control input-group", "data-rule-required" => "true", "data-msg-required" => "Please enter Address"));
                                    // echo $form->error($model, 'address');
                                    ?>
                                </div>
                            </div>






                        </div><!-- box header end -->

                    </div><!-- box header end -->
                </div><!-- box end -->
            </div> <!-- column col-lg-12 end -->
        </div><!--row end-->
    </section> <!-- section content End -->
</div><!-- tab-content end-->












