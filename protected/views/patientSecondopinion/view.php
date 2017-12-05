<?php
/* @var $this PatientSecondopinionController */
/* @var $model PatientSecondopinion */

$this->breadcrumbs=array(
	'Patient Secondopinions'=>array('index'),
	$model->opinion_id,
);

$this->menu=array(
	array('label'=>'List PatientSecondopinion', 'url'=>array('index')),
	array('label'=>'Create PatientSecondopinion', 'url'=>array('create')),
	array('label'=>'Update PatientSecondopinion', 'url'=>array('update', 'id'=>$model->opinion_id)),
	array('label'=>'Delete PatientSecondopinion', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->opinion_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PatientSecondopinion', 'url'=>array('admin')),
);
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'opinion_id',
		'user_id',
		'doctor_id',
		'fullname',
		'mobile',
		'age',
		'nature_of_visit',
		'description',
		'docs',
		'doctor_feedback',
		'status',
		'pay_amt',
		'created_date',
	),
)); ?>
