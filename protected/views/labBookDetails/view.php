<?php
/* @var $this LabBookDetailsController */
/* @var $model LabBookDetails */

$this->breadcrumbs=array(
	'Lab Book Details'=>array('index'),
	$model->book_id,
);

$this->menu=array(
	array('label'=>'List LabBookDetails', 'url'=>array('index')),
	array('label'=>'Create LabBookDetails', 'url'=>array('create')),
	array('label'=>'Update LabBookDetails', 'url'=>array('update', 'id'=>$model->book_id)),
	array('label'=>'Delete LabBookDetails', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->book_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LabBookDetails', 'url'=>array('admin')),
);
?>

<h1>View LabBookDetails #<?php echo $model->book_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'book_id',
		'patient_id',
		'role_id',
		'center_id',
		'relation',
		'full_name',
		'mobile_no',
		'patient_age',
		'service_name',
		'discription_doc',
		'collect_home',
		'pincode',
		'country_id',
		'country_name',
		'city_id',
		'city_name',
		'area_id',
		'area_name',
		'landmark',
		'address',
		'created_date',
		'updated_date',
	),
)); ?>
