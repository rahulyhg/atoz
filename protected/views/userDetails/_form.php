<?php
/* @var $this UserDetailsController */
/* @var $model UserDetails */
/* @var $form CActiveForm */
?>

<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/select2.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/multiple-select.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/bootstrap-datetimepicker.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jquery.timepicker.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/radio_style.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/moment-with-locales.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-datetimepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/select2.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/multiple-select.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.timepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.validate.min.js', CClientScript::POS_END);

Yii::app()->clientScript->registerScript('myjavascript', '
     $("#UserDetails_birth_date").datetimepicker({
                sideBySide: true,
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down"
                },
                stepping : 5,
              format:"DD-MM-YYYY",
              maxDate :new Date(),
            });
$("#UserDetails_birth_date").on("dp.change",function(e){
            var birth_date_str=$("#UserDetails_birth_date").data("DateTimePicker").date();
            var birth_date=new Date(birth_date_str);
            var birth_year=birth_date.getFullYear();
             var birth_month=birth_date.getMonth();
            var date=new Date();
            var current_year=date.getFullYear();
            var current_month=date.getMonth();
            var diffyear = current_year-birth_year;
           var diffmonth=current_month-birth_month;
           if(diffmonth<0)
            {
            diffyear=diffyear-1;
            diffmonth=12+diffmonth;
            }
           $(".age1").val(diffyear + " years, " + diffmonth + " month");
            console.log(diffyear + " years, " + diffmonth + " month");
            });', CClientScript::POS_END);

?>
<div class="">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-details-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
    'htmlOptions' => array('enctype' => 'multipart/form-data', "class" => "form-horizontal"),
  
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	
<div class="row">
 Enter ur Details
</div>
	<div class="row">
		<?php echo $form->labelEx($model,'profile_image'); ?>
		<?php echo $form->fileField($model,'profile_image'); ?>
		<?php echo $form->error($model,'profile_image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'first_name'); ?>
		<?php echo $form->textField($model,'first_name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'first_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'last_name'); ?>
		<?php echo $form->textField($model,'last_name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'last_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gender'); ?>
		<?php
            if (empty($model->gender)) {
                $model->gender = 'Male';
            }
            echo $form->radioButtonList($model, 'gender', array('Male' => 'Male', 'Female' => 'Female'), array('labelOptions' => array('style' => ''), 'separator' => '&nbsp;&nbsp;&nbsp;', 'template' => '<label class="ui-radio-inline">{input} <span>{label}</span></label>', 'container' => 'div class="ui-radio ui-radio-pink"'));
            ?>
		<?php echo $form->error($model,'gender'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'birth_date'); ?>
		<?php echo $form->textField($model,'birth_date', array( "data-format" => "dd-MM-yyyy")); ?>
		<?php echo $form->error($model,'birth_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'age'); ?>
		<?php echo $form->textField($model,'age',array('size'=>60,'maxlength'=>100,'class' => 'age1')); ?>
		<?php echo $form->error($model,'age'); ?>
	</div>

	<div class="col-sm-2">
		<?php echo $form->labelEx($model,'blood_group'); ?>
		<?php echo $form->dropDownList($model, 'blood_group', array('O+' => 'O+', 'O-' => 'O-', 'A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'AB+' => 'AB+', 'AB-' => 'AB-'), array('class' => 'otherselect form-control', 'prompt' => 'Select Blood Group')); ?>

		<?php echo $form->error($model,'blood_group'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mobile'); ?>
		<?php echo $form->textField($model,'mobile',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'mobile'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'apt_contact_no_1'); ?>
		<?php echo $form->textField($model,'apt_contact_no_1',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'apt_contact_no_1'); ?>
	</div>
        <button type="button" onclick="contact()">+</button>
        <div class="row contact_no_2 "hidden="">
		<?php echo $form->labelEx($model,'apt_contact_no_2'); ?>
		<?php echo $form->textField($model,'apt_contact_no_2',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'apt_contact_no_2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email_1'); ?>
		<?php echo $form->textField($model,'email_1',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'email_1'); ?>
	</div>
        <button type="button" onclick="email();">+</button>
	<div class="row email_2"hidden="">
		<?php echo $form->labelEx($model,'email_2'); ?>
		<?php echo $form->textField($model,'email_2',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'email_2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'country_id'); ?>
		
            <?php
            $country = CountryMaster::model()->findAll();
            $countrynameArr = CHtml::listData($country, 'country_id', 'country_name');
            echo $form->dropDownList($model, 'country_id', $countrynameArr, array('empty' => 'Select Country', 'class' => 'countryId otherselect form-control'));
            ?>
		<?php echo $form->error($model,'country_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'state_id'); ?>
		 <?php
            $stateArr = array();
            if (!empty($model->country_id)) {
                $state = StateMaster::model()->findAll(array("condition" => "country_id =  :country", "params" => array(":country" => $model->country_id), "order" => "state_name"));
                $stateArr = CHtml::listData($state, 'state_id', 'state_name');
            }
            echo $form->dropDownList($model, 'state_id', $stateArr, array('empty' => 'Select State', 'class' => 'stateId state-class otherselect form-control', 'onchange' => 'getCity()'));
            ?>
		<?php echo $form->error($model,'state_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'city_id'); ?>
		<?php
            $cityArr = array();
            if (!empty($model->state_id)) {
                $city = CityMaster::model()->findAll(array("condition" => "state_id =  :state", "params" => array(":state" => $model->state_id), "order" => "city_name"));
                $cityArr = CHtml::listData($city, 'city_id', 'city_name');
            }
            echo $form->dropDownList($model, 'city_id', $cityArr, array('empty' => 'Select City', 'class' => 'cityId city-class otherselect form-control','onchange' => 'getArea()'));
            ?>
		<?php echo $form->error($model,'city_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'area_id'); ?>
            <?php
            $areaArr = array();
           // if (!empty($model->city_id)) {
                $area = AreaMaster::model()->findAll(array("condition" => "city_id =  :city", "params" => array(":city" => $model->city_id), "order" => "area_name"));
               
                $areaArr = CHtml::listData($area, 'area_id', 'area_name');
               
          ///  }
		echo $form->dropDownList($model, 'area_id', $areaArr, array('empty' => 'Select Area','class' => 'areaId area-class otherselect form-control','onchange' => 'getAreaid()')); ?>
		<?php echo $form->error($model,'area_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pincode'); ?>
		<?php echo $form->textField($model,'pincode',array('class'=>'pincode-id-class') );  ?>
		<?php echo $form->error($model,'pincode'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'country_name'); ?>
		<?php echo $form->textField($model,'country_name',array('size'=>60,'maxlength'=>80,'class'=>'country-id-class')); ?>
		<?php echo $form->error($model,'country_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'state_name'); ?>
		<?php echo $form->textField($model,'state_name',array('size'=>60,'maxlength'=>80,'class'=>'state-id-class')); ?>
		<?php echo $form->error($model,'state_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'city_name'); ?>
		<?php echo $form->textField($model,'city_name',array('size'=>60,'maxlength'=>80 ,'class'=>'city-id-class')); ?>
		<?php echo $form->error($model,'city_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'area_name'); ?>
		<?php echo $form->textField($model,'area_name',array('size'=>60,'maxlength'=>100,'class'=>'area-id-class')); ?>
		<?php echo $form->error($model,'area_name'); ?>
        </div>
            <div class="row">
		<?php echo $form->labelEx($model,'doctor_registration_no'); ?>
		<?php echo $form->textField($model,'doctor_registration_no',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'doctor_registration_no'); ?>
            </div>
            
            
            
             <div class="row">
            <?php echo $form->labelEx($model, 'speciality', array("class" => "col-sm-2 control-label")); ?>

            <?php
            $speciality = SpecialityMaster::model()->findAll();
            $specialitynameArr = CHtml::listData($speciality, 'speciality_id', 'speciality_name');
            print_r($specialitynameArr);
            ?>
            <select class="form-control servicename" name="speciality" >
                <?php foreach ($specialitynameArr as $key => $value) {
                    ?>
                    <option value='<?php echo $key; ?>'> <?php echo $value; ?></option>
                <?php }
                ?>
            </select>
           
            <?php echo $form->error($model, 'speciality'); ?>
        </div>
            
            
            
        <div hidden="">
	<div class="row">
		<?php echo $form->labelEx($model,'experience'); ?>
		<?php echo $form->textField($model,'experience'); ?>
		<?php echo $form->error($model,'experience'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'doctor_fees'); ?>
		<?php echo $form->textField($model,'doctor_fees'); ?>
		<?php echo $form->error($model,'doctor_fees'); ?>
	</div>

	
	
	

	<div class="row">
		<?php echo $form->labelEx($model,'payment_type'); ?>
		<?php echo $form->textField($model,'payment_type',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'payment_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'longitude'); ?>
		<?php echo $form->textField($model,'longitude',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'longitude'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'latitude'); ?>
		<?php echo $form->textField($model,'latitude',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'latitude'); ?>
	</div>

	

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	

	
	<div class="row">
		<?php echo $form->labelEx($model,'created_date'); ?>
		<?php echo $form->textField($model,'created_date'); ?>
		<?php echo $form->error($model,'created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by'); ?>
		<?php echo $form->error($model,'created_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updated_date'); ?>
		<?php echo $form->textField($model,'updated_date'); ?>
		<?php echo $form->error($model,'updated_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updated_by'); ?>
		<?php echo $form->textField($model,'updated_by'); ?>
		<?php echo $form->error($model,'updated_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_active'); ?>
		<?php echo $form->textField($model,'is_active'); ?>
		<?php echo $form->error($model,'is_active'); ?>
	</div>
        </div>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Create');
              //  echo CHtml::submitButton("Save", array('class' => 'btn', 'name' => 'files', 'title' => 'Save the updates to these files'));
                ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.validate.min.js"></script>

<script type="text/javascript">
  var pinarray = [];
   $(function () {
        
   // $('.contact_no_2').hide();
    $(".countryId").change(function () {
            var country = 1;
          // alert(country);
            var country1 ="india";
            $(".country-id-class").val(country1);
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                cache: false,
                url: '<?php echo Yii::app()->createUrl("UserDetails/getStateName"); ?> ',
                data: {country: country},
                success: function (data) {

                    var dataobj = data.data;
                    
                    var statename = "<option value=''>Select State</option>";
                    $.each(dataobj, function (key, value) {
                       
                        statename += "<option value='" + value.state_id + "'>" + value.state_name + "</option>";
                    });
                    $(".stateId").html(statename);
                }
            });
        });
    
    });
function contact() {
    $('.contact_no_2').show();
}
function email() {
    $('.email_2').show();
}
 function getCity()
    {
        var state = $('.state-class option:selected').val();
        var state1 = $('.state-class option:selected').text();
        $(".state-id-class").val(state1);
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            cache: false,
            url: '<?php echo Yii::app()->createUrl("UserDetails/getCityName"); ?> ',
            data: {state: state},
            success: function (data) {
                var dataobj = data.data;
                
                var cityname = "<option value=''>Select City</option>";
                $.each(dataobj, function (key, value) {
                   
                    cityname += "<option value='" + value.city_id + "'>" + value.city_name + "</option>";
                });
                $(".cityId").html(cityname);
            }
        });
    }
  //  var pinarray =[];
    function getAreaid() {
        var area1 = $('.area-class option:selected').val();
        var area = $('.area-class option:selected').text();
      //  alert(area1);
        $(".area-id-class").val(area);
        var pincode=pinarray[area1];
      //  alert(pincode);
        $(".pincode-id-class").val(pincode);
    }
    
     function getArea()
    {
        var area = $('.city-class option:selected').val();
        var area1 = $('.city-class option:selected').text();
    //   var pinarray=[];
        $(".city-id-class").val(area1);
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            cache: false,
            url: '<?php echo Yii::app()->createUrl("UserDetails/getAreaName"); ?> ',
            data: {area: area},
            success: function (data) {
                var dataobj = data.data;
                
                var areaname = "<option value=''>Select Area</option>";
                $.each(dataobj, function (key, value) {
                  // var pincode=value.pincode;
                //  alert(pincode);
                  pinarray[value.area_id]=value.pincode;
                    areaname += "<option value='" + value.area_id + "'>" + value.area_name + "</option>";
                });
                $(".areaId").html(areaname);
              //  alert(areaname);
              //  alert(pinarray);
            }
        });
    }
 </script>