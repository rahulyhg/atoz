<?php
/* @var $this CityMasterController */
/* @var $model CityMaster */
?>



<section class="content-header">

       <h3>View City</h3>

</section>
<div class="tab-content"><!-- tab-content start-->
        <section class="content"> <!-- section content start -->
            <div class="row"><!-- row start-->
                <div class="col-lg-12"> <!-- column col-lg-12 start -->
                    <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                        <div class="box-header with-border"><!-- box header start -->
                            <div class="text-right"><!--link div-->
 
                                        
            <?php echo CHtml::link('<i class = "fa  fa-plus  fa-fw"></i> Create City ', array('cityMaster/create'), array("style" => "color: white;", 'class' => 'btn btn-info')); ?>
            <?php
            $enc_key = Yii::app()->params->enc_key;
            echo CHtml::link('<i class = "fa fa-edit "></i>Update City', array('cityMaster/update', 'id' => Yii::app()->getSecurityManager()->encrypt($model->city_id, $enc_key)), array("style" => "color: white;", 'class' => 'btn btn-info'));
            ?>
            <?php echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> Manage City ', array('cityMaster/admin'), array("style" => "color: white;", 'class' => 'btn btn-info')); ?>

                                
                                
                        </div><!--link End-->    
        <table class="table table-hover table-striped">
                <tbody>
                    <tr class="odd"><th>City Name</th><td><?php echo CHtml::encode($model->city_name); ?></td></tr>
                    <tr class="odd"><th>State Name</th><td><?php echo CHtml::encode($comFuncObj->getStateNameById($model->state_id)); ?></td></tr>
                </tbody>
            </table>
                        
                        </div><!-- box header end -->
                    </div><!-- box end -->
                </div> <!-- column col-lg-12 end -->
            </div><!--row end-->
        </section> <!-- section content End -->
    </div><!-- tab-content end-->

   
     
       
     
  
   
       
           
       
  
  