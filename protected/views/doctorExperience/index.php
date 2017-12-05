<?php
/* @var $this DoctorExperienceController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Doctor Experiences',
);

$this->menu=array(
	array('label'=>'Create DoctorExperience', 'url'=>array('create')),
	array('label'=>'Manage DoctorExperience', 'url'=>array('admin')),
);
?>

<h1>Doctor Experiences</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
