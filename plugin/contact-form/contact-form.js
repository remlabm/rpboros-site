
	/*****************************************************************/
	/*****************************************************************/

	function submitContactForm()
	{
		$.blockUI('#contact-form');
		$.post('/contact-form.php', $('#contact').serialize(),submitContactFormResponse,'json');
	}
	
	/*****************************************************************/
	
	function submitContactFormResponse(r)
	{
		$.unblockUI();
		$('#contact-user-name,#contact-user-email,#contact-message,#contact-send').qtip('destroy');

		var tPosition=
		{
			'contact-send':{'my':'right center','at':'left center'},
			'contact-message':{'my':'right center','at':'left center'},
			'contact-user-name':{'my':'right center','at':'left center'},
			'contact-user-email':{'my':'right center','at':'left center'}
		};
		
		  $('div.form-line:last').qtip(
				  {
					  style: 		{ classes:(r.status != 'ok' ? 'ui-tooltip-error' : 'ui-tooltip-success')},
					  content: 	{ text:r.msg },
					  position: 	{ my: 'top center' ,at: 'bottom center' }
				  }).qtip('show');	
		  

    $.each(r.info, function(i, info){
      try{
			  $('#'+info.id).qtip(
			  {
				  style: 		{ classes:(info.bad == 1 ? 'ui-tooltip-error' : 'ui-tooltip-success')},
				  content: 	{ text:info.msg },
				  position: 	{ my:tPosition[info.id]['my'],at:tPosition[info.id]['at'] }
			  }).qtip('show');		      
      }catch(err){
      }
    });
		
	}
	
	/*****************************************************************/
	/*****************************************************************/
