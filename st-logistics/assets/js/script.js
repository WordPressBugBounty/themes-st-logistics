jQuery(document).ready(function($) {

  var scroll = $(window).scrollTop();  
  var scrollup = $('.backtotop');
  var menu_toggle = $('.menu-toggle');
  var nav_menu = $('.main-navigation ul.nav-menu');

  $(window).scroll(function() {    
      var scroll = $(window).scrollTop();  
      if (scroll > 1) {
          $("#masthead").addClass("nav-shrink");
      }
      else {
           $("#masthead").removeClass("nav-shrink");
      }
  });

  menu_toggle.click(function(){
      var $btn  = $(this);
      var $icon = $btn.find('i');
      nav_menu.slideToggle( 280 );
      $btn.toggleClass('active');
      if ( $btn.hasClass('active') ) {
          $icon.removeClass('fa-bars').addClass('fa-times');
          $btn.attr( 'aria-expanded', 'true' );
          $btn.attr( 'aria-label', 'Close menu' );
      } else {
          $icon.removeClass('fa-times').addClass('fa-bars');
          $btn.attr( 'aria-expanded', 'false' );
          $btn.attr( 'aria-label', 'Open menu' );
      }
  });

  $('.main-navigation .nav-menu .menu-item-has-children > a').after( $('<button class="dropdown-toggle"><i class="fa fa-angle-down"></i></button>') );

  $('button.dropdown-toggle').click(function() {
      $(this).toggleClass('active');
     $(this).parent().children('.sub-menu').slideToggle( 280 );
  });



  if( $(window).width() <= 1024 ) {
      $('#primary-menu').find("li").last().bind( 'keydown', function(e) {
          if( !e.shiftKey && e.which === 9 ) {
              e.preventDefault();
              $('#masthead').find('.menu-toggle').focus();
          }
      });
  }
  else {
      $('#primary-menu').find("li").unbind('keydown');
  }

  $(window).resize(function() {
      if( $(window).width() <= 1024 ) {
          $('#primary-menu').find("li").last().bind( 'keydown', function(e) {
              if( !e.shiftKey && e.which === 9 ) {
                  e.preventDefault();
                  $('#masthead').find('.menu-toggle').focus();
              }
          });
      }
      else {
          $('#primary-menu').find("li").unbind('keydown');
      }
  });

  $('.menu-toggle').on('keydown', function (e) {
      var tabKey    = e.keyCode === 9;
      var shiftKey  = e.shiftKey;

      if( $('.menu-toggle').hasClass('active') ) {
          if ( shiftKey && tabKey ) {
              e.preventDefault();
              $('#primary-menu').find("li:last-child > a").focus();
              $('#primary-menu').find("li").last().bind( 'keydown', function(e) {
                  if( !e.shiftKey && e.which === 9 ) {
                      e.preventDefault();
                      $('#masthead').find('.menu-toggle').focus();
                  }
              });
          };
      }
  });

});

window.onload = function() {
  document.getElementById("st-logistics-loader-container").style.display = "flex";
};
window.addEventListener("load", function() {
  setTimeout(function() {
      document.getElementById("st-logistics-loader-container").style.display = "none";
  } );
});

// card appear animation js start //
document.addEventListener("DOMContentLoaded", function () {
    let cards = document.querySelectorAll(".st-logistics-post-card");

    let observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("visible");
                    entry.target.style.transitionDelay = `${index * 0.2}s`; // Stagger effect
                    observer.unobserve(entry.target); // Stop observing once it appears
                }
            });
        },
        { threshold: 0.2 } // Trigger when 20% of the element is visible
    );

    cards.forEach((card) => observer.observe(card));
});
