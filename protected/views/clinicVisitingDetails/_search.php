<?php
/* @var $this ClinicVisitingDetailsController */
/* @var $model ClinicVisitingDetails */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'clinic_id'); ?>
		<?php echo $form->textField($model,'clinic_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'doctor_id'); ?>
		<?php echo $form->textField($model,'doctor_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'day'); ?>
		<?php echo $form->textField($model,'day',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'clinic_open_time'); ?>
		<?php echo $form->textField($model,'clinic_open_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'clinic_close_time'); ?>
		<?php echo $form->textField($model,'clinic_close_time'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->