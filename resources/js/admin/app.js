require('../bootstrap.js');



$(function() {


    $('.return-confirm').on('click', function() {
        return confirm('Are you sure ?');
    })

})

$(function() {
    $('.main-sidebar .side-nav-toggler').click(function() {
        $('.main-sidebar nav.side-nav').slideToggle(500)
        $(this).find('i').toggleClass('fa-times');
    })
})

$(function() {
    if($(window).width() > 720) {
        $('.table').removeClass('table-responsive')
    }
    $(window).on('resize', function() {
        if($(window).width() > 720) {
            $('.table').removeClass('table-responsive')
        } else {
            $('.table').addClass('table-responsive')
        }
    })
})

$(function() {

    
    $('.show-popup').click(function(e) {
        e.preventDefault();
        $('#'+ $(this).data("show") + ", .popup-bg").fadeIn(100)
    })

    $('.popup .close').click(function() {
        $('.popup-bg, .popup').fadeOut(100)
    })

    
})


$(function() {
    $('#logo').change(function() {
        $(this).next().remove().end().after(`
            <label for="logo">
                <img class="w-100" src="${window.URL.createObjectURL(this.files[0])}" alt="">
            </label>
        `)
    })
    $('#favicon').change(function() {
        $(this).next().remove().end().after(`
            <label for="favicon">
                <img class="w-100" src="${window.URL.createObjectURL(this.files[0])}" alt="">
            </label>
        `)
    })

    
})




// Video streaming :
import AgoraRTC from "agora-rtc-sdk-ng"

let rtc = {
    // For the local audio and video tracks.
    localAudioTrack: null,
    localVideoTrack: null,
    client: null
};




let startLive = document.getElementById("host-join"),
    endLive = document.getElementById("leave");

async function startBasicLiveStreaming() {

    rtc.client = AgoraRTC.createClient({ mode: "live", codec: "vp8" });

    window.onload = function () {

        startLive.onclick = async function () {

            $('#wait').show();

            rtc.client.setClientRole("host");
            await rtc.client.join(options.appId, options.channel, options.token, options.uid);
            // Create an audio track from the audio sampled by a microphone.
            rtc.localAudioTrack = await AgoraRTC.createMicrophoneAudioTrack();
            // Create a video track from the video captured by a camera.
            rtc.localVideoTrack = await AgoraRTC.createCameraVideoTrack();
            // Publish the local audio and video tracks to the channel.
            await rtc.client.publish([rtc.localAudioTrack, rtc.localVideoTrack]);
            // Dynamically create a container in the form of a DIV element for playing the remote video track.
            const localPlayerContainer = document.createElement("div");
            // Specify the ID of the DIV container. You can use the `uid` of the remote user.
            localPlayerContainer.id = options.uid;
            localPlayerContainer.style.width = "100%";
            localPlayerContainer.style.height = "335px";

            $("#video").empty();
            document.getElementById('video').append(localPlayerContainer);


            $('#wait').hide()

            $('#leave').fadeIn(200, function() {
                $(this).removeClass("d-none");
            });

            rtc.localVideoTrack.play(localPlayerContainer);

            console.log("publish success!");

            console.log(options.token);
            $.ajax({
                method: "POST",
                url: startLive.getAttribute('data-link'),
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    channel : options.channel,
                    token : options.token
                },
                success: function(data) {
                    console.log(true)
                }
            })
        }

        

        endLive.onclick = async function () {
            // Close all the local tracks.
            rtc.localAudioTrack.close();
            rtc.localVideoTrack.close();
            // Traverse all remote users.
            rtc.client.remoteUsers.forEach(user => {
                // Destroy the dynamically created DIV containers.
                const playerContainer = document.getElementById(user.uid);
                playerContainer && playerContainer.remove();
            });

            // Leave the channel.
            await rtc.client.leave();

            $.ajax({
                method: "POST",
                url: endLive.getAttribute('data-link'),
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            })
        }
    }

}

startBasicLiveStreaming()

