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

	// bouton qui supprime une session dans events
	$('#session-inputs-container').find('button').not(':first').on('click', ({ currentTarget }) => {
		$(currentTarget).parent().remove();
	});

	// bouton qui permet d'ajouter un input session dans events
	$('#generate-session-btn').on('click', () => {
		const sessionInputs = $('.session-inputs').last();
		const newSessionInputs = sessionInputs.clone();
		$(newSessionInputs).find('.remove-session-btn').on('click', ({ currentTarget }) => {
			$(currentTarget).parent().remove();
		});
		newSessionInputs.insertAfter(sessionInputs);
	});

	// afficher un aperçu de l'image uploadée dans input[type='file']
	$('.media').on('change', (e) => {
		const file = e.target.files[0];
		if (file) {
			const reader = new FileReader();
			reader.onload = (_e) => {
				const src = _e.target.result;
				$('.media img').attr('src', src);
			};
			reader.readAsDataURL(file);
		}
	});
});
