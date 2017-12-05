<?php
$baseUrl = Yii::app()->request->baseUrl;
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jquery-ui.min.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery-ui.js', CClientScript::POS_END);

$searchHospUrl = Yii::app()->createUrl("site/getSearchData");
$searchCityUrl= Yii::app()->createUrl("site/getSearchLocation");

Yii::app()->clientScript->registerScript('myjavascript', '
    
if (jQuery.isFunction(jQuery.fn.select2)) { 
        jQuery("#location-hospital").select2({ placeholder: "Enter Speciality", allowClear: true });
    }
    //var redirect = "'.Yii::app()->createUrl("site/SearchCityHospital", array('speciality' => "replaceparam1", 'll' => "replaceparam2")). '";
    var redirect = "'.Yii::app()->createUrl("site/searchResult", array('speciality' => "replaceparam1", 'location' => "replaceparam2", 'iscity' => "replaceparam3")). '";
    var redirectservice = "'.Yii::app()->createUrl("site/PathologyList", array('role' => "replaceparam1")). '";
    var redirectHospitalList = "'.Yii::app()->createUrl("site/HospitalList"). '";
	var baseUrl = "'.$baseUrl.'/uploads/";
    var results = [];
    var index = 0;
   
    var detailsPageUrl = "'.Yii::app()->createUrl("site/details", array('param1' => "replaceparam",'param2' => "replaceparam2")).'";
        
var detailsPageUrl1 = "'.Yii::app()->createUrl("site/detailsOther", array('param1' => "replaceparam",'param2' => "replaceparam2")).'";
    
  $( "#search_location" ).autocomplete({
        disabled: true,
        source: function(request, response) {
                $.getJSON("' . $searchCityUrl . '", { location1: $("#search_location").val()}, 
                      response   );
                      
        },
        minLength:0,
        create: function( event, ui ) {
           $(  "#search_location" ).autocomplete( "enable" );
           
        },
        open: function (){
            $(".cat-header").removeClass("ui-menu-item");
            $(".cat-locality").not(":first").remove();
            $(".cat-locationname").not(":first").remove();
        },
        select: function(event, ui) {
            //console.log(ui.item[\'area_name\']);
             //event.preventDefault();
            $("#search_location").val(ui.item.value);
            if(ui.item.category == "main_city_name") {
                $("#is_city").val("Y");
                 console.log("location4");
            }else{
                $("#is_city").val("N");
            }
        }
    })
    .bind("focus", function(){ $(this).autocomplete("search"); } )
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
        //console.log("autocomplete");
        var str = "";
        if(item.category == "main_city_name"){
            str = "<li><a><div class=\'ui-menu-item-normal\'><span class=\'label-ac\'>" + item.label + "</span></div></a></li>";
        }else if(item.category == "area_name"){
            $("<li data-cat-type=\"toplocality\" class=\"cat-header cat-locality\">").append("<span> Top Localities</span>").appendTo(ul)
            str = "<li><a><div class=\'ui-menu-item-normal\'><span class=\'label-ac\'>" + item.label + "</span></div></a></li>";
        }
        return $( str )
            .appendTo( ul );
    };

    
    $( "#search_hospital" ).autocomplete({
        disabled: true,
        source: function(request, response) {
            $.getJSON("'.$searchHospUrl.'", { location: $("#search_location").val(), term : $("#search_hospital").val(), is_city : $("#is_city").val() }, 
                      response);
                       
        },
        minLength:0,
        create: function( event, ui ) {
           
            $(  "#search_hospital" ).autocomplete( "enable" );
            
        },
        open: function (){
            $(".cat-header").removeClass("ui-menu-item");
            $(".cat-hospital").not(":first").remove();
            $(".cat-doctor").not(":first").remove();
            $(".cat-pathology").not(":first").remove();
            $(".cat-diagnostic").not(":first").remove();
            $(".cat-BloodBank").not(":first").remove();
            $(".cat-MedicalStore").not(":first").remove();
            
        },
        select: function(event, ui) {
           
            if(ui.item.category == "speciality") { //goes to listing page
                var str = redirect.replace("replaceparam1", ui.item.value);
                str = str.replace("replaceparam2", $("#search_location").val());
                str = str.replace("replaceparam3", $("#is_city").val());
                window.location.href = str;
            }else if(ui.item.category == "service") { //goes to listing page
                var str = redirectservice.replace("replaceparam1", ui.item.value);
                window.location.href = str;
            }else if(ui.item.category == "type") { //goes to hospital listing page
                window.location.href = redirectHospitalList;
            }else{                                                              //goes to details page
               var str;
                $.ajax({
                    type: "POST",
                    dataType : "json",
                    url: "'.Yii::app()->createUrl("site/getInfoDoctor").'",
                    data: {"userid": ui.item.user, "clinic" :ui.item.clinic_id },
                    success: function (result) {
                     
                     
                    if(ui.item.category == "hospital" || ui.item.category == "doctor" ){
                        str = detailsPageUrl.replace("replaceparam", result.id);
                        str = str.replace("replaceparam2", result.clinicid);
                        }else{
                       
                        str = detailsPageUrl1.replace("replaceparam", result.id);
                        str = str.replace("replaceparam2", ui.item.role);
                        
                       }
                      
                        window.location.href = str;
                    }
                });
            } //goes to details page end here
        }
    })
    .bind("focus", function(){ $(this).autocomplete("search"); } )
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
        var str = "";
        if(item.category == "hospital") {
            //str = "<li class=\"cat-header\"><span>Hospitals</span></li>";
            $("<li data-cat-type=\"Hospitals\" class=\"cat-header cat-hospital\">").append("<span> Hospitals</span>").appendTo(ul)
            str += "<li><a><div class=\'result-img\'><img src=\'"+baseUrl+"/"+item.img+"\'/></div><div class=\'result-details\'><div>" + item.label + "</div><div class=\'result-meta-data\'>" + item.cityname + "</div></div><div style=\"clear:both;\"> </div></a></li>";
        }else if(item.category == "doctor") {
            $("<li data-cat-type=\"Doctors\" class=\"cat-header cat-doctor\">").append("<span> Doctors</span>").appendTo(ul)
            str += "<li><a><div class=\'result-img\'><img src=\'"+baseUrl+"/"+item.img+"\'/></div><div class=\'result-details\'><div>" + item.label + "</div><div class=\'result-meta-data\'>" + item.docspecial + "</div></div><div style=\"clear:both;\"> </div></a></li>";
        }else if(item.category == "pathology") {
            $("<li data-cat-type=\"Pathology\" class=\"cat-header cat-pathology\">").append("<span> Pathology</span>").appendTo(ul)
            str += "<li><a><div class=\'result-img\'><img src=\'"+baseUrl+"/"+item.img+"\'/></div><div class=\'result-details\'><div>" + item.label + "</div><div class=\'result-meta-data\'>" + item.cityname + "</div></div><div style=\"clear:both;\"> </div></a></li>";
        }else if(item.category == "diagnostic") {
            $("<li data-cat-type=\"Diagnostic\" class=\"cat-header cat-diagnostic\">").append("<span> Diagnostic</span>").appendTo(ul)
            str += "<li><a><div class=\'result-img\'><img src=\'"+baseUrl+"/"+item.img+"\'/></div><div class=\'result-details\'><div>" + item.label + "</div><div class=\'result-meta-data\'>" + item.cityname + "</div></div><div style=\"clear:both;\"> </div></a></li>";
        }else if(item.category == "Blood Bank") {
            $("<li data-cat-type=\"Blood Bank\" class=\"cat-header cat-BloodBank\">").append("<span> Blood Bank</span>").appendTo(ul)
            str += "<li><a><div class=\'result-img\'><img src=\'"+baseUrl+"/"+item.img+"\'/></div><div class=\'result-details\'><div>" + item.label + "</div><div class=\'result-meta-data\'>" + item.cityname + "</div></div><div style=\"clear:both;\"> </div></a></li>";
        }else if(item.category == "Medical Store") {
            $("<li data-cat-type=\"Medical Store\" class=\"cat-header cat-MedicalStore\">").append("<span> Medical Store</span>").appendTo(ul)
            str += "<li><a><div class=\'result-img\'><img src=\'"+baseUrl+"/"+item.img+"\'/></div><div class=\'result-details\'><div>" + item.label + "</div><div class=\'result-meta-data\'>" + item.cityname + "</div></div><div style=\"clear:both;\"> </div></a></li>";
        }else if(item.category == "service") {
            str = "<li><a><div class=\'ui-menu-item-normal\'><span class=\'label-ac\'>" + item.label + "</span><span class=\'keyword-type\'>SERVICE</span></div></a></li>";
        }else if(item.category == "type") {
            str = "<li><a><div class=\'ui-menu-item-normal\'><span class=\'label-ac\'>" + item.label + "</span><span class=\'keyword-type\'>TYPE</span></div></a></li>";
        }else{
            str = "<li><a><div class=\'ui-menu-item-normal\'><span class=\'label-ac\'>" + item.label + "</span><span class=\'keyword-type\'>SPECIALITY</span></div></a></li>";
        }
        return $( str )
        .appendTo( ul );
    };
    $(".btn-search").click(function(){
        $("#search_hospital").autocomplete("search");
       
    });
       ', CClientScript::POS_END);

?>
<div class="row search-bar">
    <div class="advanced-search">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'search-form',
            'enableAjaxValidation' => false,
            'action' => CController::createUrl("site/searchResult"),
            'method' => "get",
            'htmlOptions' => array(),
        ));
        $purifiedObj = Yii::app()->purifier;
        $userId = Yii::app()->user->id;
        ?>
        <div class="col-md-4 col-sm-6 search-col">
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                </div>
                <input class="form-control" id="search_location" type="text" value="" placeholder="SELECT LOCALITY">
                <input type="hidden" name="is_city" id="is_city" value="Y">
            </div>

        </div>
        <div class="col-md-6 col-sm-6 search-col">
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </div>
                <input class="form-control" name="speciality" id="search_hospital" type="text" value="" placeholder="TYPE TO START SEARCHING SPECIALIST OR HOSPITALS" >

            </div>
            <div class="doctorsearch" style="position: absolute;">

            </div>
        </div>
        <div class="col-md-2 col-sm-6 search-col">
            <button class="btn btn-search btn-block" style="color: rgba(63, 70, 74, 0.71);background: #FFF;" type="button"><strong>Search</strong></button>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>