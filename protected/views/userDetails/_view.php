<?php
/* @var $this UserDetailsController */
/* @var $data UserDetails */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->user_id), array('view', 'id'=>$data->user_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('role_id')); ?>:</b>
	<?php echo CHtml::encode($data->role_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('profile_image')); ?>:</b>
	<?php echo CHtml::encode($data->profile_image); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('first_name')); ?>:</b>
	<?php echo CHtml::encode($data->first_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_name')); ?>:</b>
	<?php echo CHtml::encode($data->last_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gender')); ?>:</b>
	<?php echo CHtml::encode($data->gender); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('birth_date')); ?>:</b>
	<?php echo CHtml::encode($data->birth_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('age')); ?>:</b>
	<?php echo CHtml::encode($data->age); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('blood_group')); ?>:</b>
	<?php echo CHtml::encode($data->blood_group); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mobile')); ?>:</b>
	<?php echo CHtml::encode($data->mobile); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('password')); ?>:</b>
	<?php echo CHtml::encode($data->password); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('apt_contact_no_1')); ?>:</b>
	<?php echo CHtml::encode($data->apt_contact_no_1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('apt_contact_no_2')); ?>:</b>
	<?php echo CHtml::encode($data->apt_contact_no_2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email_1')); ?>:</b>
	<?php echo CHtml::encode($data->email_1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email_2')); ?>:</b>
	<?php echo CHtml::encode($data->email_2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('country_id')); ?>:</b>
	<?php echo CHtml::encode($data->country_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('state_id')); ?>:</b>
	<?php echo CHtml::encode($data->state_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('city_id')); ?>:</b>
	<?php echo CHtml::encode($data->city_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('area_id')); ?>:</b>
	<?php echo CHtml::encode($data->area_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pincode')); ?>:</b>
	<?php echo CHtml::encode($data->pincode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('country_name')); ?>:</b>
	<?php echo CHtml::encode($data->country_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('state_name')); ?>:</b>
	<?php echo CHtml::encode($data->state_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('city_name')); ?>:</b>
	<?php echo CHtml::encode($data->city_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('area_name')); ?>:</b>
	<?php echo CHtml::encode($data->area_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('experience')); ?>:</b>
	<?php echo CHtml::encode($data->experience); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('doctor_fees')); ?>:</b>
	<?php echo CHtml::encode($data->doctor_fees); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hospital_name')); ?>:</b>
	<?php echo CHtml::encode($data->hospital_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type_of_hospital')); ?>:</b>
	<?php echo CHtml::encode($data->type_of_hospital); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hospital_registration_no')); ?>:</b>
	<?php echo CHtml::encode($data->hospital_registration_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hos_establishment')); ?>:</b>
	<?php echo CHtml::encode($data->hos_establishment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hos_validity')); ?>:</b>
	<?php echo CHtml::encode($data->hos_validity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type_of_establishment')); ?>:</b>
	<?php echo CHtml::encode($data->type_of_establishment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_no_of_bed')); ?>:</b>
	<?php echo CHtml::encode($data->total_no_of_bed); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('emergency_no_1')); ?>:</b>
	<?php echo CHtml::encode($data->emergency_no_1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('emergency_no_2')); ?>:</b>
	<?php echo CHtml::encode($data->emergency_no_2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ambulance_no_1')); ?>:</b>
	<?php echo CHtml::encode($data->ambulance_no_1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ambulance_no_2')); ?>:</b>
	<?php echo CHtml::encode($data->ambulance_no_2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tollfree_no_1')); ?>:</b>
	<?php echo CHtml::encode($data->tollfree_no_1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tollfree_no_2')); ?>:</b>
	<?php echo CHtml::encode($data->tollfree_no_2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('landline_1')); ?>:</b>
	<?php echo CHtml::encode($data->landline_1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('landline_2')); ?>:</b>
	<?php echo CHtml::encode($data->landline_2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('take_home')); ?>:</b>
	<?php echo CHtml::encode($data->take_home); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('blood_bank_no')); ?>:</b>
	<?php echo CHtml::encode($data->blood_bank_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_type')); ?>:</b>
	<?php echo CHtml::encode($data->payment_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('longitude')); ?>:</b>
	<?php echo CHtml::encode($data->longitude); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('latitude')); ?>:</b>
	<?php echo CHtml::encode($data->latitude); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hospital_open_time')); ?>:</b>
	<?php echo CHtml::encode($data->hospital_open_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hospital_close_time')); ?>:</b>
	<?php echo CHtml::encode($data->hospital_close_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('coordinator_name_1')); ?>:</b>
	<?php echo CHtml::encode($data->coordinator_name_1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('coordinator_name_2')); ?>:</b>
	<?php echo CHtml::encode($data->coordinator_name_2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('coordinator_mobile_1')); ?>:</b>
	<?php echo CHtml::encode($data->coordinator_mobile_1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('coordinator_mobile_2')); ?>:</b>
	<?php echo CHtml::encode($data->coordinator_mobile_2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('coordinator_email_1')); ?>:</b>
	<?php echo CHtml::encode($data->coordinator_email_1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('coordinator_email_2')); ?>:</b>
	<?php echo CHtml::encode($data->coordinator_email_2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_date')); ?>:</b>
	<?php echo CHtml::encode($data->created_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_by')); ?>:</b>
	<?php echo CHtml::encode($data->created_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_date')); ?>:</b>
	<?php echo CHtml::encode($data->updated_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_by')); ?>:</b>
	<?php echo CHtml::encode($data->updated_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_active')); ?>:</b>
	<?php echo CHtml::encode($data->is_active); ?>
	<br />

	*/ ?>

</div>