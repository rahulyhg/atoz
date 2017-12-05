<?php
/* @var $this DocumentDetailsController */
/* @var $data DocumentDetails */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('doc_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->doc_id), array('view', 'id'=>$data->doc_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('doc_type')); ?>:</b>
	<?php echo CHtml::encode($data->doc_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('document')); ?>:</b>
	<?php echo CHtml::encode($data->document); ?>
	<br />


</div>