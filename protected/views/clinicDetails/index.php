<?php
/* @var $this ClinicDetailsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Clinic Details',
);

$this->menu=array(
	array('label'=>'Create ClinicDetails', 'url'=>array('create')),
	array('label'=>'Manage ClinicDetails', 'url'=>array('admin')),
);
?>

<h1>Clinic Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
