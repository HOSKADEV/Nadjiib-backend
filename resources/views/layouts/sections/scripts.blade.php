<!-- BEGIN: Vendor JS-->
<script src="{{ asset(mix('assets/vendor/libs/jquery/jquery.js')) }}"></script>
<script src="{{ asset(mix('assets/vendor/libs/popper/popper.js')) }}"></script>
{{-- <script src="{{ asset(mix('assets/vendor/js/bootstrap.js')) }}"></script> --}}
<script src="{{ asset(mix('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')) }}"></script>
<script src="{{ asset(mix('assets/vendor/js/menu.js')) }}"></script>
<script src="{{ asset('assets/vendor/js/jquery.repeater.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
@yield('vendor-script')
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
<script src="{{ asset(mix('assets/js/main.js')) }}"></script>
{{-- <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script> --}}
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> --}}

{{-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> --}}

@php
    $instanceId = DB::table('settings')->where('name', 'pusher_instance_id')->value('value');
    $currentUser = auth()->user();
@endphp

@if ($currentUser?->isAdmin() && $instanceId)
    <script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>
    <script>
        const instanceId = "{{ $instanceId }}";
        const currentUserId = "{{ $currentUser->id }}";
        const ringtone = "{{ asset('/assets/audio/mixkit-urgent-simple-tone-loop-2976.wav') }}"

        const beamsClient = new PusherPushNotifications.Client({
            instanceId: instanceId,
        });

        const beamsTokenProvider = new PusherPushNotifications.TokenProvider({
            url: "/pusher/beams-auth",
        });

        beamsClient
            .start()
            .then(() => beamsClient.setUserId(currentUserId, beamsTokenProvider))
            .catch(console.error);
        navigator.serviceWorker.addEventListener('message', event => {
            if (event.data.type === 'PLAY_NOTIFICATION_SOUND') {
                const audio = new Audio(ringtone);
                audio.play();
            }
        });
        beamsClient
            .getUserId()
            .then((userId) => {
                // Check if the Beams user matches the user that is currently logged in
                if (userId !== currentUserId) {
                    // Unregister for notifications
                    return beamsClient.stop();
                }
            })
            .catch(console.error);
    </script>
@endif

<!-- END: Theme JS-->
<!-- Pricing Modal JS-->
@stack('pricing-script')
<!-- END: Pricing Modal JS-->
<!-- BEGIN: Page JS-->
@yield('page-script')
<!-- END: Page JS-->
