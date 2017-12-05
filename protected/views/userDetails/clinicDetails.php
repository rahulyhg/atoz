<!--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyA1vr2RVgKBydJQhSo1LUsP3pUcKh4IFGI"></script>-->
<?php
/* @var $this ClinicDetailsController */
/* @var $model ClinicDetails */
/* @var $form CActiveForm */


Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/select2.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/main.css');
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
$model2->latitude = !empty($model2->latitude) ? $model2->latitude : 18.5204303;
$model2->longitude = !empty($model2->longitude) ? $model2->longitude : 73.8567437;
Yii::app()->clientScript->registerScript('myjavascript', '
      $(".multipleselect").multipleSelect({
            filter: true,
            multiple: true,
            placeholder: "Select service",
            width: "100%",
            multipleWidth: 500
        });
         $(".multipleselect3").multipleSelect({
            filter: true,
            multiple: true,
            placeholder: "Select payment type",
            width: "100%",
            multipleWidth: 500
        });
        $(".multipleselect4").multipleSelect({
            filter: true,
            multiple: true,
            placeholder: "Select Days",
            width: "100%",
            multipleWidth: 500
        });
        
          
  $(".clinictime").datetimepicker({
                    format: "LT"
                });
$(".pincode-id-class").blur(function(){
        var pincode = $(this).val();
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            cache: false,
            url: "' . Yii::app()->createUrl("UserDetails/getPincodeData") . '",
            data: {pincode: pincode},
            success: function (result) {
                var citydata = result.citydata;
                $(".cityId").html(citydata);
                var areadata = result.areadata;
                $(".areaId").html(areadata);
                $(".state-class").val(result.stateid);
                //$(".state-id-class").val(result.stateid);
                $(".area-id-class").val(result.areaname);
                $(".city-id-class").val(result.cityname);
                
                var state1 = $(".state-class option:selected").text();
                $(".state-id-class").val(state1);
            }
        });
        })
        
        function initialize() {
        
        var lattitude =  ' . $model2->latitude . ';
        var longitutde = ' . $model2->longitude . ' ;
        var myLatLng = new google.maps.LatLng(lattitude, longitutde);
        var mapOptions = {
            zoom: 12,
            center: myLatLng,
            // This is where you would paste any style found on Snazzy Maps.
            styles: [{featureType:"landscape",stylers:[{saturation:-100},{lightness:65},{visibility:"on"}]},{featureType:"poi",stylers:[{saturation:-100},{lightness:51},{visibility:"simplified"}]},{featureType:"road.highway",stylers:[{saturation:-100},{visibility:"simplified"}]},{featureType:"road.arterial",stylers:[{saturation:-100},{lightness:30},{visibility:"on"}]},{featureType:"road.local",stylers:[{saturation:-100},{lightness:40},{visibility:"on"}]},{featureType:"transit",stylers:[{saturation:-100},{visibility:"simplified"}]},{featureType:"administrative.province",stylers:[{visibility:"off"}]},{featureType:"administrative.locality",stylers:[{visibility:"off"}]},{featureType:"administrative.neighborhood",stylers:[{visibility:"on"}]},{featureType:"water",elementType:"labels",stylers:[{visibility:"off"},{lightness:-25},{saturation:-100}]},{featureType:"water",elementType:"geometry",stylers:[{hue:"#ffff00"},{lightness:-25},{saturation:-97}]}],

            // Extra options
            mapTypeControl: false,
            panControl: false,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.SMALL,
                position: google.maps.ControlPosition.LEFT_BOTTOM
            }
        };
        var map = new google.maps.Map(document.getElementById("p-map"), mapOptions);
        var image = "' . Yii::app()->baseUrl . '/images/marker-1.png";

        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            draggable: true,
            icon: image
        });
        if (jQuery("#ClinicDetails_address").length > 0) {
        
            var input = document.getElementById("ClinicDetails_address");
            var autocomplete = new google.maps.places.Autocomplete(input);
            console.log("hiii");
            google.maps.event.addListener(autocomplete, "place_changed", function () {
                var place = autocomplete.getPlace();
                jQuery("#ClinicDetails_latitude").val(place.geometry.location.lat());
                jQuery("#ClinicDetails_longitude").val(place.geometry.location.lng());
                marker.setPosition(place.geometry.location);
                map.setCenter(place.geometry.location);
                map.setZoom(15);
            });
        }
        google.maps.event.addListener(marker, "dragend", function (event) {
            jQuery("#ClinicDetails_latitude").val(event.latLng.lat());
            jQuery("#ClinicDetails_longitude").val(event.latLng.lng());
        });
    }
    google.maps.event.addDomListener(window, "load", initialize);

       ', CClientScript::POS_END);
?>
<section id="intro" class="section-details">
<div class="overlay">
    <div  class="container">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'clinic-details-form',
            'htmlOptions' => array('enctype' => 'multipart/form-data', "class" => "w3-container"),
            'enableAjaxValidation' => false,
        ));
        ?>

        <div class="row">  
            <?php
                    $enc_key = Yii::app()->params->enc_key;
                    $baseUrl = Yii::app()->baseUrl;
                    $path = $baseUrl . "/uploads/" . $model->profile_image;
                    if (empty($model->profile_image)) {
                        $path = $baseUrl . "/images/icons/icon01.png";
                    }
                    ?>
            <div class="col-md-3" style="background-image:url(<?= $baseUrl; ?>/images/icon46.png);height: 1105px;background-size: 100% auto;background-position: center center;">
                <div class="fileinput fileinput-new" data-provides="fileinput" style="position: relative;">
                    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="background: transparent;width:140px;height:140px;text-align: center; margin: auto;border-radius: 50%;overflow: hidden;">
                         <img src="<?php echo $path; ?>" class="img-circle img-responsive" style="margin-bottom:15px">
                    </div>
                    <span class=" btn-file" style="position: absolute;top: 60%;right: 20px;border: 1px solid #888;    padding: 3px 8px;">
                                <span class="fileinput-new">Edit</span>
                                <?php
                                echo $form->fileField($model, 'profile_image', array("class" => ""));
                                echo $form->error($model, 'profile_image');
                                ?>
                            </span>
                </div>
                <ul class="nav nav-pills nav-stacked "  id="myTabs">

                    <li class="active"><a href="#tab_a" data-toggle="pill">Personal Details &nbsp; <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                        </a></li>
                    <li><a href="#tab_b" data-toggle="pill">Clinics </a></li>
                    <li><a href="#tab_c" data-toggle="pill">Upload Documents </a></li>                                  
                </ul>
            </div>
            <div class="tab-content col-md-9">   
                <h3 class="center title">Clinic Details </h3>
                     <div class="underline"></div>   
                <div class="textdetails">
                    <div class="col-md-10">
                        <span>Clinic Name</span>
                        <?php
                        if (isset($session['clinic_name'])) {
                            $model2->clinic_name = $session['clinic_name'];
                        }
                        echo $form->textField($model2, 'clinic_name', array('size' => 60, 'maxlength' => 200, "data-rule-required" => "true", "data-msg-required" => "Please enter Clinic Name"));
                        echo $form->error($model2, 'clinic_name');
                        ?>
                    </div>                                                	
                </div>

                <div class="clearfix"></div>
                <div class="textdetails">
                    <div class="col-md-3">
                        <span>Services</span>
                        <?php
                        $serviceArr = array();
                        $selected = array();
                        $serviceType = Yii::app()->db->createCommand()->select("service_id,service_name")->from("az_service_master")->queryAll();
                        foreach ($serviceType as $row) {
                            $serviceArr[$row['service_id']] = $row['service_name'];
                        }
                        echo $form->dropDownList($model4, 'service_id[]', $serviceArr, array("class" => "w3-input serviceoption", "style" => "width:100%;", "prompt" => "Select Services", "data-rule-required" => "true", "data-msg-required" => "Please Select Services"));
                        ?>   
                    </div>   

                    <div class="col-md-2">
                        <span>Discount %</span>
                        <?php
                        if (isset($session['service_discount'])) {
                            $model4->service_discount = $session['service_discount'];
                        }
                        echo $form->textField($model4, 'service_discount[]', array("class" => "w3-input input-group"));
                        echo $form->error($model4, 'service_discount');
                        ?> 
                    </div>
                    <div class="col-md-3">
                        <span>Corporate Discount %</span>
                        <?php
                        if (isset($session['corporate_discount'])) {
                            $model4->corporate_discount = $session['corporate_discount'];
                        }
                        echo $form->textField($model4, 'corporate_discount[]', array("class" => "w3-input input-group"));
                        echo $form->error($model4, 'corporate_discount');
                        ?> 
                    </div>
                    <div class="col-md-2">
                        <span>24x7</span>
                        <?php
                        if (isset($session['twentyfour'])) {
                            $model4->is_available_allday = $session['twentyfour'];
                        }
                        echo $form->dropDownList($model4, 'twentyfour[]', array("Yes" => "Yes", "No" => "No"), array("class" => "w3-input input-group"));
                        echo $form->error($model4, 'twentyfour');
                        ?> 
                    </div>
                   
                    <div class="clearfix">&nbsp;</div>
                    <div class="col-md-12 btnaddservice">
                        <a class="" href="javascript:" onclick="addMoreServices(this);"><i class="fa fa-plus" aria-hidden="true"></i> Add </a>
                    </div>
                </div>
                <div class="clearfix"></div>
                <!-- Timing start here -->
                <div class="textdetails">
                    <h4 class="title-details">Timings</h4>
                    <div class="col-md-12" style=""> 
                         <label><input  type="checkbox" name="ClinicDetails[alldayopen]" value="Y" onclick="isalldayopen(this)" class="isall"> Clinic open 24x7</label>
                    </div>
                    <div class="col-md-12 day" style="">
                        <ul class="list-inline">
                            <li id="mon" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="mon"> Monday</li>
                            <li id="tue" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="tue"> Tuesday</li>
                            <li id="wed" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="wed"> Wednesday</li>
                            <li id="thur" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="thur"> Thursday</li>
                            <li id="fri" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="fri"> Friday</li>
                            <li id="sat" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="sat"> Saturday</li>
                            <li id="sun" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="sun"> Sunday</li>
                        </ul>

                    </div>

                    
                </div>
                <!-- Timing end here -->
                				<div class="textdetails">
				 <h4 class="title-details">Location</h4>
					<div class="col-md-4">
						<span>Zip Code</span>
						<?php
						if (isset($session['pincode'])) {
							$model->pincode = $session['pincode'];
						}
						echo $form->textField($model2, 'pincode', array("class" => "w3-input input-group pincode-id-class"));
						echo $form->error($model2, 'pincode');
						?>
					</div>  
					<div class="col-md-4">
						<span>State</span>
						<?php
						$stateArr = array();
						$selected = array();
						$stateType = Yii::app()->db->createCommand()->select("state_id,state_name")->from("az_state_master")->queryAll();
						foreach ($stateType as $row) {
							$stateArr[$row['state_id']] = $row['state_name'];
						}
						if (isset($session['state_id'])) {
							$model2->state_id = $session['state_id'];
						}
						echo $form->dropDownList($model2, 'state_id', $stateArr, array("class" => "w3-input state-class", "style" => "width:100%;", "prompt" => "Select State", "data-rule-required" => "true", "data-msg-required" => "Please Select State", 'onchange' => 'getCity()'));
						echo $form->error($model2, 'state_id');
						if (isset($session['state_name'])) {
							$model2->state_name = $session['state_name'];
						}
						echo $form->hiddenField($model2, "state_name", array("class" => "state-id-class"));
						?>   

					</div>
					<div class="col-md-4">
						<span>City</span>
						<?php
						$cityArr = array();
						if(!empty($model2->state_id)){
							$citycmd = Yii::app()->db->createCommand()->select('city_id,city_name')->from('az_city_master')->where('state_id=:id', array(':id' => $model2->state_id))->queryAll();
							foreach($citycmd as $row) {
								$cityArr[$row['city_id']] = $row['city_name'];
							}
						}
						if (isset($session['city_id'])) {
							$model2->city_id = $session['city_id'];
						}
						echo $form->dropDownList($model2, 'city_id', $cityArr, array("class" => "w3-input cityId city-class", "style" => "width:100%;", "prompt" => "Select City", "data-rule-required" => "true", "data-msg-required" => "Please Select City", 'onchange' => 'getArea()'));
						echo $form->error($model2, 'city_id');
						if (isset($session['city_name'])) {
							$model2->city_name = $session['city_name'];
						}
						echo $form->hiddenField($model2, "city_name", array("class" => "city-id-class"));
						?>

					</div>
				</div>
				<div class="clearfix"></div>
				<div class="textdetails">

					<div class="col-md-4">
						<span>Area</span>
						<?php
						$areaArr = array();
						$selected = array();
						if(!empty($model2->city_id)){
							$stateType = Yii::app()->db->createCommand()->select("area_id,area_name")->from("az_area_master")->where('city_id=:id', array(':id' => $model2->city_id))->queryAll();
							foreach ($stateType as $row) {
								$areaArr[$row['area_id']] = $row['area_name'];
							}
						}
						if (isset($session['area_id'])) {
							$model2->area_id = $session['area_id'];
						}
						echo $form->dropDownList($model2, 'area_id', $areaArr, array("class" => "w3-input area-class areaId", "style" => "width:100%;", "prompt" => "Select Area", "data-rule-required" => "true", "data-msg-required" => "Please Select Area", 'onchange' => 'getAreaid()'));
						echo $form->error($model2, 'area_id');
						if (isset($session['area_name'])) {
							$model2->area_name = $session['area_name'];
						}
						echo $form->hiddenField($model2, "area_name", array("class" => "area-id-class"));
						?>   

					</div>
					<div class="col-md-4">
						<span>Landmark</span>
						<?php
						if (isset($session['landmark'])) {
							$model2->landmark = $session['landmark'];
						}
						echo $form->textField($model2, 'landmark', array("class" => "w3-input input-group"));
						echo $form->error($model2, 'landmark');
						?>

					</div>
<!--					<div class="col-md-4">
                        <span>Street Address</span>
                        <?php
//                        if (isset($session['address'])) {
//                            $model2->address = $session['c_address'];
//                        }
//                        echo $form->textField($model2, 'address', array("class" => "w3-input input-group", "data-rule-required" => "true", "data-msg-required" => "Please enter Address"));
//                        echo $form->error($model2, 'address');
                        ?>

                    </div>-->
					
				</div>
                
                
                <div class="clearfix"></div>
              


                <div class="col-md-4">
                    <span>Payment Modes</span>
                    <?php
                    // PAYMENT_TYPE is constant which contains array of payment type
                    $paymenttypeArr = explode(";", Constants:: PAYMENT_TYPE);
                    $paymenttypeFinalArr = array_combine($paymenttypeArr, $paymenttypeArr);
                    $selected = array("A2Z E-money"=> array('selected' => 'selected',"disabled" => true));
                    echo $form->dropDownList($model2, 'payment_type[]', $paymenttypeFinalArr, array("class" => "multipleselect3 form-control2", 'multiple' => 'multiple', "data-rule-required" => "true", "data-msg-required" => "Please Select Payent Type",'options' => $selected));

                    echo $form->error($model2, 'payment_type');
                    ?>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-10">
                    <div class="col-md-5"> 
                        <span>OPD Consultation Fees</span>
                        <?php echo $form->textField($model2, 'opd_consultation_fee', array("class" => "w3-input input-group", "data-rule-required" => "true", "data-msg-required" => "Please Consultation Fee"));
                        echo $form->error($model2, 'opd_consultation_fee');
                        ?>
                    </div>
                    <div class="col-md-5"> 
                        <span>Discount %</span>
                        <?php echo $form->textField($model2, 'opd_consultation_discount', array("class" => "w3-input input-group"));
                        echo $form->error($model2, 'opd_consultation_discount');
                        ?>
                    </div>
                </div>
                <div class="clearfix"></div>
                <h4 class="title-details">Free OPD</h4>
                <div class="col-md-10">
                    <div class="col-md-5"> 
                        <span>Per Day</span>
<?php echo $form->textField($model2, 'free_opd_perday', array("class" => "w3-input input-group"));
echo $form->error($model2, 'free_opd_perday');
?>
                    </div>
                    <div class="col-md-5"><span>Preferred Days</span>
                        <?php
                        // DAY_STR is constant which contains array of Days
                        $DayArr = explode(";", Constants:: DAY_STR);
                        $DayFinalArr = array_combine($DayArr, $DayArr);
                        echo $form->dropDownList($model2, 'free_opd_preferdays[]', $DayFinalArr, array("class" => "multipleselect4 form-control2", 'multiple' => 'multiple', "data-rule-required" => "true", "data-msg-required" => "Please Select Days"));

                        echo $form->error($model2, 'free_opd_preferdays');
                        ?>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group clearfix">
                                                <div class="col-sm-4">
                                                    <?php
                                                    echo $form->labelEx($model2, 'address');

                                                    echo $form->textField($model2, 'address', array("class" => "form-control input-group"));
                                                    echo $form->error($model2, 'address');
                                                    ?>
                                                </div>
                                                <div class="col-sm-4">
                                                    <?php
                                                    echo $form->labelEx($model2, 'Latitude');
                                                    echo $form->textField($model2, 'latitude', array("class" => "form-control input-group latitude"));
                                                    echo $form->error($model2, 'latitude');
                                                    ?>
                                                </div>
                                                <div class="col-sm-4">
                                                    <?php
                                                    echo $form->labelEx($model2, 'Longitude');

                                                    echo $form->textField($model2, 'longitude', array("class" => "form-control input-group longitude"));
                                                    echo $form->error($model2, 'longitude');
                                                    ?>
                                                </div>
                    <br><br><br><br>
                                                <div class="col-sm-12 clearfix">
                                                    <div id="p-map" style="height: 340px;width: 100%;border:1px solid #533223;"></div>
                                                </div>
                                            </div>
                
                
                
                
               
                <div class="center buttons">
                    <?php echo CHtml::submitButton("Create  ", array('class' => 'btn')); ?>
                   
                </div>

<?php $this->endWidget(); ?>

            </div>

        </div><!--         row-->
    </div>
</div>
    
    
    <div class="modal" id="myModal" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="uncheckday(this);">&times;</button>
                <h4 class="modal-title">Visit Details</h4>
            </div>
            <div class="modal-body">

                <div class="col-md-12">

                    <div class="col-md-6">

                        <div class="col-sm-2" style="z-index:2;position: relative">
                            <label>Morning</label>
                            <?php echo $form->textField($model6, 'clinic_open_time[]', array('class' => 'clinictime open_time ', "data-rule-required" => "true", "data-msg-required" => "Please enter time")); ?>
                            <label class='text-center'>TO</label>
                            <?php echo $form->textField($model6, 'clinic_close_time[]', array('class' => 'clinictime close_time ', "data-msg-required" => "Please enter time")); ?>
                        </div>
                    </div>


                    <div class="col-md-6">

                        <div class="col-sm-2" style="z-index:2;position: relative">
                            <label>Evening</label> 
                            <?php echo $form->textField($model6, 'clinic_eve_open_time[]', array('class' => 'clinictime eve_open_time ', "data-msg-required" => "Please enter time")); ?>
                            <label class='text-center'>TO</label>
                            <?php echo $form->textField($model6, 'clinic_eve_close_time[]', array('class' => 'clinictime eve_close_time ', "data-rule-required" => "true", "data-msg-required" => "Please enter time")); ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix" ></div>
                <div class="model-backdrop">&nbsp;</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="clinic_time()">save</button>
            </div>
        </div>
    </div>
</div>
    
</section>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.validate.min.js"></script>

<script type="text/javascript">
            var pinarray = [];
            var dayhtml;
            $(function () {
                // $('.contact_no_2').hide();
    $(".countryId").change(function () {
        var country = 1;

        var country1 = "india";
        $(".country-id-class").val(country1);
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            cache: false,
            url: '<?php echo Yii::app()->createUrl("ClinicDetails/getStateName"); ?> ',
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

        $('.day:checkbox').on('click', function (e) {
        if (e.target.checked) {
            dayhtml = $(this);

            var day = $('.day:checked').val();

            $('#myModal').modal({
                backdrop: 'static',
                keyboard: false
            });
        } else {
            $(this).closest('li').find('.timeing').remove();
            $(this).closest('li').find('span').remove();
        }

    });

         
    
    });                                               
                                                        
                                               
            function addMoreServices(htmlObj){
        var str = "";
        var serviceoption = $(".serviceoption:first").html();
        str += "<div class=\"servicename\"><div class=\"col-md-3\"><select class=\"w3-input serviceoption\" data-rule-required=\"true\" name=\"ServiceUserMapping[service_id][]\" style=\"width:100%;\">"+serviceoption+"</select></div>";
        str += "<div class=\"col-md-2\"><input class=\"w3-input input-group\" name=\"ServiceUserMapping[service_discount][]\" type=\"text\"></div>";
        str += "<div class=\"col-md-3\"><input class=\"w3-input input-group\" name=\"ServiceUserMapping[corporate_discount][]\" type=\"text\"></div>";
        str += "<div class=\"col-md-2\"><select class=\"w3-input serviceoption\" data-rule-required=\"true\" name=\"ServiceUserMapping[twentyfour][]\"  style=\"width:100%;\"><option value=\"Yes\">Yes</option><option value=\"No\">No</option></select></div>";
        str += "<i class='fa fa-times delete' aria-hidden='true'  onclick='remove_service_details(this)'></i><div class=\"clearfix\">&nbsp;</div></div>";
        $(htmlObj).parents(".btnaddservice").before(str);
       // console.log("tabid",$(htmlObj).parents(".btnaddservice").html(),str);
    }
    
    function remove_service_details(htmlobj)
    {

        $(htmlobj).parents('.servicename').remove();
    }                                            
                                                        
                                                        
                                                        
function clinic_time() {

    var open_time = $('.open_time').val();
    var close_time = $('.close_time').val();
    var eve_open_time = $('.eve_open_time').val();
    var eve_close_time = $('.eve_close_time').val();

    var hiddenhtml = "";
    hiddenhtml = "<span ><input type='hidden'  name='ClinicVisitingDetails[clinic_open_time][]' value='" + open_time + "' class='clinic_open_time'><input type='hidden'  name='ClinicVisitingDetails[clinic_close_time][]' value='" + close_time + "' class='clinic_close_time'><input type='hidden'  name='ClinicVisitingDetails[clinic_eve_open_time][]' value='" + eve_open_time + "' class='clinic_eve_open_time'><input type='hidden'  name='ClinicVisitingDetails[clinic_eve_close_time][]' value='" + eve_close_time + "' class='clinic_eve_close_time'></span><div class='timing-list timeing'>Mon:" + open_time + " - " + close_time + "<br>Evn:" + open_time + " - " + close_time + "</div>"

    $(dayhtml).closest(".weekday").find('.day').before(hiddenhtml);


}


function isalldayopen(htmlobj) {
    // var aa= $(".isall" ).attr( "checked" ) ;
    if ($(htmlobj).prop("checked")) {
        $(".day").attr("disabled", true);
        $(".day").attr("checked", false);
    } else {
        $(".day").attr("disabled", false);
    }

}


       // Specify the visiting time timepick for clone 
    function timepick(htmlobj)
    {
        $(".clinictime").timepicker({
            sideBySide: true,
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            },
            stepping: 5,
            format: "h:mm A",
        });
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
            url: '<?php echo Yii::app()->createUrl("ClinicDetails/getCityName"); ?> ',
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

    function getAreaid() {
        var area1 = $('.area-class option:selected').val();
        var area = $('.area-class option:selected').text();

        $(".area-id-class").val(area);
        var pincode = pinarray[area1];

        $(".pincode-id-class").val(pincode);
    }

    function getArea()
    {
        var area = $('.city-class option:selected').val();
        var area1 = $('.city-class option:selected').text();

        $(".city-id-class").val(area1);
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            cache: false,
            url: '<?php echo Yii::app()->createUrl("ClinicDetails/getAreaName"); ?> ',
            data: {area: area},
            success: function (data) {
                var dataobj = data.data;
                var areaname = "<option value=''>Select Area</option>";
                $.each(dataobj, function (key, value) {
                    pinarray[value.area_id] = value.pincode;
                    areaname += "<option value='" + value.area_id + "'>" + value.area_name + "</option>";
                });
                $(".areaId").html(areaname);

            }
        });
    }

    function uncheckday(obj)
    {

    var dayhtml = $(this);
    var day = $(dayhtml).find(".day:checked").val();
    $('input:checkbox[value="' + day + '"]').last().attr('checked', false);
    }




</script>