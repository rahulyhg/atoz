<?php
/* @var $this ClinicDetailsController */
/* @var $model ClinicDetails */

$this->breadcrumbs=array(
	'Clinic Details'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ClinicDetails', 'url'=>array('index')),
	array('label'=>'Manage ClinicDetails', 'url'=>array('admin')),
);
?>

<h1>Create ClinicDetails</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>