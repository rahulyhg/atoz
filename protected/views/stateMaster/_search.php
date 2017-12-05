<?php
/* @var $this CityMasterController */
/* @var $model CityMaster */
/* @var $form CActiveForm */
?>

<div class="box box-primary">
    <div class="box-header text-center">
        <h3 class="box-title " >Search Form</h3>
    </div>

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>


    <div class="box-body">
        <div class="form-group">

            <?php echo $form->label($model, 'country_name', array("class" => "col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model, 'country_id', array("class" => "form-control ")); ?>
            </div>
            <?php echo $form->label($model, 'state_name', array("class" => "col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model, 'state_name', array("class" => "form-control ")); ?>
            </div>  
        </div>
    </div>

    <div class="box-footer text-center">
        <?php echo CHtml::submitButton('Search', array("class" => "btn btn-primary")); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->