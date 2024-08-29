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

        let active_txt = '256px';
            let sizeInPx = parseInt(active_txt);  // Convert size to integer
            $('#modal-icon-img').css({
                'width': sizeInPx + 'px',
                'height': sizeInPx + 'px'
            });

            // Reset color on new icon selection
            $('#customColorPicker').val('#000000'); // Reset to default color
            // selectColor('#000000'); // Apply default color to icon
            // Reset dark mode
            $('#moon-icon').show();
            $('#sun-icon').hide();
            $('#modal-icon-img').css({
                'filter': 'none',  // Remove dark mode filter
            });
            $('.modal-image-container').css({
                'background-color': '#fff' // Light background for day mode
            });
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
    //   alert(results)
      var query_string = 'license=' + encodeURIComponent(license_slug) +
                         '&style=' + encodeURIComponent(style_slug) +
                         '&icon=' + encodeURIComponent(icon_slug) +
                         '&sortby=' + encodeURIComponent(sortby_slug);
      var url = base_url + '&' + query_string;
    //   alert(url);
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

$(document).ready(function() {
    let active_txt = 256; // Default size

    // Function to update the size display and image
    function updateSizeDisplay() {
        $('#size-display').text(active_txt + 'px');
        $('#modal-icon-img').css({
            'width': active_txt + 'px',
            'height': active_txt + 'px'
        });

    }

    // Function to change size
    window.changeSize = function(delta) {
        const minSize = 16;  // Set minimum size
        const maxSize = 512; // Set maximum size

        if (active_txt + delta >= minSize && active_txt + delta <= maxSize) {
            active_txt += delta;
            updateSizeDisplay();
        }
    }

    // Reset size on modal close
    $("#exampleModal").on("hide.bs.modal", function () {
        active_txt = 256;  // Reset size to default
        updateSizeDisplay();
    });

    function showLoading() {
        $('#loadingSpinner').modal('show');
    }

    // Function to hide the loading spinner
    function hideLoading() {
        $('#loadingSpinner').modal('hide');
    }

    // Handle dark mode switching
    $('#moon-icon').on('click', function() {
        $('#moon-icon').hide();
        $('#sun-icon').show();
        $('#modal-icon-img').css({
            'filter': 'invert(1)',  // Example filter to simulate dark mode
            'padding':'0.5vh',
            'border-radius':'10px'
        });
        $('.modal-image-container').css({
            'background-color': '#000' // Dark background for dark mode
        });
    });

    $('#sun-icon').on('click', function() {
        $('#sun-icon').hide();
        $('#moon-icon').show();
        $('#modal-icon-img').css({
            'filter': 'none',  // Remove dark mode filter
        });
        $('.modal-image-container').css({
            'background-color': '#fff' // Light background for day mode
        });
    });

  // Handle click on the download button
  $("#downloadpng").click(function() {
    showLoading(); // Show loading spinner when download starts
    //   var imgUrl = $(this).data('img');
    // //   var url = base_url + 'download_icon';
    // var url = base_url + 'download_icon?imgUrl=' + encodeURIComponent(imgUrl) + '&active_txt=' + active_txt;
    // window.location.href = url;
    // alert(base_url);

    var base_url = window.location.origin + '/';

    var imgUrl = $(this).data('img');
    var format='png';
    var color = $('#customColorPicker').val();
    var url = base_url + 'download_icon?imgUrl=' + encodeURIComponent(imgUrl) + '&active_txt=' + active_txt + '&format=' + format + '&color='+ encodeURIComponent(color);
    // Create a temporary link element
    var link = document.createElement('a');
    link.href = url;

    // Append the link to the body (necessary for Firefox)
    document.body.appendChild(link);

    // Simulate a click on the link
    link.click();

    // Remove the link from the document
    document.body.removeChild(link);
    //   $.ajax({
    //     type: "get",
    //     url: url,
    //     dataType: 'json',
    //     data: {
    //       'imgUrl': imgUrl,
    //       'active_txt': active_txt
    //     },
    //     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    //     success: function(response) {
    //     },
    //     error: function(error) {
    //     }
    //   });
    setTimeout(function() {
        hideLoading();
    }, 1500);
  });

  $("#downloadjpeg").click(function() {
    //   var imgUrl = $(this).data('img');
    // //   var url = base_url + 'download_icon';
    // var url = base_url + 'download_icon?imgUrl=' + encodeURIComponent(imgUrl) + '&active_txt=' + active_txt;
    // window.location.href = url;
    showLoading(); // Show loading spinner when download starts

    var base_url = window.location.origin + '/';
    var imgUrl = $(this).data('img');
    var format='jpeg';
    var color = $('#customColorPicker').val();

    var url = base_url + 'download_icon?imgUrl=' + encodeURIComponent(imgUrl) + '&active_txt=' + active_txt + '&format=' + format + '&color=' + encodeURIComponent(color);
    // Create a temporary link element
    var link = document.createElement('a');
    link.href = url;

    // Append the link to the body (necessary for Firefox)
    document.body.appendChild(link);

    // Simulate a click on the link
    link.click();

    // Remove the link from the document
    document.body.removeChild(link);
    //   $.ajax({
    //     type: "get",
    //     url: url,
    //     dataType: 'json',
    //     data: {
    //       'imgUrl': imgUrl,
    //       'active_txt': active_txt
    //     },
    //     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    //     success: function(response) {
    //     },
    //     error: function(error) {
    //     }
    //   });
    setTimeout(function() {
        hideLoading();
    }, 1500);
  });

  $("#downloadsvg").click(function() {
    //   var imgUrl = $(this).data('img');
    // //   var url = base_url + 'download_icon';
    // var url = base_url + 'download_icon?imgUrl=' + encodeURIComponent(imgUrl) + '&active_txt=' + active_txt;
    // window.location.href = url;
    showLoading(); // Show loading spinner when download starts

    var base_url = window.location.origin + '/';
    var imgUrl = $(this).data('img');
    var format='svg';
    var color = $('#customColorPicker').val();
    var url = base_url + 'download_icon?imgUrl=' + encodeURIComponent(imgUrl) + '&active_txt=' + active_txt + '&format=' + format + '&color=' + encodeURIComponent(color);
    // Create a temporary link element
    var link = document.createElement('a');
    link.href = url;

    // Append the link to the body (necessary for Firefox)
    document.body.appendChild(link);

    // Simulate a click on the link
    link.click();

    // Remove the link from the document
    document.body.removeChild(link);
    //   $.ajax({
    //     type: "get",
    //     url: url,
    //     dataType: 'json',
    //     data: {
    //       'imgUrl': imgUrl,
    //       'active_txt': active_txt
    //     },
    //     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    //     success: function(response) {
    //     },
    //     error: function(error) {
    //     }
    //   });
    setTimeout(function() {
        hideLoading();
    }, 1500);
  });
});


// //  Event listener for the color picker input
// document.getElementById("customColorPicker").addEventListener("input", function() {
//     const selectedColor = this.value;
//     selectColor(selectedColor);
// });
// function selectColor(color) {

//     if (color.toLowerCase() === '#000000') {

//         // Set the filter to none for black
//         $('#modal-icon-img').css('filter', 'none');
//     } else {
//             return $('#modal-icon-img').css('fill', color);
//         }
// }

// Function to handle color change
// function selectColor(color) {
//     if (color.toLowerCase() === '#000000') {
//         // Set the filter to none for black
//         $('#modal-icon-img').css('filter', 'none');
//     } else {
//         // console.log(color);
//         const hue = colorToHue(color);
//         // console.log(hue);
//         $('#modal-icon-img').css('filter', `invert(1) sepia(1) saturate(10000%) hue-rotate(${hue}deg)`);
//     }
// }

// Function to convert hex color to hue rotation degree for CSS filter
// function colorToHue(hex) {
//     // Convert hex to RGB
//     const r = parseInt(hex.slice(1, 3), 16);
//     const g = parseInt(hex.slice(3, 5), 16);
//     const b = parseInt(hex.slice(5, 7), 16);
//     console.log(r);
//     console.log(g);
//     console.log(b);
//     // Convert RGB to hue
//     const max = Math.max(r, g, b);
//     const min = Math.min(r, g, b);
//     const delta=max-min;

//     let h=0;

//     if(delta !== 0){
//         if(max===r){
//             h=((g-b)/delta)%6;
//         }
//          if(max===g){
//             h=(2+(b-r)/delta)%6;
//         }else{
//             h=(4+(r-g)/delta)%6;
//         }
//     }
//     h *=60;
//     if (h < 0) {
//         h += 360;
//     }
//     return h;
//     // console.log(max);
//     // console.log(min);
//     // if(min==max){
//     //     return 0;
//     // }

//     // // let h = 0;
//     // if (max !== min) {
//     //     const d = max - min;
//     //     if (max === r) {
//     //         h = (g - b) / (max-min);
//     //     } else if (max === g) {
//     //         h = 2 +(b-r)/(max-min);
//     //     } else if (max === b) {
//     //         h = 4 + (r-g)/(max-min);
//     //     }
//     //     h = h*60;
//     // }
//     // h %= 360;
//     // if(h < 0){
//     //     h += 360;
//     // }
//     // Math.round(h);
//     // console.log(h);
//     // return h;

// }

// // Event listener for the color picker input
// document.getElementById("customColorPicker").addEventListener("input", function() {
//     const selectedColor = this.value;
//     // console.log(selectedColor);
//     selectColor(selectedColor);
// });


//copyimage

toastr.options = {
  "closeButton": true,
  "newestOnTop": false,
  "progressBar": true,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "400",
  "hideDuration": "1100",
  "timeOut": "600",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
};

function copyImageURL(imageURL) {
  if (!imageURL) {
    toastr.error('No image URL provided!');
    return;
  }
  // Use Clipboard API
  navigator.clipboard.writeText(imageURL)
    .then(function() {
      toastr.success('Image URL copied to clipboard!');
    })
    .catch(function() {
      toastr.error('Failed to copy image URL.');
    });
}
