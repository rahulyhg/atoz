<?php
/* @var $this AreaMasterController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Area Masters',
);

$this->menu=array(
	array('label'=>'Create AreaMaster', 'url'=>array('create')),
	array('label'=>'Manage AreaMaster', 'url'=>array('admin')),
);
?>

<h1>Area Masters</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
