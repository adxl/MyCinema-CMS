import $ from 'jquery';

const $body = $('body');

$(() => {
	// menu déroulant du header
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

	// bouton qui permet d'ajouter un input session dans events
	$('#generate-session-btn').on('click', ({ target }) => {
		const sessionInputs = $('.session-inputs').first();
		const newSessionInputs = sessionInputs.clone();
		$(newSessionInputs).find('.remove-session-btn').on('click', ({ currentTarget }) => {
			$(currentTarget).parent().remove();
		});
		newSessionInputs.insertBefore(target.parentElement);
	});
});
