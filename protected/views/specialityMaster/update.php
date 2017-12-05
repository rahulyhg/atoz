<?php
/* @var $this SpecialityMasterController */
/* @var $model SpecialityMaster */
$enc_key = Yii::app()->params->enc_key;
?>
<section class="content-header">

     <h3>Update Speciality</h3>

</section>
<div class="tab-content"><!-- tab-content start-->
        <section class="content"> <!-- section content start -->
            <div class="row"><!-- row start-->
                <div class="col-lg-12"> <!-- column col-lg-12 start -->
                    <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                        <div class="box-header with-border"><!-- box header start -->
                            <div class="text-right"><!--link div-->
 
                                
            <?php echo CHtml::link('<i class = "fa fa-plus fa-fw"></i>Create Speciality', array('specialityMaster/create'), array("style" => "color: white;", 'class' => 'btn btn-info')) ?>
            <?php echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> View Speciality ', array('specialityMaster/view', 'id' => Yii::app()->getSecurityManager()->encrypt($model->speciality_id, $enc_key)), array("style" => "color: white;", 'class' => 'btn btn-info')); ?>
            <?php echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> Manage Speciality ', array('specialityMaster/admin'), array("style" => "color: white;", 'class' => 'btn btn-info')); ?>

                                
                                
                        </div><!--link End-->    
                                <?php $this->renderPartial('_form', array('model' => $model)); ?>
                        
                        </div><!-- box header end -->
                    </div><!-- box end -->
                </div> <!-- column col-lg-12 end -->
            </div><!--row end-->
        </section> <!-- section content End -->
    </div><!-- tab-content end-->

  
      
    

   
