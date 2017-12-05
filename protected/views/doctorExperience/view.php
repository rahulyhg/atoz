
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
           
            echo CHtml::link('<i class = "fa fa-edit "></i>Update Doctor Exp', array('DoctorExperience/updateAdmindoctorexp', 'id' => Yii::app()->getSecurityManager()->encrypt($model->id, $enc_key)),array("style" => "color: white;", 'class' => 'btn btn-info'));
            ?>
            <?php echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> Manage Doctor Exp ', array('DoctorExperience/AdminDocExperience', 'id' => Yii::app()->getSecurityManager()->encrypt($model->doctor_id, $enc_key)), array("style" => "color: white;", 'class' => 'btn btn-info')); ?>
       

                                
                                
                        </div><!--link End-->    
       Experience
                            <table class="table table-hover table-striped">
                <tbody>
                    <tr class="odd"><th> Year</th><td><?php echo $model->work_from.' Years'; ?></td></tr>
                   
                    <tr class="odd"><th>  Month</th><td><?php echo $model->work_to.' Months'; ?></td></tr>
                  
                    
                
                </tbody>
            </table>
     
                        </div><!-- box header end -->
                    </div><!-- box end -->
                </div> <!-- column col-lg-12 end -->
            </div><!--row end-->
        </section> <!-- section content End -->
    </div><!-- tab-content end-->


  
            
           

    
       
        
  
  


