/*!
 * BootCMS Vanilla Framework v2.1 
 * URI https://netbuddy.net
 * Copyright 2026 Netbuddy.Net
 * Licensed under MIT 
 */
 
// Nav Menu ============================ /
document.querySelectorAll('.navbar-toggle').forEach(button => {
  button.addEventListener('click', () => {
    const menu = button.parentElement.nextElementSibling;
    const open = menu.classList.toggle('is-open');
    button.setAttribute('aria-expanded', open);
  });
});
document.querySelectorAll('.bootcms-navbar .menu-item-has-children > a[href="#"]')
.forEach(link => {
  link.addEventListener('click', e => e.preventDefault());
});
 
//  Carousel  ========================= /
document.querySelectorAll('.carousel').forEach(carousel => {
  const slides = [...carousel.querySelectorAll('.carousel-item')];
  const dots = [...carousel.querySelectorAll('.carousel-indicators button')];
  const interval = Number(carousel.dataset.bsInterval) || 4000;
  const autoplay = carousel.dataset.bsRide === 'carousel' && slides.length > 1;
  let index = Math.max(0, slides.findIndex(s => s.classList.contains('active')));
  let timer;
  const show = i => {
    index = (i + slides.length) % slides.length;
    slides.forEach((s, n) => s.classList.toggle('active', n === index));
    dots.forEach((d, n) => {
      d.classList.toggle('active', n === index);
      n === index ? d.setAttribute('aria-current', 'true') : d.removeAttribute('aria-current');
    });
  };
  const start = () => {
    clearInterval(timer);
    if (autoplay) timer = setInterval(() => show(index + 1), interval);
  };
  carousel.addEventListener('click', e => {
    const c = e.target.closest('.carousel-control-prev, .carousel-control-next, [data-bs-slide-to]');
    if (!c || slides.length < 2) return;
    show(c.hasAttribute('data-bs-slide-to')
      ? Number(c.dataset.bsSlideTo)
      : index + (c.classList.contains('carousel-control-next') ? 1 : -1));
    start();
  });
  carousel.addEventListener('pointerdown', e => {
    if (!e.target.closest('button')) clearInterval(timer);   // hold to pause
  });
  ['pointerup', 'pointerleave', 'pointercancel'].forEach(ev => carousel.addEventListener(ev, start));
  let startX = 0, startY = 0;
  carousel.addEventListener('pointerdown', e => { startX = e.clientX; startY = e.clientY; });
  carousel.addEventListener('pointerup', e => {
    if (e.target.closest('button')) return;
    const dx = e.clientX - startX, dy = e.clientY - startY;
    if (Math.abs(dx) > 50 && Math.abs(dx) > Math.abs(dy) * 1.5) show(index + (dx < 0 ? 1 : -1));
  });  
  start();
});

//  Show password on mouse hold  ===== /
document.querySelectorAll('div[data-password]').forEach(div => {
  const input = div.querySelector('input');
  if (!input) return;
  const hide = () => {
    input.type = 'password';
    div.classList.remove('password-visible');
  };
  div.addEventListener('pointerdown', e => {
    if (e.clientX < div.getBoundingClientRect().right - 50) return;
    e.preventDefault();
    div.setPointerCapture(e.pointerId);
    input.type = 'text';
    div.classList.add('password-visible');
  });
  ['pointerup', 'pointercancel', 'lostpointercapture'].forEach(ev =>
    div.addEventListener(ev, hide));
  div.addEventListener('contextmenu', e => {
    if (e.clientX >= div.getBoundingClientRect().right - 50) e.preventDefault();
  });
});

// Disable form submissions if there are invalid fields  == /
(function () {
 'use strict';
 document.querySelectorAll('.needs-validation').forEach(form => {
  const fields = form.querySelectorAll('input, select, textarea'),
   messages = ['valid-submit-feedback','invalid-submit-feedback','valid-submit-tooltip','invalid-submit-tooltip'].map(c => form.querySelector('.' + c)),
   hide = () => messages.forEach(m => { if (m) m.style.display = 'none'; }),
   check = f => {
    f.classList.toggle('is-valid', f.checkValidity());
    f.classList.toggle('is-invalid', !f.checkValidity());
   };
  fields.forEach(f => {
   f.addEventListener('input', () => { check(f); hide(); });
   f.addEventListener('change', () => { check(f); hide(); });
   f.addEventListener('blur', () => check(f));
  });
  form.addEventListener('submit', e => {
   const valid = form.checkValidity();
   if (!valid) { e.preventDefault(); e.stopPropagation(); }
   form.classList.add('was-validated');
   messages.forEach((m, i) => {
    if (m) m.style.display = (i % 2 === (valid ? 0 : 1)) ? 'block' : 'none';
   });
  });
  form.addEventListener('reset', () => {
   form.classList.remove('was-validated');
   fields.forEach(f => f.classList.remove('is-valid', 'is-invalid'));
   hide();
  });
 });
})();

// Display range scale value  ============= /
document.querySelectorAll(".form-scale").forEach(function(wrapper) {
  var slider = wrapper.querySelector(".scale");
  var output = wrapper.querySelector(".range-tooltip");
  function updateScale() {
    output.textContent = slider.value;
    var min = Number(slider.min || 0);
    var max = Number(slider.max || 100);
    var percent = max === min ? 0 :
      (Number(slider.value) - min) / (max - min);
    output.style.left = (percent * 100) + "%"; }
  slider.addEventListener("input", function() {
    updateScale();
    output.style.display = "block"; });
  slider.addEventListener("pointerdown", function() {
    updateScale();
    output.style.display = "block"; });
  slider.addEventListener("focus", function() {
    updateScale();
    output.style.display = "block"; });
  slider.addEventListener("blur", function() {
    output.style.display = "none"; });
});	

//  Pagination  =========================== /
document.querySelectorAll('.pagination').forEach(p => {
const previousNext = p.classList.contains('previous-next');
const prev = document.createElement('li');
prev.className = 'page-item';
prev.innerHTML = `<a class="page-link" href="#" aria-label="Previous">
    ${previousNext ? 'Previous' : '<span aria-hidden="true">&laquo;</span>'} </a>`;
const next = prev.cloneNode(true);
next.querySelector('a').innerHTML = previousNext
    ? 'Next'
    : '<span aria-hidden="true">&raquo;</span>';
next.querySelector('a').setAttribute('aria-label', 'Next');
if (!previousNext) {
    prev.querySelector('a').dataset.pageStep = '-1';
    next.querySelector('a').dataset.pageStep = '1';
}
p.prepend(prev);
p.append(next);
    const dotsBefore = document.createElement('li');
    dotsBefore.className = 'page-item';
    dotsBefore.innerHTML = '<span class="page-link">…</span>';
    const dotsAfter = dotsBefore.cloneNode(true);
    const pages = [...p.querySelectorAll('.page-item')]
        .filter(li => /^\d+$/.test(li.textContent.trim()));
    const count = +getComputedStyle(p)
        .getPropertyValue('--pages-visible').trim() || 5;
    let start = Math.max(0, Math.min(
        pages.findIndex(li => li.classList.contains('active')) -
            Math.floor(count / 2),
        pages.length - count
    ));
    function show() {
if (previousNext) {
    const items = [...p.querySelectorAll('.page-item')]
    .filter(li => li !== prev && li !== next);
    const current = items.findIndex(li => li.classList.contains('active'));
    if (current < 0) return;
    const findPage = (step) => {
        for (let i = current + step; i >= 0 && i < items.length; i += step) {
            const a = items[i].querySelector('a');
            if (a && !items[i].classList.contains('disabled')) return a;
        }
        return null;
    };
    const before = findPage(-1);
    const after = findPage(1);
    const prevLink = prev.querySelector('a');
    const nextLink = next.querySelector('a');
    prev.classList.toggle('disabled', !before);
    next.classList.toggle('disabled', !after);
    prevLink.setAttribute('aria-disabled', String(!before));
    nextLink.setAttribute('aria-disabled', String(!after));	
    if (before) prevLink.href = before.href;
    if (after) nextLink.href = after.href;
    items.forEach(li => {
        li.style.display = li === items[current] ? '' : 'none';
    });
    prev.style.display = '';
    next.style.display = '';
} else {
            pages.forEach((li, i) =>
                li.style.display =
                    i >= start && i < start + count ? '' : 'none'
            );
            dotsBefore.remove();
            dotsAfter.remove();
            if (start > 0) pages[start].before(dotsBefore);
            if (start + count < pages.length)
                pages[start + count - 1].after(dotsAfter);
            prev.classList.toggle('disabled', start === 0);
            next.classList.toggle('disabled', start + count >= pages.length);
            prev.querySelector('a').setAttribute('aria-disabled', start === 0);
            next.querySelector('a').setAttribute('aria-disabled', start + count >= pages.length);
        }
        p.style.display = 'flex';
    }
    if (!previousNext) {
        p.querySelectorAll('[data-page-step]').forEach(a =>
            a.addEventListener('click', e => {
                e.preventDefault();
                if (a.getAttribute('aria-disabled') === 'true') return;

                start = Math.max(0, Math.min(
                    start + (+a.dataset.pageStep) * count,
                    pages.length - count
                ));
                show();
            })
        );
    }
    show();
});

// Stepper  ========================== /
function updateStepper(currentStep) {
  const steps = document.querySelectorAll('#dynamic-stepper .step');
  steps.forEach((step, index) => {
	step.classList.remove('completed', 'in-progress', 'pending');
	  if (index + 1 < currentStep) {
		step.classList.add('completed');
		step.dataset.status = 'Completed';
	  } else if (index + 1 === currentStep) {
		step.classList.add('in-progress');
		step.dataset.status = 'In progress';
	  } else {
		step.classList.add('pending');
		step.dataset.status = 'Pending'; }
  });
}
// Vertical Stepper  ========================== /
function updateVerticalStepper(verticalStep) {
    const checkboxes = document.querySelectorAll(
        '#dynamic-stepper-vertical .v-substep input[type="checkbox"]'
    );
    checkboxes.forEach((checkbox, index) => {
        checkbox.checked = index < verticalStep;
    });
}