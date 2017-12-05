<?php
/* @var $this ClinicDetailsController */
/* @var $model ClinicDetails */

$this->breadcrumbs=array(
	'Clinic Details'=>array('index'),
	$model->clinic_id,
);

$this->menu=array(
	array('label'=>'List ClinicDetails', 'url'=>array('index')),
	array('label'=>'Create ClinicDetails', 'url'=>array('create')),
	array('label'=>'Update ClinicDetails', 'url'=>array('update', 'id'=>$model->clinic_id)),
	array('label'=>'Delete ClinicDetails', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->clinic_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ClinicDetails', 'url'=>array('admin')),
);
?>

<h1>View ClinicDetails #<?php echo $model->clinic_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'clinic_id',
		'doctor_id',
		'clinic_name',
		'register_no',
		'opd_consultation_fee',
		'opd_consultation_discount',
		'free_opd_perday',
		'free_opd_preferdays',
	),
)); ?>
