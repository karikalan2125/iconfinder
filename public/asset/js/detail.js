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

        $('#image_down input[name="imgslug"]').val(iconUrl);

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

            // Reset the dark-mode
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

    // Function to get URL parameters
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
        var base_url = cat_slug;
        var query_string = 'license=' + encodeURIComponent(license_slug) +
                           '&style=' + encodeURIComponent(style_slug) +
                           '&icon=' + encodeURIComponent(icon_slug) +
                           '&sortby=' + encodeURIComponent(sortby_slug);
        var url = base_url + '?' + query_string;
        window.history.replaceState(null, null, url);
        // alert(url);
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
                'cat_slug': base_url
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

// image download
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
  $("#downloadpng").click(async function() {
    showLoading(); // Show the loading spinner when the download starts

    var imgUrl = $(this).data('img');
    console.log(imgUrl);
    var format = 'png'; // Extract format from the ID
    var color = $('#customColorPicker').val();
    var url = base_url + 'download_icon?imgUrl=' + encodeURIComponent(imgUrl) + '&active_txt=' + active_txt + '&format=' + format + '&color=' + encodeURIComponent(color);

    try {
        // Fetch the image file
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        if (!response.ok) {
            throw new Error('Failed to fetch the image');
        }

        // Get the image as a Blob
        const blob = await response.blob();
        const blobUrl = URL.createObjectURL(blob);

        // Create a temporary link element
        const link = document.createElement('a');
        link.href = blobUrl;

        // Determine the correct file extension
        let extension = format;
        link.download = `downloaded_image.${extension}`;

        // Append the link to the body
        document.body.appendChild(link);

        // Trigger the download
        link.click();

        // Cleanup
        URL.revokeObjectURL(blobUrl);
        document.body.removeChild(link);
    } catch (error) {
        console.error(error);
        alert('Failed to download the image.');
    } finally {
        hideLoading(); // Hide the loading spinner
    }
});

$("#downloadjpeg").click(async function() {
    showLoading(); // Show the loading spinner when the download starts

    var imgUrl = $(this).data('img');
    var format = 'jpeg'; // Extract format from the ID
    var color = $('#customColorPicker').val();
    var url = base_url + 'download_icon?imgUrl=' + encodeURIComponent(imgUrl) + '&active_txt=' + active_txt + '&format=' + format + '&color=' + encodeURIComponent(color);

    try {
        // Fetch the image file
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        if (!response.ok) {
            throw new Error('Failed to fetch the image');
        }

        // Get the image as a Blob
        const blob = await response.blob();
        const blobUrl = URL.createObjectURL(blob);

        // Create a temporary link element
        const link = document.createElement('a');
        link.href = blobUrl;

        // Determine the correct file extension
        let extension = format;
        link.download = `downloaded_image.${extension}`;
        
        // Append the link to the body
        document.body.appendChild(link);

        // Trigger the download
        link.click();

        // Cleanup
        URL.revokeObjectURL(blobUrl);
        document.body.removeChild(link);
    } catch (error) {
        console.error(error);
        alert('Failed to download the image.');
    } finally {
        hideLoading(); // Hide the loading spinner
    }
});

$("#downloadsvg").click(async function() {
    showLoading(); // Show the loading spinner when the download starts

    var imgUrl = $(this).data('img');
    console.log(imgUrl);
    var format = 'svg';
    var color = $('#customColorPicker').val();
    var url = base_url + 'download_icon?imgUrl=' + encodeURIComponent(imgUrl) + '&active_txt=' + active_txt + '&format=' + format + '&color=' + encodeURIComponent(color);

    try {
        // Fetch the image file
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        if (!response.ok) {
            throw new Error('Failed to fetch the image');
        }

        // Get the image as a Blob
        const blob = await response.blob();
        const blobUrl = URL.createObjectURL(blob);

        // Create a temporary link element
        const link = document.createElement('a');
        link.href = blobUrl;

        // Determine the correct file extension
        let extension = format ;
        link.download = `downloaded_image.${extension}`;

        // Append the link to the body
        document.body.appendChild(link);

        // Trigger the download
        link.click();

        // Cleanup
        URL.revokeObjectURL(blobUrl);
        document.body.removeChild(link);
    } catch (error) {
        console.error(error);
        alert('Failed to download the image.');
    } finally {
        hideLoading(); // Hide the loading spinner
    }
});


    // $("#downloadjpeg").click(function() {
    //     showLoading(); // Show the loading spinner when the download starts

    //     var imgUrl = $(this).data('img');
    //     var format = 'jpeg';
    //     var color = $('#customColorPicker').val();
    //     var url = base_url + 'download_icon?imgUrl=' + encodeURIComponent(imgUrl) + '&active_txt=' + active_txt + '&format=' + format + '&color=' + encodeURIComponent(color);

    //     // Create a temporary link element
    //     var link = document.createElement('a');
    //     link.href = url;

    //     // Append the link to the body (necessary for Firefox)
    //     document.body.appendChild(link);

    //     // Simulate a click on the link
    //     link.click();

    //     // Remove the link from the document
    //     document.body.removeChild(link);

    //     // Set a timeout to hide the loading spinner after a short delay
    //     setTimeout(function() {
    //         hideLoading();
    //     }, 1500); // Adjust the delay as needed for download completion
    // });


//   $("#downloadsvg").click(function() {
//     //   var imgUrl = $(this).data('img');
//     // //   var url = base_url + 'download_icon';
//     // var url = base_url + 'download_icon?imgUrl=' + encodeURIComponent(imgUrl) + '&active_txt=' + active_txt;
//     // window.location.href = url;
//     showLoading();
//     var imgUrl = $(this).data('img');
//     var format='svg';
//     var color = $('#customColorPicker').val();
//     var url = base_url + 'download_icon?imgUrl=' + encodeURIComponent(imgUrl) + '&active_txt=' + active_txt + '&format=' + format + '&color=' + encodeURIComponent(color);
//     // Create a temporary link element
//     var link = document.createElement('a');
//     link.href = url;

//     // Append the link to the body (necessary for Firefox)
//     document.body.appendChild(link);

//     // Simulate a click on the link
//     link.click();

//     // Remove the link from the document
//     document.body.removeChild(link);
//     //   $.ajax({
//     //     type: "get",
//     //     url: url,
//     //     dataType: 'json',
//     //     data: {
//     //       'imgUrl': imgUrl,
//     //       'active_txt': active_txt
//     //     },
//     //     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
//     //     success: function(response) {
//     //     },
//     //     error: function(error) {
//     //     }
//     //   });
//     setTimeout(function() {
//         hideLoading();
//     }, 1500); // Adjust the delay as needed for download completion
//     });
  });




//  Event listener for the color picker input
// document.getElementById("customColorPicker").addEventListener("input", function() {
//     const selectedColor = this.value;
//     selectColor(selectedColor);
// });
function selectColor(color) {
    var url = $('$modal-icon-img')
    return $('#modal-icon-img').css('fill', color);
}

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
