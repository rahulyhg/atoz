<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$latLogStr = "";
$address = "";
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.infinitescroll.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.ba-bbq.js', CClientScript::POS_END);
?>

<section class="section-patch container-fuild" style=" background-color:#788598;border-bottom: 1px solid #ededed;">
    <div class="ambulance-note text-center">
        <h5><img src="images/icons/ambulance.png" width="64"> &nbsp; Ambulance </h5>
    </div>
    <div class="overlay">
        <div class="row">
            <div class=" container">
            <div class="col-md-12 appointment-button text-right">
                <?php
                $form1 = $this->beginWidget('CActiveForm', array(
                    'action' => array('site/ambulanceList'),
                    'method' => 'get',
                    'id' => 'ambulancesearch'
                ));
                ?>
                <?php
                $sortarray = array();
                $sortarray = array("AirAmbulance" => "Air Ambulance", "Trauma" => "Trauma", "cardiac" => "cardiac", "pediatric" => "pediatric", "basic life support" => "basic life support", "patient transport" => "patient transport");
                ?>

                <select class="minimal" name="category"  id="sort">
                    <option value="">Select Type</option>
                    <?php
                    foreach ($sortarray as $sorttype => $value) {
                        // print_r($value);
                        echo "<option value='$value' ";
                        if ($category == $value) {
                            echo " selected ";
                        }
                        echo ">$value</option>";
                    }
                    ?>
                </select>
                <input type="text" name="address" class="address" placeholder="Enter address to Serch" value="<?php echo $name ?>">
                <?php
                echo CHtml::submitButton("Search", array('class' => 'btn', 'style' => 'padding:7px 32px'));

                $this->endWidget();
                ?>
            </div>
            </div>
            <!-- 2-column layout -->
            <div class=" container">


                <div class="col-sm-12  location-add">

                    <div id="p-map" style="height: 400px;width: 100%;border:1px solid #533223;"></div>


                </div><!--/.container section-->
            </div>





            <div class=" container">
                <div class="col-sm-12  location-add">

                    <div id="posts">

                        <?php $i = 0; ?>
                        <?php
                        foreach ($posts as $post):
                            $latLogStr .= "['" . $post->hospital_name . "'," . $post->latitude . "," . $post->longitude . ",'" . $post->address . "'],";
                            ?>
                            <div class="col-sm-6">
                                <ul><li class="post"><span>Mr. <?php echo $post->hospital_name; ?></span>
                                        <p>Category : <?php echo $post->company_name; ?>  </p>
                                        <p>Type :  <?php echo $post->type_of_hospital; ?> </p>	
                                        <p>Mobile No. +91 <?php echo $post->mobile; ?> </p>
                                        <p>Address: <?php echo$post->address; ?>  </p>

                                    </li>
                                </ul>
                            </div>


                        <?php endforeach; ?>


                        <?php
                        $this->widget('ext.yiinfinite-scroll.YiinfiniteScroller', array(
                            'contentSelector' => '#posts',
                            'itemSelector' => 'li.post',
                            'loadingText' => 'Loading...',
                            'donetext' => ' end...',
                            'pages' => $pages,
                        ));
                        ?>
                    </div>
                    <input type="hidden" name="offset" value="0" class="offset1">
                </div>
            </div>
        </div>
    </div>
</section>                                        
<?php
if ($latLogStr != "") {
    $latLogStr = trim($latLogStr, ",");
}

Yii::app()->clientScript->registerScript('myjavascript', '
var markers =[' . $latLogStr . '];
var map;
var position;
var count=0;
function initialize() {        
        var bounds = new google.maps.LatLngBounds();
        var mapOptions = {
          
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
          
        for( i = 0; i < markers.length; i++ ) {
            var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
            bounds.extend(position);
            var marker = new google.maps.Marker({
                position: position,
                map: map,
                draggable: true,
                icon: image,
                title:markers[i][3],
            });
            // Allow each marker to have an info window    
            google.maps.event.addListener(marker, "click", (function(marker, i) {
                return function() {
                    infoWindow.setContent(infoWindowContent[i][0]);
                    infoWindow.open(map, marker);
                }
            })(marker, i));
            // Automatically center the map fitting all markers on the screen
            map.fitBounds(bounds);
        }
        // Override our map zoom level once our fitBounds funct ion runs (Make sure it only runs once)
        var boundsListener = google.maps.event.addListener((map), "bounds_changed", function(event) {
            this.setZoom(14);
            google.maps.event.removeListener(boundsListener);
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
    }
    google.maps.event.addDomListener(window, "load", initialize);
', CClientScript::POS_END);
?>
<script type="text/javascript">

//    $(document).ready(function () {
//        $('#sort').on('change', function () {
//            var $form = $(this).closest('form');
//         
//            $("#sort-form").submit();
//        });
//
//    });

    function getambulance()
    {
        $("#ambulancesearch").submit(function () {
            var address = $(".address").val();


        });

    }

</script>



