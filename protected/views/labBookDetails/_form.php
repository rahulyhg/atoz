<?php
/* @var $this LabBookDetailsController */
/* @var $model LabBookDetails */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'lab-book-details-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'patient_id'); ?>
		<?php echo $form->textField($model,'patient_id'); ?>
		<?php echo $form->error($model,'patient_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'role_id'); ?>
		<?php echo $form->textField($model,'role_id'); ?>
		<?php echo $form->error($model,'role_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'center_id'); ?>
		<?php echo $form->textField($model,'center_id'); ?>
		<?php echo $form->error($model,'center_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'relation'); ?>
		<?php echo $form->textField($model,'relation',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'relation'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'full_name'); ?>
		<?php echo $form->textField($model,'full_name',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'full_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mobile_no'); ?>
		<?php echo $form->textField($model,'mobile_no',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'mobile_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'patient_age'); ?>
		<?php echo $form->textField($model,'patient_age'); ?>
		<?php echo $form->error($model,'patient_age'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'service_name'); ?>
		<?php echo $form->textField($model,'service_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'service_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discription_doc'); ?>
		<?php echo $form->textField($model,'discription_doc',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'discription_doc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'collect_home'); ?>
		<?php echo $form->textField($model,'collect_home',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'collect_home'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pincode'); ?>
		<?php echo $form->textField($model,'pincode'); ?>
		<?php echo $form->error($model,'pincode'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'country_id'); ?>
		<?php echo $form->textField($model,'country_id'); ?>
		<?php echo $form->error($model,'country_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'country_name'); ?>
		<?php echo $form->textField($model,'country_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'country_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'city_id'); ?>
		<?php echo $form->textField($model,'city_id'); ?>
		<?php echo $form->error($model,'city_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'city_name'); ?>
		<?php echo $form->textField($model,'city_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'city_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'area_id'); ?>
		<?php echo $form->textField($model,'area_id'); ?>
		<?php echo $form->error($model,'area_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'area_name'); ?>
		<?php echo $form->textField($model,'area_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'area_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'landmark'); ?>
		<?php echo $form->textField($model,'landmark',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'landmark'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textField($model,'address',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_date'); ?>
		<?php echo $form->textField($model,'created_date'); ?>
		<?php echo $form->error($model,'created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updated_date'); ?>
		<?php echo $form->textField($model,'updated_date'); ?>
		<?php echo $form->error($model,'updated_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->