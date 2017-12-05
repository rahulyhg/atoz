<?php
/* @var $this ClinicVisitingDetailsController */
/* @var $data ClinicVisitingDetails */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('clinic_id')); ?>:</b>
	<?php echo CHtml::encode($data->clinic_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('doctor_id')); ?>:</b>
	<?php echo CHtml::encode($data->doctor_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('day')); ?>:</b>
	<?php echo CHtml::encode($data->day); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('clinic_open_time')); ?>:</b>
	<?php echo CHtml::encode($data->clinic_open_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('clinic_close_time')); ?>:</b>
	<?php echo CHtml::encode($data->clinic_close_time); ?>
	<br />


</div>