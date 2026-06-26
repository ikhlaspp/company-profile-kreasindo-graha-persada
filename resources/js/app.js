import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

/*
 * Scroll reveal — subtle fade/slide-up for elements with class "reveal".
 * Adds "is-visible" when the element scrolls into view. Respects
 * prefers-reduced-motion (elements are shown immediately, no animation).
 */
(function () {
    const reveal = () => {
        const els = document.querySelectorAll('.reveal:not(.is-visible)');
        if (!els.length) return;

        const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (reduce || !('IntersectionObserver' in window)) {
            els.forEach((el) => el.classList.add('is-visible'));
            return;
        }

        const io = new IntersectionObserver((entries, obs) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    obs.unobserve(entry.target);
                }
            });
        }, { rootMargin: '0px 0px -10% 0px', threshold: 0.1 });

        els.forEach((el) => io.observe(el));
    };

    document.addEventListener('DOMContentLoaded', reveal);
    // Re-scan after Livewire/Alpine swaps or late content.
    document.addEventListener('alpine:initialized', reveal);
})();
