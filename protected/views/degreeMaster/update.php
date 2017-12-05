<?php
/* @var $this DegreeMasterController */
/* @var $model DegreeMaster */

$this->breadcrumbs = array(
    'Degree Masters' => array('index'),
    $model->degree_id => array('view', 'id' => $model->degree_id),
    'Update',
);
//
//$this->menu=array(
//	array('label'=>'List DegreeMaster', 'url'=>array('index')),
//	array('label'=>'Create DegreeMaster', 'url'=>array('create')),
//	array('label'=>'View DegreeMaster', 'url'=>array('view', 'id'=>$model->degree_id)),
//	array('label'=>'Manage DegreeMaster', 'url'=>array('admin')),
//);
$enc_key = Yii::app()->params->enc_key;
?>

<section class="content-header">

    <h3>Update State</h3>

</section>
<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row"><!-- row start-->
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                    <div class="box-header with-border"><!-- box header start -->
                        <div class="text-right"><!--link div-->


                            <?php echo CHtml::link('<i class = "fa fa-plus fa-fw"></i>Create Degree', array('DegreeMaster/create'), array("style" => "color: white;", 'class' => 'btn btn-info')); ?>
                            <?php echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> View Degree ', array('DegreeMaster/view', 'id' => Yii::app()->getSecurityManager()->encrypt($model->degree_id, $enc_key)), array("style" => "color: white;", 'class' => 'btn btn-info')); ?>
                            <?php echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> Manage Degree ', array('DegreeMaster/admin'), array("style" => "color: white;", 'class' => 'btn btn-info')); ?>
                        </div><!--link End-->    

                        <?php $this->renderPartial('_form', array('model' => $model)); ?>

                    </div><!-- box header end -->
                </div><!-- box end -->
            </div> <!-- column col-lg-12 end -->
        </div><!--row end-->
    </section> <!-- section content End -->
</div><!-- tab-content end-->






