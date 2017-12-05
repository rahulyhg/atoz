<?php
/* @var $this PatientSecondopinionController */
/* @var $data PatientSecondopinion */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('opinion_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->opinion_id), array('view', 'id'=>$data->opinion_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('doctor_id')); ?>:</b>
	<?php echo CHtml::encode($data->doctor_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fullname')); ?>:</b>
	<?php echo CHtml::encode($data->fullname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mobile')); ?>:</b>
	<?php echo CHtml::encode($data->mobile); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('age')); ?>:</b>
	<?php echo CHtml::encode($data->age); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nature_of_visit')); ?>:</b>
	<?php echo CHtml::encode($data->nature_of_visit); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('docs')); ?>:</b>
	<?php echo CHtml::encode($data->docs); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('doctor_feedback')); ?>:</b>
	<?php echo CHtml::encode($data->doctor_feedback); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pay_amt')); ?>:</b>
	<?php echo CHtml::encode($data->pay_amt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_date')); ?>:</b>
	<?php echo CHtml::encode($data->created_date); ?>
	<br />

	*/ ?>

</div>