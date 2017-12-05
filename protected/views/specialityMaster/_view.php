<?php
/* @var $this SpecialityMasterController */
/* @var $data SpecialityMaster */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('speciality_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->speciality_id), array('view', 'id'=>$data->speciality_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('speciality_name')); ?>:</b>
	<?php echo CHtml::encode($data->speciality_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('img_name')); ?>:</b>
	<?php echo CHtml::encode($data->img_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_active')); ?>:</b>
	<?php echo CHtml::encode($data->is_active); ?>
	<br />


</div>