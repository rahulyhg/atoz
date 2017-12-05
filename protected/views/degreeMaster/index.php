<?php
/* @var $this DegreeMasterController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Degree Masters',
);

$this->menu=array(
	array('label'=>'Create DegreeMaster', 'url'=>array('create')),
	array('label'=>'Manage DegreeMaster', 'url'=>array('admin')),
);
?>

<h1>Degree Masters</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
