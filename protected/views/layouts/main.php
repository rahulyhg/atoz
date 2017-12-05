<?php
$baseUrl = Yii::app()->request->baseUrl;
$session = new CHttpSession;
$session->open();
$roleid = $session['user_role_id'];
$username = ucwords(strtolower($session['user_fullname'])) ;
$hosname = ucwords(strtolower($session["hospital_name"])) ;
//echo $hosname.'hiiiii';
//print_r($session["hospital_name"]);
?>    
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">    
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <meta name="author" content="Clasified">
        <meta name="description" content="AtoZ is online healthcare portal.">
        <meta name="keywords" content="Medical, Healthcare, Hospital"><!-- Add some Keywords based on your Company and your business and separate them by comma -->
        <title>A-Z Health+ </title>    
        <!-- Favicon -->
        <link rel="shortcut icon" href="<?=$baseUrl; ?>/images/favicon.PNG">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="<?=$baseUrl; ?>/css/bootstrap.min.css" type="text/css">    
       
        <!-- Font Awesome CSS -->
        <link rel="stylesheet" href="<?=$baseUrl; ?>/css/font-awesome.min.css" type="text/css">
        <!-- Line Icons CSS -->
        <link rel="stylesheet" href="<?=$baseUrl; ?>/fonts/line-icons/line-icons.css" type="text/css">
        <!-- Line Icons CSS -->
        <link rel="stylesheet" href="<?=$baseUrl; ?>/fonts/line-icons/line-icons.css" type="text/css">
        <!-- Main Styles -->
        <link rel="stylesheet" href="<?=$baseUrl; ?>/css/main.css" type="text/css">
        <!-- Animate CSS -->
        <link rel="stylesheet" href="<?=$baseUrl; ?>/extras/animate.css" type="text/css">
           
        <!-- Responsive CSS Styles -->
        <link rel="stylesheet" href="<?=$baseUrl; ?>/css/responsive.css" type="text/css">
        <!-- Slicknav js -->
        <link rel="stylesheet" href="<?=$baseUrl; ?>/css/slicknav.css" type="text/css">
        <!-- Bootstrap Select -->
        <link rel="stylesheet" href="<?=$baseUrl; ?>/css/bootstrap-select.min.css">

        <script type="text/javascript" src="<?=$baseUrl; ?>/js/jquery-2.2.3.min.js"></script>
    </head>
    <body class="">
        <header id="main-header">
            <!-- Header Section Start -->
            <div class="header">    
                <nav class="navbar navbar-default main-navigation" role="navigation">
                    <div class="container">
                        <div class="navbar-header">
                            <!-- Stat Toggle Nav Link For Mobiles -->
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <!-- End Toggle Nav Link For Mobiles -->
                            <a class="navbar-brand logo" href="<?=  Yii::app()->createUrl("site/index"); ?>"><img src="<?=$baseUrl; ?>/images/logo.png" alt=""></a>
                        </div>
                        <div class="pull-right">
                        <!-- brand and toggle menu for mobile End -->
                        <div class="postadd text-right" id="">
                            
                            
                            <a class="btn theme-color btn-post pull-right" href="<?=  Yii::app()->createUrl("pages/emergency"); ?>">EMERGENCY <span class="">&nbsp;</span></a>
                            <div class="offeramt pull-right">UPTO 50%</div>
                            <div class="btn-post pull-right" style="text-align: justify;font-size: 10px;line-height: 1.4;margin-top: 7px;">SAVING IN YOUR<br> HOSPITAL BILLS</div>
<!--                            <div class="clearfix">&nbsp;</div>-->
                        </div>
                        <!-- Navbar Start -->
                        <div class="collapse navbar-collapse clearfix" id="navbar">
                                <ul class="nav navbar-nav navbar-right">
                                    <li><a href="#"><img src="<?= $baseUrl; ?>/images/icons/app.png"/> Download the App</a></li>
<!--                                    <li><a href="<?php //echo Yii::app()->createUrl("pages/commingsoon"); ?>"><img src="<?= $baseUrl; ?>/images/icons/discount.png"/> Deals & Offers </a></li>-->

                                    <?php if ($roleid == 3) {
                                        ?>
                                        <li>
                                            <?php echo CHtml::link("<img src='$baseUrl/images/icons/sign-in.png'/> $username", array("site/docViewAppointment"), array("class" => "")); ?>
                                        </li> 
                                    <?php } ?>
                                    <?php if ($roleid == 4 ) {
                                        ?>
                                        <li>
                                            <?php echo CHtml::link("<img src='$baseUrl/images/icons/sign-in.png'/> $username", array("userDetails/patientAppointments"), array("class" => "")); ?>
                                        </li> 
                                    <?php } ?>
                                    <?php if ($roleid == 5) {
                                        ?>
                                        <li>
                                            <?php echo CHtml::link("<img src='$baseUrl/images/icons/sign-in.png'/> $hosname", array("site/hosViewAppointment"), array("class" => "")); ?>
                                        </li> 
                                    <?php } ?>
                                    <?php if ($roleid == 6 || $roleid == 7 || $roleid == 8 || $roleid == 9) {
                                        ?>
                                        <li>
                                            <?php echo CHtml::link("<img src='$baseUrl/images/icons/sign-in.png'/> $hosname", array("site/labViewAppointment", "roleid" => $roleid)); ?>
                                        </li> 
                                    <?php } ?>
                                         <?php if ($roleid == 11 ) {
                                        ?>
                                        <li>
                                            <?php echo CHtml::link("<img src='$baseUrl/images/icons/sign-in.png'/> $username", array("userDetails/corporateList"), array("class" => "")); ?>
                                        </li> 
                                    <?php } ?>

                                    <?php if (!Yii::app()->user->isGuest) { ?>
                                        <li>
                                            <?php echo CHtml::link("<img src='$baseUrl/images/icons/sign-in.png'/> Logout", array("site/logout"), array("class" => "")); ?>
                                        </li>
                                    <?php } else { ?>
                                        <li>
                                            <?php echo CHtml::link("<img src='$baseUrl/images/icons/sign-in.png'/> Log in/Sign up ", array("site/login"), array("class" => "", "data-toggle" => "modal", "data-target" => "#myModal","onclick"=>"$('.error-div').hide();$('.login_error').html('')")); ?>   
                                        </li>
                                    <?php } ?>

                                </ul>
                            </div>
                        <!-- Navbar End -->
                    </div>
                        <div class="clearfix">&nbsp;</div>
                    </div>
                </nav>

            </div>
            <!-- Header Section End -->
        </header>
        
        <?php echo $content; ?>
        <div class="">
            <div class="modal fade bs-example-modal-lg" id="myModal" role="dialog">
              <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                </div>
              </div>
            </div>

        </div>

        <!-- Footer Section Start -->
        <footer>
            <!-- Footer Area Start -->
            <section class="footer-Content">
                <div class="container">
                    <div class="row wow fadeInUp" data-wow-delay="0.3s">
                        <div class="col-sm-12 col-md-9 " >
                            <ul class="list-inline sideborder">
                                <li><a href="<?php echo Yii::app()->createUrl("pages/whatwedo");?>"><strong>What We Do</strong></a></li>
                                <li><a href="<?php echo Yii::app()->createUrl("pages/innovativetechnique");?>"><strong>Innovative Techniques</strong></a></li>
                                <li><a href="<?php echo Yii::app()->createUrl("pages/services");?>"><strong>Services</strong></a></li>
                                <li><a href="<?php echo Yii::app()->createUrl("pages/career");?>"><strong>Careers</strong></a></li>
                                <li><a href="<?php echo Yii::app()->createUrl("pages/about");?>"><strong>About Us</strong></a></li>
                                <li class="lastelement" style="border:none"><a href="<?php echo Yii::app()->createUrl("pages/contact");?>"><strong>Contact Us</strong></a></li>
                            </ul>
                        </div>
                        <div class="col-sm-12  col-md-3 "  >
                            <a href="#"><img src="<?=$baseUrl; ?>/images/icons/facebook.PNG" width="40"></a>
                            <a href="#"><img src="<?=$baseUrl; ?>/images/icons/google-plus.PNG" width="40"></a>
                            <a href="#"><img src="<?=$baseUrl; ?>/images/icons/linketin.PNG" width="40"></a>
                            <a href="#"><img src="<?=$baseUrl; ?>/images/icons/twitter.PNG" width="40"></a>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-12 col-md-9" >
                            <p>A UNIQUE & INSPIRED SOLUTION THAT WILL TRIGGER A HEALTHCARE REVOLUTION </p>
                            <p>The Game-changer in India's Healthcare Services </p>
                            <p>Empowering Healthcare Consumers through Technology, Innovation & Social Service</p>
                            <br>
                            <p>A2Z HEALTH+ is on a deeply inspired social mission to align healthcare services to the needs and concerns of consumers; we aim to transform it into a patient-focused system that responds to their requirements with speed and reliability.</p><br>
                            <p class="footer-top" style="color:#0db7a8"> An ISO 9001:2015 Certified Company </p>
                            <p>Recognized by DIPP, Ministry of Commerce and Industry, Goverment of India. </p><br>
                        </div>
                        <div class="col-sm-12 col-md-9">
                            <ul class="list-inline">
                                <li><a href="#"><strong>Listing Policy</strong></a></li>
                                <li><a href="#"><strong>Terms of Use</strong></a></li>
                                <li><a href="#"><strong>Privacy Policy</strong></a></li>
                                <li><a href="#"><strong>*T&amp;C apply</strong></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </footer>
        <!--Scroll to top-->
        <div class="scroll-to-top scroll-to-target" data-target="#main-header"><span class="icon fa fa-long-arrow-up"></span></div>

        <!-- Footer Section End -->
<!--        <script type="text/javascript" src="<?=$baseUrl; ?>/js/jquery-1.11.1.min.js"></script>-->
        <script type="text/javascript" src="<?=$baseUrl; ?>/js/bootstrap.min.js"></script>
<!--        <script type="text/javascript" src="js/material.min.js"></script>
        <script type="text/javascript" src="js/material-kit.js"></script>
        <script type="text/javascript" src="js/jquery.parallax.js"></script>
        <script type="text/javascript" src="js/owl.carousel.min.js"></script>-->
        <script type="text/javascript" src="<?=$baseUrl; ?>/js/wow.js"></script>

        <script type="text/javascript" src="<?=$baseUrl; ?>/js/template.js"></script>
<!--        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAqLUl68QJCvUBCfGW4hsa_j3sU1aEyDoI"></script>-->
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyA1vr2RVgKBydJQhSo1LUsP3pUcKh4IFGI"></script>
     <script type="text/javascript" charset="utf-8">

     $(document).ready(function() {
         var currgeocoder;
         //Set geo location lat and long
            navigator.geolocation.getCurrentPosition(function(position, html5Error) {
            geo_loc = processGeolocationResult(position);
            currLatLong = geo_loc.split(",");
            initializeCurrent(currLatLong[0], currLatLong[1]);

        });
        //Get geo location result
       function processGeolocationResult(position) {
             html5Lat = position.coords.latitude; //Get latitude
             html5Lon = position.coords.longitude; //Get longitude
             html5TimeStamp = position.timestamp; //Get timestamp
             html5Accuracy = position.coords.accuracy; //Get accuracy in meters
             return (html5Lat).toFixed(8) + ", " + (html5Lon).toFixed(8);
       }
        //Check value is present or not & call google api function

        function initializeCurrent(latcurr, longcurr) {
             currgeocoder = new google.maps.Geocoder();
             //console.log(latcurr + "-- ######## --" + longcurr);

             if (latcurr != '' && longcurr != '') {
                 var myLatlng = new google.maps.LatLng(latcurr, longcurr);
                 return getCurrentAddress(myLatlng);
             }
       }

        //Get current address

         function getCurrentAddress(location) {
              currgeocoder.geocode({
                  'location': location

            }, function(results, status) {
           
                if (status == google.maps.GeocoderStatus.OK) {
                   // console.log(results[0]);
                    if (results[1]) {
                        for (var i=0; i<results[0].address_components.length; i++) {
                            for (var b=0;b<results[0].address_components[i].types.length;b++) {
                                //there are different types that might hold a city admin_area_lvl_1 usually does in come cases looking for sublocality type will be more appropriate
                                if (results[0].address_components[i].types[b] == "administrative_area_level_2") {
                                    //this is the object you are looking for
                                    city= results[0].address_components[i];
                                    break;
                                }
                            }
                        }
                        //city data
                        //alert(city.short_name + " " + city.long_name)
                        if(city.long_name){
                            jQuery.ajax({
                                type: "POST",
                                cache: false,
                                url: '<?php echo Yii::app()->createUrl("site/setSessionCity"); ?>',
                                data: {city: city.long_name},
                                success: function (result) {
                                }
                            });
                        }

                    }
                    //$("#address").html(results[0].formatted_address);
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });
         }
    });

    </script>
    </body>
</html>