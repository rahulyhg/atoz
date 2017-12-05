<?php
/* @var $this AreaMasterController */
/* @var $model AreaMaster */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>
   <div class="box-body">
    <div class="form-group">

        <?php echo $form->label($model, 'city_name', array("class" => "col-sm-2 control-label")); ?>
        <div class="col-sm-2">
            <?php echo $form->textField($model, 'city_id', array("class" => "form-control ")); ?>
        </div>
        <?php echo $form->label($model, 'area_name', array("class" => "col-sm-2 control-label")); ?>
        <div class="col-sm-2">
            <?php echo $form->textField($model, 'area_name', array("class" => "form-control ")); ?>
        </div>
         <?php echo $form->label($model, 'pincode', array("class" => "col-sm-2 control-label")); ?>
        <div class="col-sm-2">
            <?php echo $form->textField($model, 'pincode', array("class" => "form-control ")); ?>
        </div>  
    </div>
</div>
<div class="box-footer text-center">
    <?php echo CHtml::submitButton('Search', array("class" => "btn btn-primary center")); ?>
</div>



<?php $this->endWidget(); ?>

</div><!-- search-form -->