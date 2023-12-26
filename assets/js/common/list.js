let tableObj = '';
var dtClassName = '';
function datatable() {
    //column settings :starts
    const columnFirst = [{
        'className': dtClassName,
        'defaultContent': '',
        'data': null,
        'orderable': false,
        'render': function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
        }
    }];

    let columnAction = [];
    if(typeof actionsSettings === 'undefined'){
        let actionsSettings = {};
    }
    if(typeof actionsSettings === 'undefined' || actionsSettings === null){
        actionsSettings = {};
    }

    if (Object.hasOwn(actionsSettings, 'view') || Object.hasOwn(actionsSettings, 'history') || Object.hasOwn(actionsSettings, 'extraAdd') || Object.hasOwn(actionsSettings, 'edit') || Object.hasOwn(actionsSettings, 'delete') || (typeof listActionButtons !== 'undefined' && listActionButtons.length > 0)) {
        columnAction = [{
            // 'className': 'dt-control',
            'data': null,
            'orderable': false,
            'render': function (data, type, row, meta) {
                let actionHtm = '';
                if (Object.hasOwn(actionsSettings, 'view')) {
                    let editsettings = actionsSettings.view;
                    let hideEditBtn = '';
                    if (typeof editsettings.hideActionRule !== 'undefined') {
                        //hide buttons on specific condition                        
                        if (typeof editsettings.hideActionRule !== 'undefined') {
                            hideEditBtn = 'yes';                      
                            $.each(editsettings.hideActionRule, function (index, dataval) {                                
                                if (dataval !== ''){
                                    if (Array.isArray(dataval) && !($.inArray(row[index], dataval) > -1)) {
                                        hideEditBtn = '';
                                    } else if(!Array.isArray(dataval) && row[index] != dataval && hideBtnClass != ""){
                                        hideEditBtn = '';
                                    }
                                } 
                            });
                        }
                    }
                    
                    if(hideEditBtn != 'yes'){
                        if(actionsSettings['view'] == 'popup'){
                            actionHtm += `<a class="btn btn-sm btn-info ${actionsSettings['viewClass']}" href='#'  data-cname="${row['CName']}" id="${row['PONumber']}"> <i class="mdi mdi-eye"></i></a>`;
                        }else{
                            //custom view button for advance payment employee model
                            var viewMode = (typeof actionsSettings.viewMode == 'undefined')?3:actionsSettings.viewMode;
                            var viewColValue = (typeof actionsSettings.viewColValue == 'undefined')?row['AutoID']:row[actionsSettings.viewColValue];
                            
                            if(typeof actionsSettings.viewurl == 'undefined'){
                                var  viewurl = (typeof customEditUrl !== 'undefined' && customEditUrl !== "") ? `${customEditUrl}?mode=${viewMode}&id=${viewColValue}` : `${base_url}${baseModule}/manage/${row['AutoID']}`;                               
                            }else{
                                var viewurl = `${actionsSettings.viewurl}?mode=${viewMode}&id=${viewColValue}`;
                            }
                            actionHtm += `<a class="btn btn-sm btn-info ${actionsSettings['viewClass']}" href='${viewurl}${editExtraParams}'> <i class="mdi mdi-eye"></i></a>`;
                        }
                      
                    }
                }

                if (Object.hasOwn(actionsSettings, 'edit')) {
                    let editsettings = actionsSettings.edit;
                    let editActionUrlStatus=true;
                    let hideEditBtn = '';
                    if (typeof editsettings.hideActionRule !== 'undefined') {
                        //hide buttons on specific condition                        
                        if (typeof editsettings.hideActionRule !== 'undefined') {
                            hideEditBtn = 'yes';                      
                            $.each(editsettings.hideActionRule, function (index, dataval) {                                
                                if (dataval !== ''){
                                    if (Array.isArray(dataval) && !($.inArray(row[index], dataval) > -1)) {
                                        hideEditBtn = '';
                                    } else if(!Array.isArray(dataval) && row[index] != dataval && hideBtnClass != ""){
                                        hideEditBtn = '';
                                    }
                                } 
                            });
                        }
                    }
					
                    if(hideEditBtn != 'yes'){
                        if(actionsSettings['edit'] == 'popup'){
                            actionHtm += `&nbsp;&nbsp; <a class="btn btn-sm btn-info ${actionsSettings['editpopupID']}" href='#' data-bs-toggle="modal" data-bs-target="#${actionsSettings['editpopupID']}" id="${row['AutoID']}"> <i class="si si-pencil"></i></a>`;
                        }else{
                            let editurl;
                            let editurlClass;
                            if(actionsSettings['isEditDisable'] === true){
                                if(row['CreatedBy'] == actionsSettings['isEditDisableID']){
                                    editurl = (typeof customEditUrl !== 'undefined' && customEditUrl !== "") ? `${customEditUrl}?mode=2&id=${row['AutoID']}` : `${base_url}${baseModule}/manage/${row['AutoID']}`;
                                }else{
                                    editurl = 'javascript:void(0)';
                                    editurlClass='editDisable';
                                }
                            }else{
                                editurl = (typeof customEditUrl !== 'undefined' && customEditUrl !== "") ? `${customEditUrl}?mode=2&id=${row['AutoID']}` : `${base_url}${baseModule}/manage/${row['AutoID']}`;
                            }
                            if(row['logStatus']  && row['logStatus'] == 2){
                                editurl = 'javascript:void(0)';
                                editurlClass='editDisable';
                            }
                            editActionUrlStatus = (typeof actionsSettings.editUrlStatus == 'undefined')?true:actionsSettings.editUrlStatus;
                            if(editActionUrlStatus){
                                actionHtm += `&nbsp;&nbsp;<a class="btn update_currency bg-success mx-2 btn-sm ${actionsSettings['editClass']} ${editurlClass}"   href='${editurl}${editExtraParams}'> <i class="si si-pencil"></i></a>`;
                            }else{
                                actionHtm += `&nbsp;&nbsp;<button class="btn update_currency bg-success mx-2 btn-sm ${actionsSettings['editClass']} ${editurlClass}"   href='#' data-mode="2" data-id="${row['AutoID']}"> <i class="si si-pencil"></i></button>`;
                            }
                            // actionHtm += `&nbsp;&nbsp;<a class="btn btn-sm btn-warning ${actionsSettings['editClass']} ${editurlClass}"   href='${editurl}${editExtraParams}'> <i class="si si-pencil"></i></a>`;
                        }
                    }
                    // if(typeof actionsSettings.editpopupID != 'undefined' && actionsSettings.editpopupID != ''){
                    //     $('#'+actionsSettings.editpopupID).modal('show');
                    // }
                }

                /**
                 * Send to History => Employee => Log Report
                 */
                if (Object.hasOwn(actionsSettings, 'history')) {
                    let editsettings = actionsSettings.history;
                    let hideEditBtn = '';
                    if (typeof editsettings.hideActionRule !== 'undefined') {
                        //hide buttons on specific condition                        
                        if (typeof editsettings.hideActionRule !== 'undefined') {
                            hideEditBtn = 'yes';                      
                            $.each(editsettings.hideActionRule, function (index, dataval) {                                
                                if (dataval !== ''){
                                    if (Array.isArray(dataval) && !($.inArray(row[index], dataval) > -1)) {
                                        hideEditBtn = '';
                                    } else if(!Array.isArray(dataval) && row[index] != dataval && hideBtnClass != ""){
                                        hideEditBtn = '';
                                    }
                                } 
                            });
                        }
                    }
                    
                    if(hideEditBtn != 'yes'){
                        if(actionsSettings['history'] == 'popup'){
                            actionHtm += `&nbsp;&nbsp; <a class="btn btn-sm btn-info ${actionsSettings['historyClass']}" href='#'  data-cname="${row['CName']}" id="${row['PONumber']}"> <i class="mdi mdi-eye"></i></a>`;
                        }else{
                            //custom view button for advance payment employee model
                            var historyMode = (typeof actionsSettings.historyMode == 'undefined')?3:actionsSettings.historyMode;
                            var historyColValue = (typeof actionsSettings.historyColValue == 'undefined')?row['AutoID']:row[actionsSettings.historyColValue];
                            
                            if(typeof actionsSettings.historyurl == 'undefined'){
                                var  historyurl = (typeof customEditUrl !== 'undefined' && customEditUrl !== "") ? `${customEditUrl}?mode=${historyMode}&id=${historyColValue}` : `${base_url}${baseModule}/manage/${row['AutoID']}`;                               
                            }else{
                                var historyurl = `${actionsSettings.historyurl}?mode=${historyMode}&id=${historyColValue}`;
                            }
                            
                            actionHtm += `&nbsp;&nbsp;<a class="btn btn-sm btn-danger ${(row['Amount'] > 0)?'notSendHistory':actionsSettings['historyClass']}" data-id='${row['AutoID']}' ${(row['Amount'] > 0)?'disabled':''} > <i class="mdi mdi-history"></i></a>`;
                        }
                      
                    }
                }
                /**
                 * Add Expenses => Employee => Log Report
                 */
                if (Object.hasOwn(actionsSettings, 'extraAdd')) {
                    let editsettings = actionsSettings.extraAdd;
                    let hideEditBtn = '';
                    if (typeof editsettings.hideActionRule !== 'undefined') {
                        //hide buttons on specific condition                        
                        if (typeof editsettings.hideActionRule !== 'undefined') {
                            hideEditBtn = 'yes';                      
                            $.each(editsettings.hideActionRule, function (index, dataval) {                                
                                if (dataval !== ''){
                                    if (Array.isArray(dataval) && !($.inArray(row[index], dataval) > -1)) {
                                        hideEditBtn = '';
                                    } else if(!Array.isArray(dataval) && row[index] != dataval && hideBtnClass != ""){
                                        hideEditBtn = '';
                                    }
                                } 
                            });
                        }
                    }
                    
                    if(hideEditBtn != 'yes'){
                       
                        if(actionsSettings['extraAdd'] == 'popup'){
                            actionHtm += `&nbsp;&nbsp; <a class="btn btn-sm btn-info ${actionsSettings['extraAddClass']}" href='#'  data-cname="${row['CName']}" id="${row['PONumber']}"> <i class="mdi mdi-eye"></i></a>`;
                        }else{
                            var htmlIcon='';
                            var btncolor='';
                            //custom view button for advance payment employee model
                            var extraaddMode = (typeof actionsSettings.extraaddMode == 'undefined')?3:actionsSettings.extraaddMode;
                            var extraaddColValue = (typeof actionsSettings.extraaddColValue == 'undefined')?row['AutoID']:row[actionsSettings.extraaddColValue];
                            
                            if(typeof actionsSettings.extraaddurl == 'undefined'){
                                var  extraaddurl = (typeof customEditUrl !== 'undefined' && customEditUrl !== "") ? `${customEditUrl}?mode=${extraaddMode}&id=${extraaddColValue}` : `${base_url}${baseModule}/manage/${row['AutoID']}`;                               
                            }else{
                                if(row['logStatus']  && row['logStatus'] == 2){
                                    htmlIcon='<i class="mdi mdi-eye"></i>';
                                    btncolor='btn-info';
                                }else{
                                    htmlIcon='<i class="mdi mdi-plus"></i>';
                                    btncolor='btn-success';
                                }
                                var extraaddurl = `${actionsSettings.extraaddurl}?mode=${extraaddMode}&id=${extraaddColValue}`;
                            }
                            actionHtm += `&nbsp;&nbsp; <a class="btn btn-sm ${btncolor} ${actionsSettings['extraAddClass']}" href='${extraaddurl}${editExtraParams}'> ${htmlIcon}</a>`;
                        }
                      
                    }
                }


                if (Object.hasOwn(actionsSettings, 'delete')) {
                    let deletesettings = actionsSettings.delete;
                    let hideDelBtn = '';
                    if (typeof deletesettings.hideActionRule !== 'undefined') {
                        //hide buttons on specific condition                        
                        if (typeof deletesettings.hideActionRule !== 'undefined') {
                            hideDelBtn = 'yes';                      
                            $.each(deletesettings.hideActionRule, function (index, dataval) {                                               
                                if (dataval !== ''){
                                    if (Array.isArray(dataval) && !($.inArray(row[index], dataval) > -1)) {
                                        hideDelBtn = '';
                                    } else if(!Array.isArray(dataval) && row[index] != dataval && hideBtnClass != ""){
                                        hideDelBtn = '';
                                    }
                                } 
                            });
                        }
                    }

                    if(hideDelBtn != 'yes'){
                        let deleteurlClass;
                        if(actionsSettings['isDeleteDisable'] === true){
                            if(row['CreatedBy'] == actionsSettings['isDeleteDisableID']){
                                deleteurlClass='delete';
                            }else{
                                deleteurlClass='deleteDisable';
                            }
                        }else{
                            deleteurlClass='delete';
                        }
                        
                        actionHtm += `&nbsp;&nbsp;<button class='btn ripple delete_currency btn-danger btn-sm ${deleteurlClass}' data-id=${row['AutoID']}><i class="fe fe-trash"></i></button>`;
                    }
                }

                //custom action settings: starts
                if (typeof listActionButtons !== 'undefined' && listActionButtons.length > 0) {
                    $.each(listActionButtons, function (index, element) {

                        let icon = '';
                        if (typeof element.feathericon !== 'undefined' && element.feathericon !== '') {
                            icon = '<i data-feather="'+element.feathericon+'"></i>';
                        }
                        else if (typeof element.faicon !== 'undefined' && element.faicon !== '') {
                            icon = '<i class="' + element.faicon + '"></i>';
                        }
                        

                        let dataAttrHtm = '';
                        if (typeof element.data_attribute !== 'undefined' && element.data_attribute !== '' && element.data_attribute.length > 0) {
                            $.each(element.data_attribute, function (index, dataattr) {
                                dataAttrHtm += 'data-'+dataattr+'="'+row[dataattr]+'"';
                            });                            
                        }

                        //hide buttons on specific condition
                        let hideBtnClass = '';
                        if (typeof element.hideActionRule !== 'undefined') {
                            hideBtnClass = ' d-none';                      
                            $.each(element.hideActionRule, function (index, dataval) {                                
                                if (dataval !== ''){
                                    if (Array.isArray(dataval) && !($.inArray(row[index], dataval) > -1)) {
                                        hideBtnClass = '';
                                    } else if(!Array.isArray(dataval) && row[index] != dataval && hideBtnClass != ""){
                                        hideBtnClass = '';
                                    }
                                } 
                            });
                        }

                        let href = 'javascript:void(0)';
                        if (typeof element.href !== 'undefined' && element.href !== '') {                            
                            if (typeof element.append_to_action_url !== 'undefined' && element.append_to_action_url !== '') {
                                href += '/'+element.append_to_action_url;
                            }
                            //IF find key and replace in URL
                            if (typeof element.urlsearch !== 'undefined' && typeof element.urlreplace !== 'urlreplace') {
                                href = element.href.replace(`#${element.urlsearch}#`, row[element.urlreplace]);
                            } else {
                                href = element.href+'/'+row['AutoID'];
                            }
                        }
                        
                        actionHtm += "&nbsp;&nbsp;<a href='"+href+"' id='"+element.id+row['AutoID']+"' class='"+element.className+hideBtnClass+" btn btn-xs' data-id="+row['AutoID']+" title='"+ element.title +"' "+dataAttrHtm+">"+ element.text + "&nbsp;"+icon+"</a>";
                    });
                }
                return `<div class="btn-group1">${actionHtm}</div>`;
            }
        }];
    }
	
    let columnArr = [...columnFirst, ...configuredColumns, ...columnAction];
   
    //column settings :ends

    /* For Export Buttons available inside jquery-datatable "server side processing" - Start
    - due to "server side processing" jquery datatble doesn't support all data to be exported
    - below function makes the datatable to export all records when "server side processing" is on */

    function newexportaction(e, dt, button, config) {
        var self = this;
        var oldStart = dt.settings()[0]._iDisplayStart;
        dt.one('preXhr', function (e, s, data) {
            // Just this once, load all data from the server...
            data.start = 0;
            data.length = 2147483647;
            dt.one('preDraw', function (e, settings) {
                // Call the original action function
                if (button[0].className.indexOf('buttons-copy') >= 0) {
                    $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
                } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                    $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                        $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                        $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                    $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                        $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                        $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
                } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                    $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                        $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                        $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
                } else if (button[0].className.indexOf('buttons-print') >= 0) {
                    $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                }
                dt.one('preXhr', function (e, s, data) {
                    // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                    // Set the property to what it was before exporting.
                    settings._iDisplayStart = oldStart;
                    data.start = oldStart;
                });
                // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                setTimeout(dt.ajax.reload, 0);
                // Prevent rendering of the full data to the DOM
                return false;
            });
        });
        // Requery the server with the new one-time export settings
        dt.ajax.reload();
    };
    //For Export Buttons available inside jquery-datatable "server side processing" - End
    
    let CustomExportButton ={
        title: 'Insurance Companies',
        extend: 'collection',
        text: 'Exports',
        buttons: [
            {
                extend: 'copy',
                exportOptions: {
                    columns: ':not(:last-child)' // Exclude last columns
                },
                title:$('.page-title').text()+ " List-"+new Date().toDateString(),
            },
            {
                extend: 'excel',
                exportOptions: {
                    columns: ':not(:first-child):not(:last-child)' // Exclude first and last columns
                },
                filename: () => $('.page-title').text()+ " List-"+new Date().toDateString(),
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':not(:first-child):not(:last-child)' // Exclude first and last columns
                },
                filename: () => $('.page-title').text()+ " List-"+new Date().toDateString(),
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: ':not(:last-child)' // Exclude  last columns
                },
                title:$('.page-title').text()+ " List-"+new Date().toDateString(),
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':not(:last-child)' // Exclude last columns
                },
                title:$('.page-title').text()+ " List-"+new Date().toDateString(),
            }
        ],
        className: 'btn btn-success me-1',
       
    }
    let exportButtons = [];
    if (exportSettings.length > 0) {
        function getExportFileName() {
            let listtitle = $('.page-header-content').find('.header-title').html();
            listtitle = listtitle.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '');
            var d = new Date();
            var n = d.getTime();
            return `${listtitle}-${n}`;
        }

        exportButtons = [
            {
                text: '<i class="fa fa-download"></i> Excel',
                className: 'btn btn-info me-1',
                id: 'gridExportExcel',
                extend: 'collection',
                title: '',
                action: newexportaction,
                exportOptions: {
                    columns: ':visible'
                },
                filename: function () { return getExportFileName(); }
            },
            {
                text: '<i class="fa fa-download"></i> PDF',
                className: 'btn btn-info me-1',
                id: 'gridExportExcel',
                extend: 'collection',
                action: newexportaction,
                title: '',
                exportOptions: {
                    columns: ':visible'
                },
                orientation : 'landscape',
                pageSize : 'LEGAL',
                filename: function () { return getExportFileName(); }
            },
        ];
    }

    let POrefreshButton = [];
    if (Object.hasOwn(actionsSettings, 'porefresh')) {
        let addActionUrl = `${base_url}${baseModule}/manage${addExtraParams}`;
        // if (Object.hasOwn(actionsSettings, 'refreshurl') && actionsSettings.add !== '') {
        //     addActionUrl = actionsSettings.refreshurl;
        // }
        POrefreshButton = [
            {
                text: '<i class="mdi mdi-refresh"></i> PO Refresh',
                className: 'btn btn-info me-1 POrefresh',
                id: 'gridAdd',
                titleAttr: 'PO Refresh',
                init: function (dt, node, config) {
                   // $(node).attr('href', `${addActionUrl}`)
                },
                action: function (e, dt, node, config) {
                    //This will send the page to the location specified
                    if (actionsSettings.add == 'popup') {
                        alert('showpopup');
                    } else {
                        //window.location.href = `${addActionUrl}`;
                    }
                }
            }
        ];
    }

    let LineItemrefreshButton = [];
    if (Object.hasOwn(actionsSettings, 'lineitemrefresh')) {
        let addActionUrl = `${base_url}${baseModule}/manage${addExtraParams}`;
        // if (Object.hasOwn(actionsSettings, 'refreshurl') && actionsSettings.add !== '') {
        //     addActionUrl = actionsSettings.refreshurl;
        // }
        LineItemrefreshButton = [
            {
                text: '<i class="mdi mdi-refresh"></i> Line Items Refresh',
                className: 'btn btn-info me-1 lineItemrefresh',
                id: 'gridAdd',
                titleAttr: 'Line ItemsRefresh',
                init: function (dt, node, config) {
                   // $(node).attr('href', `${addActionUrl}`)
                },
                action: function (e, dt, node, config) {
                    //This will send the page to the location specified
                    if (actionsSettings.add == 'popup') {
                        alert('showpopup');
                    } else {
                        //window.location.href = `${addActionUrl}`;
                    }
                }
            }
        ];
    }


    let refreshButton = [];
    if (Object.hasOwn(actionsSettings, 'refresh')) {
        let addActionUrl = `${base_url}${baseModule}/manage${addExtraParams}`;
        // if (Object.hasOwn(actionsSettings, 'refreshurl') && actionsSettings.add !== '') {
        //     addActionUrl = actionsSettings.refreshurl;
        // }
        refreshButton = [
            {
                text: '<i class="mdi mdi-refresh"></i> Refresh',
                className: 'btn btn-info me-1 refresh',
                id: 'gridAdd',
                titleAttr: 'Refresh',
                init: function (dt, node, config) {
                   // $(node).attr('href', `${addActionUrl}`)
                },
                action: function (e, dt, node, config) {
                    //This will send the page to the location specified
                    if (actionsSettings.add == 'popup') {
                        alert('showpopup');
                    } else {
                        //window.location.href = `${addActionUrl}`;
                    }
                }
            }
        ];
    }


    let addButton = [];
    if (Object.hasOwn(actionsSettings, 'add')) {
        let addActionUrl = `${base_url}${baseModule}/manage${addExtraParams}`;
        let addActionUrlStatus=true;
        if (Object.hasOwn(actionsSettings, 'addurl') && actionsSettings.add !== '') {
            addActionUrl = actionsSettings.addurl;
            addActionUrlStatus = (typeof actionsSettings.addurlStatus == 'undefined')?true:actionsSettings.addurlStatus;
        }
        addButton = [
            {
                text: '<i class="mdi mdi-file-plus"></i> New Record',
                className: 'btn btn-info me-1 addUrl',
                id: 'gridAdd',
                titleAttr: 'Add',
                init: function (dt, node, config) {
                    $(node).attr('href', `${addActionUrl}`)
                },
                action: function (e, dt, node, config) {
                    //This will send the page to the location specified
                    if (actionsSettings.add == 'popup' && actionsSettings.addpopupID != 'undefined') {
                        $('#'+actionsSettings.addpopupID).modal('show');
                    } else {
                        window.location.href =(addActionUrlStatus)? `${addActionUrl}`:`#`;
                    }
                }
            }
        ];
    }
	
    let importButtons = [];
	let ImportActionTarget = '';
	let ImportActionUrl = '';
    if (Object.hasOwn(actionsSettings, 'import')) {
		if (Object.hasOwn(actionsSettings, 'importurl') && actionsSettings.import == '') {
            ImportActionUrl = actionsSettings.importurl;
        }
		if (Object.hasOwn(actionsSettings, 'importTarget') && actionsSettings.import == '') {
            ImportActionTarget = $('#'+actionsSettings.importTarget);
        }
        importButtons = [
            {
                text: '<i class="mdi mdi-upload "></i> Import',
                className: 'btn btn-success me-1',
                id: 'gridImport',
                title: 'Import data',
                action: function (e, dt, node, config) {
					if(ImportActionUrl != '')
                    window.location.href = `${ImportActionUrl}`;
					else
					ImportActionTarget.modal('show');
                }
            },
        ];
    }


	let downloadButtons = [];
	let downloadActionTarget = '';
	let downloadActionUrl = '';
	if (Object.hasOwn(actionsSettings, 'download')) {
		if (Object.hasOwn(actionsSettings, 'downloadurl') && actionsSettings.download == '') {
            downloadActionUrl = actionsSettings.downloadurl;
        }
		if (Object.hasOwn(actionsSettings, 'downloadTarget') && actionsSettings.download == '') {
            downloadActionTarget = $('#'+actionsSettings.downloadTarget);
        }
        downloadButtons = [
            {
                text: '<i class="mdi mdi-download "></i> Download Template',
                className: 'btn btn-danger me-1',
                id: 'gridImport',
                title: 'Download Template',
                action: function (e, dt, node, config) {
					if(downloadActionUrl != '')
                    window.location.href = `${downloadActionUrl}`;
					else
					downloadActionTarget.modal('show');
                }
            },
        ];
    }
    
    //Button Setting: ends

    //
    let default_buttons = [{
        text: '<i class="fa fa-low-vision"></i> Columns',
        extend: 'colvis',
        className: 'btn btn-warning',
        title: 'Col Vis',
        columnText: function ( dt, idx, title ) {
            return title;
        }
    }];
    //
    
    //Extra Top Button Setting: starts
    let buttonSettings1 = [...POrefreshButton,...LineItemrefreshButton,...refreshButton,...addButton,CustomExportButton, ...downloadButtons, ...importButtons, ...default_buttons];
    let buttonSettings2 = [];
    let extraBtnArr = [];
    if (typeof listTopButtons !== 'undefined' && listTopButtons.length > 0) {
        $.each(listTopButtons, function (index, element) {
            let icon = '';
            if (typeof element.feathericon !== 'undefined' && element.feathericon !== '') {
                icon = '<i data-feather="' + element.feathericon + '"></i>';
            }
            else if (typeof element.faicon !== 'undefined' && element.faicon !== '') {
                icon = '<i class="' + element.faicon + '"></i>';
            }

            let btnarr = [];
            if (element.href !== '') {
                btnarr = [{
                    text: icon + ' ' + element.text,
                    className: element.className + '',
                    id: element.id,
                    title: element.title,
                    action: function (e, dt, node, config) {
                        window.location.href = element.href;
                    }
                }];
            } else {
                btnarr = [{
                    text: icon + ' ' + element.text,
                    className: element.className + ' ',
                    id: element.id,
                    title: element.title,
                }];
            }
            extraBtnArr = [...extraBtnArr, ...btnarr];
        });
        buttonSettings2 = extraBtnArr;

    }
    let buttonSettings = $.merge(buttonSettings1, buttonSettings2);
    //Extra Top Button Setting: ends 
	
    //List page custom parameters
    let pgNm = '';
    if ($('#' + baseModule + '_swpg').length) {
        pgNm = $('#' + baseModule + '_swpg').val();
        $(document).on("change", '#' + baseModule + '_swpg', function () {
            dataParams.pgnm = $(this).val();
            $(`#${baseModule}List`).DataTable().ajax.reload();
        });
    }
	
    

    /**
     * Advance Filter
     */
    $(document).on('click', `#${baseModule}advancefilter`, function () {
       let callfilter = 0;
        $(`#${baseModule}FilterContainer input, #${baseModule}FilterContainer select`).each(function (index) {
            var input = $(this);
            if (typeof input.attr('name') !== 'undefined') {
                let attrnm = $(this).attr('name');
                let attrval = $(this).val();    
                if($.inArray(input.attr('type'),['checkbox','radio']) > -1){
                    attrval = input.is(':checked') ? 1 : 0;//get checkbox value. Still need tobe implemented
                }                
                dataParams[attrnm] = attrval;          
                callfilter = 1;      
            }
        });
        if(callfilter){
            $(`#${baseModule}List`).DataTable().ajax.reload();
        }
        
    });
    
    /**
     * Clear Advance Filters
     */
    $(document).on('click', `#${baseModule}clearFilters`, function () {
        let callfilter = 0;
        $(`#${baseModule}FilterContainer input, #${baseModule}FilterContainer select`).each(function (index) {
        var input = $(this);
        if (typeof input.attr('name') !== 'undefined') {
            let attrnm = $(this).attr('name');
            let attrval = '';               
            if($.inArray(input.attr('type'),['checkbox','radio']) > -1){
                if(input.is(':checked') == 1){
                    //uncheck the box
                    input.prop('checked', false);//set first unchecked radio or checkboxes
                }
                attrval = 0;//get checkbox value. Still need tobe implemented
            }
            input.val('');
            $('#DepartmentID').multiselect('rebuild');
            $('#CategoryID').multiselect('rebuild');
            $('#SubCategoriesID').multiselect('rebuild');                
            $('#issuers').multiselect('rebuild');                
            $('#resolvers').multiselect('rebuild');                
            $('#furtherCategoriesID').multiselect('rebuild');                
            dataParams[attrnm] = attrval;
            callfilter = 1;      
        }     
        
        });
        if(callfilter){
            $(`#${baseModule}List`).DataTable().ajax.reload();
        }
    });

    let dataParams = (pgNm != '') ? { pgnm: pgNm } : {};
    if (typeof listExtraParams !== 'undefined' && listExtraParams !== "") {
        dataParams = { ...dataParams, ...listExtraParams };
    }
    let orderSetting; //=  [[1, 'asc']];    
    if (typeof orderListSetting !== 'undefined' && orderListSetting.length > 0) {
        orderSetting = orderListSetting;
    }

    //console.log(...orderSetting);

    var removeByAttr = function(arr, attr, value){
        var i = arr.length;
        while(i--){
            if( arr[i] && arr[i].hasOwnProperty(attr) && (arguments.length > 2 && arr[i][attr] === value ) ){ 
               arr.splice(i,1);
            }
        }
        return arr;
    }
    $.each(expandableColumns, function (index, expVal) {
        removeByAttr(columnArr, 'data', expVal);
    });

    var sortCol = $(`#${baseModule}List`).attr('sortCol');
    var sortOrder = $(`#${baseModule}List`).attr('sortOrder');
    var sortData = [];
    if(sortCol != '' && sortOrder != ''){
        sortData.push( [sortCol, sortOrder] );
    }
	
	//List page custom parameters for User/ViewPaymentmode
    let paymentType = '';
    $(document).on('click', `.pmode`, function () {
        dataParams.paymentType = 0;
        $(`#${baseModule}List`).DataTable().ajax.reload();
    });
    $(document).on('click', `.cpmode`, function () {
        dataParams.paymentType =1;
        $(`#${baseModule}List`).DataTable().ajax.reload();
    });
	
	
    //Button Setting: ends
    tableObj = $(`#${baseModule}List`).DataTable({
        'responsive': true,
        'orderable': true,
        'processing': true,
        'serverSide': true,
        'colReorder': true,
        'stateSave': true,
        'aaSorting': orderSetting,
        'dom': "<'row d-flex justify-content-between'<'col-sm-10 mt-3'B><'col-sm-2'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row d-flex justify-content-between my-3'<'col-sm-5'l><'col-sm-7 d-flex justify-content-end'pi>>",//'Blfrtip',
        // 'bSort': true,
        //'sDom': '<"H"lr>t<"F"ip>',
        'lengthMenu': [[10,20,30,50, 100, - 1], [10,20,30,50, 100, "All"]],
        'buttons': buttonSettings,
        'language': {
            searchPlaceholder: 'Search Records'
        },
        'ajax': {
            'url': `${base_url}${baseModule}/getRecords${queryParams}`,
            'type': 'POST',
            data: function (d) { 
                if ($('meta[name="csrf_hash_name"]').length) {
                    const csrfdata = { 'csrf_hash_name': $('meta[name="csrf_hash_name"]').attr('content') };
                    dataParams = { ...dataParams, ...csrfdata };                    
                }
                return $.extend({}, d, dataParams);
            },
        },
        'columns': columnArr,
        /*"drawCallback": function (settings) {
            setCsrftoken(settings.json.csrfToken);
            console.log('drawCallback- ',$('meta[name="csrf_hash_name"]').attr('content'));  
        },*/
       
        'columnDefs': columnDefsSettings,
        'rowCallback': function( row, data ) {
            //Row Settings
            if(typeof rowSettings !== 'undefined' && rowSettings !== "" && rowSettings !== null){
                for (const [col, v] of Object.entries(rowSettings)) {
                    if(typeof v.datakey !== 'undefined' && v.datakey !== "" && typeof v.dataval !== 'undefined' && v.dataval !== ""){
                        if(typeof v.class !== 'undefined' && v.class !== ""){
                            if(data[v.datakey] == v.dataval){
                                $(row).addClass(v.class);
                            } else {
                                let splval = v.dataval.split('_');                               
                                if(splval.length > 1 && splval[0] == 'gt' && parseFloat(splval[1]) < data[v.datakey]){
                                    $(row).addClass(v.class);
                                } else if(splval.length > 1 && splval[0] == 'gte' && parseFloat(splval[1]) <= data[v.datakey]){
                                    $(row).addClass(v.class);
                                } else if(splval.length > 1 && splval[0] == 'lt' && parseFloat(splval[1]) > data[v.datakey]){
                                    $(row).addClass(v.class);
                                }  else if(splval.length > 1 && splval[0] == 'lte' && parseFloat(splval[1]) >= data[v.datakey]){
                                    $(row).addClass(v.class);
                                }
                            }                            
                        }
                    }
                }//for
            }//IF

            //Column Settings
            if(typeof colSettings !== 'undefined' && colSettings !== "" && colSettings !== null){  
                for (const [col, v] of Object.entries(colSettings)) {
                    let classname = (typeof v.class !== 'undefined' && v.class !== "") ? v.class : '';
                    if(typeof v.url !== 'undefined' && v.url !== ""){
                        let url = `${base_url}${v.url}`;
                        //let finalurl = url.replace(/#ID#/g, data.AutoID);
                        let finalurl = url.replace(`#${v.search}#`, data[v.replace]);
                        $(`td:eq(${col})`, row).html(`<a class='${classname}' href='${finalurl}'>${data[v.colValue]}</a>`);
                    } else if(typeof v.default_edit !== 'undefined' && v.default_edit === 1){
                        $(`td:eq(${col})`, row).html(`<a class='${classname}' href='${base_url}${baseModule}/manage/${data.AutoID}'>${data[v.colValue]}</a>`);
                    } else if(typeof v.default_view !== 'undefined' && v.default_view === 1){                        
                        $(`td:eq(${col})`, row).html(`<a class='${classname}' href='${base_url}${baseModule}/view/${data.AutoID}'>${data[v.colValue]}</a>`);
                    } else if(typeof v.download_url !== 'undefined' && v.download_url === 1){  
                        $(`td:eq(${col})`, row).html(`<a class='${classname}' href='${base_url}uploads/salarysheet/${data.AutoID}/${data[v.colValue]}' target='__blank'>${data[v.colValue]}</a>`);
                    } else if(typeof v.img_url !== 'undefined' && v.img_url != ''){ 
                        //	columnNo=>['img_url' => 'ProfileIMG','classname' => 'rounded-circle', 'css' => 'margin-bottom:7px;', 'colValue' => 'Name','height'=>'30','width'=>'30'],
                        $(`td:eq(${col})`, row).html(`<img class='${v.classname}' style='${v.css}' src='${data[v.img_url]}' height='${v.height}' width='${v.width}' alter='${data[v.colValue]}' /> ${data[v.colValue]}`);
                    } else if(typeof v.inputType !== 'undefined' && v.inputType != ''){ 
                        let isChecked = '';
                        isChecked = (data[v.employeeDef] == 1)?isChecked='checked':'';
                        //columnNo=>['inputType' => 'checkbox','className' =>'form-check form-check-inline','fieldName'=>'Status' , 'colValue' => 'AutoID','css' => '']
                        $(`td:eq(${col})`, row).html(`<input type="${v.inputType}" class="${v.className}" name="${v.fieldName}" ${isChecked} value="${data[v.colValue]}" style='${v.css}'>`);
                    } else if(typeof v.html_tag !== 'undefined' && v.html_tag != '' && typeof v.colValue !== 'undefined' && v.colValue != ''){
                       
                        let colvalue = data[v.colValue];
                        if(typeof v.conditional_class !== 'undefined'  && typeof v.conditional_class === 'object'){
                            if(colvalue in v.conditional_class){                                
                                classname = v.conditional_class[colvalue];
                            } else {
                                for (const [cc_col, cc_v] of Object.entries(v.conditional_class)) {
                                    let splval = cc_col.split('_');        
                                    let applychanges = 0;
                                    if(splval.length > 1 && splval[0] == 'gt' && parseFloat(splval[1]) < colvalue){
                                        applychanges = 1;                                  
                                    } else if(splval.length > 1 && splval[0] == 'gte' && parseFloat(splval[1]) <= colvalue){
                                        applychanges = 1; 
                                    } else if(splval.length > 1 && splval[0] == 'lt' && parseFloat(splval[1]) > colvalue){
                                        applychanges = 1;                                       
                                    }  else if(splval.length > 1 && splval[0] == 'lte' && parseFloat(splval[1]) >= colvalue){
                                        applychanges = 1;                          
                                    }
                                    
                                    if(applychanges){
                                        if(typeof cc_v.class !== 'undefined' && cc_v.class !== ""){
                                            classname =  cc_v.class;
                                        } 
                                        if(typeof cc_v.overwritetext !== 'undefined' && cc_v.overwritetext !== ""){
                                            colvalue =  cc_v.overwritetext;
                                        } 
                                        else if(typeof cc_v.appendtext !== 'undefined' && cc_v.appendtext !== ""){
                                            colvalue +=  ' '+cc_v.appendtext;
                                        }
                                    }                                        
                                }//for

                            }//else                            
                        }
                        let finalhtml;
                        if(v.isCustomField && data[v.colValue] == '' && v.userType == 3 &&  v.userType != 'undefined' ){
                            //status => 1, 7 // approved/missing trxn no
                            if(data.Status == "Pending" || statusRecord == 1 || statusRecord == 7){
                                //console.log(data);
                                finalhtml = `<a class='btn btn-sm btn-warning text-center' href="#" data-id="${data.AutoID}" data-atxn="${data.ATxnNo}" data-bs-toggle="modal" data-bs-target="#statusModal"  data-backdrop="static" data-keyboard="false"><i class="mdi mdi-pencil"></i></a>`;
                            }
                        }else{
                            if(v.classname != '' && v.classname != 'undefined'){
                                finalhtml = `<${v.html_tag} class='${v.classname}'>${colvalue}</${v.html_tag}>`;

                            }if(v.isConvertZeroToDecimal  && ( data[v.colValue] == '.00' || data[v.colValue]  == null) ){

                                finalhtml = `<${v.html_tag} class='${v.classname}'>0.00</${v.html_tag}>`;
                            }else{
                                finalhtml = `<${v.html_tag} class='${data[v.colorClass]}'>${colvalue}</${v.html_tag}>`;
                            }
                        }
                       
                        //console.log(data['statusColor']);
                        $(`td:eq(${col})`, row).html(finalhtml);
                    }
                }
            }
        },
        'footerCallback':function (row, data, start, end, display) {
            if(footerParams.isFooter == 1){
                var api = this.api();
                var symbol = '';
                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
                };
                // Total over all pages
                let total = api
                    .column(footerParams.columnNo)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                // Update footer
                $(api.column(footerParams.columnNo).footer()).html(total.toFixed(2));
            }
        },
        
    });

    // tableObj.on('xhr.dt',function (e, settings, data, xhr) {
    //     $('.dataTables_filter').addClass('float-right');
    // });

    // $(document).on('click', `.pmode`, function () {
    //     tableObj.ajax.reload();
    // });
    // $(document).on('click', `.cpmode`, function () {
    //     tableObj.ajax.reload();
    // });

    
}

/* Formatting function for row details*/
function format(d) {
    // d is the original data object for the row
    var tablehtml = ''
    tablehtml += '<table cellpadding="2" class="table mb-0 text-nowrap text-md-nowrap table-sm">';
    $.each(expandableColumns, function (index, expVal) {
        tablehtml += '<thead><td width="15%"><b>'+ columnsHeading[expVal].langLabel +':</b></td><td>' + d[expVal] + '</td></thead>';
    });
    tablehtml += '</table>';
    return (tablehtml);
}

$(`#${baseModule}List`).on('click', 'td.dt-control', function () {
	var tr = $(this).closest('tr');
	var row = tableObj.row(tr);

	if (row.child.isShown()) {
		// This row is already open - close it
		row.child.hide();
		tr.removeClass('shown');
	} else {
		// Open this row
		row.child(format(row.data())).show();
		tr.addClass('shown');
	}
});

export { datatable };

