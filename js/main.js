jQuery(document).ready(function( $ ) {

  // Back to top button
  $(window).scroll(function() {
    if ($(this).scrollTop() > 100) {
      $('.back-to-top').fadeIn('slow');
    } else {
      $('.back-to-top').fadeOut('slow');
    }
  });
  $('.back-to-top').click(function(){
    $('html, body').animate({scrollTop : 0},1500, 'easeInOutExpo');
    return false;
  });

  // Header fixed on scroll
  $(window).scroll(function() {
    if ($(this).scrollTop() > 100) {
      $('#header').addClass('header-scrolled');
    } else {
      $('#header').removeClass('header-scrolled');
    }
  });

  if ($(window).scrollTop() > 100) {
    $('#header').addClass('header-scrolled');
  }

  // Real view height for mobile devices
  if (window.matchMedia("(max-width: 767px)").matches) {
    $('#intro').css({ height: $(window).height() });
  }

  // Initiate the wowjs animation library
  new WOW().init();

  // Initialize Venobox
  $('.venobox').venobox({
    bgcolor: '',
    overlayColor: 'rgba(6, 12, 34, 0.85)',
    closeBackground: '',
    closeColor: '#fff'
  });

  // Initiate superfish on nav menu
  $('.nav-menu').superfish({
    animation: {
      opacity: 'show'
    },
    speed: 400
  });

  // Mobile Navigation
  if ($('#nav-menu-container').length) {
    var $mobile_nav = $('#nav-menu-container').clone().prop({
      id: 'mobile-nav'
    });
    $mobile_nav.find('> ul').attr({
      'class': '',
      'id': ''
    });
    $('body').append($mobile_nav);
    $('body').prepend('<button type="button" id="mobile-nav-toggle"><i class="fa fa-bars"></i></button>');
    $('body').append('<div id="mobile-body-overly"></div>');
    $('#mobile-nav').find('.menu-has-children').prepend('<i class="fa fa-chevron-down"></i>');

    $(document).on('click', '.menu-has-children i', function(e) {
      $(this).next().toggleClass('menu-item-active');
      $(this).nextAll('ul').eq(0).slideToggle();
      $(this).toggleClass("fa-chevron-up fa-chevron-down");
    });

    $(document).on('click', '#mobile-nav-toggle', function(e) {
      $('body').toggleClass('mobile-nav-active');
      $('#mobile-nav-toggle i').toggleClass('fa-times fa-bars');
      $('#mobile-body-overly').toggle();
    });

    $(document).click(function(e) {
      var container = $("#mobile-nav, #mobile-nav-toggle");
      if (!container.is(e.target) && container.has(e.target).length === 0) {
        if ($('body').hasClass('mobile-nav-active')) {
          $('body').removeClass('mobile-nav-active');
          $('#mobile-nav-toggle i').toggleClass('fa-times fa-bars');
          $('#mobile-body-overly').fadeOut();
        }
      }
    });
  } else if ($("#mobile-nav, #mobile-nav-toggle").length) {
    $("#mobile-nav, #mobile-nav-toggle").hide();
  }

  // Smooth scroll for the menu and links with .scrollto classes
  $('.nav-menu a, #mobile-nav a, .scrollto').on('click', function() {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      if (target.length) {
        var top_space = 0;

        if ($('#header').length) {
          top_space = $('#header').outerHeight();

          if( ! $('#header').hasClass('header-fixed') ) {
            top_space = top_space - 20;
          }
        }

        $('html, body').animate({
          scrollTop: target.offset().top - top_space
        }, 1500, 'easeInOutExpo');

        if ($(this).parents('.nav-menu').length) {
          $('.nav-menu .menu-active').removeClass('menu-active');
          $(this).closest('li').addClass('menu-active');
        }

        if ($('body').hasClass('mobile-nav-active')) {
          $('body').removeClass('mobile-nav-active');
          $('#mobile-nav-toggle i').toggleClass('fa-times fa-bars');
          $('#mobile-body-overly').fadeOut();
        }
        return false;
      }
    }
  });

  // Gallery carousel (uses the Owl Carousel library)
  $(".gallery-carousel").owlCarousel({
    autoplay: true,
    dots: true,
    loop: true,
    center:true,
    responsive: { 0: { items: 1 }, 768: { items: 3 }, 992: { items: 4 }, 1200: {items: 5}
    }
  });

  // Buy tickets select the ticket type on click
  $('#buy-ticket-modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var ticketType = button.data('ticket-type');
    var modal = $(this);
    modal.find('#ticket-type').val(ticketType);
  })

// custom code

});


 
function downloadDocument() {
  // Get the selected file path
  var selectedFile = document.getElementById("documentSelect").value;
  // Trigger the download
  window.location.href = selectedFile;
}


$('.nav-menu a, #mobile-nav a, .scrollto').on('click', function(e) {
  if (this.hostname !== location.hostname || this.pathname !== location.pathname) {
    return; // Pour les liens externes, ne pas interférer
  }

  var target = $(this.hash);
  if (target.length) {
    var top_space = 0;
    if ($('#header').length) {
      top_space = $('#header').outerHeight();
      if (!$('#header').hasClass('header-fixed')) {
        top_space = top_space - 100;
      }
    }

    $('html, body').animate({
      scrollTop: target.offset().top - top_space
    }, 2200, 'easeInOutExpo');
    return false;
  }
});


document.getElementById('ticket-form').addEventListener('submit', function(event) {
 
  document.getElementById('formReservation').addEventListener('submit', function(event) {
    var prenom = document.getElementById('prenom').value;
    var nom = document.getElementById('nom').value;
    var email = document.getElementById('email').value;
    var profession = document.getElementById('profession').value;
    var nombre_tickets = document.getElementById('nombre_tickets').value;

    // Si un champ est vide, empêcher l'envoi du formulaire
    if (!prenom || !nom || !email || !profession || !nombre_tickets) {
        alert('Erreur lors de la réservation. Veuillez remplir tous les champs.');
        event.preventDefault(); // Empêche la soumission du formulaire
        return false;
    }

    // Si tout est OK, le formulaire est soumis
});

 
  // Envoyer une requête à l'API Eventbrite
  fetch('VOTRE_URL_EVENTBRITE_API', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Authorization': 'Bearer VOTRE_JETON_D_ACCES'
    },
    body: JSON.stringify({
      // Données pour l'API Eventbrite
      first_name: firstName,
      last_name: lastName,
      email: email,
      profession: profession,
      quantity: ticketQuantity
    })
  })

});


// Fonction pour activer le lien correspondant à la section visible
window.addEventListener('scroll', function () {
  let sections = document.querySelectorAll('section');
  let navLinks = document.querySelectorAll('#nav-menu-container .nav-menu li');
  let fromTop = window.scrollY + document.querySelector('#header').offsetHeight;

  // Supprime 'active-section' de tous les liens avant de vérifier la nouvelle section active
  navLinks.forEach(link => link.classList.remove('active-section'));

  sections.forEach(section => {
    let sectionTop = section.offsetTop;
    let sectionHeight = section.offsetHeight;

    if (fromTop >= sectionTop && fromTop <= sectionTop + sectionHeight) {
      let activeLink = document.querySelector(`.nav-menu a[href="#${section.id}"]`);
      if (activeLink) {
        activeLink.parentElement.classList.add('active-section'); // Ajoute 'active-section' au lien correspondant
      }
    }
  });
});

// Exécute la fonction une première fois au chargement pour identifier la section active
document.addEventListener('DOMContentLoaded', () => {
  window.dispatchEvent(new Event('scroll'));
});
