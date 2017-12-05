<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 $enc_key = Yii::app()->params->enc_key;
?>
<section class="content-header">

    <h3>View Diagnostic</h3>

</section>
<div class="tab-content"><!-- tab-content start-->
        <section class="content"> <!-- section content start -->
            <div class="row"><!-- row start-->
                <div class="col-lg-12"> <!-- column col-lg-12 start -->
                    <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                        <div class="box-header with-border"><!-- box header start -->
                            <div class="text-right"><!--link div-->
                                            <?php echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> Manage Diagnostic ', array('users/manageDiagnostic'), array("style" => "color: white;", 'class' => 'btn btn-info')); ?>

                      </div><!--link End-->    
                          
            <table class="table table-hover table-striped">
                <tbody>
                    <tr class="odd"><th>Diagnostic Name</th><td><?php echo CHtml::encode($model->hospital_name); ?></td></tr>
                    <tr class="odd"><th>Type of Diagnostic</th><td><?php echo CHtml::encode($model->type_of_hospital); ?></td></tr>
                    <tr class="odd"><th>Diagnostic Registration No</th><td><?php echo CHtml::encode($model->hospital_registration_no); ?></td></tr>
                    <tr class="odd"><th>Diagnostic Establishment</th><td><?php echo CHtml::encode($model->hos_establishment); ?></td></tr>
                    
                 
                    <?php if(!empty($model->apt_contact_no_1)){echo"<tr class='odd'><th>Appointment Contact No</th><td>$model->apt_contact_no_1</td></tr>"; }?>
                    <?php if(!empty($model->apt_contact_no_2)){echo"<tr class='odd'><th>Appointment Contact No</th><td>$model->apt_contact_no_2</td></tr>"; }?>
            
                    <tr class="odd"><th>Address</th><td><?php echo CHtml::encode($model->address); ?></td></tr>
                    <tr class="odd"><th>Landmark</th><td><?php echo CHtml::encode($model->landmark); ?></td></tr>
                     <tr class="odd"><th>Pincode</th><td><?php echo CHtml::encode($model->pincode); ?></td></tr>
                      <tr class="odd"><th>City</th><td><?php echo CHtml::encode($model->city_name); ?></td></tr>
                       <tr class="odd"><th>State</th><td><?php echo CHtml::encode($model->state_name); ?></td></tr>
                 </tbody>
            </table>
                        
                        </div><!-- box header end -->
                    </div><!-- box end -->
                </div> <!-- column col-lg-12 end -->
            </div><!--row end-->
        </section> <!-- section content End -->
    </div><!-- tab-content end-->


    
        
       
           
           
           

       
 
    

    
 

