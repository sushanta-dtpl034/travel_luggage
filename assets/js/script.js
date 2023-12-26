
$(document).ready(function(){
var i = 1;
var table = $('#planlist').DataTable( {
      
    "processing": false,
    'serverSide':false,
     'paging':'true',
     'order':[],
     'ajax': {
        'url':base_url+'Plan/getplan',
        'type':'GET',
      },
    "columns": [
        {"render": function(data, type, row, meta ) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {data: 'PlanName'},
        {data: 'Price'},
        {data: 'Storage'},
        { "render": function ( AutoID, type, row, meta ) {
            if(row.TimePeriod==1){
                return '<p class="text-success small mb-0 mt-1 tx-12">Month</p>';
            }else{
                return '<p class="text-success small mb-0 mt-1 tx-12">Year</p>';
            }
          }},
        {data: 'TotalDays'},
        {
            "render": function ( AutoID, type, row, meta ) {
                if(row.isActive==1){
                    return '<p class="text-success small mb-0 mt-1 tx-12">Active</p>';
                }else{
                    return '<p class="text-danger small mb-0 mt-1 tx-12">Inactive</p>';
                }
              }
        },
        { "render": function ( AutoID, type, row, meta ) {
            return '<button class="btn planview btn-primary" id="'+row.AutoID+'" datatype="view"><i class="fe fe-eye"></i></button><button class="btn planview bg-success" id="'+row.AutoID+'"  datatype="edit"><i class="si si-pencil"></i></button><button class="btn ripple plandelete btn-info" id="'+row.AutoID+'"><i class="fe fe-trash"></i></button>';
          }
        }
        

    ]
} );

$("#plan").click(function(){
    if($('#planform').parsley().validate())
     {
         var planurl = $('#planurl').val();
         $.ajax({
                 url : planurl,
                 type: "POST",
                 data : $("#planform").serialize(),
                 success: function(result)
                 {
                     var jsonData = JSON.parse(result);
                     if(jsonData.status===1){
                         $('#planmodal').modal('toggle');
                         $('.insert').show();
                         $('#planmodal form')[0].reset();
                    setInterval(function(){
                             $('.insert').hide();
                             table.ajax.reload();
                             location.href=base_url+'Plan/planList';
                         },2000);
                     }else{
                         $('#planmodal').modal('toggle');
                         $('.alert-solid-warning').show();
                         $('#planmodal form')[0].reset();
                          setInterval(function(){ 
                            $('.alert-solid-warning').hide();
                            table.ajax.reload();
                            location.href=base_url+'Plan/planList';
                            },2000);
                     }
                 },
               
             });
     }

}); 


$("#planlist").on('click', '.planview', function(){
	var id = $(this).attr("id");
    var actiontype = $(this).attr('datatype');
    $.ajax({
        url: base_url+'Plan/getsingleplan',
        type: 'post',
        data: {id: id},
        dataType: 'json',
        success: function(response){
           if(response.status == 1){
            $('#updateplan').modal('show');  
             $('#up_planname').val(response.data.planname);
             $('#up_amount').val(response.data.amount);
             $('#up_storage').val(response.data.storage);
             $('#up_period').val(response.data.month);
             $('#up_days').val(response.data.days);

             if(response.data.active==1){
                $('#up_active').prop('checked', true); // Checks it
             }else{
                $('#up_active').prop('checked', false); // Unchecks it
             }
             $('#updateid').val(response.data.id);
             if(actiontype=='view'){
                $('#update').hide();
            }else{
                $('#update').show();
               
             }
           }else{
             alert("Invalid ID.");
           }
        }
     });


});

$("#update").click(function(){
    if($('#updateplanform').parsley().validate())
     {
     
         $.ajax({
                 url : base_url+'Plan/updateplan',
                 type: "POST",
                 data : $("#updateplanform").serialize(),
                 success: function(result)
                 {
                     var jsonData = JSON.parse(result);
                     if(jsonData.status===1){
                         $('#updateplan').modal('toggle');
                         $('.alert-solid-success').show();
                         setInterval(function(){ 
                             $('.update').hide();
                             table.ajax.reload();
                             location.href=base_url+'Plan/planList';
                            },2000);
                     }else{
                         $('#updateplan').modal('toggle');
                         $('.alert-solid-warning').show();
                         setInterval(function(){ 
                             $('.alert-solid-warning').hide();
                             table.ajax.reload();
                             location.href=base_url+'Plan/planList';
                            },2000);
                         
                     }
                 },
                
             });
     }

}); 


$('#planlist').on('click','.plandelete',function(){
    var id = $(this).attr('id');
    var deleteConfirm = confirm("Are you sure?");
    if (deleteConfirm == true) {
       // AJAX request
       $.ajax({
         url: base_url+'Plan/deleteplan',
         type: 'post',
         data: {id: id},
         success: function(response){
            if(response == 1){
                table.ajax.reload();
            }else{
               alert("Invalid ID.");
            }
         }
       });
    } 

 });

});
