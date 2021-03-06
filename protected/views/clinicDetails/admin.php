<?php
/* @var $this ClinicDetailsController */
/* @var $model ClinicDetails */

$this->breadcrumbs=array(
	'Clinic Details'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ClinicDetails', 'url'=>array('index')),
	array('label'=>'Create ClinicDetails', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#clinic-details-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Clinic Details</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'clinic-details-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'clinic_id',
		'doctor_id',
		'clinic_name',
		'register_no',
		'opd_consultation_fee',
		'opd_consultation_discount',
		/*
		'free_opd_perday',
		'free_opd_preferdays',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
