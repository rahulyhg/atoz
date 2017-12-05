<?php
/* @var $this StateMasterController */
/* @var $model StateMaster */

//$this->breadcrumbs = array(
//    'State Masters' => array('index'),
//    $model->state_id,
//);
?>
<section class="content-header">

    <h3>View State</h3>

</section>
<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row"><!-- row start-->
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                    <div class="box-header with-border"><!-- box header start -->

                        <div class="text-right"><!--link div-->   

                            <?php echo CHtml::link('<i class = "fa  fa-plus  fa-fw"></i> Create State ', array('stateMaster/create'), array("style" => "color: white;", 'class' => 'btn btn-info')); ?>
                            <?php
                            //
                            $enc_key = Yii::app()->params->enc_key;
                            echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> Update State ', array('stateMaster/update', 'id' => Yii::app()->getSecurityManager()->encrypt($model->state_id, $enc_key)), array("style" => "color: white;", 'class' => 'btn btn-info'));
                            ?>
                            <?php echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> Manage State ', array('stateMaster/admin'), array("style" => "color: white;", 'class' => 'btn btn-info')); ?>
                        </div><!--link End-->
                        <div class="box-body">
                            <table class="table table-hover table-striped">
                                <tbody>
                                    <tr class="odd"><th>State Name</th><td><?php echo CHtml::encode($model->state_name); ?></td></tr>
                                    <tr class="even"><th>Country Name</th><td><?php echo CHtml::encode($comFuncObj->getCountryNameById($model->country_id)); ?>

                                        </td></tr>
                                </tbody>
                            </table> 
                        </div>  
                    </div><!-- box header end -->
                </div><!-- box end -->
            </div> <!-- column col-lg-12 end -->
        </div><!--row end-->
    </section> <!-- section content End -->
</div><!-- tab-content end-->











