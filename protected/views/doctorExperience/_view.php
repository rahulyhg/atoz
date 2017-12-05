<?php
/* @var $this DoctorExperienceController */
/* @var $data DoctorExperience */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('doctor_id')); ?>:</b>
	<?php echo CHtml::encode($data->doctor_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('work_from')); ?>:</b>
	<?php echo CHtml::encode($data->work_from); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('work_to')); ?>:</b>
	<?php echo CHtml::encode($data->work_to); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('doctor_role')); ?>:</b>
	<?php echo CHtml::encode($data->doctor_role); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('city_id')); ?>:</b>
	<?php echo CHtml::encode($data->city_id); ?>
	<br />


</div>