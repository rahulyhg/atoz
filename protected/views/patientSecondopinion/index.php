<?php
/* @var $this PatientSecondopinionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Patient Secondopinions',
);

$this->menu=array(
	array('label'=>'Create PatientSecondopinion', 'url'=>array('create')),
	array('label'=>'Manage PatientSecondopinion', 'url'=>array('admin')),
);
?>

<h1>Patient Secondopinions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
