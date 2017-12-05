<div class="col-md-2 text-center">
                        <div>
                            <?php
                            $session = new CHttpSession;
                            $session->open();
                            $id = $session["user_id"];
                            $roleid = $session["user_role_id"];
                            
                            $baseUrl = Yii::app()->baseUrl;
                            $path = $baseUrl . "/uploads/" . $PatientInfoArr['profile_image'];
                            if (empty($PatientInfoArr['profile_image'])) {
                                $path = $baseUrl . "/images/icons/expert.png";
                               
                            }
                            ?>
                            <img alt="shortcut icon" src="<?php echo $path ?>" class="img-circle" width= "137" border=" 1px solid #dfdfdf" height="137"/>
                        </div><div class="clearfix"></div>
                        <div>
                            <?php
                            if($PatientInfoArr['parent_hosp_id']){
                                 $companyName = Yii::app()->db->createCommand()
                                    ->select('company_name')
                                    ->from(' az_user_details')
                                    ->where('user_id=:id', array(':id' => $PatientInfoArr['parent_hosp_id']))
                                    ->queryScalar();
                                 echo '<div>Company Name</div>';
                                echo $companyName.'<br>';
                            }
                            ?>
                            
                            <span class="text-uppercase"><?php echo $PatientInfoArr['first_name'] . ' ' . $PatientInfoArr['last_name']; ?> </span>
                            <div>+91 <?php echo $PatientInfoArr['mobile']; ?> </div> 
                            <span><?php echo $PatientInfoArr['email_1']; ?></span>
                            <div>Age:<?php echo $PatientInfoArr['age']; ?> </div>

                            <span>Address <?php echo $PatientInfoArr['address']; ?></span>
                            <hr style="border: 1px solid #031097;">

                        </div>

                        <div class="clearfix"></div>

                        <div class="text-left">                                       		
                            <span class="text-payment">Payment </span>              	
                            <ul class="profile-list text-left col-pad text-top">

                                <li><a class="bank"> Bank Account Details </a> </li>
<!--                                <li><a href=""> Claim your cash back </a> </li>-->
                                
                                <li><?php 
                                if($roleid == 4){
                                echo CHtml::link('My Request',array('userDetails/getPatientRequest'));}
                                else{
                                   echo ' My Request ';
                                }
?></li>
                                <li>
                                    
                                 <?php   echo CHtml::link('Pending Requests',array('userDetails/getPendingRequest'));               ?>
                                    

                                    
                                </li>
                            </ul>

                        </div>  

<!--                        <div class="text-left note">
                            <span>Note:</span>
                            <p>Dummy text: Verification Goverment Policy</p>

                        </div>             -->
                    </div>