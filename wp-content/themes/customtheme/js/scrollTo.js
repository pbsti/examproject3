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
  var toggleBtn = document.getElementById('menu-toggle');
  var menu = document.getElementById('menu');
  toggleBtn.addEventListener('click', function() {
    menu.classList.toggle('hidden');
  });

  var toggle = document.getElementById('lang-toggle');
  var langMenu = document.getElementById('lang-menu');
  toggle.addEventListener('click', function(e) {
    e.stopPropagation();
    langMenu.classList.toggle('hidden');
  });
  document.addEventListener('click', function(e) {
    if (!document.getElementById('lang-dropdown').contains(e.target)) {
      langMenu.classList.add('hidden');
    }
  });
});