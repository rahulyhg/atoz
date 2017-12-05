<?php
/* @var $this ClinicDetailsController */
/* @var $model ClinicDetails */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<div class="form-grop">
	<div class="col-sm-4">
		  <span>Clinic Name</span>
		<?php echo $form->textField($model,'clinic_name',array('size'=>60,'maxlength'=>200,'class'=>'form-control')); ?>
	</div>

	

	<div class="col-sm-4">
            <span>OPD Consultation Fees</span>
		<?php echo $form->textField($model,'opd_consultation_fee',array('class'=>'form-control')); ?>
	</div>

	
</div>
	
	<div class="row buttons text-center">
		<?php echo CHtml::submitButton('Search',array('class' => 'btn')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->