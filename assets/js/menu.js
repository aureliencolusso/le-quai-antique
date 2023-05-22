function afficherDescription(menu) {
  var menuTitles = document.getElementsByClassName('menu-title');
  var menuDescriptions = document.getElementsByClassName('menu-description');

  // Parcours de tous les titres de menu
  for (var i = 0; i < menuTitles.length; i++) {
    // Si le titre correspond au menu sélectionné, on l'active et affiche sa description
    if (menuTitles[i].getAttribute('data-menu') === menu) {
      menuTitles[i].classList.add('active');
      menuDescriptions[i].style.display = 'block';
    } else {
      // Sinon, on désactive le titre et cache sa description
      menuTitles[i].classList.remove('active');
      menuDescriptions[i].style.display = 'none';
    }
  }
}
