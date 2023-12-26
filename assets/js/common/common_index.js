// import { datatable } from './list.js?2';

import { datatable } from './list.js';
"use strict";
// Class definition
var userTypeModule = function () {  
    return {
        // public functions
        init: function () {
            datatable();
            
        }
    };
}();

jQuery(document).ready(function () {
    userTypeModule.init();
});

/**
 * Add Form Modal Close time Form field value reset
 */
$(".closeModal").on("click", function () {
    $('#addForm')[0].reset();
    $(".print-error-msg").hide();
    $('#form_errors').html(""); 
    $(".print-update-error-msg").hide();
    $('#update_form_errors').html(""); 
});
