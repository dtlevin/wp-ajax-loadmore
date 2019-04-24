jQuery(function($){ // use jQuery code inside this to avoid "$ is not defined" error
	$('.misha_loadmore').click(function(){

		// alert('goteem');
 		// set variable for ajax call here they are equal to the myajax ones you set in the loadmore button script 
		var button = $(this),
		    data = {
			'action': 'loadmore',
			'query': posts_myajax,
			'page' : current_page_myajax
		};
 
		$.ajax({ // you can also use $.post here
			url : misha_loadmore_params.ajaxurl, // AJAX handler
			data : data,
			type : 'POST',
			beforeSend : function ( xhr ) {
				button.text('Loading...'); // change the button text, you can also add a preloader image
			},
			success : function( data ){
				console.log(data);
				if( data ) { 
					$('#post-card-wrapper').append(data);
					$('.new-card').hide().each(function(i) {
						$(this).delay(100 * i).fadeIn(500).removeClass('new-card');
					});
					button.text( 'More posts' ).prev().before(data); // insert new posts
					current_page_myajax++;
 
					if ( misha_loadmore_params.current_page == misha_loadmore_params.max_page ) 
						button.remove(); // if last page, remove the button
 
					// you can also fire the "post-load" event here if you use a plugin that requires it
					// $( document.body ).trigger( 'post-load' );
				} else {
					button.remove(); // if no data, remove the button as well
				}
			}
		});
	});
});