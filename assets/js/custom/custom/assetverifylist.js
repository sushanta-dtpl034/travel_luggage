$("#find_Assest").on('click', function(){
var assetno  = $('#asset_number').val();
$.ajax({
          url : base_url+'Assetmanagement/getassetfor_verify',
          type: "POST",
          data : {assetno:assetno},
          success: function(result)
          {
                $("#assest_details").show();
                $('#assest_details tbody').empty();  
                $("#assest_details").append(result);
          }
      });

});

function assetdetail(id){
    var ref = $("#"+id).val();
    var stringArray = ref.split("/");
    var assestref = stringArray[0];
    var assesttype = stringArray[1];
    url =  base_url+'Assetmanagement/ViewAssetDetails?ref_no='+assestref+'&type='+assesttype,
    location.href = url;
}



