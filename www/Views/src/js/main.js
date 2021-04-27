import $ from 'jquery';

$(() => {
	$('#user-profile-button').on('click', (event) => {
		$('#user-profile-menu').toggleClass('hidden');
		event.stopPropagation();

		if (!$('#user-profile-menu').hasClass('hidden')){
			$('body').on('click', function(e){
				$('#user-profile-menu').toggleClass('hidden');
				$('body').off('click');
			})
		}
		else {
			$('body').off('click');
		}

	});
});