<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.ba-bbq.js"></script>
<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.yiigridview.js"></script>
<section class="section-details container-fuild" style=" background-color:#fff;border-bottom: 1px solid #ededed;">
    <div class="overlay">
        <div class="row">
            <!-- 2-column layout -->
            <div class="container">
                <div class="col-md section" style="">

                    <div class="col-md-2 text-center" style="margin-top: -35px;">
                        <div class="col-md-12 text-left text-img" style="">
                            <?php
                            $HospitalinfoArr = Yii::app()->db->createCommand()
                                    ->select("*")
                                    ->from("az_user_details")
                                    ->where("role_id=5 And parent_hosp_id =$id")
                                    ->queryRow();
                            $baseUrl = Yii::app()->baseUrl;
                            $path = $baseUrl . "/uploads/" . $HospitalinfoArr['profile_image'];
                            if (empty($HospitalinfoArr['profile_image'])) {
                                $path = $baseUrl . "/images/icons/icon01.png";
                            }
                            ?>
                            <a href="">
                                <img src="<?php echo $path; ?>" class="img-circle img-responsive" style="margin-bottom:15px;height:135px;width:135px;">
                            </a> 

                        </div>
                        <div class="col-md-12 text-center">               	
                          <ul class="service-list text-left col-pad" style="padding-top:22px">

                              <li><a href=""><img src="<?=$baseUrl; ?>/images/icons/special-doctor.png" width="22" style="vertical-align:middle">&nbsp; Doctors </a> </li>
                              <li><a href=""><img src="<?=$baseUrl; ?>/images/icons/icon38.png" width="22" style="vertical-align:middle">&nbsp; Services </a> </li>
                              <li><a href=""><img src="<?=$baseUrl; ?>/images/icons/amenities.png" width="22" style="vertical-align:middle">&nbsp; Amenities </a> </li>
                              <li><a href=""><img src="<?=$baseUrl; ?>/images/icons/icon39.png" width="22" style="vertical-align:middle">&nbsp; Discount </a> </li>
                              <li><a href=""><img src="<?=$baseUrl; ?>/images/icons/icon39.png" width="22" style="vertical-align:middle">&nbsp; Payment </a> </li>
                          </ul>

                       </div>   
                    </div>
                     <div class="col-md-10 col-mar" style="margin-top: -35px;"> 
                       <?php  $hospitalDoctorArr =Yii::app()->db->createCommand()
                                    ->select("*")
                                    ->from("az_user_details")
                                    ->where("role_id=3 And parent_hosp_id =$id")
                                    ->queryAll();
                         foreach($hospitalDoctorArr as $doctorkey=>$value)
                         {?>
                         <div class="col-md-10 col-mar">
                          <?php
                            $baseUrl = Yii::app()->baseUrl;
                            $path = $baseUrl."/uploads/".$HospitalinfoArr['profile_image'];
                            if(empty($HospitalinfoArr['profile_image'])){
                                $path  = $baseUrl."/images/icons/icon01.png";
                            }
                            ?>
                            <a href="">
                                <img src="<?php echo $path; ?>" class="img-circle img-responsive" style="margin-bottom:15px;height:135px;width:135px;"">
                             </a> 

                                    <h4 style=" text-transform: capitalize;"><?php echo CHtml::link($value['first_name'] . " " . $value['last_name'] . "<br>"); ?></h4>
     
        <span class="col-view">Address<?php echo " " . $value['city_name'] . " " . $value['state_name'] . " " . $value['country_name'] . "<br>"; ?></span>
       
        <p> <?php echo $value['description']; ?></p>


        <div class="saving">
            <div class='starrr' id='star1'> 
                <div style="margin-left:5px">
                    <span class='your-choice-was' style='display:none;'>
                        Your rating was <span class='choice'></span>
                    </span>
                </div> 
            </div> 
            <span>Savings 25%*</span>
        </div> 

        <div class="viewer"> 
            <ul class="view-list">              
                <li style="padding-left:0"><a href="javascript:" class="btn-default"> 
                    <?php 
                    if(!empty($value['$doctor_fees'])) {
                        echo "Fee - ".$value['$doctor_fees'];
                    }
                    ?>&nbsp;</a> 
                </li>  
                <li><a href="" class="btn-default">Experience- <?php echo $value['experience'] ?></a> </li>		
                <li><a href="" class="btn-default">Distance - 2km </a></li>
                <li><a href="" class="btn-default">Review +15 </a></li>
                <li style="border-right:none"><a class="btn-default"  onclick ="checkuser('<?php echo $value['mobile']; ?>');" href="javascript:">Book your Appointment </a></li>
            </ul>
        </div>
                         </div>
                        <?php }?>
                        
                              
                     </div>
                </div>
            </div>
        </div>
    </div>
</section>