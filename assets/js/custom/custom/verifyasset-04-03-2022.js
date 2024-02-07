
// function getLocation() {
//       if (navigator.geolocation) {
//       navigator.geolocation.getCurrentPosition(showPosition);
//     } else { 
//       x.innerHTML = "Geolocation is not supported by this browser.";
//     }
//   }
  
//   function showPosition(position) {
//     lat = position.coords.latitude;
//     lng = position.coords.longitude;
//     $('#verify_model').modal('show');  
//     $('#verify_lat').val(lat);
//     $('#verify_long').val(lng); 

//   }

$(".verify").on('click', function(){
         
    $('#verify_model').modal('show');  
   
});

$("#verify_button").on('click', function(){
   
    if($('#verify_form').parsley().validate())
    {
        
        var verify_asset = new FormData();
        
        // var verify_files = document.getElementById('verify_picture').files.length;
        // for (var index = 0; index < verify_files; index++) {
        //     verify_asset.append("verifypicture[]", document.getElementById('verify_picture').files[index]);
        // }


        var verify_condition =  $('#verify_condition').val();
        verify_asset.append('verify_condition',verify_condition);
        var view_assetid =  $('#view_assetid').val();
        verify_asset.append('view_assetid',view_assetid);
        var verify_lat =  $('#verify_lat').val();
        verify_asset.append('location[lat]',verify_lat);
        var verify_long =  $('#verify_long').val();
        verify_asset.append('location[long]',verify_long);

        var view_verifyinterval =  $('#view_verifyinterval').val();
        verify_asset.append('verifyinterval',view_verifyinterval);

        var verify_address =  $('#verify_address').val();
        verify_asset.append('verify_address',verify_address);

        var view_createdDate =  $('#view_createdDate').val();
        verify_asset.append('createdDate',view_createdDate);

        var view_VerificationDate =  $('#view_VerificationDate').val();
        verify_asset.append('VerificationDate',view_VerificationDate);

        var view_numberOfPicture =  $('#view_numberOfPicture').val();
        var view_titlestatus =  $('#view_titlestatus').val();

        

        var count=0;
        $.each($(".picture"), function(i, obj) {
            $.each(obj.files,function(j, file){
                verify_asset.append('verifypicture['+count+']', file);
                count=count+1;
            })
        });

          var test_arr = $("input[name='picture_tile[]']");
          var title_count = 0
            $.each(test_arr, function(i, item) {  //i=index, item=element in array
                // myarray.push($(item).val());
                if($(item).val()!=''){
                    title_count=title_count+1;
                }
                verify_asset.append('verify_picturetitle['+i+']',$(item).val());
              });

              submit_status = 0;
             if(view_numberOfPicture==count){
                submit_status = 1;
             }
             if(view_titlestatus==1){
                if(view_numberOfPicture==title_count){
                    submit_status = 1;
                 }
             }

         if(submit_status==1){

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

         }else{
            swal(
                {
                    title: 'Please Give Asset Details',
                    type: 'warning',
                    confirmButtonColor: '#57a94f'
                }
            );
         }
        
    }
   

});


function getlocationRemove() {
    if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(removeshowPosition);
  } else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function removeshowPosition(position) {
  lat = position.coords.latitude;
  lng = position.coords.longitude;
  $('#remove_model').modal('show'); 
   $('#lat').val(lat);
  $('#long').val(lng); 
 
}

$(".remove").on('click', function(){
    $('#remove_model').modal('show'); 
});

$("#remove_button").on('click', function(){
   
    if($('#remove_form').parsley().validate())
    {

    var deleteConfirm = confirm("Are you sure remove this?");
    if (deleteConfirm == true) {
      
        var remove_status = $('#remove_status').val();
        var remove_asset = new FormData();
        // var remove_files = document.getElementById('remove_picture').files.length;
        // for (var index = 0; index < remove_files; index++) {
        //     remove_asset.append("removepicture[]", document.getElementById('remove_picture').files[index]);
        // }
        var remove_condition =  $('#remove_condition').val();
        remove_asset.append('remove_condition',remove_condition);
        var view_assetid =  $('#view_assetid').val();
        remove_asset.append('view_assetid',view_assetid);
        remove_asset.append('remove_status',remove_status);

        var view_uin = $("#view_assetUIN").val();
        remove_asset.append('view_uin',view_uin);

        var remove_address =  $('#remove_address').val();
        remove_asset.append('remove_address',remove_address);

        var view_numberOfPicture =  $('#view_numberOfPicture').val();
        var view_titlestatus =  $('#view_titlestatus').val();

        var count=0;
        $.each($(".picture"), function(i, obj) {
            $.each(obj.files,function(j, file){
                remove_asset.append('removepicture['+count+']', file);
                count=count+1;
            })
        });

          var test_arr = $("input[name='remove_tile[]']");
          var title_count = 0
            $.each(test_arr, function(i, item) {  //i=index, item=element in array
                // myarray.push($(item).val());
                if($(item).val()!=''){
                    title_count=title_count+1;
                }
                remove_asset.append('removepicturetitle['+i+']',$(item).val());
              });

              submit_status = 0;
              if(view_numberOfPicture==count || view_numberOfPicture<count){
                 submit_status = 1;
              }
              if(view_titlestatus==1){
                 if(view_numberOfPicture==title_count || view_numberOfPicture<title_count){
                     submit_status = 1;
                  }
              }
 
        if(submit_status==1){
      

       
        $.ajax({
            url : base_url+'Assetmanagement/remove_asset',
            type: "POST",
            contentType: false,
            processData: false,
             data : remove_asset,
            beforeSend: function() {
                $('.load-removeasset').show();
                $('#remove_button').hide();
              },
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
                    // $('.remove').hide();
                    // $('#Removereason').modal('toggle');
                    
                }
            },
            error: function ()
            {
         
            }
        });

    }else{

        swal(
            {
                title: 'Please Give Asset Details',
                type: 'warning',
                confirmButtonColor: '#57a94f'
            }
        );

    }
    }
    }
   

});
function removefileverify(id){
    var removeid = id;
    $('#row_'+removeid).remove();
}
function removefileremove(id){
    var removeid = id;
    $('#remove_'+removeid).remove();
}

function addverifyFileupload(){

    var numItems = $('.picturelimit').length;
    var currentlength = numItems + 1;
    var  titlestatus =  $("#view_titlestatus").val();
   
    data ="<div class='row p-0 mb-2 mt-4 picturelimit' id='row_"+currentlength+"'>";
    data +="<div class='col-sm-5'><input type='file'  name='picture[]'  class='picture form-control' accept='.png,.jpg,.jpeg,.pdf'></div>";
    if(titlestatus==1){
    data +="<div class='col-sm-5'><input type='text' name='picture_tile[]'  class='picture_tile form-control'></div>";
    }
    data +="<div class='col-sm-2 text-right'><button class='btn btn-danger btn-circle btn-sm remCF' name='sub' id='del1' type='button' onclick='removefile("+currentlength+")'>-</button></div>";
    data +="</div>";
    $('#pictureupload').append(data);

}
function addremoveFileupload(){

    var numItems = $('.removepicturelimit').length;
    var currentlength = numItems + 1;
    var  titlestatus =  $("#view_titlestatus").val();
   
    data ="<div class='row p-0 mb-2 mt-4 removepicturelimit' id='row_"+currentlength+"'>";
    data +="<div class='col-sm-5'><input type='file'  name='picture[]'  class='picture form-control' accept='.png,.jpg,.jpeg,.pdf'></div>";
    if(titlestatus==1){
    data +="<div class='col-sm-5'><input type='text' name='remove_tile[]'  class='picture_tile form-control'></div>";
    }
    data +="<div class='col-sm-2 text-right'><button class='btn btn-danger btn-circle btn-sm remCF' name='sub' id='del1' type='button' onclick='removefile("+currentlength+")'>-</button></div>";
    data +="</div>";
    $('#pictureremove').append(data);

}
