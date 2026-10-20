/*! Abraqyah International – interactions & animations (vanilla JS, no dependencies) */
(function () {
	'use strict';

	var doc = document;
	var root = doc.documentElement;
	var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	function $(sel, ctx) { return (ctx || doc).querySelector(sel); }
	function $$(sel, ctx) { return Array.prototype.slice.call((ctx || doc).querySelectorAll(sel)); }
	function clamp(n, a, b) { return Math.min(b, Math.max(a, n)); }

	$$('[data-service-dialog]').forEach(function (button) {
		var dialog = doc.getElementById(button.getAttribute('data-service-dialog'));
		if (!dialog || typeof dialog.showModal !== 'function') { return; }

		button.addEventListener('click', function () { dialog.showModal(); });
		$('[data-service-dialog-close]', dialog).addEventListener('click', function () { dialog.close(); });
		dialog.addEventListener('keydown', function (event) {
			if ('Escape' === event.key) {
				event.preventDefault();
				event.stopPropagation();
				dialog.close();
			}
		});
		dialog.addEventListener('click', function (event) {
			if (event.target === dialog) { dialog.close(); }
		});
	});

	/* 1 ── Split headings into masked words for a rising reveal */
	$$('.split').forEach(function (el) {
		var words = el.textContent.trim().split(/\s+/);
		el.setAttribute('aria-label', words.join(' '));
		el.innerHTML = '';
		words.forEach(function (word, i) {
			var outer = doc.createElement('span');
			var inner = doc.createElement('span');
			outer.className = 'w';
			outer.setAttribute('aria-hidden', 'true');
			inner.className = 'wi';
			inner.style.setProperty('--i', i);
			inner.textContent = word;
			outer.appendChild(inner);
			el.appendChild(outer);
			if (i < words.length - 1) { el.appendChild(doc.createTextNode(' ')); }
		});
	});

	/* 2 ── Stagger index for grouped reveals */
	$$('[data-stagger]').forEach(function (group) {
		$$('.rv', group).forEach(function (el, i) { el.style.setProperty('--i', Math.min(i, 8)); });
	});

	/* 3 ── Count-up numbers */
	function formatCount(el, value) {
		var decimals = parseInt(el.getAttribute('data-count-decimals'), 10) || 0;
		var scale = Math.pow(10, decimals);
		value = Math.round(value * scale) / scale;
		if ('true' === el.getAttribute('data-count-group')) {
			return value.toLocaleString('en-US', { minimumFractionDigits: decimals, maximumFractionDigits: decimals });
		}
		return decimals ? value.toFixed(decimals) : String(Math.round(value));
	}

	function countUp(el) {
		var target = parseFloat(el.getAttribute('data-count'));
		if (isNaN(target)) { return; }
		if (reduce) { el.textContent = formatCount(el, target); return; }
		var start = null, dur = 1700;
		function tick(ts) {
			if (start === null) { start = ts; }
			var t = clamp((ts - start) / dur, 0, 1);
			var eased = 1 - Math.pow(1 - t, 4);
			el.textContent = formatCount(el, target * eased);
			if (t < 1) { requestAnimationFrame(tick); }
		}
		el.textContent = '0';
		requestAnimationFrame(tick);
	}

	/* 4 ── Reveal on scroll (one observer for everything) */
	var revealSel = '.rv, .rv-clip, .split';
	var revealEls = $$(revealSel);
	var counters = $$('[data-count]');

	if ('IntersectionObserver' in window) {
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (!entry.isIntersecting) { return; }
				var el = entry.target;
				el.classList.add('is-in');
				$$('[data-count]', el).forEach(countUp);
				if (el.hasAttribute('data-count')) { countUp(el); }
				io.unobserve(el);
			});
		}, { threshold: 0.14, rootMargin: '0px 0px -6% 0px' });
		revealEls.forEach(function (el) { io.observe(el); });
		// Counters that are not inside a revealed element
		counters.forEach(function (el) {
			if (!el.closest(revealSel)) { io.observe(el); }
		});
	} else {
		revealEls.forEach(function (el) { el.classList.add('is-in'); });
		counters.forEach(function (el) { el.textContent = formatCount(el, parseFloat(el.getAttribute('data-count'))); });
	}

	// Hero entrance: flag the page as loaded after first paint
	requestAnimationFrame(function () {
		requestAnimationFrame(function () { root.classList.add('is-loaded'); });
	});

	/* 5 ── Header state, hide-on-scroll, progress bar, parallax, pipeline rail */
	var header = $('#site-header');
	var progress = $('.scroll-progress');
	var parallax = $$('[data-parallax]');
	var steps = $('#steps');
	var stepItems = steps ? $$('.steps__item', steps) : [];
	var lastY = window.scrollY;
	var ticking = false;

	function update() {
		var y = window.scrollY;
		var vh = window.innerHeight;
		var docH = root.scrollHeight - vh;

		if (header) {
			header.classList.toggle('is-solid', y > 40);
			var navOpen = doc.body.classList.contains('nav-open');
			var goingDown = y > lastY + 6;
			var goingUp = y < lastY - 6;
			if (!navOpen && goingDown && y > 480) { header.classList.add('is-hidden'); }
			else if (goingUp || y < 480 || navOpen) { header.classList.remove('is-hidden'); }
		}
		lastY = y;

		if (progress) { progress.style.setProperty('--sp', docH > 0 ? (y / docH).toFixed(4) : 0); }

		if (!reduce) {
			parallax.forEach(function (el) {
				var rect = el.parentElement.getBoundingClientRect();
				if (rect.bottom < -100 || rect.top > vh + 100) { return; }
				var speed = parseFloat(el.getAttribute('data-parallax')) || 0.15;
				var offset = (rect.top + rect.height / 2 - vh / 2) * -speed;
				el.style.transform = 'translate3d(0,' + offset.toFixed(1) + 'px,0)';
			});
		}

		if (steps) {
			var r = steps.getBoundingClientRect();
			var line = vh * 0.62;
			var p = clamp((line - r.top) / r.height, 0, 1);
			steps.style.setProperty('--p', p.toFixed(4));
			stepItems.forEach(function (item) {
				item.classList.toggle('is-lit', item.getBoundingClientRect().top < line);
			});
		}
		ticking = false;
	}

	function onScroll() {
		if (!ticking) { ticking = true; requestAnimationFrame(update); }
	}
	window.addEventListener('scroll', onScroll, { passive: true });
	window.addEventListener('resize', onScroll);
	update();

	/* 6 ── Mobile navigation */
	var toggle = $('#nav-toggle');
	function setNav(open) {
		doc.body.classList.toggle('nav-open', open);
		if (toggle) {
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
			toggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
		}
		if (header) { header.classList.toggle('is-solid', open || window.scrollY > 40); }
	}
	if (toggle) {
		toggle.addEventListener('click', function () { setNav(!doc.body.classList.contains('nav-open')); });
		doc.addEventListener('keydown', function (e) { if (e.key === 'Escape') { setNav(false); toggle.focus(); } });
		$$('#primary-nav a').forEach(function (a) { a.addEventListener('click', function () { setNav(false); }); });
		window.matchMedia('(min-width: 1024px)').addEventListener('change', function (m) { if (m.matches) { setNav(false); } });
	}

	/* 7 ── Rotating-equipment picker: hover/focus/click + gentle auto-cycle */
	var picker = $('#picker');
	if (picker) {
		var buttons = $$('button', picker);
		var cap = $('.cap');
		var nEl = $('#eqn'), tEl = $('#eqt'), dEl = $('#eqd');
		var current = 0, timer = null, userControl = false;

		function pick(i, fromUser) {
			if (i === current && !fromUser) { return; }
			current = i;
			buttons.forEach(function (b, idx) { b.classList.toggle('is-active', idx === i); });
			if (cap && !reduce) { cap.classList.add('is-swapping'); }
			window.setTimeout(function () {
				if (nEl) { nEl.textContent = ('0' + (i + 1)).slice(-2) + ' / ' + ('0' + buttons.length).slice(-2); }
				if (tEl) { tEl.textContent = buttons[i].textContent; }
				if (dEl) { dEl.textContent = buttons[i].getAttribute('data-d') || ''; }
				if (cap) { cap.classList.remove('is-swapping'); }
			}, reduce ? 0 : 180);
		}
		buttons.forEach(function (b, i) {
			['mouseenter', 'focus', 'click'].forEach(function (ev) {
				b.addEventListener(ev, function () { userControl = true; stop(); pick(i, ev === 'click'); });
			});
		});

		function start() {
			if (reduce || userControl || timer) { return; }
			timer = window.setInterval(function () { pick((current + 1) % buttons.length); }, 3800);
		}
		function stop() { if (timer) { window.clearInterval(timer); timer = null; } }

		if ('IntersectionObserver' in window) {
			new IntersectionObserver(function (entries) {
				entries.forEach(function (en) { if (en.isIntersecting) { start(); } else { stop(); } });
			}, { threshold: 0.35 }).observe(picker);
		}
	}

	/* 8 ── Form: prevent double submit, light validation */
	var form = $('.cp-form');
	if (form) {
		form.addEventListener('submit', function (e) {
			if (!form.checkValidity()) {
				e.preventDefault();
				form.reportValidity();
				return;
			}
			var btn = $('button[type="submit"]', form);
			if (btn) { btn.disabled = true; btn.style.opacity = '.7'; btn.firstChild.textContent = 'Sending… '; }
		});
		if (/[?&](sent|error)=/.test(window.location.search)) {
			var card = $('#enquiry-form');
			if (card) { window.setTimeout(function () { card.scrollIntoView({ behavior: reduce ? 'auto' : 'smooth', block: 'center' }); }, 300); }
		}
	}
})();
