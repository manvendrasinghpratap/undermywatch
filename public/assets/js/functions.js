/** Delete Function */
function deleteByPrimaryId(siteUrl, deletePrimaryId, tableName, targetModel='modal-alert', deleteMsg = 'Deleted Succussfully!!!',deletetype = 'softdelete'){
    var $_token = jQuery('#token').val();
    $.ajax({
        type: "GET",
        cache: false,
        headers: {'X-XSRF-TOKEN': $_token},
        url: siteUrl + "/ajax/destroy/" + tableName+'/'+deletePrimaryId+'/'+deletetype,
        async: true,
        success: function (msg) {
            $("#hide_"+deletePrimaryId).fadeOut(1000);
          //  alert(msg)
            $('#'+targetModel).find('.modal-body').html(deleteMsg).end().modal('show');
            //getpageWrapperContent(siteUrl);
        },
    });
}

function deleteByCustomColumn(siteUrl, deletePrimaryId, tableName, targetModel='modal-alert', deleteMsg = 'Deleted Succussfully!!!',columnName=''){
    var $_token = jQuery('#token').val();
    $.ajax({
        type: "GET",
        cache: false,
        headers: {'X-XSRF-TOKEN': $_token},
        url: siteUrl + "/ajax/destroyByCustomColumn/" + tableName+'/'+deletePrimaryId+'/'+columnName,
        async: true,
        success: function (msg) {
            $("#hide_"+deletePrimaryId).fadeOut(1000);
            //alert(msg)
            $('#'+targetModel).find('.modal-body').html(deleteMsg).end().modal('show');
            //getpageWrapperContent(siteUrl);
        },
    });
}

$(document).ready(function() {
    /*$('#table_id').DataTable({
        "bPaginate": false,
        "bFilter": true,
        "bInfo": false
    });*/
});


$('.flash-message').fadeOut(2000);

$('.confirmDelete').on('click', function(e) {
    title =  $(this).attr("data-record-title");
    recordId =  $(this).attr("data-record-id");
    targetModel = $(this).attr("data-target");
    tableName = $(this).attr("data-tablename");
    deleteSuccussMsg = $(this).attr("data-succuss");
    siteUrl = $(this).attr('data-siteurl');
    deletetype = $(this).attr('data-deletetype');
    $('#'+targetModel).find('.modal-body')
        .html(title)
        .end()
        .modal('show');
    $('#actionDelete').click(function() {
        deleteByPrimaryId(siteUrl,recordId,tableName,'modal-alert',deleteSuccussMsg,deletetype);
        //getpageWrapperContent(siteUrl);
        $("#hide_"+recordId).fadeOut(1000);
    });
});

$('.confirmDeleteStatus').on('click', function(e) {
    title =  $(this).attr("data-record-title");
    recordId =  $(this).attr("data-record-id");
    targetModel = $(this).attr("data-target");
    tableName = $(this).attr("data-tablename");
    columnName = $(this).attr("data-deleteColumnName");
    deleteSuccussMsg = $(this).attr("data-succuss");
    siteUrl = $(this).attr('data-siteurl')
    $('#'+targetModel).find('.modal-body')
        .html(title)
        .end()
        .modal('show');
    $('#actionDelete').click(function() {
        deleteByCustomColumn(siteUrl,recordId,tableName,'modal-alert',deleteSuccussMsg,columnName);
        //getpageWrapperContent(siteUrl);
        $("#hide_"+recordId).fadeOut(1000);
    });
});



$('.confirmStatuschange').on('click', function(e) {
    title =  $(this).attr("data-record-title");
    bankId =  $(this).attr("data-record-id");
    status =  $(this).attr("data-bank-status");
    targetModel = $(this).attr("data-target");
    tableName = $(this).attr("data-tablename");
    deleteSuccussMsg = $(this).attr("data-succuss");
    siteUrl = $(this).attr('data-siteurl')
    $('#'+targetModel).find('.modal-body')
        .html(title)
        .end()
        .modal('show');
    $('#actionDelete').click(function() {
        changeBankstatus(siteUrl,bankId,status);
        //getpageWrapperContent(siteUrl);
        //$("#hide_"+recordId).fadeOut(1000);
    });
});

function changeBankstatus(siteUrl,bankId,status){
    var $_token = jQuery('#token').val();
    $.ajax({
        type: "GET",
        cache: false,
        headers: {'X-XSRF-TOKEN': $_token},
        url: siteUrl + "/ajax/changeBankStatus/" + status+'/'+bankId,
        async: true,
        success: function (msg) {
            if(msg==0) {
                $("#button_" + bankId).removeClass("label-success");
                $("#button_" + bankId).addClass("label-danger");
                $("#span_" + bankId).html("Inactive");
            }
            else{
                $("#button_" + bankId).removeClass("label-danger");
                $("#button_" + bankId).addClass("label-success");
                $("#span_" + bankId).html("Active");
            }
            //$('#'+divId).val(msg);
        },
        error:function(msg){
            console.log(msg)
            $("#span_103").removeClass("label-danger");
            $("#span_103").addClass("label-success");
        }
    });
}
