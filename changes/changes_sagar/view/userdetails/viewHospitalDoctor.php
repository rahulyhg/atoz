<?php
$session = new CHttpSession;
$session->open();
?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyA1vr2RVgKBydJQhSo1LUsP3pUcKh4IFGI"></script>
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

$this->renderPartial('commonAjax');

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
            
            width: "100%",
            multipleWidth: 500
        });
         $(".clinictime").datetimepicker({
                    format: "LT"
                });

     $("#UserDetails_birth_date").datetimepicker({
                sideBySide: true,
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down"
                },
                stepping : 5,
              format:"YYYY-MM-DD",
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
            });'
        , CClientScript::POS_END);
?>
<section class="content-header">

    <h3> <?php echo 'Dr.' . $model->first_name . ' ' . $model->last_name; ?></h3>
    
</section>
 

<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row"><!-- row start-->
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                    <div class="box-header with-border"><!-- box header start -->

                        <div class="text-right"><!--link div-->


                            <?php //echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> Manage Doctor ', array('UserDetails/admindoctor'), array("style" => "color: white;", 'class' => 'btn btn-info')); ?>
                        </div><!--link End-->   


                        <div class="box-body">
                            <div class="text-right clearfix">
    <?php
echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> Manage Doctors ', array('userDetails/manageHospitalDoctor',"param1" => base64_encode($session['user_id'])), array("style" => "color: white;", 'class' => 'btn btn-info'));
?>
</div>
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <span><b> Name</b></span>

                                    <?php echo '<br>' . $model->first_name . ' ' . $model->last_name; ?>
                                </div>

                                <div class="col-sm-4">
                                    <span><b>Gender</b></span>
                                    <?php
                                    if (empty($model->gender)) {
                                        $model->gender = 'Male';
                                    }
                                    echo '<br>' . $model->gender;
                                    ?>
                                </div> 
                                <div class="col-sm-4">
                                    <label class="control-label">Profile Image</label>

                                    <?php
                                    $baseDir = Yii::app()->baseUrl . "/uploads/";
                                    if (!empty($model->profile_image)) {


                                        echo CHtml::image($baseDir . $model->profile_image, "icon_image", array('width' => 75, 'height' => 75, 'class' => 'img-circle'));
                                    }else{
                                   echo CHtml::image(Yii::app()->request->baseUrl . "/images/icons/icon01.png", "Profile Photo", array("class" => "img-circle", "width" => "75"));
                                    
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="clearfix" style="padding:15px"></div>
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <span><b>Date Of Birth</b></span>
                                    <?php
                                    echo '<br>' . $model->birth_date;
                                    ?>
                                </div>  
                                <div class="col-sm-4">
                                    <span><b>Blood Group</b></span>

                                    <?php echo '<br>' . $model->blood_group; ?> 
                                </div>
                                <div class="col-sm-4">
                                    <span><b>Registation Number</b></span> 
                                    <?php
                                    echo '<br>' . $model->doctor_registration_no;
                                    ?>
                                </div>
                            </div>
                            <div class="clearfix" style="padding:15px"></div>
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <span><b>  Specialty</b></span><br>
                                    <?php
                                    $speciality = SpecialityMaster::model()->findAll();
                                    $specialitynameArr = CHtml::listData($speciality, 'speciality_id', 'speciality_name');
                                    $selectedSpecialityArr = Yii::app()->db->createCommand()
                                            ->select('speciality_id')
                                            ->from('az_speciality_user_mapping')
                                            ->where('user_id=:id', array(':id' => $model->user_id))
                                            ->queryColumn();

                                    foreach ($specialitynameArr as $specialityid => $speciality) {

                                        if (in_array($specialityid, $selectedSpecialityArr)) {
                                            echo $speciality.', ';
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="col-md-4">
                                    <span><b>Sub-Specialty</b></span><br>
                                    <?php
                                    $specStr = 0;
                                    if (!empty($selectedSpecialityArr))
                                        $specStr = implode(',', $selectedSpecialityArr);
                                    $Criteria = new CDbCriteria();
                                    $Criteria->condition = "speciality_id in($specStr)";

                                    $subspeciality = SubSpeciality::model()->findAll($Criteria);
                                    $subspecialitynameArr = CHtml::listData($subspeciality, 'sub_speciality_id', 'sub_speciality_name');


                                    $sub_speciality = $model->sub_speciality;
                                    $selectedSubSpecialityArr = explode(",", $sub_speciality);

                                    foreach ($subspecialitynameArr as $specialityid => $speciality) {
                                        if (in_array($speciality, $selectedSubSpecialityArr)) {
                                            echo $speciality.',';
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="col-sm-4">
                                    <span><b> Add Degree</b> </span><br>
                                    <?php
                                    $degree = DegreeMaster::model()->findAll();
                                    $degreenameArr = CHtml::listData($degree, 'degree_id', 'degree_name');
                                    $selectedDegreeArr = Yii::app()->db->createCommand()
                                            ->select('degree_id')
                                            ->from('az_doctor_degree_mapping')
                                            ->where('doctor_id=:id', array(':id' => $model->user_id))
                                            ->queryColumn();

                                    foreach ($degreenameArr as $degreeid => $degree) {
                                        if (in_array($degreeid, $selectedDegreeArr)) {
                                            echo $degree . ' ,';
                                        }
                                    }
                                    ?>
                                   </div>
                            </div>

                            <div class="clearfix" style="padding:15px"></div>

                            <div class="col-sm-4">
                                <span><b>Appointment Contact No 1.</b></span>
                                    <?php echo '<br>' . $model->apt_contact_no_1; ?>
                                <div class="clearfix">&nbsp;</div>
                                <span><b>Appointment Contact No 2.</b></span>
                                    <?php echo '<br>' . $model->apt_contact_no_2; ?>
                            </div>
                            <div class="col-sm-4">
                                <span><b>Email 1.</b></span>
                                    <?php echo '<br>' . $model->email_1 ?>
                                <div class="clearfix">&nbsp;</div>
                                <span><b>Email 2.</b></span>
                                    <?php echo '<br>' . $model->email_2; ?>
                            </div>
                            <div class="clearfix" style="padding:15px"></div>
                            <div class="col-md-12">
                                <h4 class="box-title">About You</h4>
                            </div>  
                            <div class="col-sm-4">
                                <?php  echo '<br>' .$model->description;  ?>
                            </div>

                            <div class="clearfix" style="padding:15px"></div>
                            <div class="col-md-12">
                                <h4 class="box-title">Location</h4>
                            </div>  
                            <div class="col-md-4">
                                <span><b>Zip Code</b></span>
                                    <?php  echo '<br>'.$model->pincode;    ?>
                            </div> 
                            <div class="col-md-4">
                                <span><b>State</b></span>
                                <?php  echo '<br>' .$model->state_name;?>   

                            </div>
                            <div class="col-md-4">
                                <span><b>City</b></span>
                                <?php echo '<br>' .$model->city_name; ?>

                            </div>
                            <div class="col-md-4">
                                <span><b>Area</b></span>
                                <?php   echo '<br>' .$model->area_name; ?>   

                            </div>
                            <div class="col-md-4">
                                <span><b>Landmark</b></span>
                                <?php   echo '<br>' .$model->landmark;  ?>
                            </div>  
                            <div class="col-sm-4">
                                <b><span>Address</span></b>  
                                <?php   echo '<br>' .$model->address;   ?>
                            </div>
                        </div>

                        <div class="textdetails">
                            <h4 class="title-details">Timings</h4>
                            <div class="col-md-12" style=""> 
                                <?php
                                $alldaychecked = "";
                                if ($model2->alldayopen == 'Y') {
                                    $alldaychecked = " checked ";
                                }
                                ?>

                                <label><input  type="checkbox" name="ClinicDetails[alldayopen]" value="Y" onclick="isalldayopen(this)" class="isall" <?php echo $alldaychecked; ?>> 24x7</label>



                            </div>
                                    <?php
                                   // echo $userid;
                                    $dayarr = array("Monday" => "Monday", "Tuesday" => "Tuesday", "Wednesday" => "Wednesday", "Thursday" => "Thursday", "Friday" => "Friday", "Saturday" => "Saturday", "Sunday" => "Sunday");
                                    $userSelectedDay = array();
                                    $uservisit = Yii::app()->db->createCommand()
                                            ->select('clinic_id,day,clinic_open_time,clinic_close_time,clinic_eve_open_time,clinic_eve_close_time')
                                            ->from('az_clinic_visiting_details ')
                                            ->where('doctor_id=:id', array(':id' => $userid))
                                            ->queryAll();
                                  // echo'<pre>'; print_r($uservisit);echo'</pre>';
                                    foreach ($uservisit as $row) {
                                        $userSelectedDay[$row['day']] = array('clinic_open_time' => $row['clinic_open_time'], 'clinic_close_time' => $row['clinic_close_time'], 'clinic_eve_open_time' => $row['clinic_eve_open_time'], 'clinic_eve_close_time' => $row['clinic_eve_close_time']);
                                    }
                                //    print_r($userSelectedDay);
                                    ?>
                            <div class="col-md-12 day" style="">
                                <ul class="list-inline timing-list">
                            <?php
                            foreach ($dayarr as $key => $value) {

                                $check = '';
                                $hiddenField = '';
                                if (array_key_exists($key, $userSelectedDay)) {
                                    $check = 'checked';
                                       if(empty($userSelectedDay[$value]['clinic_open_time'])){
                                       $userSelectedDay[$value]['clinic_open_time'] = NULL; 
                                    }else{
                                        $userSelectedDay[$value]['clinic_open_time'] = date("h:i A", strtotime($userSelectedDay[$key]['clinic_open_time']));
                                    }
                                    if(empty($userSelectedDay[$value]['clinic_close_time'])){
                                       $userSelectedDay[$value]['clinic_close_time'] = NULL; 
                                     }else{
                                        $userSelectedDay[$value]['clinic_close_time'] = date("h:i A", strtotime($userSelectedDay[$key]['clinic_close_time']));
                                    }
                                    if(empty($userSelectedDay[$value]['clinic_eve_open_time'])){
                                       $userSelectedDay[$value]['clinic_eve_open_time'] = NULL; 
                                    }else{
                                        $userSelectedDay[$value]['clinic_eve_open_time'] = date("h:i A", strtotime($userSelectedDay[$key]['clinic_eve_open_time']));
                                    }
                                    if(empty($userSelectedDay[$value]['clinic_eve_close_time'])){
                                       $userSelectedDay[$value]['clinic_eve_close_time'] = NULL; 
                                     }else{
                                        $userSelectedDay[$value]['clinic_eve_close_time'] = date("h:i A", strtotime($userSelectedDay[$key]['clinic_eve_close_time']));
                                    }
                                    
                                    
                                    $hiddenField = '<span>Mon: ' . $userSelectedDay[$value]['clinic_open_time'] . '- ' . $userSelectedDay[$value]['clinic_close_time'] . '<br>Eve:' . ($userSelectedDay[$value]['clinic_eve_open_time']) . ' - ' . ($userSelectedDay[$value]['clinic_eve_close_time']) . '</span>';
                                    
                                }
                                $disabled = "";
                                if (!empty($alldaychecked)) {
                                    $disabled = " disabled ";
                                }
                               
                                 if (!empty($hiddenField)) {
                                                                echo '<li id="$key" class="weekday"> ' . $value . '<br> &nbsp;' . $hiddenField . '</li>';
                                                            } else {
                                                                echo '<li id="$key" class="weekday"> ' . $value . '<br><br> &nbsp;&nbsp;' . $hiddenField . '</li>';
                                                            }
                            }
                            ?>

                                </ul>

                            </div>
                                   

                        </div>

                        <div class="clearfix"></div>
                           
                       


                    </div><!-- box header end -->

                </div><!-- box end -->
            </div> <!-- column col-lg-12 end -->
        </div><!--row end-->
    </section> <!-- section content End -->
</div><!-- tab-content end-->
<script type="text/javascript">
var pinarray = [];
var dayhtml;
$(function () {
    $(".speciality-class").change(function () {
        getSubSpeciality();
    });
    // $('.contact_no_2').hide();
    $(".countryId").change(function () {
        var country = 1;
        // alert(country);
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
    $.validator.addMethod(
            "regexp",
            function (value, element, regexp) {
                var re = new RegExp(regexp);
                return this.optional(element) || re.test(value);
            },
            "Please check your input."
            );
    $("#update-doctor-details-form").validate({
        rules: {
            "UserDetails[first_name]": {
                required: true,
                maxlength: 50,
                regexp: /^[a-zA-Z]+$/,
            }, "UserDetails[last_name]": {
                required: true,
                maxlength: 50,
                regexp: /^[a-zA-Z]+$/,
            },
            "UserDetails[mobile]": {
                required: true,
                maxlength: 10,
                regexp: /^[7-9]{1}[0-9]{9}$/,
            },
            "UserDetails[apt_contact_no_1]": {
                required: true,
               // maxlength: 30,
                regexp: /^[7-9]{1}[0-9]{9,29}$/,
            },
            "UserDetails[apt_contact_no_2]": {
               // maxlength: 30,
                regexp: /^[7-9]{1}[0-9]{9,29}$/,
            },
            "UserDetails[email_1]": {
                required: true,
                email: true,
                regexp: /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/,
                maxlength: 100
            },
            "UserDetails[email_2]": {
                email: true,
                regexp: /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/,
                maxlength: 100
            },
            "UserDetails[country_id]": {
                required: true
            },
            "UserDetails[state_id]": {
                required: true
            },
            "UserDetails[city_id]": {
                required: true
            },
            "UserDetails[area_id]": {
                required: true
            },
            "UserDetails[pincode]": {
                required: true,
                maxlength: 6,
                // regexp: /^[1-9]{1}[0-9]{5}$/
            },
            "UserDetails[description]": {
                required: true,
                maxlength: 250,
                regexp: /^[a-zA-Z0-9_,.'/\n/ ]*$/},
        },
        // Specify the validation error messages
        messages: {
            "UserDetails[first_name]": {
                required: "Please Enter First Name",
                regexp: "Invalid First Name"
            },
            "UserDetails[last_name]": {
                required: "Please Enter Last Name",
                regexp: "Invalid Last Name"
            },
            "UserDetails[apt_contact_no_1]": {
                required: "Please Select Appointment Contact No",
                regexp: "Invalid  Appointment Contact No",
                maxlength: "Invalid  Appointment Contact No"
            },
            "UserDetails[apt_contact_no_2]": {
                regexp: "Invalid  Appointment Contact No",
                maxlength: "Invalid  Appointment Contact No"
            },
            "UserDetails[mobile]": {
                required: "Please Select Mobile Number",
                regexp: "Invalid Mobile Number",
                maxlength: "Invalid Mobile Number"
            },
            "UserDetails[email_1]": {
                maxlength: "Invalid Email-address",
                regexp: "Invalid Email-address",
                required: "Please Enter Email-ID",
                email: "Invalid Email-ID"},
            "UserDetails[email_2]": {
                maxlength: "Invalid Email-address",
                regexp: "Invalid Email-address",
                required: "Please Enter Email-ID",
                email: "Invalid Email-ID"},
            "UserDetails[country_id]": {
                required: "Please select Country",
            },
            "UserDetails[state_id]": {
                required: "Please select State",
            },
            "UserDetails[city_id]": {
                required: "Please select City",
            },
            "UserDetails[area_id]": {
                required: "Please select Area",
            },
            "UserDetails[pincode]": {
                required: "Please Enter Pincode",
                //regexp: "Invalid Pincode",
            },
            "UserDetails[description]": {
                required: "Please Enter About Yourself",
                regexp: "Invalid description",
            },
        }
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
function clinic_time() {
    var open_time = $('.open_time').val();
    var close_time = $('.close_time').val();
    var eve_open_time = $('.eve_open_time').val();
    var eve_close_time = $('.eve_close_time').val();
    var hiddenhtml = "";
    hiddenhtml = "<span ><input type='hidden'  name='ClinicVisitingDetails[clinic_open_time][]' value='" + open_time + "' class='clinic_open_time'><input type='hidden'  name='ClinicVisitingDetails[clinic_close_time][]' value='" + close_time + "' class='clinic_close_time'><input type='hidden'  name='ClinicVisitingDetails[clinic_eve_open_time][]' value='" + eve_open_time + "' class='clinic_eve_open_time'><input type='hidden'  name='ClinicVisitingDetails[clinic_eve_close_time][]' value='" + eve_close_time + "' class='clinic_eve_close_time'></span><div class='timing-list timeing'>Mon:" + open_time + " - " + close_time + "<br>Evn:" + eve_open_time + " - " + eve_close_time + "</div><br>"
    $(dayhtml).closest(".weekday").find('.day').before(hiddenhtml);


}

function contactshow(htmlobj, currentHtml)
{
    $(htmlobj).show();
    $(currentHtml).hide();
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
    var pincode = pinarray[area1];                                             //  alert(pincode);
    // alert(area1);
    //alert(pincode);
    $(".pincode-id-class").val(pincode);
}
    function initialize() {  

if (jQuery("#UserDetails_address").length > 0) {
var input = document.getElementById("UserDetails_address");
var autocomplete = new google.maps.places.Autocomplete(input);
google.maps.event.addListener(autocomplete, "place_changed", function () {
var place = autocomplete.getPlace();

});
}
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
function showimg()
{

$('#myimg').modal('show');
}
function uncheckday()
{
    var day = $(".day:checked").val();
    $('input:checkbox[value="' + day + '"]').attr('checked', false);
}

</script>



