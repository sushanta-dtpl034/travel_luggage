
/* Save Function */
$("#add_button").click(function(){ 
    if($('#addForm').parsley().validate()){            
        $.ajax({
            url : base_url+'Currency/currency_save',
            type: "POST",
            data : $("#addForm").serialize(),
            dataType: 'json',
            processData: false,
            beforeSend: function () {
                $('#global-loader').show();
            },
            success: function(result){ 
                $('#global-loader').hide();
				if(result.status==1){
                    $('#currencymodal').modal('hide');
                    $('.add_msg').html('Currency');
                    $('.insert').show();
       				$('#currencymodal').trigger("reset");
                    
                    setTimeout(function(){
                        $('.insert').hide();
                        $(`#${baseModule}List`).DataTable().ajax.reload();
                        //location.href=base_url+'Currency';
                    },2000);
                }else{
                    $('#currencymodal').modal('hide');
                    $('.add_msg').html('Currency');
					$('.alert-solid-warning').show();
                    
                    setTimeout(function(){ 
                        $('.alert-solid-warning').hide();
                        $('#currencymodal').modal('show');
                        $(`#${baseModule}List`).DataTable().ajax.reload();
                        //location.href=base_url+'Currency';
                    },2000);
                }
            },
            error: function (xhr, status, errors) {
                $('#global-loader').hide();
                //console.log(xhr.responseText);
                var pattern = /<p>(.*?)<\/p>/g;
                var arrayOfStrings = [];
                var match;
                while ((match = pattern.exec(xhr.responseText)) !== null) {
                    arrayOfStrings.push(match[1]);
                }
                $('#form_errors').html(""); 
                if(arrayOfStrings.length > 0){
                    $.each(arrayOfStrings, function (key, item) {
                        $("#form_errors").append("<li class='alert alert-danger m-0 border-0 p-1'>" + item + "</li>");
                    });
                    $(".print-error-msg").show();
                }
            }
        });
    }

}); 

/* Update Modal Open & Data Set Function */
$("body").on('click', '.up_currencymodal', function(){
	var id = $(this).attr("id");
    $.ajax({
        url: base_url+'Currency/getonecurrecny',
        type: 'post',
        data: {id: id},
        dataType: 'json',
        beforeSend: function () {
            $('#global-loader').show();
        },
        success: function(response){
            $('#global-loader').hide();
            if(response.status == 1){            
                $('#up_currencymodal').modal('show');  
                $('#up_currencyname').val(response.data.CurrencyName);
                $('#up_currencycode').val(response.data.CurrencyCodeame);
                $('#up_currencysymbole').val(response.data.CurrencySymbole);
                $('#up_currencyunicode').val(response.data.CurrencyUnicode);
                $('#cur_updateid').val(response.data.AutoID);
            }else{
                alert("Invalid ID.");
            }
        },
        error: function (xhr, status, errors) {
            $('#global-loader').hide();
            console.log(xhr.responseText);
        }
    });
});

/* Update Function */
$("#update_button").click(function(){
    if($('#updateForm').parsley().validate()){
        $.ajax({
            url : base_url+'Currency/updatecurrency',
            type: "POST",
            data : $("#updateForm").serialize(),
            dataType: 'json',
            processData: false,
            beforeSend: function () {
                $('#global-loader').show();
            },
            success: function(result){
                $('#global-loader').hide();
                if(result.status == 1){
                    $('#up_currencymodal').modal('hide');
                    $('.update_msg').html('Currency');
                    $('.update').show();
                    $('#updateForm')[0].reset();
                    setTimeout(function(){ 
                        $('.update').hide();
                        $(`#${baseModule}List`).DataTable().ajax.reload();
                        //location.href=base_url+'Currency';
                    },2000);
                }else{
                    $('#up_currencymodal').modal('hide');
                    $('.duplicate_errmsg').html('Currency');
                    $('.alert-solid-warning').show();
                    setTimeout(function(){ 
                        $('.alert-solid-warning').hide();
                        $(`#${baseModule}List`).DataTable().ajax.reload();
                        //location.href=base_url+'Currency';
                    },2000);
                    
                }
            },
            error: function (xhr, status, errors) {
                $('#global-loader').hide();
                //console.log(xhr.responseText);
                var pattern = /<p>(.*?)<\/p>/g;
                var arrayOfStrings = [];
                var match;
                while ((match = pattern.exec(xhr.responseText)) !== null) {
                    arrayOfStrings.push(match[1]);
                }
                $('#update_form_errors').html(""); 
                if(arrayOfStrings.length > 0){
                    $.each(arrayOfStrings, function (key, item) {
                        $("#update_form_errors").append("<li class='alert alert-danger m-0 border-0 p-1'>" + item + "</li>");
                    });
                    $(".print-update-error-msg").show();
                }
            }
        });
    }

}); 


/* Delete Function */
$('body').on('click','#continueDelete ',function(){
    var id = $('#updateid').val();
    // AJAX request
    $.ajax({
        url: base_url+'Currency/delete_currency',
        type: 'post',
        data: {id: id},
        beforeSend: function () {
            $('#global-loader').show();
        },
        success: function(response){
            $('#global-loader').hide();
            if(response == 1){
                $(`#${baseModule}List`).DataTable().ajax.reload();
                swal("Deleted!", "Deleted Successfully", "success");                
            }else{
                alert("Invalid ID.");
            }
        },
        error: function (xhr, status, errors) {
            $('#global-loader').hide();
            console.log(xhr.responseText);
        }
    });

});




  




