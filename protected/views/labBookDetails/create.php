<?php
/* @var $this LabBookDetailsController */
/* @var $model LabBookDetails */

$this->breadcrumbs=array(
	'Lab Book Details'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LabBookDetails', 'url'=>array('index')),
	array('label'=>'Manage LabBookDetails', 'url'=>array('admin')),
);
?>

<h1>Create LabBookDetails</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>