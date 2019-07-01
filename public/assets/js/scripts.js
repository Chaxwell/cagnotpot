M.AutoInit();

//Parallax
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.parallax');
    var instances = M.Parallax.init(elems);
});

//Sidenav
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems);
});

//Carousel
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.carousel');
    var options = {
        'dist' : 0,
        'numVisible' : 3,
        'padding' : 20,
        'indicators' : true,
        //'fullWidth' : true
    };

    var instances = M.Carousel.init(elems, options);
});

//Datepicker
document.addEventListener('DOMContentLoaded', function () {
    var elems = document.querySelectorAll('.datepicker');
    var options = {
        'format': 'yyyy-mm-dd',
        'i18n': {
            'months': ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            'monthsShort': ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Jui', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
            'weekdays': ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
            'weekdaysShort': ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
            'weekdaysAbbrev': ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
        },
        'selectYears': false,
        'cancel': 'Annuler',
        'clear': 'Effacer',
        'done': 'Ok'
    };
    var instances = M.Datepicker.init(elems, options);
});

var stripe = Stripe('pk_test_NZpVMCoqPmNUXaTZ2Ou35eEG003C3AOm7g');
var elements = stripe.elements();
