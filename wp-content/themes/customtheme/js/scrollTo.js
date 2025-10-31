document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function(e) {
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      e.preventDefault();
      target.scrollIntoView({ behavior: 'smooth' });
    }
  });
});

document.addEventListener('DOMContentLoaded', function() {
  const menuToggle = document.getElementById('menu-toggle');
  const menu = document.getElementById('menu');

  const isMobile = () => window.matchMedia('(max-width: 767px)').matches;

  if (menu && !menu.classList.contains('open') && isMobile()) {
    menu.classList.add('hidden');
  }

  if (menuToggle && menu) {
    menuToggle.addEventListener('click', function() {
      if (menu.classList.contains('open')) {
        menu.classList.remove('open');
        const onTransitionEnd = function(e) {
          if (e.propertyName === 'max-height' && isMobile()) {
            menu.classList.add('hidden');
            menu.removeEventListener('transitionend', onTransitionEnd);
          }
        };
        menu.addEventListener('transitionend', onTransitionEnd);
      } else {
        if (isMobile()) menu.classList.remove('hidden');
        void menu.offsetWidth;
        menu.classList.add('open');
      }
    });
  }

  const langToggle = document.getElementById('lang-toggle');
  const langMenu = document.getElementById('lang-menu');
  const langDropdown = document.getElementById('lang-dropdown');

  if (langMenu && !langMenu.classList.contains('hidden')) {
    langMenu.classList.add('hidden');
  }

  if (langToggle && langMenu) {
    langToggle.addEventListener('click', function(e) {
      e.stopPropagation();
      langMenu.classList.toggle('hidden');
    });
    document.addEventListener('click', function(e) {
      if (!langDropdown || !langDropdown.contains(e.target)) {
        langMenu.classList.add('hidden');
      }
    });

    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        langMenu.classList.add('hidden');
        if (menu && menu.classList.contains('open')) {
          menu.classList.remove('open');
          menu.classList.add('hidden');
        }
      }
    });
  }
});