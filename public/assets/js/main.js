/**
 * Engineer Jules Portfolio — Core Frontend JS
 * Theme toggle, mobile nav, and the hero terminal typing sequence.
 */

(function () {
    'use strict';

    /* ---------- Theme toggle ---------- */
    const root = document.documentElement;
    const toggleBtn = document.getElementById('themeToggle');
    const iconMoon = document.getElementById('iconMoon');
    const iconSun = document.getElementById('iconSun');

    function syncIcon() {
        const isLight = root.getAttribute('data-theme') === 'light';
        if (iconMoon && iconSun) {
            iconMoon.style.display = isLight ? 'none' : 'block';
            iconSun.style.display = isLight ? 'block' : 'none';
        }
    }
    syncIcon();

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            const next = root.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
            root.setAttribute('data-theme', next);
            localStorage.setItem('ej-theme', next);
            syncIcon();
        });
    }

    /* ---------- Mobile nav ---------- */
    const navToggle = document.getElementById('navToggle');
    const navLinks = document.getElementById('navLinks');
    if (navToggle && navLinks) {
        navToggle.addEventListener('click', function () {
            navLinks.classList.toggle('open');
        });
    }

    /* ---------- Hero terminal — single orchestrated type-on sequence ---------- */
    const terminalBody = document.getElementById('terminalBody');
    if (terminalBody && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        const script = [
            { text: 'const developer = {', cls: '' },
            { text: '  name: "Jules",', cls: '' },
            { text: '  role: "Full-Stack Engineer",', cls: '' },
            { text: '  stack: ["PHP", "MySQL", "JS"],', cls: '' },
            { text: '  focus: "shipping things that work"', cls: '' },
            { text: '};', cls: '' },
            { text: '', cls: '' },
            { text: 'build(developer.stack);', cls: '' },
            { text: '// \u2713 build complete', cls: 't-com' },
        ];

        terminalBody.innerHTML = '';
        let lineIndex = 0;

        function typeLine() {
            if (lineIndex >= script.length) {
                const cursor = document.createElement('span');
                cursor.className = 't-cursor';
                terminalBody.appendChild(cursor);
                return;
            }
            const lineData = script[lineIndex];
            const lineEl = document.createElement('div');
            lineEl.className = 'line ' + lineData.cls;
            terminalBody.appendChild(lineEl);

            let charIndex = 0;
            const speed = 18;

            function typeChar() {
                if (charIndex <= lineData.text.length) {
                    lineEl.textContent = lineData.text.slice(0, charIndex);
                    charIndex++;
                    setTimeout(typeChar, speed);
                } else {
                    lineIndex++;
                    setTimeout(typeLine, 120);
                }
            }
            typeChar();
        }

        setTimeout(typeLine, 400);
    } else if (terminalBody) {
        // Reduced motion: show final state immediately
        terminalBody.innerHTML =
            '<div class="line">const developer = {</div>' +
            '<div class="line">  name: "Jules",</div>' +
            '<div class="line">  role: "Full-Stack Engineer",</div>' +
            '<div class="line">  stack: ["PHP", "MySQL", "JS"],</div>' +
            '<div class="line">  focus: "shipping things that work"</div>' +
            '<div class="line">};</div>' +
            '<div class="line"></div>' +
            '<div class="line">build(developer.stack);</div>' +
            '<div class="line t-com">// \u2713 build complete</div>';
    }
})();
