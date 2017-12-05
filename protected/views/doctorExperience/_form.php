<?php
/* @var $this DoctorExperienceController */
/* @var $model DoctorExperience */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'doctor-experience-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'doctor_id'); ?>
		<?php echo $form->textField($model,'doctor_id'); ?>
		<?php echo $form->error($model,'doctor_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'work_from'); ?>
		<?php echo $form->textField($model,'work_from',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'work_from'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'work_to'); ?>
		<?php echo $form->textField($model,'work_to',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'work_to'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'doctor_role'); ?>
		<?php echo $form->textField($model,'doctor_role',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'doctor_role'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'city_id'); ?>
		<?php echo $form->textField($model,'city_id'); ?>
		<?php echo $form->error($model,'city_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->