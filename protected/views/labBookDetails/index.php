<?php
/* @var $this LabBookDetailsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Lab Book Details',
);

$this->menu=array(
	array('label'=>'Create LabBookDetails', 'url'=>array('create')),
	array('label'=>'Manage LabBookDetails', 'url'=>array('admin')),
);
?>

<h1>Lab Book Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
