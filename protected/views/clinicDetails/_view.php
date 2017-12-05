<?php
/* @var $this ClinicDetailsController */
/* @var $data ClinicDetails */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('clinic_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->clinic_id), array('view', 'id'=>$data->clinic_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('doctor_id')); ?>:</b>
	<?php echo CHtml::encode($data->doctor_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('clinic_name')); ?>:</b>
	<?php echo CHtml::encode($data->clinic_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('register_no')); ?>:</b>
	<?php echo CHtml::encode($data->register_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('opd_consultation_fee')); ?>:</b>
	<?php echo CHtml::encode($data->opd_consultation_fee); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('opd_consultation_discount')); ?>:</b>
	<?php echo CHtml::encode($data->opd_consultation_discount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('free_opd_perday')); ?>:</b>
	<?php echo CHtml::encode($data->free_opd_perday); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('free_opd_preferdays')); ?>:</b>
	<?php echo CHtml::encode($data->free_opd_preferdays); ?>
	<br />

	*/ ?>

</div>