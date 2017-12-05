<?php
$baseUrl = Yii::app()->request->baseUrl;

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jquery-ui.min.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery-ui.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/select2.min.js', CClientScript::POS_END);

$searchHospUrl = Yii::app()->createUrl("site/getSearchData");
$searchCityUrl = Yii::app()->createUrl("site/getSearchLocation");

Yii::app()->clientScript->registerScript('offerjavascript', '

');
?>

<div class="section-content">
    <div class="input-group center-bloc " style="padding:25px">
        <div class="col-md-12" style="text-align:center;">
        <a  href="javascript:" onclick="save_promo()" style="color: #0DB7A8;" >Generate Promo Code</a>
        </div><br>
        <div class="col-md-12" style="text-align:center;">
            <input type="text" class="form-control2 promo_code text-center" name="promocode" placeholder="Promo Code"  value="">
            <span id="msg" style="color: red;"></span>
            
        </div>
     
        <div class="clearfix"></div>
    </div>



    <div class="center-block">
        <div class="tab-content" style="padding:inherit">
            <!--tab content-->                                          
            <div role="tabpanel" class="tab-pane active col-md-12" id="tab1" style="margin-top:15px;">                    							
                <div class="form-group clearfix">
                    <div class=" col-sm-12 col-md-4 text-center">
                        <label class=" ">SELECT DATE <span style="display:block"> </span></label>
                        <div class="input-group  date datepick" style="width:250px;margin: 0 auto;">
                            <input class="from promo_date  form-control" name="StartDate" value="" type="text" />
                            <span class="input-group-addon" style="padding: 5px !important;"><i class="glyphicon glyphicon-th"></i></span>
                        </div>
                    </div>    
                    <div class=" col-sm-12 col-md-6 search-col">
                        <label class=" "> </label>
                        <div class="input-group">
                            <div class="input-group-addon" style="padding: 10px !important;">
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                            </div>
                            <input class="form-control" id="search_offer_location" type="text" value="" placeholder="SELECT LOCALITY"  disabled="">
                            <input type="hidden" name="is_city" id="is_offer_city1" value="Y">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="form-group clearfix list_panel" >
                    
                </div>
                <div class='clearfix'> </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<style>
    ul.ui-menu{ z-index: 88888 !important; }
    
    ul { list-style-type: none; }

    .accordion {
      width: 100%;
      background: #FFF;
      -webkit-border-radius: 4px;
      -moz-border-radius: 4px;
      border-radius: 4px;
    }

    .accordion .link {
      cursor: pointer;
      display: block;
      padding:15px 15px 15px 0px;
      color: #4D4D4D;
      font-size: 14px;
      position: relative;
      -webkit-transition: all 0.4s ease;
      -o-transition: all 0.4s ease;
      transition: all 0.4s ease;
    }

    .accordion li:last-child .link { border-bottom: 0; }

    .accordion li i {
      position: absolute;
      top: 16px;
      left: 12px;
      font-size: 18px;
      color: #595959;
      -webkit-transition: all 0.4s ease;
      -o-transition: all 0.4s ease;
      transition: all 0.4s ease;
    }

    .accordion li i.fa-chevron-down {
      right: 12px;
      left: auto;
      font-size: 11px;
      top: 22px;
    }

    .accordion li.open .link { color: #b63b4d; }

    .accordion li.open i { color: #b63b4d; }

    .accordion li.open i.fa-chevron-down {
      -webkit-transform: rotate(180deg);
      -ms-transform: rotate(180deg);
      -o-transform: rotate(180deg);
      transform: rotate(180deg);
    }

    /**
     * Submenu
     -----------------------------*/


    .submenu {
      display: none;
      background: #444359;
      font-size: 14px;
    }
    .submenu a {
      display: block;
      text-decoration: none;
      color: #d9d9d9;
      padding: 12px;
      -webkit-transition: all 0.25s ease;
      -o-transition: all 0.25s ease;
      transition: all 0.25s ease;
    }

    .submenu a:hover {
      background: #b63b4d;
      color: #FFF;
    }
</style>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/bootstrap-datepicker.css" />
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-datepicker.min.js"></script>
<script>
    $(function () {
        var redirect = "<?php Yii::app()->createUrl("site/searchResult", array('speciality' => "replaceparam1", 'location' => "replaceparam2", 'iscity' => "replaceparam3", 'isfree' => "Y")) ?>";

        
        //$( "#search_offer_location" ).autocomplete( "disable" );
        $(".datepick").datepicker({
            autoclose : true,
            format: 'dd-mm-yyyy',
            startDate : "+1d"
        }) .on("changeDate", function(e) {
            // `e` here contains the extra attributes
            $("#search_offer_location").attr("disabled",false);
            $("#search_offer_location").autocomplete({
                //disabled: true,
                autoFocus: true,
                source: function (request, response) {

                    $.getJSON("<?php echo $searchCityUrl ?>", {location1: $("#search_offer_location").val()},
                    response);

                },
                minLength: 0,
                create: function (event, ui) {
                    $("#search_offer_location").autocomplete("enable");

                },
                open: function () {

                    $(".cat-header").removeClass("ui-menu-item");
                    $(".cat-locality").not(":first").remove();
                    $(".cat-header1").removeClass("ui-menu-item");
                    $(".cat-city").not(":first").remove();
                    $(".cat-locationname").not(":first").remove();
                },
                select: function (event, ui) {
                    var is_city = "N";
                    if(ui.item.category == "main_city_name") {
                        is_city= "Y";
                    }
                    $.ajax({
                        //async: false,
                        type: 'POST',
                        cache: false,
                        url: '<?php echo Yii::app()->createUrl("site/dataFromLocation"); ?> ',
                        data: {location: ui.item.value, promo_date : $(".promo_date").val(), is_city :is_city },
                        success: function (result)
                        {
                            $('.list_panel').html(result);
                        }
                    });
                    $("#search_offer_location").val(ui.item.value);

                }
            }).bind("focus", function () {
                $(this).autocomplete("search");
            }) .autocomplete("instance")._renderItem = function (ul, item) {
                //console.log(item.label);
                //console.log(ul);
                var str = "";
                if (item.category == "main_city_name") {
                    str = "<li><a><div class='ui-menu-item-normal'><span class='label-ac'>" + item.label + "</span></div></a></li>";
                } else if (item.category == "area_name") {
                    $("<li data-cat-type=\"toplocality\" class=\"cat-header cat-locality\">").append("<span> Top Localities</span>").appendTo(ul)
                    str = "<li><a><div class='ui-menu-item-normal'><span class='label-ac'>" + item.label + "</span></div></a></li>";
                }
                else if (item.category1 == "city_name") {
                    $("<li data-cat-type=\"toplocality\" class=\"cat-header1 cat-city\">").append("<span> Top Cities</span>").appendTo(ul)
                    str = "<li><a><div class='ui-menu-item-normal'><span class='label-ac'>" + item.label + "</span></div></a></li>";
                }
                return $(str).appendTo(ul);
            }
            
            $("#search_offer_location").autocomplete("search");
        });
        
        var Accordion = function(el, multiple) {
		this.el = el || {};
		this.multiple = multiple || false;

		// Variables privadas
		var links = this.el.find('.link');
		// Evento
		links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown)
	}

	Accordion.prototype.dropdown = function(e) {
            console.log("test");
		var $el = e.data.el;
			$this = $(this),
			$next = $this.next();

		$next.slideToggle();
		$this.parent().toggleClass('open');

		if (!e.data.multiple) {
			$el.find('.submenu').not($next).slideUp().parent().removeClass('open');
		};
	}	

	var accordion = new Accordion($('#accordion'), false);

    });
    function toggleSubmenu(){
        $(".submenu").slideToggle();
    }
//    function get_doctorList(){
//     var city= $('#search_offer_location').val();
//     window.location.href = 'site/searchResult&speciality=Dentist&location='+city+'&iscity=Y';
//    }


    function data_from_location() {
        var city = $('#search_offer_location').val();



<?php //echo Yii::app()->createUrl("site/searchResult&speciality=Dentist&location=Vadgaon Bk&iscity=Y");   ?>
    }

    function save_promo() {
        $.ajax({
            type: 'POST',
            cache: false,
            url: '<?php echo Yii::app()->createUrl("site/savePromoCode"); ?> ',
            
            success: function (data)
            {
                if (data != '') {
                    $('.promo_code').val(data);
                }
            }
        });


    }
</script>
