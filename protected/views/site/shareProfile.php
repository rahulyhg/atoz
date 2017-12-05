
 <div class="container">
                <!-- Modal -->
                <div class="myprofile" >
                 
                        <div class="email col-sm-9">
                            <div class=" clearfix search-fields rerror-div " style="display: none" id="rerrorid">
                                <div class="alert alert-warning alert-dismissible fade in register-error" role="alert"  style="margin-top:15px; background-color:#E91724;border:1px solid #E91724;"><p class="text-center">Please Enter valid Email Address</p>
                                </div>
                            </div>
                            <div class=" clearfix search-fields sucess-div " style="display: none" id="sucessid">
                                <div class="alert alert-warning alert-dismissible fade in register-error" role="alert"  style="margin-top:15px; background-color:#0DB7A8;border:1px solid #0DB7A8;"><p class="text-center">Profile Share successfully </p>
                                </div>
                            </div>
                             <button type="button" class="close pull-right" style="padding-right:0px; " data-dismiss="modal">&times;</button>
                            <div class="">
                                <h4 class="text-center" style="padding:15px;">Share Profile</h4>
                              

                            </div>
                            <div class="text-centert" style="padding:0px;">
                                <div class="box box-primary">
                                    <div class=col-sm-3 clearfix>
                                        <?php
                                        $profilepath = Yii::app()->baseUrl;
                                        if (empty($userdetails['profile_image'])) {
                                            $profilepath .= "/images/icons/doctors.png";
                                        } else {
                                            $profilepath .= "/uploads/" . $userdetails['profile_image'];
                                        }
                                        echo "<img src='$profilepath' class='img-circle img-responsive' style='margin-bottom:15px;height:65px;width:65px;'>";
                                        ?>
                                    </div>
                                    <div class="col-sm-9 clearfix">
                                        <?php if ($userdetails['role_id'] == 3) {
                                            ?>
                                            <h4 class='capitalize'>Dr.<?php echo $userdetails['first_name'] . " " . $userdetails['last_name'] ?></h4>
                                            <span class='col-view degree' style='margin-top: 8px;'>  </span>
                                            <span class='col-view clinicaddress' style='margin-top: 8px;'>  <?php echo $userdetails['city_name']; ?> </span>
                                            <h5 class='title-details clinicname' style='padding-left:0;'><?php //echo $clinicname; ?> </h5>
                                            <?php
                                        } else if ($userdetails['role_id'] == 5 || $userdetails['role_id'] == 6 || $userdetails['role_id'] == 7 || $userdetails['role_id'] == 8|| $userdetails['role_id'] == 9) {
                                            echo $userdetails['hospital_name'];
                                            ?>
                                            <h5 class='title-details' style='padding-left:0px;'> <?php echo $userdetails['type_of_hospital']; ?> </h5>
                                            <span class='col-view'>  <?php echo $userdetails['city_name'] . ", " . $userdetails['state_name'] . " " . $userdetails['country_name'] ?> </span>
                                            <h5 class='title-details' style='padding-left:0px;'> NO.Of Beds- <?php echo $userdetails['total_no_of_bed'] ?></h5>
                                            <?php
                                        }
                                        echo $userdetails['description'];
                                        ?>
                                    </div> 

                                    <div>&nbsp;</div>
                                </div>
                                <div class="emailsend clearfix"style="margin:15px 15px 15px 15px;">
                                    <div class="col-sm-2" style="padding:15px;">
                                        <label >Share With:</label>
                                    </div>
                                    <div class="col-sm-6" >
                                        <input type="text" name="email" class="emailaddress form-control">
                                        <p>Note:Enter Email Address Separated by comma </p>
                                    </div>
                                </div>
                                <div class="modal-footer text-center" style="text-align:center;">
                                <button type="button" class="btn" onclick="take_email(<?php echo $userdetails['user_id'] ?>);">Send</button>
                            </div>
                            </div>
                         
                        </div>
                   
                </div>
            </div>