
<?php
$clientScriptObj = Yii::app()->clientScript;
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/select2.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/multiple-select.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/bootstrap-datetimepicker.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/cropper.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/radio_style.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/bootstrap-datepicker.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/moment-with-locales.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.validate.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-datepicker.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-datetimepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/select2.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/multiple-select.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-fileupload.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/cropper.js', CClientScript::POS_END);
$model->latitude = !empty($model->latitude) ? $model->latitude : 18.5204303;
$model->longitude = !empty($model->longitude) ? $model->longitude : 73.8567437;
$setDataLink = Yii::app()->createUrl("userDetails/setUserData");
Yii::app()->clientScript->registerScript('myjavascript', '
   var pinarray = [];
    $.validator.addMethod(
        "regexp",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Please check your input."
    );
    $("#user-details-form").validate({
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
    $(".datepick").datepicker({
        
         autoclose: true,
    maxDate :new Date(),
    minViewMode: 1,
    format: "mm-yyyy"
        
    });
    $(".timepick").datetimepicker({
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
    function showHospTime(){
        if($(".isopenallday:checked").val() == "N") { $(".hospitaltime").show(); }else{  $(".hospitaltime").hide(); }
    }
    function showNextSlide(nextslideid, tabid){
        
      if($("#user-details-form").valid()){
     //   if(1){

            $.ajax({
                type: "POST",
                url: "' . $setDataLink . '",
                data: $("#user-details-form").serialize(),
                //dataType: "json",
                success: function (result)
                {
                    $(".mySlides").hide();
                    $("#"+nextslideid).show();
                    $("html, body").animate({ scrollTop: $(".tab-content").offset().top }, 1500);
                    $("#myTabs a[href=\"#"+tabid+"\"]").tab("show");
                    $(".fa-angle-double-right").remove();
                    $("#myTabs a[href=\"#"+tabid+"\"]").append("<i class=\"fa fa-angle-double-right\" aria-hidden=\"true\"></i>");
                }
            });
        }
    }
    function showPrevSlide(prevslideid, tabid){
        
        $(".mySlides").hide();
        $("#"+prevslideid).show();
        $("#myTabs a[href=\"#"+tabid+"\"]").tab("show");
        $(".fa-angle-double-right").remove();
        $("#myTabs a[href=\"#"+tabid+"\"]").append("<i class=\"fa fa-angle-double-right\" aria-hidden=\"true\"></i>");
        

    }
    function getCity()
    {
        var state = $(".state-class option:selected").val();
        var state1 = $(".state-class option:selected").text();
        $(".state-id-class").val(state1);
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            cache: false,
            url: "' . Yii::app()->createUrl("UserDetails/getCityName") . '",
            data: {state: state},
            success: function (data) {
                var dataobj = data.data;

                var cityname = "<option value=\"\">Select City</option>";
                $.each(dataobj, function (key, value) {

                    cityname += "<option value=\"" + value.city_id + " \">" + value.city_name + "</option>";
                });
                $(".cityId").html(cityname);
            }
        });
    }
    function getArea()
    {
        var area = $(".city-class option:selected").val();
        var area1 = $(".city-class option:selected").text();

        $(".city-id-class").val(area1);
        jQuery.ajax({
            type: "POST",dataType: "json",cache: false,
            url: "' . Yii::app()->createUrl("UserDetails/getAreaName") . '",
            data: {area: area},
            success: function (data) {
                var dataobj = data.data;
                var areaname = "<option value=\"\">Select Area</option>";
                pinarray = [];
                $.each(dataobj, function (key, value) {
                    pinarray[""+value.area_id] = value.pincode;
                    areaname += "<option value=\"" + value.area_id + " \">" + value.area_name + "</option>";
                });
                $(".areaId").html(areaname);
            }
        });
    }
    function getAreaid() {
        var area1 = $(".area-class option:selected").val();
        var area = $(".area-class option:selected").text();
       
        $(".area-id-class").val(area);
        var pincode = pinarray[parseInt(area1)];
        $(".pincode-id-class").val(pincode);
    }

    
function addMoreServices(htmlObj) {
        var str = "";
        var serviceoption = $(".serviceoption:first").html();
        str += "<br><div class=\"servicename\"><div class=\"col-md-3\"><select class=\"w3-input serviceoption\" name=\"UserDetails[userservice][]\" style=\"width:100%;\">" + serviceoption + "</select></div>";
        str += "<div class=\"col-md-3\"><input class=\"w3-input input-group\" name=\"UserDetails[discount][]\" type=\"text\"></div>";
        str += "<div class=\"col-md-3\"><input class=\"w3-input input-group\" name=\"UserDetails[corporate_discount][]\" type=\"text\"></div>";
        str += "<div class=\"col-md-2\"><select class=\"w3-input serviceoption\"  name=\"UserDetails[twentyfour][]\"  style=\"width:100%;\"><option value=\"No\">No</option><option value=\"Yes\">Yes</option></select></div>";
        str += "<i class=\'fa fa-times delete\' aria-hidden=\'true\' onclick=\'remove_service_details(this)\'></i><div class=\"clearfix\">&nbsp;</div></div>";
        $(htmlObj).parents(".btnaddservice").before(str);
        // console.log("tabid",$(htmlObj).parents(".btnaddservice").html(),str);
    }
function remove_service_details(htmlobj)
    {

        $(htmlobj).parents(\'.servicename\').remove();
    }


$(".multipleselect3").multipleSelect({
            filter: true,
            multiple: true,
            width: "100%",
            multipleWidth: 500
        });
  $(".multipleselect4").multipleSelect({
            filter: true,
            multiple: true,
          //  placeholder: "Select Speciality",
            width: "100%",
            multipleWidth: 500
        });      

    function checkEstType(htmlObj){
        $(".otherdisptype").val("");
        if($(htmlObj).val() == "others") {
            $(".otherdisptype").attr("style","visibility:visible;");
        }else{
            $(".otherdisptype").attr("style","visibility:hidden;");
        }
    }
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


<section id="intro" class="section-details">
    <div class="overlay">
        <div class="container">
            <div class="main-text">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'user-details-form',
                    'htmlOptions' => array('enctype' => 'multipart/form-data', "class" => "w3-container"),
                    'enableAjaxValidation' => false,
                ));
                ?>
                <?php $baseUrl = Yii::app()->request->baseUrl; ?>
                <!-- Start Search box -->
                <div class="row">
                    <div class="col-md-3" style="background-image:url(<?= $baseUrl; ?>/images/icon46.png);height: 1590px;background-size: 100% auto;background-position: center center;">
                        <div class="fileinput fileinput-new" data-provides="fileinput" style="position: relative;">
                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="background: transparent;width:140px;height:140px;text-align: center; margin: auto;border-radius: 50%;overflow: hidden;">
                                <?php
                                if (empty($model->profile_image)) {
                                    echo CHtml::image(Yii::app()->request->baseUrl . "/images/icons/icon02.png", "Profile Photo", array("class" => "img-circle", "width" => "150"));
                                }
                                ?>

                            </div>
                            <span class=" btn-file" style="position: absolute;top: 60%;right: 26px;border: 1px solid #888;padding:0px;">

                                <button type="button" onclick="showimg();" class="fileinput-new">Edit</button>

                                <input type ="hidden" class="imgname" name="profile">
                                <?php echo $form->error($model, 'profile_image');
                                ?>

                            </span>
                        </div>
                        <ul class="nav nav-pills nav-stacked "  id="myTabs">

                            <li class="active"><a href="#tab_a" data-toggle="pill">Hospital Details &nbsp; <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                                </a></li>
                            <li><a href="#tab_b" data-toggle="pill">Services </a></li>
                            <li><a href="#tab_c" data-toggle="pill">Upload Documents </a></li>                                  
                        </ul>
                    </div>
                    <div class="tab-content col-md-9">                             	

                        <div class="tab-pane active" id="tab_a">

                            <div class="w3-content w3-display-container">
                                <div class="mySlides" id="slide1">
                                    <h3 class="title">Enter Hospital Details </h3>
                                    <div class="underline"></div>
                                    <h4 class="title-details">Hospital Details  </h4>
                                    <?php echo $form->errorSummary($model); ?>
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

                                    <div class="textdetails">
                                        <div class="col-md-4">
                                            <span>Hospital Name</span>
                                            <?php
                                            if (isset($session['hospital_name'])) {
                                                $model->hospital_name = $session['hospital_name'];
                                            }
                                            echo $form->textField($model, 'hospital_name', array("class" => "w3-input input-group"));
                                            echo $form->error($model, 'hospital_name');
                                            ?>
                                        </div>
                                        <div class="col-md-4">
                                            <span>Type Of Hospital</span>  
                                            <?php
                                            $hospCat = Constants::HOSPITAL_CATEGORY;
                                            $hospCateArr = explode(";", $hospCat);
                                            $cateArr = array_combine($hospCateArr, $hospCateArr);
                                            if (isset($session['type_of_hospital'])) {
                                                $model->type_of_hospital = $session['type_of_hospital'];
                                            }
                                            echo $form->dropDownList($model, 'type_of_hospital', $cateArr, array("class" => "w3-input input-group", "style" => "width:100%;", "prompt" => "Select Type Of Hospital", "data-msg-required" => "Please Select Type"));
                                            echo $form->error($model, 'type_of_hospital');
                                            ?>                                                 
                                        </div>
                                        <div class="col-md-4">
                                            <span>Hospital Registration Number</span>
                                            <?php
                                            if (isset($session['hospital_registration_no'])) {
                                                $model->hospital_registration_no = $session['hospital_registration_no'];
                                            }
                                            echo $form->textField($model, 'hospital_registration_no', array("class" => "w3-input input-group", "data-msg-required" => "Please Enter Registration Number"));
                                            echo $form->error($model, 'hospital_registration_no');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="textdetails">
                                        <div class="col-md-4">
                                            <span>Payment Modes</span>
                                            <?php
                                            $paytype = Constants::PAYMENT_TYPE;
                                            $payTypeArr = explode(";", $paytype);
                                            $paymentArr = array_combine($payTypeArr, $payTypeArr);

                                            $selected = array("A2Z E-money" => array('selected' => 'selected', "disabled" => true));
                                            if (isset($session['payment_type'])) {
                                                foreach ($session['payment_type'] as $payment_type) {
                                                    $selected[$payment_type] = array('selected' => 'selected');
                                                }
                                            }
                                            echo $form->dropDownList($model, 'payment_type', $paymentArr, array("class" => "w3-input multipleselect3", "style" => "width:100%;", "multiple" => true, "data-msg-required" => "Please Select Payment Type", 'options' => $selected));
                                            echo $form->error($model, 'payment_type');
                                            ?>   

                                        </div>
                                        <div class="col-md-4">
                                            <span>Year of Establishment</span> 
                                            <?php
                                            if (isset($session['hos_establishment'])) {
                                                $model->hos_establishment = $session['hos_establishment'];
                                            }
                                            echo $form->textField($model, 'hos_establishment', array("class" => "w3-input input-group datepick", "data-date-format" => "mm-yyyy", "data-date-end-date" => "0d", "data-date-min-view-mode" => "1", "data-msg-required" => "Please Select Year of Establishment"));
                                            echo $form->error($model, 'hos_establishment');
                                            ?>                                                   
                                        </div>
                                        <div class="col-md-4">

                                        </div>
                                    </div>
                                    <div class="clearfix"></div>

                                    <div class="textdetails">
                                        <div class="col-md-12">
                                            <span>Type of Establishment</span>
                                            <?php
                                            $estTypeArr = array("privateltd" => "Private Ltd", "partnership" => "Partnership", "publicltd" => "Public Ltd", "individual" => "Individual", "trust" => "Trust", "others" => "Others");
                                            $type_of_establishment = "";
                                            if (isset($session['type_of_establishment'])) {
                                                $type_of_establishment = $session['type_of_establishment'];
                                            }
                                            foreach ($estTypeArr as $value => $text) {
                                                echo "<label> <input class='w3-input' type='radio' name='UserDetails[type_of_establishment]' value='$value'";
                                                if ($value == $type_of_establishment) {
                                                    echo " checked ";
                                                }
                                                echo " onclick='checkEstType(this);'> $text </label> ";
                                            }

                                            if (isset($session['other_est_type'])) {
                                                $model->other_est_type = $session['other_est_type'];
                                            }
                                            echo $form->textField($model, 'other_est_type', array("class" => "w3-input input-group1 otherdisptype", "placeholder" => "Specify other type", "style" => "visibility:hidden;"));
                                            echo $form->error($model, 'other_est_type');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="textdetails">
                                        <div class="col-sm-4">
                                            <span>Specialty</span> 
                                            <?php
                                            $speArr = array();
                                            $selected = array();
                                            $sepeType = Yii::app()->db->createCommand()->select("speciality_id,speciality_name")->from("az_speciality_master")->where("is_active=1")->queryAll();
                                            foreach ($sepeType as $row) {
                                                $speArr[$row['speciality_id']] = $row['speciality_name'];
                                            }

                                            if (isset($session['speciality']) && is_array($session['speciality'])) {
                                                foreach ($session['speciality'] as $speciality) {
                                                    $selected[$speciality] = array('selected' => 'selected');
                                                }
                                            }
                                            echo $form->dropDownList($model, 'speciality[]', $speArr, array("class" => "w3-input multipleselect4", "style" => "width:100%;", "multiple" => true, "data-rule-required" => "true", 'options' => $selected));
                                            echo $form->error($model, 'speciality');
                                            ?>     

                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-sm-6">
                                        <h4 class="title-details"></h4>
                                        <div class="textdetails">
                                            <div class="col-md-10">

                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="clearfix"></div>

                                    <h4 class="title-details">Login Details </h4>
                                    <div class="textdetails">
                                        <div class="col-md-4">
                                            <span>Mobile Number<strong class="mandatory">*</strong></span>  
                                            <?php
                                            if (isset($session['mobile'])) {
                                                $model->mobile = $session['mobile'];
                                            }
                                            echo $form->numberField($model, 'mobile', array('maxlength' => 10, "class" => "w3-input input-group mobileclass", "data-rule-required" => "true", "data-msg-required" => "Please Enter Mobile no", "data-rule-regexp" => "^[0-9]{10}$", "onblur" => "chk_mobile()"));
                                            ?>
                                            <span id="mobileno" style="color: red;"></span>
                                            <?php echo $form->error($model, 'mobile');
                                            ?>                                                    
                                        </div>
                                        <div class="col-md-4">
                                            <span>Password<strong class="mandatory">*</strong></span>
                                            <?php
                                            echo $form->passwordField($model, 'password', array("class" => "w3-input input-group", "data-rule-required" => "true", "data-msg-required" => "Please Enter Password","id"=>"pass"));
                                            echo $form->error($model, 'password');
                                            ?>                                                   
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <span>   Confirm Password<strong class="mandatory">*</strong></span>

    <?php  echo $form->passwordField($model, 'confirm_password', array('size' => 20, 'maxlength' => 30, "class" => "w3-input input-group password", "data-rule-required" => "true", "data-rule-equalTo" => "#pass", "data-rule-regexp" => "^[\w.,-\s\/\']+$"));?> 
                                        </div>
                                        
                                    </div>
                                    <div class="clearfix"></div>
                                    <h4 class="title-details">Contact Details </h4>
                                    <div class="textdetails">
                                        <div class="col-md-4">
                                            <span>Landline Number</span>
                                            <?php
                                            if (isset($session['landline_1'])) {
                                                $model->landline_1 = $session['landline_1'];
                                            }
                                            echo $form->textField($model, 'landline_1', array("class" => "w3-input input-group", "data-msg-required" => "Please Enter Landline"));
                                            echo $form->error($model, 'landline_1');
                                            ?>                                                  
                                        </div>
                                        <div class="col-md-4">
                                            <span>Email Address</span>
                                            <?php
                                            if (isset($session['email_1'])) {
                                                $model->email_1 = $session['email_1'];
                                            }
                                            echo $form->textField($model, 'email_1', array("class" => "w3-input input-group"));
                                            echo $form->error($model, 'email_1');
                                            ?>                                                 
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="textdetails">
                                        <div class="col-md-4">
                                            <span>Emergency No</span>  
                                            <?php
                                            if (isset($session['emergency_no_1'])) {
                                                $model->emergency_no_1 = $session['emergency_no_1'];
                                            }
                                            echo $form->textField($model, 'emergency_no_1', array("class" => "w3-input input-group", "data-rule-regexp" => "^[\d]+$"));
                                            echo $form->error($model, 'emergency_no_1');
                                            ?>                                                 
                                        </div>
                                        <div class="col-md-4">
                                            <span>Ambulance No</span>                                               
                                            <?php
                                            if (isset($session['ambulance_no_1'])) {
                                                $model->ambulance_no_1 = $session['ambulance_no_1'];
                                            }
                                            echo $form->textField($model, 'ambulance_no_1', array("class" => "w3-input input-group", "data-rule-regexp" => "^[\d]+$"));
                                            echo $form->error($model, 'ambulance_no_1');
                                            ?>                                                   
                                        </div>
                                        <div class="col-md-4">
                                            <span>Toll Free No</span> 
                                            <?php
                                            if (isset($session['tollfree_no_1'])) {
                                                $model->tollfree_no_1 = $session['tollfree_no_1'];
                                            }
                                            echo $form->textField($model, 'tollfree_no_1', array("class" => "w3-input input-group", "data-rule-regexp" => "^[\d]+$"));
                                            echo $form->error($model, 'tollfree_no_1');
                                            ?>                                                     
                                        </div>
                                    </div>
                                    <div class="clearfix">&nbsp;</div>

                                    <h4 class="title-details">A-Z Health+ coordinator from Hospital</h4>
                                    <div class="textdetails">
                                        <div class="col-md-4">
                                            <div class="contacts">
                                                <span>1. Name</span>                                                        
                                                <?php
                                                if (isset($session['coordinator_name_1'])) {
                                                    $model->coordinator_name_1 = $session['coordinator_name_1'];
                                                }
                                                echo $form->textField($model, 'coordinator_name_1', array("class" => "w3-input input-group"));
                                                echo $form->error($model, 'coordinator_name_1');
                                                ?>
                                            </div>           
                                        </div>
                                        <div class="col-md-4">                                                    	
                                            <span>Contact Number </span>                                                        
                                            <?php
                                            if (isset($session['coordinator_mobile_1'])) {
                                                $model->coordinator_mobile_1 = $session['coordinator_mobile_1'];
                                            }
                                            echo $form->textField($model, 'coordinator_mobile_1', array('maxlength' => 10, "class" => "w3-input input-group", "data-msg-required" => "Please Enter Mobile No", "data-rule-regexp" => "^[0-9]{10}$"));
                                            echo $form->error($model, 'coordinator_mobile_1');
                                            ?>
                                        </div>
                                    </div> <!--end textdetails-->

                                    <div class="clearfix"></div>
                                    <div class="textdetails">
                                        <div class="col-md-4">
                                            <div class="contacts">
                                                <span>2. Name</span>                                                        
                                                <?php
                                                if (isset($session['coordinator_name_2'])) {
                                                    $model->coordinator_name_2 = $session['coordinator_name_2'];
                                                }
                                                echo $form->textField($model, 'coordinator_name_2', array("class" => "w3-input input-group"));
                                                echo $form->error($model, 'coordinator_name_2');
                                                ?>
                                            </div>           
                                        </div>
                                        <div class="col-md-4">                                                    	
                                            <span>Contact Number </span>                                                        
                                            <?php
                                            if (isset($session['coordinator_mobile_2'])) {
                                                $model->coordinator_mobile_2 = $session['coordinator_mobile_2'];
                                            }
                                            echo $form->textField($model, 'coordinator_mobile_2', array('maxlength' => 10, "class" => "w3-input input-group", "data-rule-regexp" => "^[0-9]{10}$"));
                                            echo $form->error($model, 'coordinator_mobile_2');
                                            ?>
                                        </div>

                                    </div> <!--end textdetails-->

                                    <div class="clearfix"></div>
                                    <div class="textdetails">
                                        <div class="col-md-4">
                                            <div class="contacts">
                                                <span>Email Address 1</span>                                                        
                                                <?php
                                                if (isset($session['coordinator_email_1'])) {
                                                    $model->coordinator_email_1 = $session['coordinator_email_1'];
                                                }
                                                echo $form->textField($model, 'coordinator_email_1', array("class" => "w3-input input-group"));
                                                echo $form->error($model, 'coordinator_email_1');
                                                ?>
                                            </div>
                                            <a class="btn-block" href="javascript:" onclick="$('.cordemail2').show();$(this).hide();"><i class="fa fa-plus" aria-hidden="true"></i> Add Email Address </a>
                                        </div>                               
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="textdetails cordemail2" style="display: none;">
                                        <div class="col-md-4">                                                    	
                                            <span>Email Address 2 </span>                                                        
                                            <?php
                                            if (isset($session['coordinator_email_2'])) {
                                                $model->coordinator_email_2 = $session['coordinator_email_2'];
                                            }
                                            echo $form->textField($model, 'coordinator_email_2', array("class" => "w3-input input-group"));
                                            echo $form->error($model, 'coordinator_email_2');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="clearfix">&nbsp;</div>

                                    <div class="textdetails">
                                        <span>Timing</span>
                                        <div class="col-md-4">
                                            <?php
                                            $estTypeArr = array("Y" => "Clinic Open 24x7", "N" => "Day-Care");
                                            $is_open_allday = "";
                                            if (isset($session['is_open_allday'])) {
                                                $is_open_allday = $session['is_open_allday'];
                                            }
                                            ?>
                                            <label> <br> <input class="w3-input isopenallday" type="radio" name="UserDetails[is_open_allday]" value="Y" id="is_open_Y" <?php echo $is_open_allday == "Y" ? "checked" : ""; ?> onclick="if ($('.isopenallday:checked').val() == 'N') {
                                                        $('.hospitaltime').show();
                                                    } else {
                                                        $('.hospitaltime').hide();
                                                    }"> 24x7 </label> 
                                            <label> <br> <input class="w3-input isopenallday" type="radio" name="UserDetails[is_open_allday]" value="N"  id="is_open_N" <?php echo $is_open_allday == "N" ? "checked" : ""; ?> onclick="showHospTime()"> Day-Care </label>                                         
                                        </div>
                                        <div class="col-md-8 hospitaltime" style="display: none;">
                                            <div class="col-md-6">
                                                <span>Open Time</span>
                                                <?php
                                                if (isset($session['hospital_open_time'])) {
                                                    $model->hospital_open_time = $session['hospital_open_time'];
                                                }
                                                echo $form->textField($model, 'hospital_open_time', array("class" => "w3-input input-group timepick"));
                                                echo $form->error($model, 'hospital_open_time');
                                                ?>
                                            </div>
                                            <div class="col-md-6">
                                                <span>Close Time</span>
                                                <?php
                                                if (isset($session['hospital_close_time'])) {
                                                    $model->hospital_close_time = $session['hospital_close_time'];
                                                }
                                                echo $form->textField($model, 'hospital_close_time', array("class" => "w3-input input-group timepick"));
                                                echo $form->error($model, 'hospital_close_time');
                                                ?>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="clearfix">&nbsp;</div>                  	
                                    <h4 class="title-details clearfix">Location</h4>
                                    <div class="textdetails">
                                        <div class="col-md-4">
                                            <span>Zip Code</span>
                                            <?php
                                            if (isset($session['pincode'])) {
                                                $model->pincode = $session['pincode'];
                                            }
                                            echo $form->textField($model, 'pincode', array("class" => "w3-input input-group pincode-id-class"));
                                            echo $form->error($model, 'pincode');
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
                                                $model->state_id = $session['state_id'];
                                            }
                                            echo $form->dropDownList($model, 'state_id', $stateArr, array("class" => "w3-input state-class", "style" => "width:100%;", "prompt" => "Select State", "data-msg-required" => "Please Select State", 'onchange' => 'getCity()'));
                                            echo $form->error($model, 'state_id');
                                            if (isset($session['state_name'])) {
                                                $model->state_name = $session['state_name'];
                                            }
                                            echo $form->hiddenField($model, "state_name", array("class" => "state-id-class"));
                                            ?>   

                                        </div>
                                        <div class="col-md-4">
                                            <span>City</span>
                                            <?php
                                            $cityArr = array();

                                            if (isset($session['city_id'])) {
                                                $model->city_id = $session['city_id'];
                                            }
                                            echo $form->dropDownList($model, 'city_id', $cityArr, array("class" => "w3-input cityId city-class", "style" => "width:100%;", "prompt" => "Select City", "data-msg-required" => "Please Select City", 'onchange' => 'getArea()'));
                                            echo $form->error($model, 'city_id');
                                            if (isset($session['city_name'])) {
                                                $model->city_name = $session['city_name'];
                                            }
                                            echo $form->hiddenField($model, "city_name", array("class" => "city-id-class"));
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
                                            if (!empty($model->city_id)) {
                                                $stateType = Yii::app()->db->createCommand()->select("area_id,area_name")->from("az_area_master")->where('city_id=:id', array(':id' => $model->city_id))->queryAll();
                                                foreach ($stateType as $row) {
                                                    $areaArr[$row['area_id']] = $row['area_name'];
                                                }
                                            }

                                            if (isset($session['area_id'])) {
                                                $model->area_id = $session['area_id'];
                                            }

                                            echo $form->dropDownList($model, 'area_id', $areaArr, array("class" => "w3-input area-class areaId", "style" => "width:100%;", "prompt" => "Select Area", "data-msg-required" => "Please Select Area", 'onchange' => 'getAreaid()'));
                                            echo $form->error($model, 'area_id');
                                            if (isset($session['area_name'])) {
                                                $model->area_name = $session['area_name'];
                                            }
                                            echo $form->hiddenField($model, "area_name", array("class" => "area-id-class"));
                                            ?>   

                                        </div>
                                        <div class="col-md-4">
                                            <span>Landmark</span>
                                            <?php
                                            if (isset($session['landmark'])) {
                                                $model->landmark = $session['landmark'];
                                            }
                                            echo $form->textField($model, 'landmark', array("class" => "w3-input input-group"));
                                            echo $form->error($model, 'landmark');
                                            ?>

                                        </div>

                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-md-4">
                                        <span>Address</span>
                                        <?php
                                        if (isset($session['address'])) {
                                            $model->address = $session['address'];
                                        }
                                        echo $form->textField($model, 'address', array("class" => "w3-input input-group"));
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
                                    <div class="clearfix">&nbsp;</div>
                                    <div class="col-sm-12 clearfix">
                                        <div id="p-map" style="height: 340px;width: 100%;border:1px solid #533223;"></div>
                                    </div>


                                    <div class="clearfix"></div>
                                    <div class="textdetails">

                                        <div class="col-md-8">
                                            <span>About Hospital</span>
                                            <?php
                                            if (isset($session['description'])) {
                                                $model->description = $session['description'];
                                            }
                                            echo $form->textArea($model, 'description', array('maxlength' => 500, 'rows' => 5, 'cols' => 50, "data-msg-required" => "Please Enter Description"));
                                            echo $form->error($model, 'description');
                                            ?>

                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="button-arrow">

                                        <button class="w3-button w3-black w3-display-right" onClick="showNextSlide('slide2', 'tab_b')" type="button">&#10095;</button>
                                    </div>
                                </div><!--end mySlides-->

                            </div> <!--end w3-display-container-->                                  

                        </div>           
                        <!--end tab_a -->
                        <div class="tab-pane" id="tab_b">
                            <div class="w3-content w3-display-container">
                                <div class="mySlides"  id="slide2">
                                    <h3 class="title">Services</h3>
                                    <div class="textdetails">
                                        <div class="col-md-3">
                                            <span>Services</span>
                                            <?php
                                            $serviceArr = array();
                                            $selected = array();
                                            $serviceType = Yii::app()->db->createCommand()->select("service_id,service_name")->from("az_service_master")->where('role_id=:roleid', array(':roleid' => $roleid))->queryAll();
                                            foreach ($serviceType as $row) {
                                                $serviceArr[$row['service_id']] = $row['service_name'];
                                            }
                                            echo $form->dropDownList($model, 'userservice[]', $serviceArr, array("class" => "w3-input serviceoption", "style" => "width:100%;", "prompt" => "Select Services", "data-msg-required" => "Please Select Services"));
                                            echo $form->error($model, 'userservice');
                                            ?>   

                                        </div>    
                                        <div class="col-md-3">
                                            <span>Discount %</span>
                                            <?php
                                            if (isset($session['discount'])) {
                                                $model->discount = $session['discount'];
                                            }
                                            echo $form->textField($model, 'discount[]', array("class" => "w3-input input-group", "data-rule-regexp" => "^0*(?:[1-9][0-9]?|100)$", "data-msg-required" => "Invalid Discount Fee"));
                                            echo $form->error($model, 'discount');
                                            ?> 
                                        </div>
                                        <div class="col-md-3">
                                            <span>Corporate Discount %</span>
                                            <?php
                                            if (isset($session['corporate_discount'])) {
                                                $model->corporate_discount = $session['corporate_discount'];
                                            }
                                            echo $form->textField($model, 'corporate_discount[]', array("class" => "w3-input input-group", "data-rule-regexp" => "^0*(?:[1-9][0-9]?|100)$", "data-msg-required" => "Invalid Discount Fee"));
                                            echo $form->error($model, 'corporate_discount');
                                            ?> 
                                        </div>
                                        
                                        <div class="col-md-2">
                                            <span>24x7</span>
                                            <?php
                                            if (isset($session['twentyfour'])) {
                                                $model->twentyfour = $session['twentyfour'];
                                            }
                                            echo $form->dropDownList($model, 'twentyfour[]', array("No" => "No", "Yes" => "Yes"), array("class" => "w3-input input-group"));
                                            echo $form->error($model, 'twentyfour');
                                            ?> 
                                        </div>
                                        <div class="clearfix">&nbsp;</div>
                                        <div class="col-md-12 btnaddservice">
                                            <a class="" href="javascript:" onclick="addMoreServices(this);"><i class="fa fa-plus" aria-hidden="true"></i> Add Services </a>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="button-arrow">
                                        <button class="w3-button w3-black w3-display-left" onClick="showPrevSlide('slide1', 'tab_a')" type="button">&#10094;</button>
                                        <button class="w3-button w3-black w3-display-right" onClick="showNextSlide('slide3', 'tab_c')" type="button">&#10095;</button>
                                    </div>
                                </div> <!--end mySlides-->
                                <!-- </form>-->

                            </div> <!--end w3-display-container-->

                        </div> <!--end tab_b id-->
                        <div class="tab-pane" id="tab_c">
                            <div class="w3-content w3-display-container">
                                <div class="mySlides"  id="slide3">
                                    <h3 class="title">Documents / Certificates</h3>
                                    <div class="textdetails">
                                        <div class="col-md-4">
                                            <span>Registration Certificate</span>
                                            <?php
                                            echo $form->fileField($model, 'registraiondoc', array("class" => "w3-input input-group"));
                                            echo $form->error($model, 'registraiondoc');
                                            ?> 
                                        </div>
                                        <div class="col-md-4">
                                            <span>Other Certificate</span>
                                            <?php
                                            echo $form->fileField($model, 'otherdoc', array("class" => "w3-input input-group"));
                                            echo $form->error($model, 'otherdoc');
                                            ?> 
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div><span style="color:red">Please Select png ,gif ,jpg ,pdf ,doc ,docx ,txt Files Only</span></div>
                                    
                                    <div class="form-group clearfix">
                                <input type="checkbox" name="acceptcondition"  class="agree required"/> Agree to Terms & Conditions
                                <p><span id="agree1" class="error1"></span></p>
                                <div class="clearfix"></div>
                            </div> 
                                    
                                    <div class="textdetails text-center">
                                        <?php
                                        echo CHtml::submitButton("Save", array('class' => 'btn'));
                                        ?>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="button-arrow">
                                        <button class="w3-button w3-black w3-display-left" onClick="showPrevSlide('slide2', 'tab_b')" type="button">&#10094;</button>
                                    </div>
                                </div>
                            </div>


                        </div><!--end tab_c id-->

                        <div class="clearfix"></div>  
                    </div><!-- tab content -->

                </div>
                <!-- End Search box -->
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</section>
<!-- end intro section -->
<div class="modal fade" id="myimg" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Profile Image</h4>
            </div>
            <div class="modal-body">

                <div class="col-md-6" style="padding-top:30px;">

                    <br/>
                    <div class="col-md-12 text-center">
                        <div id="upload-demo" style="width:350px"></div>
                    </div>
                    <div class="col-sm-11">
                        <?php echo $form->fileField($model, 'profile_image', array("class" => "", "id" => "upload")); ?>
                    </div>
                    <div class="col-sm-1">
                        <button class="btn btn-success upload-result" data-dismiss="modal">Upload Image</button>
                    </div>
                </div>
                <div class="col-md-6" style="">
                    <div id="upload-demo-i" style="background:#e1e1e1;width:300px;padding:30px;height:300px;margin-top:82px"></div>
                </div>			
            </div>
            <div class="modal-footer text-center" style="border:0px;">

            </div>
        </div>

    </div>
</div>

<link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/croppie.css">
<script src="http://demo.itsolutionstuff.com/plugin/croppie.js"></script>
<script>
                                            $(function () {
                                                
                                                  $(window).keydown(function(e){
    if (e.which == 13) {
        var $targ = $(e.target);

        if (!$targ.is("textarea") && !$targ.is(":button,:submit")) {
            var focusNext = false;
            $(this).find(":input:visible:not([disabled],[readonly]), a").each(function(){
                if (this === e.target) {
                    focusNext = true;
                }
                else if (focusNext){
                    $(this).focus();
                    return false;
                }
            });

            return false;
        }
    }
  });
                                                
                                                $uploadCrop = $('#upload-demo').croppie({
                                                    enableExif: true,
                                                    viewport: {
                                                        width: 200,
                                                        height: 200,
                                                        type: 'circle'
                                                    },
                                                    boundary: {
                                                        width: 300,
                                                        height: 300
                                                    },
                                                    //enableZoom : true

                                                });
                                                $('#upload').on('change', function () {
                                                    var reader = new FileReader();
                                                    reader.onload = function (e) {
                                                        $uploadCrop.croppie('bind', {
                                                            url: e.target.result
                                                        }).then(function () {
                                                            console.log('jQuery bind complete');
                                                        });

                                                    }
                                                    reader.readAsDataURL(this.files[0]);
                                                });

                                                $('.upload-result').on('click', function (ev) {
                                                    $uploadCrop.croppie('result', {
                                                        type: 'canvas',
                                                        size: 'viewport'
                                                    }).then(function (resp) {
                                                        html = '<img src="' + resp + '"/base64 />';
                                                        $("#upload-demo-i").html(html);
                                                        $(".thumbnail").html(html);
                                                        $(".imgname").val(resp);
                                                    });

                                                });
                                            });
                                            function chk_mobile() {

                                                var mobile = $('.mobileclass').val();
                                                if (mobile != "") {
                                                    jQuery.ajax({
                                                        type: 'POST',
                                                        dataType: 'json',
                                                        cache: false,
                                                        url: '<?php echo Yii::app()->createUrl("site/check_Mobile"); ?> ',
                                                        data: {mobile: mobile},
                                                        success: function (data) {
                                                            var dataobj = data.data;

                                                            if (dataobj > 0) {
                                                                var error_msg = 'Mobile No Already Present';
                                                                $("#mobileno").html(error_msg);
                                                            } else {
                                                                $("#mobileno").html('');
                                                            }
                                                        }
                                                    });
                                                }
                                            }

                                            var slideIndex = 1;
                                            showDivs(slideIndex);

                                            function plusDivs(n) {
                                                showDivs(slideIndex += n);
                                            }

                                            function showDivs(n) {
                                                var i;
                                                var x = document.getElementsByClassName("mySlides");
                                                if (n > x.length) {
                                                    slideIndex = 1
                                                }
                                                if (n < 1) {
                                                    slideIndex = x.length
                                                }
                                                for (i = 0; i < x.length; i++) {
                                                    x[i].style.display = "none";
                                                }
                                                x[slideIndex - 1].style.display = "block";
                                            }
                                            function showimg()
                                            {

                                                $('#myimg').modal('show');
                                            }
</script>