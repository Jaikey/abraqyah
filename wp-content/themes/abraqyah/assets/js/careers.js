(function () {
	'use strict';

	var page = document.querySelector('.career-page');
	if (!page) return;

	var filters = page.querySelectorAll('[data-career-filter]');
	var jobs = page.querySelectorAll('.career-job');
	var toggles = page.querySelectorAll('.career-job-toggle');
	var roleInput = page.querySelector('#career-role');
	var divisionSelect = page.querySelector('#career-division');
	var application = page.querySelector('#general-application');
	function setChevronState(toggle, open) {
		var chevron = toggle.querySelector('.career-chevron');
		if (!chevron) return;
		chevron.style.transform = open ? 'translateY(2px) rotate(225deg)' : '';
		chevron.style.color = open ? 'var(--career-red)' : '';
	}

	filters.forEach(function (filterButton) {
		filterButton.addEventListener('click', function () {
			var category = filterButton.getAttribute('data-career-filter');
			filters.forEach(function (button) {
				button.classList.toggle('is-active', button === filterButton);
			});
			jobs.forEach(function (job) {
				var visible = category === 'all' || job.getAttribute('data-career-category') === category;
				job.hidden = !visible;
				if (!visible) {
					job.classList.remove('is-open');
					var toggle = job.querySelector('.career-job-toggle');
					toggle.setAttribute('aria-expanded', 'false');
					setChevronState(toggle, false);
					job.querySelector('.career-job-detail').hidden = true;
				}
			});
		});
	});

	toggles.forEach(function (toggle) {
		toggle.addEventListener('click', function () {
			var job = toggle.closest('.career-job');
			var detail = job.querySelector('.career-job-detail');
			var willOpen = !job.classList.contains('is-open');
			jobs.forEach(function (otherJob) {
				otherJob.classList.remove('is-open');
				var otherToggle = otherJob.querySelector('.career-job-toggle');
				otherToggle.setAttribute('aria-expanded', 'false');
				setChevronState(otherToggle, false);
				otherJob.querySelector('.career-job-detail').hidden = true;
			});
			job.classList.toggle('is-open', willOpen);
			toggle.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
			setChevronState(toggle, willOpen);
			detail.hidden = !willOpen;
		});
	});

	page.querySelectorAll('.career-apply').forEach(function (applyButton) {
		applyButton.addEventListener('click', function () {
			if (roleInput) roleInput.value = applyButton.getAttribute('data-career-title') || '';
			if (divisionSelect) divisionSelect.value = applyButton.getAttribute('data-career-division') || '';
			if (!application) return;
			application.scrollIntoView({ behavior: 'smooth', block: 'start' });
			var nameInput = page.querySelector('#career-name');
			if (nameInput) window.setTimeout(function () { nameInput.focus(); }, 500);
		});
	});
}());