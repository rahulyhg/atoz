<?php
/* @var $this PatientSecondopinionController */
/* @var $model PatientSecondopinion */
/* @var $form CActiveForm */
?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyA1vr2RVgKBydJQhSo1LUsP3pUcKh4IFGI"></script>
<?php
$clientScriptObj = Yii::app()->clientScript;
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/select2.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/multiple-select.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/bootstrap-datetimepicker.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jquery.timepicker.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/radio_style.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/bootstrap-datepicker.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/moment-with-locales.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.validate.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-datepicker.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-datetimepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/select2.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/multiple-select.js', CClientScript::POS_END);
$model->latitude = !empty($model->latitude) ? $model->latitude : 18.5204303;
$model->longitude = !empty($model->longitude) ? $model->longitude : 73.8567437;
Yii::app()->clientScript->registerScript('myjavascript', '
    
  $.validator.addMethod(
        "regexp",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Please check your input."
    );
    $("#ambulance-details-form").validate({
        errorElement: "label",
        ignore:":not(:visible)",
        errorClass: "help-block has-error",
        errorPlacement: function (error, element) {
            if (element.parents("label").length > 0) {
                element.parents("label").after(error);
            } else {
                element.after(error);
            }
        },
        highlight: function (label) {
            $(label).closest("div").removeClass("has-error has-success").addClass("has-error");
        },
        success: function (label) {
            label.addClass("valid").closest("div").removeClass("has-error has-success").addClass("has-success");
        },
        onkeyup: function (element) {
            $(element).valid();
        },
        onfocusout: function (element) {
            $(element).valid();
        }
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
                $(".city-id-class").val(result.cityname);
                
              
            }
        });
    })
 function initialize() {
        var lattitude =  ' . $model->latitude . ';
        var longitutde = ' . $model->longitude . ' ;
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
        if (jQuery("#UserDetails_address").length > 0) {
            var input = document.getElementById("UserDetails_address");
            var autocomplete = new google.maps.places.Autocomplete(input);
            google.maps.event.addListener(autocomplete, "place_changed", function () {
                var place = autocomplete.getPlace();
                jQuery("#UserDetails_latitude").val(place.geometry.location.lat());
                jQuery("#UserDetails_longitude").val(place.geometry.location.lng());
                marker.setPosition(place.geometry.location);
                map.setCenter(place.geometry.location);
                map.setZoom(15);
            });
        }
        google.maps.event.addListener(marker, "dragend", function (event) {
            jQuery("#UserDetails_latitude").val(event.latLng.lat());
            jQuery("#UserDetails_longitude").val(event.latLng.lng());
        });
    }
    google.maps.event.addDomListener(window, "load", initialize);
', CClientScript::POS_END);
?>  
<div class="form section-details ">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'ambulance-details-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        'enableAjaxValidation' => false,
    ));
    ?>
   
    <div class="container">

        <section id="intro">
            <div class="row">
                <div class= main-text">
                    <div class="col-md-12 backward">
                         <a class="back-home" href="<?php echo Yii::app()->baseUrl; ?>">Home / </a> <a class="back-sub" href="">  Ambulance Registration</a>
                    </div>

                </div>
            </div>
            <?php if (Yii::app()->user->hasFlash('Success')): ?>
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert">
                        <span aria-hidden="true">x</span>
                    </button>
                    <div>
                        <?php echo Yii::app()->user->getFlash('Success'); ?>
                    </div>
                </div>
            <?php endif; ?>


            <?php echo $form->errorSummary($model); ?>
            <h4>AMBULANCE REGISTRATION</h4>
            <div class="form-grop">

                <div class="col-sm-3">
                    <span>Owner Name</span>
                    <?php echo $form->textField($model, 'first_name', array('class' => 'form-control', "data-rule-required" => "true", "data-msg-required" => "Please Eenter Your full Name")); ?>
                    <?php echo $form->error($model, 'first_name'); ?>
                </div>

                <div class="col-sm-3">
                    <span>Company Name</span>
                    <?php echo $form->textField($model, 'company_name', array('class' => 'form-control', "data-rule-required" => "true", "data-msg-required" => "Please Enter Company  Name")); ?>
                    <?php echo $form->error($model, 'company_name'); ?>
                </div>
                <div class="col-sm-3">
                    <span>Type of Ambulance</span>
                    <?php
                    $AmbCat = Constants::AMBULANCE_CATEGORY;
                    $AmbCateArr = explode(";", $AmbCat);
                    $cateArr = array_combine($AmbCateArr, $AmbCateArr);

                    echo $form->dropDownList($model, 'type_of_hospital', $cateArr, array('class' => 'form-control', "data-rule-required" => "true", "data-msg-required" => "Please Enter Type Of Ambulance", "prompt" => "Select Type Of Ambulance"));
                    echo $form->error($model, 'type_of_hospital');
                    ?>       

                </div>
                <div class="col-sm-3">
                    <span>Registration no.</span>
                    <?php echo $form->textField($model, 'hospital_registration_no', array('class' => 'form-control', "data-rule-required" => "true", "data-msg-required" => "Please Enter Registration No.")); ?>
                    <?php echo $form->error($model, 'hospital_registration_no'); ?>
                </div>

            </div>
            <div class="clearfix">&nbsp;</div>
            <div class="form-grop clearfix">

                <div class="col-sm-3">
                    <span>Driver Name</span>
                    <?php echo $form->textField($model, 'hospital_name', array('class' => 'form-control', "data-rule-required" => "true", "data-msg-required" => "Please Enter Your Driver Name")); ?>
                    <?php echo $form->error($model, 'hospital_name'); ?>
                </div>
                <div class="col-sm-3">
                    <span>Mobile<strong class="mandatory">*</strong></span>
                  <?php echo $form->textField($model, 'mobile', array('maxlength' => 10, "class" => "form-control mobileclass ", "data-msg-required" => "Please Enter Mobile", "data-rule-required" => "true",  "onblur" => "chk_mobile(this)"));?>
                      <span id="mobileno" style="color: red;"></span>
                    <?php echo $form->error($model, 'mobile'); ?>
                </div>
                <div class="col-md-3">
                    <span>Password<strong class="mandatory">*</strong></span>
                    <?php
                    echo $form->passwordField($model, 'password', array("class" => "form-control input-group", "data-rule-required" => "true", "data-msg-required" => "Please Enter Password"));
                    echo $form->error($model, 'password');
                    ?>                                                   
                </div>
                <div class="col-md-3">
                    <span>Smart Phone</span>

                    <?php echo $form->dropDownList($model, 'take_home', array("Yes" => "Yes", "No" => "No"), array("class" => "form-control input-group"));
                    ?>
                </div>
            </div>
            <div class="clearfix">&nbsp;</div>

            <div class="form-group clearfix">
                <div class="col-sm-12">
                    Ambulance Coordinator
                </div>
                <div class="col-sm-4">
                    <b><span>Name</span></b>
                    <?php
                    echo $form->textField($model, 'coordinator_name_1', array("class" => "form-control"));
                    echo $form->error($model, 'coordinator_name_1');
                    ?>
                </div>
                <div class="col-md-4 contacts">
                    <span>Contact Number</span>
                    <?php
                    echo $form->textField($model, 'coordinator_mobile_1', array('maxlength' => 10, "class" => "form-control input-group", "data-msg-required" => "Please Enter contact no", "data-rule-regexp" => "^[\d]+$"));
                    echo $form->error($model, 'coordinator_mobile_1');
                    ?>
                    <a class="btn-block" href="javascript:" onclick="$('.contact_no_2').show();
                            $(this).hide();"><i class="fa fa-plus" aria-hidden="true"></i> Add Contact Number </a>
                       <div class="contact_no_2" style="display: none;">
                        <br>
                        <?php
                       
                        echo $form->textField($model, 'coordinator_mobile_2', array('maxlength' => 10, "class" => "form-control input-group", "data-msg-required" => "Please Enter contact no", "data-rule-regexp" => "^[\d]+$"));
                        echo $form->error($model, 'apt_contact_no_2');
                        ?>
                    </div>
                </div>
                <div class="col-sm-4">

                    <b><span> Email</span></b>
                    <?php
                    echo $form->textField($model, 'coordinator_email_1', array("class" => "form-control"));
                    echo $form->error($model, 'coordinator_email_1');
                    ?>
                </div>
            </div>


            <div class="clearfix">&nbsp;</div>


            <div class="form-grop clearfix">
                <div class="col-sm-5">
                    <span>Working Days  </span>
                    <?php
                    echo $form->radioButtonList($model5, 'working_day', array('Monday-Saturday' => 'Monday-Saturday', 'Monday-Sunday' => 'Monday-Sunday', 'other' => 'other'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '&nbsp;&nbsp;&nbsp;', 'container' => 'div class="ui-radio ui-radio-pink"', "data-rule-required" => "true", "data-msg-required" => "Please Select Working Day"));
                    echo $form->error($model5, 'working_day');
                    ?>

                </div>
                <div class="col-sm-4">
                    <span>24x7 Emergency  </span>
                    <?php echo $form->dropDownList($model, 'emergency', array("Yes" => "Yes", "No" => "No"), array("class" => "form-control input-group")); ?>
                    <?php echo $form->error($model, 'emergency'); ?>
                </div>
                <div class="col-sm-3">
                    <span>Free Services  </span>
                    <?php echo $form->dropDownList($model, 'extra_charges', array("Yes" => "Yes", "No" => "No"), array("class" => "form-control input-group")); ?>
                    <?php echo $form->error($model, 'extra_charges'); ?>
                </div>
            </div>
            <div class="clearfix">&nbsp;</div>


            <div class="form-grop clearfix">
                <div class="col-sm-12"> Registration Fee</div>
                <div class="col-md-4">
                    <span>Vehicle No</span>
                    <?php
                    echo $form->textField($model5, 'vehical_no', array("class" => "form-control", "data-rule-required" => "true"));
                    echo $form->error($model5, 'acc_holder_name');
                    ?> 
                </div>
                <div class="col-md-4">
                    <span>Vehicle Type</span>
                    <?php
                    echo $form->textField($model5, 'vehical_type', array("class" => "form-control"));
                    echo $form->error($model5, 'vehical_type');
                    ?> 
                </div>
            </div>
            <div class="clearfix">&nbsp;</div>


            <div class="form-grop clearfix">
                <div class="col-sm-4">
                    <b><span>Executive Name</span></b>
                    <?php
                    echo $form->textField($model5, 'ex_name', array("class" => "form-control"));
                    echo $form->error($model5, 'ex_name');
                    ?>
                </div>
                <div class="col-sm-4">
                    <b><span> Executive Contact no.</span></b>
                    <?php
                    echo $form->textField($model5, 'ex_contact_no', array("class" => "form-control", "maxlength" => 10));
                    echo $form->error($model5, 'ex_contact_no');
                    ?>
                </div>
                <div class="col-sm-4">
                    <b><span> Documents upload</span></b>
                    <?php
                    echo $form->fileField($model2, 'document', array("class" => "w3-input input-group"));
                    echo $form->error($model2, 'document');
                    ?> 
                </div>
            </div>
            <div class="form-grop clearfix">
                <div class="col-sm-12">Address</div>

                <div class="col-md-4">
                    <span>Zip Code</span>
                    <?php
                    if (isset($session['pincode'])) {
                        $model->pincode = $session['pincode'];
                    }
                    echo $form->textField($model, 'pincode', array("class" => "form-control input-group pincode-id-class"));
                    echo $form->error($model, 'pincode');
                    ?>
                </div>  
                <div class="col-md-4">
                    <b><span>City<strong class="mandatory">*</strong></span></b>
                    <?php
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


            </div>
            <div class="form-grop clearfix">
                <div class="col-sm-4">
                    <b><span>Sr./Surve/Bldg No.</span></b>
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
                    ?>
                </div>
            </div>
              <div class="form-grop clearfix">
                <div class="col-sm-12 clearfix" style="margin-top: 15px;">
                    <div id="p-map" style="height: 340px;width: 100%;border:1px solid #533223;"></div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group clearfix">
                <input type="checkbox" name="acceptcondition"  class="agree required"/> I/ we Agree with the term and condition .
<!--                mentioned in the web policy of the company and attached annexure.-->
                <p><span id="agree1" class="error1"></span></p>
                <div class="clearfix"></div>
            </div> 
            <div class="row buttons text-center">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Submit' : 'Save', array('class' => 'btn')); ?>
            </div>
        </section>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->
<script src="js/jquery-2.2.3.min.js"></script>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery-min.js"></script>
<script src="js/jquery.validate.min.js"></script>

<script type="text/javascript">
                        //          

                       

   function chk_mobile(obj) {

        var mobile = $('.mobileclass').val();
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            cache: false,
            url: '<?php echo Yii::app()->createUrl("site/check_Mobile"); ?> ',
            data: {mobile: mobile},
            success: function (data) {
                var dataobj = data.data;
                 
                if (dataobj > 0) {
                    var error_msg = 'Mobile No is Already Registered';
                    $("#mobileno").html(error_msg);
                } else {
                    $("#mobileno").html('');
                }
            }
        });

    }
</script>
