/*jslint unparam: true */
/*global window, $ */

var filesubmiter = {};
$(function () {      
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = '/25_wetransfer/send_mail.php'; 
    $('#fileupload').fileupload({
        url: url,
    //    dataType: 'json',
        
         
         add: function (e, data) {
                filesubmiter = data;
           
        },
        
        done: function (e, data) {
            console.log(data);
            console.log(data.files[0].name);
                $('<p/>').text(data.files[0].name).appendTo('#files'); 
        
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled'); 
});
   
$('#fileupload').bind('fileuploadsubmit', function (e, data) {
    // 
    data.formData = $('form').serializeArray();
    
});




