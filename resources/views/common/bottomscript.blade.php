<script src="{{asset('asset/jquery/jquery.min.js')}}"></script>
<script src="{{asset('asset/bootstrap/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('asset/js/common.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
</script>
<script>
    $(document).ready(function() {

        if (sessionStorage.getItem('visited') === null) {
            sessionStorage.setItem('visited', 'true');

            const sessionId = Date.now(); // Example of a unique ID (timestamp based)
            sessionStorage.setItem('sessionId', sessionId);

            $.ajax({
                type: "POST",
                url: "/store-user-details",
                data: {
                    _token: "{{ csrf_token() }}",
                    ip: "{{ request()->ip() }}",
                    location: "{{ request()->session()->get('location') }}",
                    sessionId: sessionId // Send session ID to server
                },
                success: function(response) {
                    console.log('User details stored successfully');
                },
                error: function(error) {
                    console.error('Error storing user details', error);
                }
            });
        }

    });
</script>
{{-- <script>
    window.addEventListener('beforeunload', function (e) {

        e.preventDefault();
        e.returnValue = 'Are you sure want to close';

        const sessionId = sessionStorage.getItem('sessionId');
        const logoutTime = new Date().toISOString();

        // Prepare data to send to the server
        const data = new FormData();
        data.append('_token', "{{ csrf_token() }}");
        data.append('sessionId', sessionId);
        data.append('logoutTime', logoutTime);

        // Use navigator.sendBeacon for reliable background transmission
        navigator.sendBeacon("/store-out-time", data);
    });
</script> --}}
