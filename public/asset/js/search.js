$(document).ready(function(){
    $(".owl-carousel").owlCarousel({
      loop: true,
      nav: true,
      dots: false,
      autoplay: false,
      autoplayTimeout: 3000,
      responsive: {
        0:{
          items: 2
        },
        480: {
          items: 3
        },
        800: {
          items: 5
        },
        1000: {
          items: 6
        }
      }
    });
});

// model

function attachCardClickHandler() {
  $('.cards.cursor, .owl-card.cursor').on('click', function() {
      var iconUrl = $(this).data('icon-url');
      var iconName = $(this).data('icon-name');

      $('#modal-icon-img').attr('src', iconUrl);
      $('#modal-icon-name').text(iconName);

      if (!$('#exampleModal').hasClass('show')) {
        var modal = new bootstrap.Modal(document.getElementById('exampleModal'));
        modal.show();
      }
  });
}
attachCardClickHandler();

// Filter function

$(document).ready(function() {
  function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
  }

  // Function to set the form check inputs based on URL parameters
  function setFormCheckInputs() {
      var license = getUrlParameter('license');
      var style = getUrlParameter('style');
      var icon = getUrlParameter('icon');
      var sortby = getUrlParameter('sortby');

      if (license) {
          $('input[name="flexRadioDefault"][data-slug="' + license + '"]').prop('checked', true);
      }
      if (style) {
          $('input[name="flexRadioDefault1"][data-slug="' + style + '"]').prop('checked', true);
      }
      if (icon) {
          $('input[name="flexRadioDefault2"][data-slug="' + icon + '"]').prop('checked', true);
      }
      if (sortby) {
          $('input[name="flexRadioDefault3"][data-slug="' + sortby + '"]').prop('checked', true);
      }
  }

  // Call the function to set the form check inputs on page load
  setFormCheckInputs();
  getvalue();
  $('.form-check-input').on('click', function() {
    getvalue();
  });

  function getvalue() {
      var selected_license = $('input[name="flexRadioDefault"]:checked');
      var selected_license_val = selected_license.val();
      var selected_license_slug = selected_license.attr('data-slug');

      var selected_style = $('input[name="flexRadioDefault1"]:checked');
      var selected_style_val = selected_style.val();
      var selected_style_slug = selected_style.attr('data-slug');

      var selected_icon = $('input[name="flexRadioDefault2"]:checked');
      var selected_icon_val = selected_icon.val();
      var selected_icon_slug = selected_icon.attr('data-slug');

      var selected_sortby = $('input[name="flexRadioDefault3"]:checked');
      var selected_sortby_val = selected_sortby.val();
      var selected_sortby_slug = selected_sortby.attr('data-slug');

      changenextcat(selected_license_slug, selected_style_slug, selected_icon_slug, selected_sortby_slug, selected_license_val, selected_style_val, selected_icon_val, selected_sortby_val);
  }

  function changenextcat(license_slug, style_slug, icon_slug, sortby_slug, license_val, style_val, icon_val, sortby_val) {
      var base_url = '?search=' + getUrlParameter('search');
      var results = result;
      // alert(base_url)
      var query_string = 'license=' + encodeURIComponent(license_slug) +
                         '&style=' + encodeURIComponent(style_slug) +
                         '&icon=' + encodeURIComponent(icon_slug) +
                         '&sortby=' + encodeURIComponent(sortby_slug);
      var url = base_url + '&' + query_string;
      window.history.replaceState(null, null, url);

      // Make the AJAX request
      $.ajax({
          type: "get",
          url: base_url,
          dataType: 'json',
          data: {
              'selected_sortby_val': sortby_val,
              'selected_icon_val': icon_val,
              'selected_style_val': style_val,
              'selected_license_val': license_val,
              'result': results
          },
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          success: function(response) {
              if (response) {
                  $('#filter_res').empty();
                  $('#filter_res').append(response);
                  attachCardClickHandler();
              } else {
                  $('#filter_res').empty();
                  $('#filter_res').append(
                      '<div><h3 class="fw-bold opacity-75 pb-3">No icons found</h3>' +
                      '<span class="text-secondary font-sz">Try checking your spelling or use a more general term. ' +
                      'Also, you can explain to us the icon you need, and we\'ll draw it for free in one of the existing Iconfinder styles or any other (but paid). ' +
                      'The free images are pixel perfect to fit your design and available in both png and vector. ' +
                      'Download icons in all formats or edit them for your designs.</span></div>'
                  );
              }
          }
      });
  }

  // Initial check for URL and attach event handlers
  attachCardClickHandler();
});
