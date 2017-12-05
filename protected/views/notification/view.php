<?php
/* @var $this NotificationController */
/* @var $model Notification */

$this->breadcrumbs=array(
	'Notifications'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Notification', 'url'=>array('index')),
	array('label'=>'Create Notification', 'url'=>array('create')),
	array('label'=>'Update Notification', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Notification', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Notification', 'url'=>array('admin')),
);
?>

<h1>View Notification #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'record_id',
		'module',
		'action',
		'operation',
		'notification',
		'viewed',
		'created_by',
		'created_date',
	),
)); ?>
