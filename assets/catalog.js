(function () {
  var form = document.querySelector('[data-filters]');
  var grid = document.querySelector('[data-grid]');

  // Кнопка «Випадкове» в меню на сторінках без каталогу веде на головну з #random.
  if (!form || !grid) return;

  var cards = Array.prototype.slice.call(grid.querySelectorAll('.card'));
  var countEl = document.querySelector('[data-count]');
  var emptyEl = grid.querySelector('[data-empty]');

  function plural(n) {
    var a = n % 10, b = n % 100;
    if (a === 1 && b !== 11) return 'тайтл';
    if (a >= 2 && a <= 4 && (b < 12 || b > 14)) return 'тайтли';
    return 'тайтлів';
  }

  function visible() {
    return cards.filter(function (c) { return !c.hidden; });
  }

  function apply() {
    var q = form.q.value.trim().toLowerCase();
    var genre = form.genre.value;
    var decade = form.decade.value;
    var sort = form.sort.value;

    cards.forEach(function (c) {
      var ok = true;
      if (q && c.dataset.title.indexOf(q) === -1) ok = false;
      if (genre && (' ' + c.dataset.genres + ' ').indexOf(' ' + genre + ' ') === -1) ok = false;
      if (decade) {
        var y = parseInt(c.dataset.year, 10) || 0;
        if (Math.floor(y / 10) * 10 !== parseInt(decade, 10)) ok = false;
      }
      c.hidden = !ok;
    });

    var sorted = cards.slice().sort(function (a, b) {
      var ya = +a.dataset.year || 0, yb = +b.dataset.year || 0;
      var ra = +a.dataset.rating || 0, rb = +b.dataset.rating || 0;
      if (sort === 'new') return yb - ya;
      if (sort === 'old') return ya - yb;
      if (sort === 'az') return a.querySelector('.card-title').textContent.localeCompare(b.querySelector('.card-title').textContent, 'uk');
      return rb - ra;
    });
    sorted.forEach(function (c) { grid.insertBefore(c, emptyEl); });

    var n = visible().length;
    if (countEl) countEl.textContent = 'Знайдено: ' + n + ' ' + plural(n);
    if (emptyEl) emptyEl.hidden = n !== 0;
  }

  function goRandom() {
    var list = visible();
    if (!list.length) list = cards;
    if (!list.length) return;
    window.location.href = list[Math.floor(Math.random() * list.length)].href;
  }

  form.addEventListener('input', apply);
  form.addEventListener('change', apply);

  var rnd = form.querySelector('[data-random-btn]');
  if (rnd) rnd.addEventListener('click', goRandom);

  document.querySelectorAll('[data-random]').forEach(function (a) {
    a.addEventListener('click', function (e) { e.preventDefault(); goRandom(); });
  });

  apply();
  if (window.location.hash === '#random') goRandom();
})();
