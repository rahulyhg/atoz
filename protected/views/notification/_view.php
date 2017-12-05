<?php
/* @var $this NotificationController */
/* @var $data Notification */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('record_id')); ?>:</b>
	<?php echo CHtml::encode($data->record_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('module')); ?>:</b>
	<?php echo CHtml::encode($data->module); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('action')); ?>:</b>
	<?php echo CHtml::encode($data->action); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('operation')); ?>:</b>
	<?php echo CHtml::encode($data->operation); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('notification')); ?>:</b>
	<?php echo CHtml::encode($data->notification); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('viewed')); ?>:</b>
	<?php echo CHtml::encode($data->viewed); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_by')); ?>:</b>
	<?php echo CHtml::encode($data->created_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_date')); ?>:</b>
	<?php echo CHtml::encode($data->created_date); ?>
	<br />

	*/ ?>

</div>