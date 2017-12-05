<?php
/* @var $this DocumentDetailsController */
/* @var $model DocumentDetails */

$this->breadcrumbs=array(
	'Document Details'=>array('index'),
	$model->doc_id,
);

$this->menu=array(
	array('label'=>'List DocumentDetails', 'url'=>array('index')),
	array('label'=>'Create DocumentDetails', 'url'=>array('create')),
	array('label'=>'Update DocumentDetails', 'url'=>array('update', 'id'=>$model->doc_id)),
	array('label'=>'Delete DocumentDetails', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->doc_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DocumentDetails', 'url'=>array('admin')),
);
?>

<h1>View DocumentDetails #<?php echo $model->doc_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'doc_id',
		'user_id',
		'doc_type',
		'document',
	),
)); ?>
