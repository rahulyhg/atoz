
<script type="text/javascript">
    var pinarray = [];
    $(function(){
        $(".pincode-id-class").blur(function(){
        var pincode = $(this).val();
            getPincodeCity(pincode);
        })
    });
    function getPincodeCity(){
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            cache: false,
                url: '<?php echo Yii::app()->createUrl("UserDetails/getPincodeData") ?>',
                data: {pincode: pincode},
                success: function (result) {
                    var citydata = result.citydata;
                    $(".cityId").html(citydata);
                    var areadata = result.areadata;
                    $(".areaId").html(areadata);
                    $(".state-class").val(result.stateid);
                    //$(".state-id-class").val(result.stateid);
                    $(".area-id-class").val(result.areaname);
                    $(".city-id-class").val(result.cityname);

                    var state1 = $(".state-class option:selected").text();
                    $(".state-id-class").val(state1);
                }
        });
    }
    function getCity()
    {
        var state = $('.state-class option:selected').val();
        var state1 = $('.state-class option:selected').text();
        $(".state-id-class").val(state1);
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            cache: false,
            url: '<?php echo Yii::app()->createUrl("UserDetails/getCityName"); ?> ',
            data: {state: state},
            success: function (data) {
                var dataobj = data.data;
                var cityname = "<option value=''>Select City</option>";
                $.each(dataobj, function (key, value) {

                    cityname += "<option value='" + value.city_id + "'>" + value.city_name + "</option>";
                });
                $(".cityId").html(cityname);
            }
        });
    }                                             //  var pinarray =[];
    function getAreaid() {
        var area1 = $('.area-class option:selected').val();
        var area = $('.area-class option:selected').text();
        //  alert(area1);
        $(".area-id-class").val(area);
        var pincode = pinarray[area1];
        //  alert(pincode);
        // alert(area1);
        //alert(pincode);
        $(".pincode-id-class").val(pincode);
    }

    function getArea()
    {
        var area = $('.city-class option:selected').val();
        var area1 = $('.city-class option:selected').text();
        //   var pinarray=[];
        $(".city-id-class").val(area1);
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            cache: false,
            url: '<?php echo Yii::app()->createUrl("UserDetails/getAreaName"); ?> ',
            data: {area: area},
            success: function (data) {
                var dataobj = data.data;
                var areaname = "<option value=''>Select Area</option>";
                $.each(dataobj, function (key, value) {
                    // var pincode=value.pincode;
                    //  alert(pincode);
                    pinarray[value.area_id] = value.pincode;
                    areaname += "<option value='" + value.area_id + "'>" + value.area_name + "</option>";
                });
                $(".areaId").html(areaname);
                //  alert(areaname);
                //  alert(pinarray);
            }
        });
    }
</script>
