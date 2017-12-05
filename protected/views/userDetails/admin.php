<?php
/* @var $this UserDetailsController */
/* @var $model UserDetails */

$this->breadcrumbs=array(
	'User Details'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List UserDetails', 'url'=>array('index')),
	array('label'=>'Create UserDetails', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-details-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage User Details</h1>

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
	'id'=>'user-details-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'user_id',
		'role_id',
		'profile_image',
		'first_name',
		'last_name',
		'gender',
		/*
		'birth_date',
		'age',
		'blood_group',
		'mobile',
		'password',
		'apt_contact_no_1',
		'apt_contact_no_2',
		'email_1',
		'email_2',
		'country_id',
		'state_id',
		'city_id',
		'area_id',
		'pincode',
		'country_name',
		'state_name',
		'city_name',
		'area_name',
		'experience',
		'doctor_fees',
		'hospital_name',
		'type_of_hospital',
		'hospital_registration_no',
		'hos_establishment',
		'hos_validity',
		'type_of_establishment',
		'total_no_of_bed',
		'emergency_no_1',
		'emergency_no_2',
		'ambulance_no_1',
		'ambulance_no_2',
		'tollfree_no_1',
		'tollfree_no_2',
		'landline_1',
		'landline_2',
		'take_home',
		'blood_bank_no',
		'payment_type',
		'longitude',
		'latitude',
		'hospital_open_time',
		'hospital_close_time',
		'description',
		'coordinator_name_1',
		'coordinator_name_2',
		'coordinator_mobile_1',
		'coordinator_mobile_2',
		'coordinator_email_1',
		'coordinator_email_2',
		'created_date',
		'created_by',
		'updated_date',
		'updated_by',
		'is_active',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
