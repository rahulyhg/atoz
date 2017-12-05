 <?php 
$baseUrl = Yii::app()->request->baseUrl;
 $enc_key = Yii::app()->params->enc_key;
?>
<!-- Start intro section -->
<div class="section-body"> 
 <section id="intro" class="section-doctor">
     <div class="overlay">
         <div class="container">
             <div class="main-text">
                 <div class="col-md-12 text-center chart">
                         <span> Create your A2Z Health+ profile </span>
                     <h4 class="sub-title">Choose your Profile type </h4>

                     <div class="col-md-12">
                         <div class="doctors" style="z-index: 1000;position: relative;">
                                 <a href="<?php echo CController::createUrl("userDetails/doctorDetails",array("roleid"=>base64_encode(3)));?>"> <img src="<?=$baseUrl; ?>/images/icons/doctors.png" width="70">
                                     <span>Doctor( Clinic )</span></a>
                         </div>
                     </div>

                    <div class="col-md-12">
                         <div class="hospital">
                             <a href="<?php echo CController::createUrl("userDetails/hospital",array("roleid"=>base64_encode(5)));?>"> <img src="<?=$baseUrl; ?>/images/icons/polyclinics.png" width="70">
                                 <span>Hospital </span></a>
                         </div>
                     </div>

                    <div class="col-md-12">
                         <div class="pathology">
					
                        <a href="<?php echo CController::createUrl("userDetails/pathology",array("roleid"=>6));?>"> <img src="<?=$baseUrl; ?>/images/icons/pathology.png" width="70">
                                 <span>Pathology Lab </span></a>
                         </div>
                     </div> 

                    <div class="col-md-12">
                         <div class="diagnostics text-center">
                              <a href="<?php echo CController::createUrl("users/diagnostic",array("roleid"=>base64_encode(7)));?>">
                                 <img src="<?=$baseUrl; ?>/images/icons/diagnostics.png" width="70">
                                 <span>Diagnostic Center </span></a>
                         </div>
                     </div>

                    <div class="col-md-12">
                         <div class="blood-bank text-center">
                                  <a href="<?php echo CController::createUrl("users/bloodBank",array("roleid"=>base64_encode(8)));?>"><img src="<?=$baseUrl; ?>/images/icons/blood-bank.png" width="70">
                                      <span>Blood Banks </span></a>
                         </div>
                     </div>

                   <div class="col-md-12">
                         <div class="Medical-Stores text-center">
                                 <a href="<?php echo CController::createUrl("users/bloodBank",array("roleid"=>base64_encode(9)));?>"><img src="<?=$baseUrl; ?>/images/icons/pharmacies.png" width="70">
                                 <span>Medical Stores </span></a>
                         </div>
                     </div>

                   <div class="col-md-12">
                         <div class="emergency-services text-center">
						 <a href="<?php echo  CController::createUrl("users/ambulanceDetails",array("param1"=>base64_encode(10)));?>
                                 "><img src="<?=$baseUrl; ?>/images/icons/icon21.png" width="70">
                                 <span>Emergency Services </span></a>
                         </div>
                    </div>

                 </div>

             </div>
         </div>
     </div>
 </section>
 <!-- end intro section -->
 </div>