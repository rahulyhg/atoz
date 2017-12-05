<?php
/* @var $this AreaMasterController */
/* @var $data AreaMaster */
?>

<div class="view">

	

	<b><?php echo CHtml::encode($data->getAttributeLabel('area_name')); ?>:</b>
	<?php echo CHtml::encode($data->area_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pincode')); ?>:</b>
	<?php echo CHtml::encode($data->pincode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('city_name')); ?>:</b>
	<?php echo CHtml::encode($data->city_id); ?>
	<br />


</div>