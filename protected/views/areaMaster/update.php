<?php
/* @var $this AreaMasterController */
/* @var $model AreaMaster */

$this->breadcrumbs = array(
    'Area Masters' => array('index'),
    $model->area_id => array('view', 'id' => $model->area_id),
    'Update',
);

$this->menu = array(
    array('label' => 'List AreaMaster', 'url' => array('index')),
    array('label' => 'Create AreaMaster', 'url' => array('create')),
    array('label' => 'View AreaMaster', 'url' => array('view', 'id' => $model->area_id)),
    array('label' => 'Manage AreaMaster', 'url' => array('admin')),
);
$enc_key = Yii::app()->params->enc_key;
?>

<section class="content-header">

    <h3>Update AreaMaster</h3>

</section>

<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row"><!-- row start-->
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                    <div class="box-header with-border"><!-- box header start -->
                         <div class="text-right">
                            <?php echo CHtml::link('<i class = "fa fa-plus fa-fw"></i>Create Area', array('areaMaster/create'), array("style" => "color: white;", 'class' => 'btn btn-info')) ?>
                              <?php echo CHtml::link('<i class="fa fa-search fa-fw"></i> View Area',array('AreaMaster/view', 'id' => Yii::app()->getSecurityManager()->encrypt($model->area_id, $enc_key)), array("style" => "color: white;", 'class' => 'btn btn-info')); ?>

                                  <?php echo CHtml::link('<i class = "fa fa-gear fa-fw"></i> Manage Area',array('AreaMaster/admin'), array("style"=>"color: white;",'class'=>'btn btn-info'))?>

                        </div>
                        <?php $this->renderPartial('_form', array('model' => $model)); ?>

                    </div><!-- box header end -->
                </div><!-- box end -->
            </div> <!-- column col-lg-12 end -->
        </div><!--row end-->
    </section> <!-- section content End -->
</div><!-- tab-content end-->



