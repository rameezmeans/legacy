$(function () {
    //Textare auto growth 

    //Datetimepicker plugin
    $('.datetimepicker').bootstrapMaterialDatePicker({
        format: 'DD MM YYYY - HH:mm',
        clearButton: true,
        weekStart: 1
    });

    $('.datepicker').bootstrapMaterialDatePicker({
        format: 'YYYY-MM-DD',
        clearButton: true,
        weekStart: 1,
        time: false
    });

    $('.timepicker').bootstrapMaterialDatePicker({
        format: 'HH:mm',
        clearButton: true,
        date: false
    });
	
	/*$('#editbtnprofile').on('click',function(e){
		e.preventDefault();
		var pass1 = $.trim($('#password').val());		
		var pass2 = $.trim($('#confirmpassword').val());
		alert(pass1);
		if(pass1 != ''){			
			if(pass1 == pass2){
				$('#editprofile').submit();
			}else{
				$('.passerror').text("Password Mismatch.");
				return false;
			}
		}
		$('#editprofile').submit();
	});*/
});