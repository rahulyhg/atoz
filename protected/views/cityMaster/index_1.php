<?php
/* @var $this CityMasterController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'City Masters',
);

$this->menu=array(
	array('label'=>'Create CityMaster', 'url'=>array('create')),
	array('label'=>'Manage CityMaster', 'url'=>array('admin')),
);
?>

<h1>City Masters</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
