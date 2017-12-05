<?php
/* @var $this DocumentDetailsController */
/* @var $model DocumentDetails */

$this->breadcrumbs=array(
	'Document Details'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List DocumentDetails', 'url'=>array('index')),
	array('label'=>'Manage DocumentDetails', 'url'=>array('admin')),
);
?>

<h1>Create DocumentDetails</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>