
<?php
if ($data->is_clinic == 'Y') {
    $address = Yii::app()->db->createCommand()
            ->select("address")
            ->from("az_clinic_details")
            ->where("clinic_id= " . $data->hospital_id)
            ->queryRow();
} elseif ($data->is_clinic == 'N') {
    $address = Yii::app()->db->createCommand()
            ->select("address")
            ->from("az_user_details")
            ->where("user_id= " . $data->hospital_id)
            ->queryRow();
}
?>
<tr>
    <td><?php echo ++$index; ?></td>
    <td> <a href="#">Dr.<?php echo $data->first_name . ' ' . $data->last_name; ?> </a> </td>
    <td> <?php echo $data->mobile; ?></td>
    <td> <?php echo $data->speciality; ?></td>
    <td> <?php echo $data->appointment_date . '/' . $data->time; ?></td>
    <td>
        <div class="center">
            <span data-toggle="modal" data-target="#viewreport" class="btn-primary " title="view" style="background: transparent;border: none;color: #3c8dbc;" onclick="viewreport('<?php echo $data->first_name. ' ' . $data->last_name;?>','<?php echo $data->appointment_id ;?>')"><i class="fa fa-search" aria-hidden="true"></i></span>
            <span data-toggle="modal" data-target="#editreport" class=" btn-primary" title="Edit" style="background: transparent;border: none;color: #3c8dbc;" onclick="editreport('<?php echo $data->appointment_id ;?>')"><i class="fa fa-pencil" aria-hidden="true"></i></span>
<!--            <span  data-toggle="modal" data-target="#delete" class="btn-info" title="delete" style="background: transparent;border: none;color: #3c8dbc;"><i class="fa fa-trash" aria-hidden="true"></i> </span>-->
            <span data-toggle="modal" data-target="#forward" class=" btn-primary" title="forward" style="background: transparent;border: none;color: #3c8dbc;" onclick="deletereport()"><i class="fa fa-share" aria-hidden="true"></i></span>
        </div>   
    </td>
    <td>  &nbsp; <button type="button" class="btn-info" title="delete" style="background: transparent;border: none;color: #3c8dbc;"><i class="fa fa-trash" aria-hidden="true" onclick="deleteRecord(<?php echo $data->appointment_id?>);" class="delrec"></i> </button></td>

</tr>  

