import $ from 'jquery';

const $body = $('body');

$(() => {
	$('#user-profile-button').on('click', (event) => {
		$('#user-profile-menu').toggleClass('hidden');
		event.stopPropagation();

		if (!$('#user-profile-menu').hasClass('hidden')) {
			$body.on('click', () => {
				$('#user-profile-menu').toggleClass('hidden');
				$body.off('click');
			});
		} else {
			$body.off('click');
		}
	});
});
