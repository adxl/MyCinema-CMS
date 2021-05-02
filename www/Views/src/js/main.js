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

	// bouton qui ajoute un réalisateur (directed-by)
	$('#directed-by-btn').on('click', () => {
		const directedByField = $('#directed-by');
		const value = directedByField.val();

		if (value) {
			const tag = $("<p class=''></p>").text(value);
			$(tag).on('click', ({ target }) => {
				$(target).remove();
			});

			$('#directed-by-values').append(tag);
			directedByField.val('');
		}
	});

	// bouton qui ajoute un acteur (starring)
	$('#starring-btn').on('click', () => {
		const starringField = $('#starring');
		const value = starringField.val();

		if (value) {
			const tag = $("<p class=''></p>").text(value);
			$(tag).on('click', ({ target }) => {
				$(target).remove();
			});

			$('#starring-values').append(tag);
			starringField.val('');
		}
	});

	// bouton qui ajoute un tag (tags)
	$('#tags-btn').on('click', () => {
		const tagsField = $('#tags');
		const value = tagsField.val();

		if (value) {
			const tag = $("<p class=''></p>").text(value);
			$(tag).on('click', ({ target }) => {
				$(target).remove();
			});

			$('#tags-values').append(tag);
			tagsField.val('');
		}
	});
});
