<?php
/* @var $this CityMasterController */
/* @var $data CityMaster */
?>

<div class="view">

	

	<b><?php echo CHtml::encode($data->getAttributeLabel('state_name')); ?>:</b>
	<?php echo CHtml::encode($data->state_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('country_name')); ?>:</b>
	<?php echo CHtml::encode($data->country_id); ?>
	<br />


</div>