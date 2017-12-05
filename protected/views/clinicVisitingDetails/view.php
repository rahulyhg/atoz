<?php
/* @var $this ClinicVisitingDetailsController */
/* @var $model ClinicVisitingDetails */

$this->breadcrumbs=array(
	'Clinic Visiting Details'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ClinicVisitingDetails', 'url'=>array('index')),
	array('label'=>'Create ClinicVisitingDetails', 'url'=>array('create')),
	array('label'=>'Update ClinicVisitingDetails', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ClinicVisitingDetails', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ClinicVisitingDetails', 'url'=>array('admin')),
);
?>

<h1>View ClinicVisitingDetails #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'clinic_id',
		'doctor_id',
		'day',
		'clinic_open_time',
		'clinic_close_time',
	),
)); ?>
