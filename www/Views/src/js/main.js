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
	$('#session-inputs-container').find('button').not(':first').on('click', ({ currentTarget }) => {
		$(currentTarget).parent().remove();
	});

	$('#generate-session-btn').on('click', () => {
		const sessionInputs = $('.session-inputs').last();
		const newSessionInputs = sessionInputs.clone();
		$(newSessionInputs).find('.remove-session-btn').on('click', ({ currentTarget }) => {
			$(currentTarget).parent().remove();
		});
		newSessionInputs.insertAfter(sessionInputs);
	});
});
