(function () {
	'use strict';

	var gallery = document.querySelector('.hn-work');
	if (!gallery) return;

	var filters = gallery.querySelectorAll('[data-work-filter]');
	var cards = gallery.querySelectorAll('[data-work-category]');
	var emptyState = gallery.querySelector('.hn-work-empty');

	filters.forEach(function (filter) {
		filter.addEventListener('click', function () {
			var category = filter.getAttribute('data-work-filter');
			var visibleCount = 0;

			filters.forEach(function (button) {
				var isActive = button === filter;
				button.classList.toggle('is-active', isActive);
				button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
			});

			cards.forEach(function (card) {
				var isVisible = category === 'all' || card.getAttribute('data-work-category') === category;
				card.hidden = !isVisible;
				if (isVisible) visibleCount++;
			});

			if (emptyState) emptyState.hidden = visibleCount > 0;
		});
	});
}());