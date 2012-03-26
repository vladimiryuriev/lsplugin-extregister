var lastCheckedLogin = '';
var lastCheckedEmail = '';


$('input[name=login]').live("blur", function(){
    
    var log = $('input[name=login]');
    if ( !log.val() || lastCheckedLogin ==  log.val()){
        return;
    }

    if (log.val().length <3 ){
        log.removeClass('success').addClass('error');
        ls.msg.error(ls.lang.get('error'),ls.lang.get('extreg_too_short_login'));
        return;
    }

    log.addClass('ajax-loading').removeClass('success').removeClass('error');
    
    ls.ajax(aRouter['registration']+'ajaxcheckregister/', {'var': log.val(),'do': 'login'}, function(response){
        lastCheckedLogin = log.val();
        log.removeClass('ajax-loading');
        if (!response.bStateError) {
                log.removeClass('error').addClass('success');
        } else {
                log.addClass('error');
                ls.msg.error(ls.lang.get('error'),response.sMsg);
        }
    });

});


$('input[name=mail]').live("blur", function(){

	var log = $('input[name=mail]');
	if ( !log.val() || lastCheckedEmail ==  log.val()) return;
	
	if ( validateEmail(log.val()) == false ){
		log.removeClass('success').addClass('error');
		ls.msg.error(ls.lang.get('error'),ls.lang.get('extreg_email_format_error'));
		return;
	}
	
	log.addClass('ajax-loading').removeClass('success').removeClass('error');
	
    ls.ajax(aRouter['registration']+'ajaxcheckregister/', {'var': log.val(),'do': 'mail'}, function(response){
        lastCheckedEmail = log.val();
        log.removeClass('ajax-loading');
        if (!response.bStateError) {
                log.removeClass('error').addClass('success');
        } else {
                log.removeClass('success').addClass('error');
                ls.msg.error(ls.lang.get('error'),response.sMsg);
        }
    });
});


$('input[name="password"]').live("blur", function(){
	
	var pass = $('input[name="password"]');
	var repass = $('#repass');
    
	if (pass.val()=='') return;
    if (pass.val().length <5 ){
        pass.removeClass('success').addClass('error');
        ls.msg.error(ls.lang.get('error'),ls.lang.get('extreg_pass_short'));
        return;
    } else {
        pass.removeClass('error').addClass('success');
    }
    
    if(!repass.length || repass.val()=='') return;
	
	if ( repass.val()!=pass.val() ){
		repass.removeClass('success').addClass('error');
		pass.removeClass('success').addClass('error');
        ls.msg.error(ls.lang.get('error'),ls.lang.get('extreg_pass_not_equal'));
	} else {
		repass.removeClass('error').addClass('success');
		pass.removeClass('error').addClass('success');
	}
		
});


$('#repass').live("blur", function(){
	
	var pass = $('input[name="password"]');
	var repass = $('#repass');
    
	if (pass.val()=='') return;
    
    if(!repass.length || repass.val()=='') return;
    
    if (repass.val().length <5 ){
        repass.removeClass('success').addClass('error');
        ls.msg.error(ls.lang.get('error'),ls.lang.get('extreg_pass_short'));
        return;
    }else {
        repass.removeClass('error').addClass('success');
    }
    
	if ( repass.val()!=pass.val() ){
		repass.removeClass('success').addClass('error');
		pass.removeClass('success').addClass('error');
        ls.msg.error(ls.lang.get('error'),ls.lang.get('extreg_pass_not_equal'));
	} else {
		repass.removeClass('error').addClass('success');
		pass.removeClass('error').addClass('success');
	}
		
});

function validateEmail(email) {
   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
   if(reg.test(email) == false) {
      return false;
   }
}

function checkpass() {
    if($('#password_reg').attr('type')=='password'){
        var new_input = $(document.createElement('input'))
        new_input.attr('class', 'input-text');
        new_input.attr('type', 'text');
        new_input.attr('id', 'password_visible');
        new_input.attr('name',$('#password_reg').attr('name'));
        new_input.attr('value',$('#password_reg').val());
        new_input.insertBefore($('#password_reg'));
        $('#password_reg').remove();
        $('#togglelink').html('[ '+ls.lang.get('registration_hide_pass')+' ]');
        return;
    }
    
    if($('#password_visible').attr('type')=='text'){
        var new_input = $(document.createElement('input'))
        new_input.attr('class', 'input-text');
        new_input.attr('type', 'password');
        new_input.attr('id', 'password_reg');
        new_input.attr('name',$('#password_visible').attr('name'));
        new_input.attr('value',$('#password_visible').val());
        new_input.insertBefore($('#password_visible'));
        $('#password_visible').remove();
        $('#togglelink').html('[ '+ls.lang.get('registration_show_pass')+' ]');
        return;
    }
}