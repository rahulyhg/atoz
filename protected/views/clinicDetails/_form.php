<?php
/* @var $this ClinicDetailsController */
/* @var $model ClinicDetails */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'clinic-details-form',
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
		<?php echo $form->labelEx($model,'clinic_name'); ?>
		<?php echo $form->textField($model,'clinic_name',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'clinic_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'register_no'); ?>
		<?php echo $form->textField($model,'register_no',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'register_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'opd_consultation_fee'); ?>
		<?php echo $form->textField($model,'opd_consultation_fee'); ?>
		<?php echo $form->error($model,'opd_consultation_fee'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'opd_consultation_discount'); ?>
		<?php echo $form->textField($model,'opd_consultation_discount'); ?>
		<?php echo $form->error($model,'opd_consultation_discount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'free_opd_perday'); ?>
		<?php echo $form->textField($model,'free_opd_perday'); ?>
		<?php echo $form->error($model,'free_opd_perday'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'free_opd_preferdays'); ?>
		<?php echo $form->textField($model,'free_opd_preferdays',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'free_opd_preferdays'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->