<?php
$baseUrl = Yii::app()->request->baseUrl;

$session = new CHttpSession;
$session->open();
//print_r($session);
//Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/select2.css');
//Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/multiple-select.css');
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/multiple-select.js', CClientScript::POS_END);

//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/select2.min.js', CClientScript::POS_END);

?> 
<!-- Start intro section -->
<section id="intro" class="section-intro">
    <div class="overlay">
        <div class="container">
            <div class="main-text">
                <h1 class="intro-title">&nbsp;</h1>
                <p class="sub-title">&nbsp;</p>

                <!-- Start Search box -->
                <?php  $this->renderPartial('_searchbox'); ?>
                <!-- End Search box -->
            </div>
        </div>
    </div>
</section>
<!-- end intro section -->
<!-- Start Services Section -->
<div class="features">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="features-box wow fadeInDownQuick clearfix" data-wow-delay="0.3s">
                    <div class="features-icon">
                        <a href="<?php echo Yii::app()->createUrl("site/doctordetails"); ?>">
                            <img src="<?= $baseUrl; ?>/images/icons/icon01.png" width="50">
                            <strong>Doctors</strong>
                        </a>
                    </div>

                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="features-box wow fadeInDownQuick clearfix" data-wow-delay="0.6s">
                    <div class="features-icon">
                        <a href="<?php echo Yii::app()->createUrl("site/HospitalList"); ?>">
                            <img src="<?= $baseUrl; ?>/images/icons/icon02.png" width="50">
                            <strong>Hospitals</strong>
                        </a>
                    </div>

                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="features-box wow fadeInDownQuick clearfix" data-wow-delay="0.9s">
                    <div class="features-icon">
                         <a href="<?php echo Yii::app()->createUrl("site/PathologyList",array("role"=>7)); ?>">
                            <img src="<?= $baseUrl; ?>/images/icons/icon03.png" width="50">
                            <strong>Diagnostic Centers</strong>
                        </a>
                    </div>                              
                </div>
            </div> 
            <div class="col-md-4 col-sm-6">
                <div class="features-box wow fadeInDownQuick clearfix" data-wow-delay="1.2s">
                    <div class="features-icon">
                         <a href="<?php echo Yii::app()->createUrl("site/PathologyList",array("role"=>6)); ?>">
                            
                            <img src="<?= $baseUrl; ?>/images/icons/icon06.png" width="50">
                            <strong>Pathology Labs</strong>
                        </a>
                    </div>
                </div>
            </div>           
            <div class="col-md-4 col-sm-6">
                <div class="features-box wow fadeInDownQuick clearfix" data-wow-delay="1.5s">
                    <div class="features-icon">
                        <a href="<?php echo Yii::app()->createUrl("site/PathologyList",array("role"=>8)); ?>">
                            <img src="<?= $baseUrl; ?>/images/icons/icon05.png" width="50">
                            <strong>Blood Banks</strong>
                        </a>
                    </div>

                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="features-box wow fadeInDownQuick clearfix" data-wow-delay="1.8s">
                    <div class="features-icon">
                        <a href="<?php echo Yii::app()->createUrl("site/PathologyList",array("role"=>9)); ?>">
                            <img src="<?= $baseUrl; ?>/images/icons/icon04.png" width="50">
                            <strong>Medical Stores</strong>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Services Section -->
<div class="wrapper_mid">
    <section class="aboutusintro" style="background-image:url(images/back_mid.png);background-position: center center;background-repeat: no-repeat;background-size: cover;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">  
                    <div class="col-md-3">
                        <div class="features-box wow fadeInDownQuick clearfix" data-wow-delay="1.8s">
                            <div class="features-icon text-center">
                                <a href="javascript:" onclick="dailyfree();">
                                   <img src="images/icons/icon42.png" width="70">  <!--  freeoffer.png-->
                                    <strong class="subtrong">Daily Free Offering </strong>
                                </a>
                            </div>    
                        </div>
                    </div> 
                    <div class="col-md-3">
                        <div class="features-box wow fadeInDownQuick clearfix" data-wow-delay="1.8s">
                            <div class="features-icon text-center">
<!--                                <a href="javascript:" onclick="secound_opinion();">
                                    <img src="images/icons/opinion.png" width="70">
                                    <strong class="subtrong">Second Opinion </strong>
                                    <span class="subpan">Get advice - Topmost Doctors </span>
                                </a>-->
                            </div>    
                        </div>
                    </div> 
                    <div class="col-md-3">
                        <div class="features-box wow fadeInDownQuick clearfix" data-wow-delay="1.8s">
                            <div class="features-icon text-center">
<!--                                <a href="<?php echo Yii::app()->createUrl("pages/commingsoon"); ?>">
                                    <img src="images/icons/icon26.png" width="70">
                                    <strong class="subtrong">You Request - Quote </strong>
                                    <span class="subpan">Looking for treatment cost estimate? </span>
                                </a>-->
                            </div>    
                        </div>
                    </div> 
                    <div class="col-md-3">
                        <div class="features-box wow fadeInDownQuick clearfix" data-wow-delay="1.8s">
                            <div class="features-icon text-center">
                                <a href="<?php echo Yii::app()->createUrl("pages/commingsoon"); ?>">
                                    <img src="images/icons/expert.png" width="70">
                                    <strong class="subtrong">Help Desk </strong>
<!--                                    <span class="subpan">Tailormade, on-demand information regarding medical treatments </span>-->
                                </a>
                            </div>    
                        </div>
                    </div>    
                </div>	
            </div>
        </div>
    </section>
</div>

<!-- Modal -->
<div class="loginmodel">
    <!-- Modal -->
    <div class="modal" id="myOpinion" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" >Modal Header</h4>
                </div>
                <div class="modal-body clearfix" style="padding:25px 0px 15px 15px;">
                    <label class="col-sm-2">Speciality</label>
                    <?php
                    $speciality = SpecialityMaster::model()->findAll();
                    $specialitynameArr = CHtml::listData($speciality, 'speciality_id', 'speciality_name');
                    ?>
                    <select name="UserDetails[speciality][]" class="col-sm-6 specialityId">
                        <?php
                        echo "<option>Select speciality </option>";
                        ;
                        foreach ($specialitynameArr as $specialitykey => $speciality) {
                            echo "<option value='$specialitykey' ";

                            echo ">$speciality</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="modal-footer text-center clearfix" style="text-align: center;">
                    <button type="button" class="btn btn-default" onclick="select_speciality();" >Select</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-example-modal-lg" id="appointModal" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content appointcontent">

        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.validate.min.js"></script>

<?php $redirectUrl = Yii::app()->request->getUrl(); ?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyBacLj_vpokyTYesTfLGAf0AfKZJ9QCH-g"></script>
<script type="text/javascript">

                    function init() {
                        var input = document.getElementById('searchTextField');
                        var autocomplete = new google.maps.places.Autocomplete((input), {});
                        google.maps.event.addListener(autocomplete, 'place_changed', function () {
                            var place = autocomplete.getPlace();
                            // alert(place.name);
                            var ll = document.getElementById('ll');
                            ll.value = place.name;
                        });
                    }
                    google.maps.event.addDomListener(window, 'load', init);

</script>
<script type="text/javascript">
    var redirectUrl = '<?php echo $redirectUrl;?>';
    <?php if(isset($session['opendailyfreeoffer'])) { ?>
        dailyfree();
    <?php } ?>
    function secound_opinion()
    {

        $('#myOpinion').modal('show');
    }
    function select_speciality()
    {

        var specialityid = $('.specialityId').val();
        window.location.href = '<?php echo Yii::app()->createUrl('site/specialityList'); ?>' + '/specialityid/' + encodeURI(specialityid);

    }
    function dailyfree(){
      //alert('in daily');
       $.ajax({
            //async: false,
            type: 'POST',
            cache: false,
            url: '<?php echo Yii::app()->createUrl("site/dailyfreeoffer"); ?> ',
            data: {redirectUrl : redirectUrl },
            success:function(data)
            {
                //alert(data);
                $(".appointcontent").html(data);
                $("#appointModal").modal("show");
            }
        });
    }

</script>
