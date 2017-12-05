<?php
/* @var $this AreaMasterController */
/* @var $model AreaMaster */

$this->breadcrumbs = array(
    'Area Masters' => array('index'),
    $model->area_id,
);
?>

<section class="content-header">

    <h3>View Area</h3>

</section>
<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row"><!-- row start-->
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                    <div class="box-header with-border"><!-- box header start -->
                        <div class="text-right"><!--link div-->

                            <?php echo CHtml::link('<i class = "fa  fa-plus  fa-fw"></i> Create Area ', array('AreaMaster/create'), array("style" => "color: white;", 'class' => 'btn btn-info')); ?>
                            <?php
                            //
                            $enc_key = Yii::app()->params->enc_key;
                            echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> Update Area ', array('AreaMaster/update', 'id' => Yii::app()->getSecurityManager()->encrypt($model->city_id, $enc_key)), array("style" => "color: white;", 'class' => 'btn btn-info'));
                            ?>
                            <?php echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> Manage Area ', array('AreaMaster/admin'), array("style" => "color: white;", 'class' => 'btn btn-info')); ?>
                        </div><!--link End-->    

                        <table class="table table-hover table-striped">
                            <tbody><tr class="odd"><th>Area Name</th><td><?php echo CHtml::encode($model->area_name); ?></td></tr>
                                <tr class="even"><th>City Name</th><td><?php echo CHtml::encode($comFuncObj->getCityNameById($model->city_id)); ?></td></tr>
                                <tr class="even"><th>pincode</th><td><?php echo CHtml::encode($model->pincode); ?></td></tr>
                            </tbody>
                        </table> 
                    </div><!-- box header end -->
                </div><!-- box end -->
            </div> <!-- column col-lg-12 end -->
        </div><!--row end-->
    </section> <!-- section content End -->
</div><!-- tab-content end-->












