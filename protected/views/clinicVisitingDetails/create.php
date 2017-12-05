<?php
/* @var $this ClinicVisitingDetailsController */
/* @var $model ClinicVisitingDetails */

$this->breadcrumbs=array(
	'Clinic Visiting Details'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ClinicVisitingDetails', 'url'=>array('index')),
	array('label'=>'Manage ClinicVisitingDetails', 'url'=>array('admin')),
);
?>

<h1>Create ClinicVisitingDetails</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>