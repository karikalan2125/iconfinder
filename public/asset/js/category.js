$(document).ready(function() {
    var page = 1;
    var length = 0;
    var windowHeight = $(window).height();
    // console.log('windowHeight'+ windowHeight);
    $(window).scroll(function() {
        if($('#load-more').html()){
            var div_length = $('.scroll_height').length;
            if(length != div_length){
                var check = div_length - 1;
                var targetDivs = $('.scroll_height').eq(check);
                targetDivs.each(function() {
                    var targetDiv = $(this);
                    // console.log(targetDiv);
                    var targetOffset = targetDiv.offset().top +50;
                    // console.log('targetOffset'+targetOffset);
                    if ($(window).scrollTop() + windowHeight >= targetOffset && $('.load').html()=='false') {
                        length = div_length;
                        console.log('length'+length);
                        page = parseInt(page) + 1;
                        $('.load').html('true');
                        $('#loading-infinity').show();
                        $.ajax({
                            url: baseUrl + '/icons',
                            method: "GET",
                            data: { page: page },
                            cache: false,
                            success: function (data) {
                                console.log('action'+data);
                                    $('#src').append($(data).hide().fadeIn(1000));
                                    $('.load').html('false');
                                    $('#loading-infinity').hide();
                                    if(page== parseInt($('#load-more').html())){
                                    $('#load-more').remove();
                                }
                            },
                            error: function() {
                                // Hide loading indicator even if there's an error
                                $('#loading-infinity').hide();
                                $('.load').html('false');
                            }
                        });
                    }
                });
            }
        }
    });
});
