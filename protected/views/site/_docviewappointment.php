<?php
//echo CHtml::link(CHtml::encode($data->user_id), array('details', 'id'=>$data->user_id)); 
//echo CHtml::link(CHtml::encode($data->first_name), array('details', 'id'=>$data->user_id)); 
//print_r($data);
?>





<!-- <input type="text" id="searchpatient" placeholder="search">-->
 

                
                <?php
                
                ?>
                <?php
               // foreach ($appointmentdetailArr as $key => $value) {
                    ?>
                    <tr>
                        <?php
//                        $name = Yii::app()->db->createCommand()->select('first_name,last_name')
//                                ->from('az_user_details')->where('user_id =:userid', array(':userid' => $value['patient_id']))
//                               ->queryRow();
                        ?>


                        <td><?php  echo $data['first_name'] . ' ' . $data['last_name']; ?></td>
                        <td>appointment_date<?php  //echo $value['appointment_date'] . ' / ' . $value['time']; ?></td>
                        <td>profile</td>
                        <td>Patient History</td>
                        <td>Report</td>
                        <td>Forward</td>
                        <td>Diagnostic</td>
                    </tr>
                   



<?php //$this->endWidget(); ?>
 
 
<script>
//   $(function () {
//          
//     $("#searchpatient").blur(function(){
//         var name=$("#searchpatient").val();
//         alert(name);
//         
//          jQuery.ajax({
//            type: 'POST',
//            dataType: 'json',
//            cache: false,
//            url: '<?php // echo Yii::app()->createUrl("site/getPatientName"); ?> ',
//            data: {name: name},
//            success: function (data) {
//        var dataobj = data.data;       
//        console.log(dataobj);
//                
//            }
//        });
//         
//     });
//        
//   });
      </script>
      
      <div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>




    <div class="col-sm-6 ">
        <?php //echo CHtml::submitButton('Search',array("class" => "btn btn-primary")); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->