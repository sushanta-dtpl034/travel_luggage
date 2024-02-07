$("#removeasset_button").on('click', function(){
    var assetno  = $('#asset_number').val();
    $.ajax({
              url : base_url+'Assetmanagement/getassetfor_remove',
              type: "POST",
              data : {assetno:assetno},
              success: function(result)
              {
                  $("#assest_details").show();
                  $("#assest_details").append(result);
              }
          });
    
    });
    
    
    
    