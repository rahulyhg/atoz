<?php
/* @var $this DoctorExperienceController */
/* @var $model DoctorExperience */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	

	<div class="row">
		<?php echo $form->label($model,'doctor_id'); ?>
		<?php echo $form->textField($model,'doctor_id'); ?>
	</div>

	<div class="row">
            <label>Year</label>
		<?php echo $form->textField($model,'work_from',array('size'=>20,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<label>Months</label>
		<?php echo $form->textField($model,'work_to',array('size'=>20,'maxlength'=>100)); ?>
	</div>

	

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->