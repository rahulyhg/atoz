
<script type="text/javascript">

function getSubSpeciality(){
       console.log("infuncion");
        var speciality = $('.speciality-class').val();
        if(speciality != null){
        var aa= speciality.toString();
  
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            cache: false,
            url: '<?php echo Yii::app()->createUrl("users/getSubSpeciality"); ?> ',
            data: {speciality: aa},
            success: function (data) {
                
                var dataobj = data.data;
                
                var specialityname = "";
                $.each(dataobj, function (key, value) {
                    specialityname += "<option value='" + value.sub_speciality_name + "'>" + value.sub_speciality_name + "</option>";
                });
                
                $("#UserDetails_sub_speciality").html(specialityname);
                $("#UserDetails_sub_speciality").multipleSelect({
                    filter: true,
                    multiple: true,
                   // placeholder: "Select Speciality",
                    width: "100%",
                    multipleWidth: 500
                });
             }
        });
        }
    }

    
</script>