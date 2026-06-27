jQuery(function ($) {
    $('.parent-import-container').each(function () {
      var $wrap = $('<div>', { class: 'st-logistics-compare-feature' });
  
      var $btns = $('<div>', { class: 'st-logistics-portal-btn' });
      $('<a>', {
        href: 'https://striviothemes.com/product/logistics-wordpress-theme/?utm_source=wordpress&utm_medium=theme&utm_campaign=free_theme_admin_banner',
        class: 'button button-primary st-logistics-buy-now',
        target: '_blank',
        text: 'Buy Now'
      }).appendTo($btns);
      $('<a>', {
        href: 'https://striviothemes.com/preview/st-logistic-pro/?utm_source=wordpress&utm_medium=theme&utm_campaign=free_theme_admin_banner',
        class: 'button button-primary st-logistics-view-demo',
        target: '_blank',
        text: 'Demo'
      }).appendTo($btns);
  
      var $h2 = $('<h2>', {
        class: 'st-logistics-feature-comparison',
        text: 'Feature Comparison'
      });
  
      var rows = [
        ['Features', 'Pro', 'Free', true], // true => header row
        ['Animations', 'available', 'not-available'],
        ['Services Custom Posttype', 'available', 'not-available'],
        ['Booking Form', 'available', 'not-available'],
        ['About Page', 'available', 'not-available'],
        ['Contact Page', 'available', 'not-available'],
        ['Services Page', 'available', 'not-available'],
        ['Blog Page', 'available', 'not-available'],
        ['More Sections', 'available', 'not-available'],
        ['Before After Image', 'available', 'not-available'],
        ['Detailed Documentation', 'available', 'not-available']
      ];
  
      var $table = $('<table>', { class: 'st-logistics-compare-table' });
  
      rows.forEach(function (r, i) {
        var $tr = $('<tr>');
        if (r[3]) {
          $('<th>', { class: 'st-logistics-compare-th', text: r[0] }).appendTo($tr);
          $('<th>', { class: 'st-logistics-compare-th-pro', text: r[1] }).appendTo($tr);
          $('<th>', { class: 'st-logistics-compare-th', text: r[2] }).appendTo($tr);
        } else {
          $('<td>', { class: 'st-compare-td', text: r[0] }).appendTo($tr);
          $('<td>', {
            class: 'st-logistics-compare-td-pro'
          }).append($('<img>', {
            src: 'https://striviothemes.com/demo/st-demo-importer-imgs/' + r[1] + '.png',
            alt: r[1] === 'available' ? 'Available' : 'Not Available'
          })).appendTo($tr);
          $('<td>', {
            class: 'st-logistics-compare-td-free'
          }).append($('<img>', {
            src: 'https://striviothemes.com/demo/st-demo-importer-imgs/' + r[2] + '.png',
            alt: r[2] === 'available' ? 'Available' : 'Not Available'
          })).appendTo($tr);
        }
        $table.append($tr);
      });
  
      $wrap.append($btns, $h2, $table);
      $(this).append($wrap);
    });
  });
  