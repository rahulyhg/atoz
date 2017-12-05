<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyA1vr2RVgKBydJQhSo1LUsP3pUcKh4IFGI"></script>
<?php
/* @var $this ClinicDetailsController */
/* @var $model ClinicDetails */
/* @var $form CActiveForm */
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

$model->latitude = !empty($model->latitude) ? $model->latitude : 18.5204303;
$model->longitude = !empty($model->longitude) ? $model->longitude : 73.8567437;
Yii::app()->clientScript->registerScript('myjavascript', '
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
    
      $(".multipleselect").multipleSelect({
            filter: true,
            multiple: true,
            placeholder: "Select service",
            width: "100%",
            multipleWidth: 500
        });
           $(".multipleselect1").multipleSelect({
            filter: true,
            multiple: true,
            placeholder: "Select payment type",
            width: "100%",
            multipleWidth: 500
        });
        $(".multipleselect2").multipleSelect({
            filter: true,
            multiple: true,
            placeholder: "Select day",
            width: "100%",
            multipleWidth: 500
        });
        $(".clinictime").datetimepicker({
                    format: "LT"
                });
              
               function initialize() {
               
       var lattitude =  ' . $model->latitude . ';
       var longitutde = ' . $model->longitude . ' ;
        var myLatLng = new google.maps.LatLng(lattitude, longitutde);
        var mapOptions = {
            zoom: 12,
            center: myLatLng,

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
$enc_key = Yii::app()->params->enc_key;
?>


<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'clinic-details-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('enctype' => 'multipart/form-data', "class" => "w3-container"),
        ));
?>



<section class="content-header">

    <h3> Create Clinic </h3> 

</section>
<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row"><!-- row start-->
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                    <div class="box-header with-border"><!-- box header start -->
                        <div class="text-right"><!--link div-->

                            <?php echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> Manage Clinic', array('clinicDetails/adminClinic', 'id' => Yii::app()->getSecurityManager()->encrypt($id, $enc_key)), array("style" => "color: white;", 'class' => 'btn btn-info')); ?>
                        </div><!--link End-->    
                        
                            <div class="box-body">
                                <div class="col-md-12">
                                    <h4 class="box-title">Clinic Details </h4>
                                </div>
                                <div class="col-sm-4">
                                    <?php echo $form->labelEx($model, 'clinic_name'); ?> 
                                    <?php echo $form->textField($model, 'clinic_name', array('size' => 60, 'maxlength' => 200, "class" => "form-control")); ?>
                                    <?php echo $form->error($model, 'clinic_name'); ?>
                                </div>
                                <div class="col-sm-4">
                                    <?php echo $form->labelEx($model, 'register_no'); ?> 
                                    <?php echo $form->textField($model, 'register_no', array('size' => 60, 'maxlength' => 200, "class" => "form-control")); ?>
                                    <?php echo $form->error($model, 'register_no'); ?>
                                </div>

                                <div class="col-sm-4">

                                    <?php
                                    echo $form->labelEx($model, 'Clinic Certificate');
                                    echo $form->fileField($model, 'clinic_reg_certificate', array("class" => "w3-input input-group"));
                                    echo $form->error($model, 'clinic_reg_certificate');
                                    ?>
                                </div>   

                                <div class="clearfix" style="padding:15px"></div>
                                <div class="col-md-12">
                                    <h4 class="box-title">Payment Details</h4>
                                </div>          

                                <div class="col-sm-4">
                                    <?php
                                    echo $form->labelEx($model, 'Payment Modes');
                                    //echo "<pre>";print_r($doctorDegreeDetails);
                                    //DEGREE_STR is constant which contains array of degree

                                    $paymenttypeArr = explode(";", Constants::PAYMENT_TYPE);
                                    $paymenttypeFinalArr = array_combine($paymenttypeArr, $paymenttypeArr);

                                    echo $form->dropDownList($model, 'payment_type', $paymenttypeFinalArr, array("class" => " multipleselect1", "style" => "width:100%;", "multiple" => "multiple", "data-rule-required" => "true", "data-msg-required" => "Please Select Payment Type"));
                                    echo $form->error($model, 'payment_type');
                                    ?>


                                    <?php echo $form->error($model, 'payment_type'); ?>
                                </div>

                                <div class="col-sm-4">
                                    <?php echo $form->labelEx($model, 'OPD Consultation Fee'); ?>   

                                    <?php echo $form->textField($model, 'opd_consultation_fee', array('class' => 'form-control')); ?>
                                    <?php echo $form->error($model, 'opd_consultation_fee'); ?>
                                </div>
                                <div class="col-sm-4">
                                    <?php echo $form->labelEx($model, 'OPD Consultation Discount'); ?> 

                                    <?php echo $form->textField($model, 'opd_consultation_discount', array('class' => 'form-control')); ?>
                                    <?php echo $form->error($model, 'opd_consultation_discount'); ?>
                                </div>  

                                <div class="clearfix" style="padding:15px"></div>
                                <div class="col-md-12">
                                    <h4 class="box-title">OPD</h4>
                                </div>

                                <div class="col-sm-4">
                                    <?php echo $form->labelEx($model, 'Free OPD Preferdays'); ?> 

                                    <?php
                                    // DAY_STR is constant which contains array of Days
                                    $DayArr = explode(";", Constants:: DAY_STR);
                                    $DayFinalArr = array_combine($DayArr, $DayArr);
                                    echo $form->dropDownList($model, 'free_opd_preferdays[]', $DayFinalArr, array("class" => "multipleselect2 form-control2", 'multiple' => 'multiple', "data-rule-required" => "true", "data-msg-required" => "Please Select Days"));


                                    echo $form->error($model, 'free_opd_preferdays');
                                    ?>
                                </div>

                                <div class="col-sm-4">
                                    <?php echo $form->labelEx($model, 'Free OPD Perday'); ?> 

                                    <?php echo $form->textField($model, 'free_opd_perday', array("class" => "form-control")); ?>
                                    <?php echo $form->error($model, 'free_opd_perday'); ?>
                                </div>

                                <div class="clearfix" style="padding:15px"></div>
                                <div class="col-md-12">
                                    <h4 class="box-title">Service Information</h4>
                                </div>
                                <?php
                                $rindex = 0;
                                ?>
                                <div class=" form-group serviceclone clearfix" id="serviceclone">
                                    
                                    <?php
                                    $service = ServiceMaster::model()->findAll();
                                    $servicenameArr = CHtml::listData($service, 'service_id', 'service_name');
                                    ?>
                                    <div class="col-sm-3">
                                        <span>Service</span>
                                        <select class="form-control servicename" name="ClinicDetails[service][]" >
                                            <?php foreach ($servicenameArr as $servicekey => $value) {
                                                ?>

                                                <option value='<?php echo $servicekey; ?>'> <?php echo $value; ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                    <?php echo $form->error($model, 'service_id'); ?>
                                    
                                    <div class="col-sm-2  clearfix">
                                        <span>Discount</span>
                                        <input type="text" name="ClinicDetails[service_discount][]" value='' class="form-control">
                                        <?php echo $form->error($model, 'service_discount', array('class' => 'col-sm-1 control-label')); ?>
                                    </div>
                                    <div class="col-sm-2  clearfix">
                                        <span>Corporate Discount</span>
                                        <input type="text" name="ClinicDetails[corporate_discount][]" value='' class="form-control">
                                        <?php echo $form->error($model, 'corporate_discount', array('class' => 'col-sm-1 control-label')); ?>
                                    </div>
                                    
                                    <?php
                                    $isallday = array('Yes' => "Yes", 'No' => "No");
                                    ?> 
                                   
                                    <div class ="col-sm-2">
                                        
                                        <span>24X7</span>
                                        <select class="form-control twentyfour" name="ClinicDetails[twentyfour][]">
                                            <?php foreach ($isallday as $key => $value) { ?>
                                                <option value='<?php echo $key; ?>' > <?php echo $value; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-2 clearfix">
                                           <?php $dindex = 0; ?>
                                        <?php
                                        if ($rindex == 0) {
                                            echo CHtml::link('ADD', 'javascript:', array('class' => 'addservice'));
                                            $rindex++;
                                        } else {
                                            echo CHtml::link('X', 'javascript:', array('class' => 'removeservice'));
                                        }
                                        ?>
                                    </div>
                                </div>
                             
                                <div class="clearfix" style="padding:15px"></div>
                                <div class="form-group clearfix">
                                                <!-- Timing start here -->
                                                <div class="textdetails">
                                                    <b><span>Timing<strong class="mandatory">*</strong></span></b>
                                                    <div class="col-md-12" style=""> 
                                                        <b><label><input  type="checkbox" name="UserDetails[is_open_allday]" value="Y" onclick="isalldayopen(this)" class="isall"> 24x7</label></b>
                                                    </div>
                                                    <div class="col-md-12 day" style="">
                                                        <ul class="list-inline">
                                                            <li id="mon" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="Monday" data-rule-oneormorechecked="true" data-msg-oneormorechecked="Check one or more!"> Monday</li>
                                                            <li id="tue" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="Tuesday"> Tuesday</li>
                                                            <li id="wed" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="Wednesday"> Wednesday</li>
                                                            <li id="thur" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="Thursday"> Thursday</li>
                                                            <li id="fri" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="Friday"> Friday</li>
                                                            <li id="sat" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="Saturday"> Saturday</li>
                                                            <li id="sun" class="weekday"><input type="checkbox" class="day" name="ClinicVisitingDetails[day][]" value="Sunday"> Sunday</li>
                                                        </ul>

                                                    </div>


                                                    <div class="modal" id="myModal" role="dialog">
                                                        <div class="modal-dialog modal-md">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" onclick="uncheckday();">&times;</button>
                                                                    <h4 class="modal-title">Visit Details</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="col-md-12">
                                                                        <div class="col-md-6">
                                                                            <div class="col-sm-2" style="z-index:2;position: relative">
                                                                                <label>Morning</label>
                                                                                <input type="text" class="clinictime open_time">
                                                                                <label class='text-center'>TO</label>
                                                                                <input type="text" class="clinictime close_time">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="col-sm-2" style="z-index:2;position: relative">
                                                                                <label>Evening</label> 
                                                                                <input type="text" class="clinictime eve_open_time">
                                                                                <label class='text-center'>TO</label>
                                                                                <input type="text" class="clinictime eve_close_time">
                                                                            </div>
                                                                        </div>
                                                                        <div class="clearfix"></div>
                                                                    </div>

                                                                    <div class="clearfix"></div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="clinic_time()">save</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Timing end here -->

                                            </div>

                                <div class="clearfix" style="padding:15px"></div>
                                <div class="col-md-12">
                                    <h4 class="box-title">Location</h4>
                                </div>          
                             
                                
                                <div class="col-md-4">

                                    <?php
                                    echo $form->labelEx($model, 'Zip Code');
                                    if (isset($session['pincode'])) {
                                        $model->pincode = $session['pincode'];
                                    }
                                    echo $form->textField($model, 'pincode', array("class" => "form-control input-group pincode-id-class"));
                                    echo $form->error($model, 'pincode');
                                    ?>
                                </div>
                                <div class="col-md-4">

                                    <?php
                                    echo $form->labelEx($model, 'State');
                                    $stateArr = array();
                                    $selected = array();
                                    $stateType = Yii::app()->db->createCommand()->select("state_id,state_name")->from("az_state_master")->queryAll();
                                    foreach ($stateType as $row) {
                                        $stateArr[$row['state_id']] = $row['state_name'];
                                    }
                                    if (isset($session['state_id'])) {
                                        $model->state_id = $session['state_id'];
                                    }
                                    echo $form->dropDownList($model, 'state_id', $stateArr, array("class" => "form-control state-class", "style" => "width:100%;", "prompt" => "Select State", "data-rule-required" => "true", "data-msg-required" => "Please Select State", 'onchange' => 'getCity()'));
                                    echo $form->error($model, 'state_id');
                                    if (isset($session['state_name'])) {
                                        $model->state_name = $session['state_name'];
                                    }
                                    echo $form->hiddenField($model, "state_name", array("class" => "state-id-class"));
                                    ?>   

                                </div>
                                <div class="col-md-4">

                                    <?php
                                    echo $form->labelEx($model, 'City');
                                    $cityArr = array();
                                    if (!empty($model->state_id)) {
                                        $citycmd = Yii::app()->db->createCommand()->select('city_id,city_name')->from('az_city_master')->where('state_id=:id', array(':id' => $model->state_id))->queryAll();
                                        foreach ($citycmd as $row) {
                                            $cityArr[$row['city_id']] = $row['city_name'];
                                        }
                                    }
                                    if (isset($session['city_id'])) {
                                        $model->city_id = $session['city_id'];
                                    }
                                    echo $form->dropDownList($model, 'city_id', $cityArr, array("class" => "form-control cityId city-class", "style" => "width:100%;", "prompt" => "Select City", "data-rule-required" => "true", "data-msg-required" => "Please Select City", 'onchange' => 'getArea()'));
                                    echo $form->error($model, 'city_id');
                                    if (isset($session['city_name'])) {
                                        $model->city_name = $session['city_name'];
                                    }
                                    echo $form->hiddenField($model, "city_name", array("class" => "city-id-class"));
                                    ?>

                                </div>

                                <div class="col-md-4">

                                    <?php
                                    echo $form->labelEx($model, 'Area');
                                    $areaArr = array();
                                    $selected = array();
                                    if (!empty($model->city_id)) {
                                        $stateType = Yii::app()->db->createCommand()->select("area_id,area_name")->from("az_area_master")->where('city_id=:id', array(':id' => $model->city_id))->queryAll();
                                        foreach ($stateType as $row) {
                                            $areaArr[$row['area_id']] = $row['area_name'];
                                        }
                                    }
                                    if (isset($session['area_id'])) {
                                        $model->area_id = $session['area_id'];
                                    }
                                    echo $form->dropDownList($model, 'area_id', $areaArr, array("class" => "form-control area-class areaId", "style" => "width:100%;", "prompt" => "Select Area", "data-rule-required" => "true", "data-msg-required" => "Please Select Area", 'onchange' => 'getAreaid()'));
                                    echo $form->error($model, 'area_id');
                                    if (isset($session['area_name'])) {
                                        $model->area_name = $session['area_name'];
                                    }
                                    echo $form->hiddenField($model, "area_name", array("class" => "area-id-class"));
                                    ?>   

                                </div>
                                <div class="col-md-4">

                                    <?php
                                    echo $form->labelEx($model, 'Landmark');
                                    if (isset($session['landmark'])) {
                                        $model->landmark = $session['landmark'];
                                    }
                                    echo $form->textField($model, 'landmark', array("class" => "form-control input-group"));
                                    echo $form->error($model, 'landmark');
                                    ?>


                                </div><div class="clearfix"></div>
                                <div class="col-sm-4">

                                    <?php
                                    echo $form->labelEx($model, 'Address');
                                    echo $form->textField($model, 'address', array("class" => "form-control input-group"));
                                    echo $form->error($model, 'address');
                                    ?>
                                </div>
                                <div class="col-sm-4">

                                    <?php
                                    echo $form->labelEx($model, 'Latitude');
                                    echo $form->textField($model, 'latitude', array("class" => "form-control input-group latitude"));
                                    echo $form->error($model, 'latitude');
                                    ?>
                                </div>
                                <div class="col-sm-4">

                                    <?php
                                    echo $form->labelEx($model, 'Longitude');
                                    echo $form->textField($model, 'longitude', array("class" => "form-control input-group longitude"));
                                    echo $form->error($model, 'longitude');
                                    ?><br>
                                </div>
                                <div class="col-sm-12 clearfix">
                                    <div id="p-map" style="height: 340px;width: 100%;border:1px solid #533223;"></div><br>
                                </div>

                                <div class="text-center">
                                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Update', array("class" => "btn btn-primary")); ?>

                                </div>

                                
                            </div>
                      

                        <?php echo $form->errorSummary($model); ?>
                    </div><!-- box header end -->
                </div><!-- box end -->
            </div> <!-- column col-lg-12 end -->
        </div><!--row end-->
    </section> <!-- section content End -->
</div><!-- tab-content end-->
<?php $this->endWidget(); ?>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.validate.min.js"></script>

<script type="text/javascript">
    var pinarray = [];
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



        $('.addservice').click(function () {
                                                var htmlstr = "";
                                                var servicename = $('.servicename').html();
                                                var twentyfour = $('.twentyfour').html();
                                                // var dayname = $('.dayname').html();
                                                htmlstr = "<div class='form-group servicename clearfix'><div class='col-sm-3'><span>Service</span><select class='form-control servicename' name='ClinicDetails[service][]'>" + servicename + "</select></div><div class='col-sm-2'><span>Discount</span><input type=text name=ClinicDetails[service_discount][] class='form-control'></div><div class='col-sm-2'><span>Corporate Discount</span><input type=text name=ClinicDetails[corporate_discount][] class='form-control'></div><div class='col-sm-2'><span>24X7</span><select class='form-control twentyfour' name='ClinicDetails[twentyfour][]'>" + twentyfour + "</select></div><div class='col-sm-1'><i class='fa fa-times delete' aria-hidden='true'  onclick='remove_service_details(this)'></i></div>";
                                                $('#serviceclone').after(htmlstr);
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


        $.validator.addMethod(
                "regexp",
                function (value, element, regexp) {
                    var re = new RegExp(regexp);
                    return this.optional(element) || re.test(value);
                },
                "Please check your input."
                );
        $("#clinic-details-form").validate({
            rules: {
                "ClinicDetails[clinic_name]": {
                    required: true,
                   // regexp: /^[a-zA-Z]+$/,
                },
                "ClinicDetails[register_no]": {
                    required: true,
                },
               
                
                "ClinicDetails[opd_consultation_fee]": {
                    required: true,
                    regexp: /^[0-9]+$/,
                },
              
                "ClinicDetails[free_opd_perday]": {
                    required: true,
                    regexp: /^[0-9]+$/,
                },
            },
            // Specify the validation error messages
            messages: {
                "ClinicDetails[clinic_name]": {
                    required: "Please Enter Clinic Name",
                    regexp: " Invalid Clinic Name",
                },
                "ClinicDetails[register_no]": {
                    required: "Please Enter Registeration Number",
                },
               
                "ClinicDetails[opd_consultation_fee]": {
                    required: " Please Select OPD Consultation Fees",
                    regexp: " Invalid OPD Consultation Fees",
                },
                
               
                "ClinicDetails[free_opd_perday]": {
                    required: "Please Select Free OPD Per Day",
                    regexp: " Invalid Free OPD Per Day",
                },
            }
        });

        $(".openalltime").on('click', function () {
            var user = $('.openalltime:checked').val();
            if (user == 'on')
            {
                $('.visitinfo').hide();
            }

        });
    });
    
      function clinic_time() {
        var open_time = $('.open_time').val();

        var close_time = $('.close_time').val();
        var eve_open_time = $('.eve_open_time').val();
        var eve_close_time = $('.eve_close_time').val();

        var hiddenhtml = "";
        hiddenhtml = "<span><input type='hidden'  name='ClinicVisitingDetails[clinic_open_time][]' value='" + open_time + "' class='clinic_open_time'><input type='hidden'  name='ClinicVisitingDetails[clinic_close_time][]' value='" + close_time + "' class='clinic_close_time'><input type='hidden'  name='ClinicVisitingDetails[clinic_eve_open_time][]' value='" + eve_open_time + "' class='clinic_eve_open_time'><input type='hidden'  name='ClinicVisitingDetails[clinic_eve_close_time][]' value='" + eve_close_time + "' class='clinic_eve_close_time'></span><div class='timing-list timeing'>Mon:" + open_time + " - " + close_time + "<br>Evn:" + eve_open_time + " - " + eve_close_time + "</div>"
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
    
    function remove_doctor_details(htmlobj)
    {

        $(htmlobj).parents('.doctor_visiting_info').remove();
    }
    function remove_service_details(htmlobj)
    {

        $(htmlobj).parents('.servicename').remove();
    }
    $('.removeservice').click(function () {
        $('.serviceclone:last').remove();
    });
    $('.remove').click(function () {
        $('.visitdetails:last').remove();
    });
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

    function getAreaid() {
        var area1 = $('.area-class option:selected').val();
        var area = $('.area-class option:selected').text();
        //  alert(area1);
        $(".area-id-class").val(area);
        var pincode = pinarray[area1];
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
                    pinarray[value.area_id] = value.pincode;
                    areaname += "<option value='" + value.area_id + "'>" + value.area_name + "</option>";
                });
                $(".areaId").html(areaname);
                //  alert(areaname);
                //  alert(pinarray);
            }
        });
    }

</script>
