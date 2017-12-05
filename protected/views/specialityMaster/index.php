<?php
/* @var $this SpecialityMasterController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Speciality Masters',
);

$this->menu=array(
	array('label'=>'Create SpecialityMaster', 'url'=>array('create')),
	array('label'=>'Manage SpecialityMaster', 'url'=>array('admin')),
);
?>

<h1>Speciality Masters</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
