<?php
/* @var $this DegreeMasterController */
/* @var $data DegreeMaster */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('degree_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->degree_id), array('view', 'id'=>$data->degree_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('degree_name')); ?>:</b>
	<?php echo CHtml::encode($data->degree_name); ?>
	<br />


</div>