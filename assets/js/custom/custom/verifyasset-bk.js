$(".verify").on('click', function(){
   
    lat='';
    long='';

    var options = {
        enableHighAccuracy: true,
        timeout: 5000,
        maximumAge: 0
        };

        function success(pos) {
            var crd = pos.coords;
             lat = crd.latitude;
             lng = crd.longitude;
             address = '';

            var latlng = new google.maps.LatLng(lat, lng);
            // This is making the Geocode request
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': latlng },  (results, status) =>{
                if (status !== google.maps.GeocoderStatus.OK) {
                // alert(status);
                }
                // This is checking to see if the Geoeode Status is OK before proceeding
                if (status == google.maps.GeocoderStatus.OK) {
                // console.log(results);
                   var address = results[0].formatted_address;
                   $('#verify_address').val(address); 
                   
                }
            });
            $('#verify_lat').val(lat);
            $('#verify_long').val(lng); 
            $('#verify_model').modal('show');  
             
        }

        function error(err) {
         console.warn(`ERROR(${err.code}): ${err.message}`);
        }

      navigator.geolocation.getCurrentPosition(success, error, options);

    

});

$("#verify_button").on('click', function(){
   
    if($('#verify_form').parsley().validate())
    {
        
        var verify_asset = new FormData();
        
        var verify_files = document.getElementById('verify_picture').files.length;
        for (var index = 0; index < verify_files; index++) {
            verify_asset.append("verifypicture[]", document.getElementById('verify_picture').files[index]);
        }


        var verify_condition =  $('#verify_condition').val();
        verify_asset.append('verify_condition',verify_condition);
        var view_assetid =  $('#view_assetid').val();
        verify_asset.append('view_assetid',view_assetid);

      
        

        var verify_address =  $('#verify_address').val();
        verify_asset.append('verify_address',verify_address);
        

        $.ajax({
            url : base_url+'Assetmanagement/verify_asset',
            type: "POST",
            contentType: false,
            processData: false,
             data : verify_asset,
            success: function(result)
            {
                if(result){

                    $('#verify_model').modal('toggle');
                    swal(
                        {
                            title: 'Verified Successfully!!',
                            type: 'success',
                            confirmButtonColor: '#57a94f'
                        }
                    );
                    $('.verify').hide();
                    
                }
            },
            error: function ()
            {
         
            }
        });


        
    }
   

});
$(".remove").on('click', function(){

    lat='';
    long='';

    var options = {
        enableHighAccuracy: true,
        timeout: 5000,
        maximumAge: 0
        };

        function success(pos) {
            var crd = pos.coords;
             lat = crd.latitude;
             lng = crd.longitude;
             address = '';

            var latlng = new google.maps.LatLng(lat, lng);
            // This is making the Geocode request
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': latlng },  (results, status) =>{
                if (status !== google.maps.GeocoderStatus.OK) {
                // alert(status);
                }
                // This is checking to see if the Geoeode Status is OK before proceeding
                if (status == google.maps.GeocoderStatus.OK) {
                // console.log(results);
                   var address = results[0].formatted_address;
                   $('#remove_address').val(address); 
                   
                }
            });
            $('#lat').val(lat);
            $('#long').val(lng); 
            $('#remove_model').modal('show'); 
             
        }

        function error(err) {
         console.warn(`ERROR(${err.code}): ${err.message}`);
        }

      navigator.geolocation.getCurrentPosition(success, error, options);
      

       
});

$("#remove_button").on('click', function(){
   
    if($('#remove_form').parsley().validate())
    {
        
        $('#remove_model').modal('hide'); 
        $('#Removereason').modal('show'); 
        $("#remove_status").on('change', function(){
        var remove_status = $('#remove_status').val();

        if(remove_status!=''){

        var remove_asset = new FormData();
        var remove_files = document.getElementById('remove_picture').files.length;
        for (var index = 0; index < remove_files; index++) {
            remove_asset.append("removepicture[]", document.getElementById('remove_picture').files[index]);
        }
        var remove_condition =  $('#remove_condition').val();
        remove_asset.append('remove_condition',remove_condition);
        var view_assetid =  $('#view_assetid').val();
        remove_asset.append('view_assetid',view_assetid);
        remove_asset.append('remove_status',remove_status);

        var view_uin = $("#view_assetUIN").val();
        remove_asset.append('view_uin',view_uin);

        var remove_address =  $('#remove_address').val();
        remove_asset.append('remove_address',remove_address);
       
        $.ajax({
            url : base_url+'Assetmanagement/remove_asset',
            type: "POST",
            contentType: false,
            processData: false,
             data : remove_asset,
            success: function(result)
            {
                if(result){

                    $('#remove_model').modal('hide'); 
                    swal(
                        {
                            title: 'Removed Successfully!!',
                            type: 'success',
                            confirmButtonColor: '#57a94f'
                        }
                    );
                    $('.remove').hide();
                    $('#Removereason').modal('toggle');
                    
                }
            },
            error: function ()
            {
         
            }
        });

    }

      });
        
    }
   

});
   

