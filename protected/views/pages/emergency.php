<?php
$baseUrl = Yii::app()->baseUrl;
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/style_pages.css');
?>
<section class="section-patch container-fuild" style=" margin-bottom:auto;">
    <div class="overlay">
        <div class="row">

            <!-- 2-column layout -->
            <div class="container">                              		
                <div class="col-md-12 section">                               	

                    <div class="row">

                        <div class="second-opinion">
                            <div class="apoint-note text-center">
                                <h5 class="title-details">"Emergency - Live Trace & Track Services" </h5>
                                <p style="padding: 35px;">&nbsp;</p>
                                <div class="coloum">
                                    <div class="coloum-img">
                                        <img src="<?php echo $baseUrl; ?>/images/icons/blood.png" width="64">
                                    </div>
                                    <span>Blood Doner </span>
                                </div>
                                <div class="coloum">
                                    <div class="coloum-img">
                                        <a href="<?php echo Yii::app()->createUrl("site/ambulanceList"); ?>">
                                            <img src="<?= $baseUrl; ?>/images/icons/ambulance.png" width="64">

                                        </a>
                                    </div>
                                    <span>Ambulance  </span>
                                </div>
                                <div class="coloum">
                                    <div class="coloum-img">
                                        <img src="<?php echo $baseUrl; ?>/images/icons/safe-woman.png" width="64">
                                    </div>   
                                    <span>Safe Woman and Child Birth </span>
                                </div>
                                <div class="coloum">
                                    <div class="coloum-img">
                                        <img src="<?php echo $baseUrl; ?>/images/icons/hospital-near.png" width="64">
                                    </div>
                                    <span>Hospital Near by </span>
                                </div>
                                <div class="coloum">
                                    <div class="coloum-img" style="border-right:none">
                                        <img src="<?php echo $baseUrl; ?>/images/icons/emergency-serve.png" width="64">
                                    </div>
                                    <span>Doctor 24*7 </span>
                                </div> 
                                <div class="clearfix"></div>
                                <p style="padding:20px">&nbsp; </p>
                                <div class="coloum">
                                    <div class="coloum-img">
                                        <img src="<?php echo $baseUrl; ?>/images/icons/medical-store.png" width="64">
                                    </div>
                                    <span>Medical Stores 24*7 </span>
                                </div>
                                <div class="coloum">
                                    <div class="coloum-img">
                                        <img src="<?php echo $baseUrl; ?>/images/icons/police.png" width="64">
                                    </div>
                                    <span>Police </span>
                                </div>


                            </div>

                        </div>                                   

                    </div>
                </div> <!--col-md-12 end-->  

                <div class="clearfix"></div>                

            </div><!--/row-->
        </div>   
    </div>
</section>