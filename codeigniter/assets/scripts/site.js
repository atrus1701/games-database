
$(document).ready( function() {
	
	$('#login_box > .controls').hide();
	$('#login_box > .error_message').hide();
	$('#login_box > .loading').hide();
	
	var login_down_arrow = true;
	$('#header > .login_status > .login').click(function() {
		$('#login_box > .controls').slideToggle('fast', function() {
			if(login_down_arrow) {
				$('#login_arrow').attr('src', base_url + "assets/images/up_arrow.png");
			}
			else {
				$('#login_arrow').attr('src', base_url + "assets/images/down_arrow.png");
			}
			login_down_arrow = !login_down_arrow;
		});
	});
	
	$('#header > .login_status > .logout').click(function() {
		
		$.ajax({
		      type: "POST",
		      url: base_url + "ajax/site/logout",
		      data: 'ajax=1',
		      success: function(data, textStatus, jqXHR) { 
		    	  alert('You have been logged out of the system.');
		    	  window.location.href = base_url;
		      }
		});
		
		return false;
	});
	
	$('#login_form > .login_button').click(function() {
		
		$('#login_form > input[name="md5_password"]').val( $.md5($('#login_form > input[name="password"]').val()) );
		$('#login_form > input[name="password"]').val("");

		query_string = $('#login_form').serialize();
		query_string += "&ajax=1";

		$('#login_box > #login_form').hide();
		$('#login_box > .loading').show();

		$.ajax({
		      type: "POST",
		      url: base_url + "ajax/site/login",
		      data: query_string,
		      dataType: 'json',
		      success: function(data, textStatus, jqXHR) { 
		    	//alert(data);
			    if(data.success == true)
			    {
			    	alert('You have been logged into the system.');
			    	window.location.reload(true);
			    }
			    else
			    {
			    	alert( data.message );
			    }
		      },
		      error: function(jqXHR, textStatus, errorThrown) {
		    	  var s = "An error occured while processing the request: " + errorThrown + " - " + textStatus + ".";
		    	  alert(s);
		      }
		});

		return false;
	});
});

