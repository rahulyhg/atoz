<?php
/* @var $this ClinicVisitingDetailsController */
/* @var $model ClinicVisitingDetails */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'clinic-visiting-details-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'clinic_id'); ?>
		<?php echo $form->textField($model,'clinic_id'); ?>
		<?php echo $form->error($model,'clinic_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'doctor_id'); ?>
		<?php echo $form->textField($model,'doctor_id'); ?>
		<?php echo $form->error($model,'doctor_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'day'); ?>
		<?php echo $form->textField($model,'day',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'day'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'clinic_open_time'); ?>
		<?php echo $form->textField($model,'clinic_open_time'); ?>
		<?php echo $form->error($model,'clinic_open_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'clinic_close_time'); ?>
		<?php echo $form->textField($model,'clinic_close_time'); ?>
		<?php echo $form->error($model,'clinic_close_time'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->