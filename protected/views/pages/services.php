<?php
$baseUrl = Yii::app()->baseUrl;
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/style_pages.css');
?>
<section class="section-details container-fuild" style="border-bottom: 1px solid #e9e9e9;">
    <div class="overlay">
        <div class="row">
            <div class="col-md-12">
                <img src="<?php echo $baseUrl; ?>/images/banner4.jpg" class="img-responsive">
            </div>
            <!-- 2-column layout -->
            <div class="row">                              		
                <div class="col-md section" style="padding:0">                               	

                    <div class="col-md-12">

                        <div class="second-opinion">
                            <div class="background_col">
                                <div class="container apoint-note text-left" style="padding-left:15px">
                                    <div class="col-md-12">
                                        <a href="<?=  Yii::app()->createUrl("site/index"); ?>">Home /</a> <span> Services </span> 
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="container">
                                <div class="col-md-3 footer-top">
                                    <h6 class="title-1"> Services </h6>
                                    <ul class="col-service">
                                        <li><img src="<?php echo $baseUrl; ?>/images/icons/icon01.png" width="25">&nbsp; <span class="col-span"><a href="doctors.html">Doctors </a> </span></li>
                                        <li><img src="<?php echo $baseUrl; ?>/images/icons/icon02.png" width="25">&nbsp; <span class="col-span"><a href="hospitals.html">Hospitals </a> </span></li>
                                        <li><img src="<?php echo $baseUrl; ?>/images/icons/icon03.png" width="25">&nbsp; <span class="col-span"><a href="Diagnostic.html">Diagnostics Centres </a> </span></li>

                                    </ul>                                                                                          

                                </div> 
                                <div class="col-md-3 footer-top">
                                    <h6 class="title-1"> &nbsp; </h6>
                                    <ul class="col-service">

                                        <li><img src="<?php echo $baseUrl; ?>/images/icons/icon06.png" width="25">&nbsp; <span class="col-span"><a href="pathology.html">Pathology Labs </a> </span></li>
                                        <li><img src="<?php echo $baseUrl; ?>/images/icons/icon05.png" width="25">&nbsp; <span class="col-span"><a href="bloodbank.html">Blood Banks </a> </span></li>
                                        <li><img src="<?php echo $baseUrl; ?>/images/icons/icon04.png" width="25">&nbsp; <span class="col-span"><a href="medical-store.html">Medical Stores </a> </span></li>
                                    </ul>                                                                                          

                                </div> 
                                <div class="col-md-3 footer-top">
                                    <h6 class="title-1"> Emergency Services </h6>
                                    <ul class="col-service">
                                        <li><img src="<?php echo $baseUrl; ?>/images/icons/blood.png" width="25">&nbsp; <span class="col-span"><a href="doctors.html">Blood Doner </a> </span></li>
                                        <li><img src="<?php echo $baseUrl; ?>/images/icons/ambulance.png" width="25">&nbsp; <span class="col-span"><a href="hospitals.html">Ambulance   </a> </span></li>
                                        <li><img src="<?php echo $baseUrl; ?>/images/icons/safe-woman.png" width="25">&nbsp; <span class="col-span"><a href="Diagnostic.html">Safe Woman & Child Birth </a> </span></li>
                                        <li><img src="<?php echo $baseUrl; ?>/images/icons/hospital-near.png" width="25">&nbsp; <span class="col-span"><a href="pathology.html">Hospital Near by </a> </span></li>

                                    </ul>                                                                                          

                                </div>
                                <div class="col-md-3 footer-top">
                                    <h6 class="title-1"> &nbsp; </h6>
                                    <ul class="col-service">

                                        <li><img src="<?php echo $baseUrl; ?>/images/icons/emergency-serve.png" width="25">&nbsp; <span class="col-span"><a href="bloodbank.html">Doctor 24*7  </a> </span></li>
                                        <li><img src="<?php echo $baseUrl; ?>/images/icons/medical-store.png" width="25">&nbsp; <span class="col-span"><a href="medical-store.html">Medical Stores 24*7  </a> </span></li>
                                        <li><img src="<?php echo $baseUrl; ?>/images/icons/police.png" width="25">&nbsp; <span class="col-span"><a href="medical-store.html">Police   </a> </span></li>
                                    </ul>                                                                                          

                                </div>
                                <div class="clearfix"></div>                                           
                                <div class="col-md-12 footer-top">
                                    <h6 class="title-1"><img src="<?php echo $baseUrl; ?>/images/icons/doctors.png" width="25">&nbsp; Hospitals & Doctors </h6>
                                    <div class="col-md-12 col-row">
                                        <p>Through our affiliations with individual practitioners, small polyclinics, large multi specialty hospitals and elite 5-star healthcare establishments, end users can look up and select from a huge database of healthcare providers; they enjoy attractive discounts on their medical bills and serveral additional privileges of being an A2ZHEALTH+ registered user.</p>
                                        <ul class="service-col">
                                            <li>Dentist </li>
                                            <li>Urologist </li>
                                            <li>Dermatologist </li>
                                            <li>Cardiologist </li>
                                            <li>Gastroenterologist </li>
                                            <li>Orthopedics Specialist </li>
                                            <li>ENT consultant </li>
                                            <li>Gynecologist </li>
                                            <li>Neurologist </li>
                                            <li>Ophthalmologist </li>
                                            <li>Pediatric Specialist </li>
                                            <li>Cancer Specialist </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <hr>
                                <div class="col-back">
                                    <div class="col-md-6 footer-top">
                                        <h6 class="title-1"><img src="<?php echo $baseUrl; ?>/images/icons/icon04.png" width="25">&nbsp; Pharmacies </h6>
                                        <div class="col-md-12 col-row"> 
                                            <p>Consumer can view online the list of offerings from empaneled top medical stores. Comparison chart can also be accessed to choose 'best buy'. Medicines can be purchased either by visiting the chosen pharmacy or by availing doorstep delivery facility.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 footer-top">
                                        <h6 class="title-1"><img src="<?php echo $baseUrl; ?>/images/icons/icon06.png" width="25">&nbsp; Pathology Labs </h6>
                                        <div class="col-md-12 col-row"> 
                                            <p>Consumer can view online the list of offerings from empaneled top pathology labs. Comparison chart can also be accessed to choose 'best buy'. Tests can be made either by visiting the chosen lab or by availing the 'test@home' facility.</p>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>

                                    <div class="col-md-6 footer-top">
                                        <h6 class="title-1"><img src="<?php echo $baseUrl; ?>/images/icons/diagnostics.png" width="25">&nbsp; Radiology -X-Ray, CT Scan & MRI Scan </h6>
                                        <div class="col-md-12 col-row"> 
                                            <p>Our users can get their scans done att renowed scanning centers equipped with hi-end machinery and diagnostic tools. They are presented with a choice of centers and can select the one that is convenient to them as well as cost-effective.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 footer-top">
                                        <h6 class="title-1"><img src="<?php echo $baseUrl; ?>/images/icons/blood-bank.png" width="25">&nbsp; Blood Bank </h6>
                                        <div class="col-md-12 col-row"> 
                                            <p>Our network covers a large number of Blood Banks in every geographic region; priority in issuing blood and suitable price concessions are the benefits our users enjoy from Blood Banks. </p>
                                        </div>
                                    </div>

                                </div>

                            </div>                                          
                        </div>  

                    </div>                                   

                </div>
            </div> <!--col-md-12 end-->  

            <div class="clearfix"></div>                

        </div><!--/row-->
    </div>   
</div>
<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Click to return on the top page" data-toggle="tooltip" data-placement="left"><span class="glyphicon glyphicon-chevron-up"></span></a>

</section>