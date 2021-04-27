import $ from 'jquery';

$(() => {
	$('#user-profile-button').on('click', () => {
		$('#user-profile-menu').toggleClass('hidden');
	});
});
