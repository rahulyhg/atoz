<?php
$baseUrl = Yii::app()->request->baseUrl;
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/main.css');

$session = new CHttpSession;
$session->open();
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'patientappointments',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
$enc_key = Yii::app()->params->enc_key;
?>  
<section class="section-details container-fuild" style="border-bottom: 1px solid #e9e9e9;">
    <div class="overlay">
        <div class="row">

            <!-- 2-column layout -->
            <div class="container">                              		
                <div class="col-md section" style="padding:0">                                	
                    <div class="profile-note text-right" style="color:black;">
                         <a href=""style="color:#0db7a8;">Notification</a> | <a href="<?php echo $this->createUrl('userDetails/patientDetails'); ?>"style="color:#0db7a8;">Profile/Edit</a>
                    </div>
                    <?php
                    $this->renderPartial('patient_profile_view',array('PatientInfoArr' => $PatientInfoArr));
                    ?>
                    <?php  if($roleid == 4 ) {?>
                    <div class="col-md-10"> 
                        <div class="col-sm-3" style="margin:0px;padding:0px;font-size:16px;font-weight: bold; color:#0db7a8;">
                            Appointment Details
<!--                            <hr style="border: 1px solid #031097;">-->
                        </div><div class="clearfix">&nbsp;</div>
                        <div class="table-list box-body">                      
                            <table id="example2" class="table table-bordered table-hover">
                                <thead class="ppp">
                                    <tr style="text-transform:uppercase;">
                                        <th style=" color:#69ece0;">Sr.No.</th>
                                       <th style=" color:#69ece0;">Service Providers </th>
                                        <th style=" color:#69ece0;">Mobile No.</th>
                                        <th style=" color:#69ece0;">Speciality</th>                                                                  <th style=" color:#69ece0;">Date / Time  </th>
                                        <th style=" color:#69ece0;">Medical Documents </th>  
                                        <th style=" color:#69ece0;">Delete </th>                                                         
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $this->widget('zii.widgets.CListView', array(
                                        'dataProvider' => $DocArrProvider,
                                       'itemView' => '_patientappointments',
                                        'pagerCssClass' => 'pagination-box clearfix text-center',
                                        'summaryText' => '',
                                        'pager' => array(
                                            'htmlOptions' => array('class' => 'list-inline'),
                                            'header' => false,
                                            'prevPageLabel' => '&lt;&lt;',
                                            'nextPageLabel' => '&gt;&gt;',
                                            'firstPageLabel' => 'First',
                                            'lastPageLabel' => 'Last',
                                            ),
                                    ));
                                    ?>


                                </tbody>
                            </table>
                         
                        </div>


                        <div class="clearfix"></div>        
                        
                       
                    </div> <!--col-md-10 end-->   
                    
                    <?php  } ?>
                    
                     <div class="bank_details" style="display:none">
                                <label> Bank :<?php echo $bankDetails['bank_name']?></label><br>
                                <label> Branch :<?php echo $bankDetails['branch_name']?></label><br>
                                <label> Account No :<?php echo $bankDetails['account_no']?></label>
                                
                                
                        </div>
                </div><!--/row-->
            </div>   
        </div>

    </div>
</section><!--/.container-->
<?php $this->endWidget(); ?>

<div class="modal fade" id="viewreport" tabindex="1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-backdrop="static" >
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
<!--                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>-->
                                            <h3 class="modal-title" id="lineModalLabel">View Reports </h3>
                                        </div>
                                        <div class="modal-body">

                                            <!-- content goes here -->
                                            <form>
                                                <div class="form-group col-md-6">
                                                    <label>Dr Name :</label>
                                                    <label style="font-weight:600" class="dr_name"> </label>
                                                </div>	
                                                <div class="form-group col-md-4" style="padding-top:20px">

                                                    <i class="fa fa-file" aria-hidden="true"></i><label onclick="getdoc()">document</label><div class="resultdoc"></div>
                                                    
<!--                                                    <label> <a class="top" href="discription.jpg" target="_blank"><i class="fa fa-file" aria-hidden="true"></i> discription.jpg </a>  &nbsp;<a href="#"></a></label>-->
                                                    <input type="hidden" class="appointid">
                                                </div>
                                                <div class="clearfix"></div>

                                            </form>

                                        </div>
                                        <div class="modal-footer">
                                            <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                                                <div class="btn-group col-md-1" role="group">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal"  role="button" onclick="cleardoc()">Close</button>
                                                </div>

                                                                                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                            
                            <?php //print_r($_POST);?>
                            <div class="modal fade" id="editreport" tabindex="1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                <div class="modal-dialog">
                                    <form method="post" enctype="multipart/form-data">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="lineModalLabel">Edit Reports </h3>
                                        </div>
                                        <div class="modal-body">

                                            <!-- content goes here -->
                                            <div class="form-group col-md-4" style="padding-top:20px">
                                               Upload document  <input type="file" name = "p_document" class="uploaddoc">
                                                    
                                            </div>
                                                <div class="clearfix"></div>

                                            

                                        </div>
                                        <div class="modal-footer">
                                            <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                                                <div class="btn-group col-md-1" role="group">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Close</button>
                                                </div>

                                                <div class="btn-group col-md-1" role="group">
                                                    <button type="button" id="saveImage" class="btn btn-default btn-hover-green" onclick ="uploadDocument()">Submit</button>
                                                </div>                                               
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.ba-bbq.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.yiigridview.js"></script>
<style>
    .bordertab {
        border: 1px solid #c6c6c6;
        border-radius: 4px;
        padding: 5px 15px;
        margin: 15px ;
        float: left;    
    }

    .btn-datetime {
        border: 1px solid #c6c6c6;
        border-radius: 4px;
        padding: 5px 15px;
        margin: 15px -15px;
        float: left;
    }
    .btn-medical {
        border: 1px solid #c6c6c6;
        border-radius: 4px;
        padding: 7px 17px;
    }
    .Appointment-table {
        padding: 15px 0;
        margin: 15px 0;
    }
    
   
</style>

<script type="text/javascript">
    $(function () {

        $('.bank').click(function () {
            $('.bank_details').show();
        });
});

    function viewreport(drname,appointId) {
     
       $('.dr_name').html(drname);
       $('.appointid').val(appointId);
    }
    
    function getdoc(){
        var str ="";
        $('.resultdoc').append(str);
     var appintid = $('.appointid').val();
     var user_id = '<?php echo $session['user_id'];?>';
        $.ajax({
            async: false,
            type: 'POST',
            dataType: 'json',
            cache: false,
            url: '<?php echo Yii::app()->createUrl("users/getDocument"); ?> ',
            data: {appintid : appintid ,user_id :user_id},
            success: function (result) {
                var resultobj = result.result;
             
             
              if(resultobj != false){
                 str = "<a href='uploads/"+resultobj+"' target='_blank' class='documentclass'>ClickMe...</a>";
             }else{
                   str = "<label class='documentclass'>No Report</label>"; 
                }
              
        $('.resultdoc').append(str);
        
            }
        });
    }

    function cleardoc(){
        
        $('.resultdoc').find('.documentclass').remove();
    }
        
    function editreport(appointId){
        $('.appointid').val(appointId);
    }

    function uploadDocument() {
     //   
        var user_id = '<?php echo $session['user_id'];?>';
          var appintid = $('.appointid').val();
     //   var doc = $('.uploaddoc').val();
        var doc = $('.uploaddoc').prop('files')[0];   
        console.log(doc);
    
        $.ajax({
            async: false,
            type: 'POST',
            dataType: 'json',
            cache: false,
            url: '<?php echo Yii::app()->createUrl("users/editReport"); ?> ',
            data: {appintid : appintid,user_id : user_id ,doc:doc.name},
            success: function (result) {
                var resultobj = result.result;
                

            }
        });

    }

    function deleteRecord(patient_id){
        
        var result=ConfirmDelete();
        if (result) {
    $.ajax({
            async: false,
            type: 'POST',
            dataType: 'json',
            cache: false,
            url: '<?php echo Yii::app()->createUrl("users/deleteRec"); ?> ',
            data: {patient_id : patient_id},
            success: function (result) {
                //var resultobj = result.result;
                location.reload();

            }
        });
        
    }
    }

function ConfirmDelete() {
  return confirm("Are you sure you want to delete?");
}
</script>