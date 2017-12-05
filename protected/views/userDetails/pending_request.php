<section class="section-details container-fuild" style="border-bottom: 1px solid #e9e9e9;"> 
<div class="container">                              		
                <div class="col-md section" style="padding:0">                                	
                    <div class="profile-note text-right" style="color:black;">
                       <a href="<?php echo $this->createUrl('userDetails/patientAppointments'); ?> "style="color:#0db7a8;">Home</a> | <a href=""style="color:#0db7a8;">Notification</a> | <a href="<?php echo $this->createUrl('userDetails/patientDetails'); ?>"style="color:#0db7a8;">Profile/Edit</a>
                    </div>
                    <?php
                   $this->renderPartial('patient_profile_view',array('PatientInfoArr' => $PatientInfoArr));
                    ?>
                    <div class="col-md-10"> 
                        <div class="col-sm-6" style="margin:0px;padding:0px;font-size:16px;font-weight: bold; color:#0db7a8;">
                            Pending  Request
                            
                        </div><div class="clearfix">&nbsp;</div>
                        <div class="table-list box-body">                      
               <?php
               $appointmentmodel = new AptmtQuery;
                $enc_key = Yii::app()->params->enc_key;
                $patientlId = Yii::app()->user->id;
                
               // echo $patientlId;exit;
                $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'appointment-grid',
                    'dataProvider' => $appointmentmodel->getPatientQuery($patientlId),
                    'itemsCssClass' => 'table table-bordered  table-hover table-striped',
                    'pagerCssClass' => 'pagination-box  center clearfix col-lg-12',
                    'summaryText' => '',
                   'pager' => array(
                                            'htmlOptions' => array('class' => 'list-inline'),
                                            'header' => '',
                                            'prevPageLabel' => '&lt;&lt;',
                                            'nextPageLabel' => '&gt;&gt;',
                                            'firstPageLabel' => 'First',
                                            'lastPageLabel' => 'Last',
                                        ),
                    'columns' => array(
                        array(
                            'header' => 'PATIENT NAME',
                            'value' => '$data->patient_name',
                            'htmlOptions' => array("style" => "text-align:center;")
                        ),
                        array(
                            'header' => 'PATIENT MOBILE',
                            'value' => '$data->patient_mobile',
                            'htmlOptions' => array("style" => "text-align:center;")
                        ),
                        array(
                            'header' => 'TYPE OF VISIT',
                            'value' => '$data->type_of_visit',
                            'htmlOptions' => array("style" => "text-align:center;")
                        ),
                        array(
                            'header' => 'Clinic NAME',
                            'value' => '$data->clinic_name',
                            'htmlOptions' => array("style" => "text-align:center;")
                        ),
                        array(
                            'header' => 'Requested Date',
                            'value' => 'date("d-m-Y",strtotime($data->preferred_day))',
                            'htmlOptions' => array("style" => "text-align:center;")
                        ),
                        
                        
                    ),
                ));
                ?>
                                   
                                  

                               
                            
                            
                            
                            

                            

                        </div>


                        <div class="clearfix"></div>                
                    </div> <!--col-md-10 end-->       
                </div><!--/row-->
            </div>
</section>