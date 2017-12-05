<?php
/* @var $this DegreeMasterController */
/* @var $model DegreeMaster */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	
	<div class="col-sm-4">
		<?php echo $form->label($model,'degree_name'); ?>
		<?php echo $form->textField($model,'degree_name',array('class'=>'form-control')); ?>
	</div>

	<div class="row buttons text-center">
		<?php echo CHtml::submitButton('Search', array("class" => "btn btn-primary center")); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->