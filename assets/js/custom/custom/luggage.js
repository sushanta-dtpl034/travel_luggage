$(function () {
    var table = $('#luggage_table').DataTable({
        "processing": true,
        "serverSide": false,
        "order": [[0, "asc"]],

        //dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Any title for file',
                exportOptions: {
                    columns: [0, 1, 2]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [0, 1, 2]
                }
            },

        ],
        "ajax": {
            "url": base_url + "Qrcode/getLuggageList",
            "type": "POST",
        },
        "columns": [
            {
                "render": function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                "render": function (AutoID, type, row, meta) {
                    return '<button class="btn btn-sm bg-success mx-2 print_qrcode" data-id="' + row.AutoID +  '" ><i class="fa fa-qrcode fa-lg" aria-hidden="true"></i></button>';
                }
            },
            { "data": "QrCodeNo" },
            { "data": "Name" },
            { "data": "PhoneNumber" },
            { "data": "TraavelType" },
            { "data": "AirlineName" },
            { "data": "PnrNo" },
            { "data": "TraavelFrom" },
            { "data": "TraavelTo" },
            { "data": "TravelDate" },
            { "data": "HotelName" },
            { "data": "RoomNo" },
            { "data": "CheckInDate" },
            { "data": "CheckOutDate" },
           

        ],

        "drawCallback": function (settings) {

        },
        "initComplete": function (settings, json) {
        }

    });

    
    $('body').on('click','.print_qrcode',function(){
        const id=$(this).data("id") 
        $('#qrcode_id').val(id);
        $('#singleModalLuggage').modal('show');

        $('.printSingleQrcode').click(function () {
            let noOfCopy = $('.print_copySingle :selected').val();
            if (noOfCopy.length == 0) {
                alert('Choose No of Copy');
                return false;
            } else {
                $('#singleModalLuggage').modal('hide');
            }
        });
    })

    $('body').on('click','.updateRoomNo',function(){
        const id=$(this).data("id") 
        console.log(id);
        $('#travel_id').val(id);
        $('#UpdateTravelModal').modal('show');
    })
    $('body').on('click','.updateRoom',function(){
        const travel_id =$('#travel_id').val();
        const RoomNo =$('#RoomNo').val();
        if(RoomNo !="" && RoomNo.length > 0){
            $.ajax({
                url: base_url+'Qrcode/alert_room_no',
                type: 'post',
                data: {
                    travel_id: travel_id,
                    RoomNo:RoomNo
                },
                dataType: 'json',
                success: function(response){
                    if(response.status == 200){
                        $('#UpdateTravelModal').modal('hide'); 
                        alert('Room no alerted Successfully.')  
                    }else{
                        alert("Invalid ID.");
                    }
                }
            });
        }else{
            alert('Enter Room No.')
        }
    }) 

});


 
// const printSingleQrcode = (id) => {
//     $('#singleModal').modal('show');
//     $('#qrcode_id').val(id);
//     $('.printSingleQrcode').click(function () {
//         let noOfCopy = $('.print_copySingle :selected').val();
//         if (noOfCopy.length == 0) {
//             alert('Choose No of Copy');
//             return false;
//         } else {
//             $('#singleModal').modal('hide');
//         }
//     });

// }