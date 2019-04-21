$(document).ready(function(){
	$("#back-top").hide();
	$(function () {
		$(window).scroll(function(){
			if ($(this).scrollTop() > 100) {
				$('#back-top').fadeIn();
			} else {
				$('#back-top').fadeOut();
			}
		});
		$('#back-top i').click(function(){
			$('body,html').animate({
				scrollTop: 0
			}, 250);
			return false;
		});
	});
    $('#submitorder').attr('disabled',true);
    function update(){
        if(verify()){
            $('#submitorder').removeAttr('disabled');
        }else{
            $('#submitorder').attr('disabled',true);
        }
    }
    function verify(){
        if($('#hari').val() != '' && $('#jam_ke').val() != '' && $('#lamaMengajar').val() != '' && $('#guru').val() != ''){
            return true;
        }else{
            return false;
        }
    }
    $('#hari').change(update);
    $('#jam_ke').change(update);
    $('#lamaMengajar').change(update);
    $('#guru').change(update);

    $('#form1').submit(function(){
	    if($('input:checkbox', this).is(':checked')){
	        return true;
	    }else{
	        alert('pilih salah satu kelas!');
	        return false;
	    }
	});
});