require('./bootstrap');


$(function() {
    $('.main-sidebar .side-nav-toggler').click(function() {
        $('.main-sidebar nav.side-nav').slideToggle(500)
        $(this).find('i').toggleClass('fa-times');
    })
})

$(function() {
    $('.login-form span.toggle-password i#show').click(function() {
        $(this).parentsUntil(".form-group").siblings('input').attr('type', 'text')
        $(this).hide().addClass('d-none');
        $(this).siblings("i#hide").show().removeClass('d-none')
    })
    $('.login-form span.toggle-password i#hide').click(function() {
        $(this).parentsUntil(".form-group").siblings('input').attr('type', 'password')
        $(this).hide().addClass('d-none');
        $(this).siblings("i#show").show().removeClass('d-none')

    })
})

$(function() {

    $('.checkout .method').click(function() {
        var id = $(this).data('id');
        $('.checkout .method').removeClass('active');
        $(this).addClass('active');
        $('.checkout form').hide(300).removeClass('active');
        $('.checkout form#' + id).fadeIn(600).addClass('active');
    })

})



import AgoraRTC from "agora-rtc-sdk-ng"

let rtc = {
    // For the local audio and video tracks.
    localAudioTrack: null,
    localVideoTrack: null,
    client: null
};




async function startBasicLiveStreaming() {

    rtc.client = AgoraRTC.createClient({ mode: "live", codec: "vp8" });

    window.onload = function () {

        document.getElementById("audience-join").onclick = async function () {

            $('#wait').show();

            setTimeout(function () {
                const status = localStorage.getItem('live-status');
                if(status == "deprecated") {
                    alert('Live is unfortunately deprecated because of many reasons . We are sorry . check our whatsapp group for more details')    
                    $('#wait').hide();
                }

            }, 5000);

            rtc.client.setClientRole("audience");
            await rtc.client.join(options.appId, options.channel, options.token, options.uid);
            rtc.client.on("user-published", async (user, mediaType) => {
                // Subscribe to a remote user.
                await rtc.client.subscribe(user, mediaType);

                localStorage.setItem('live-status', 'online')

                console.log("subscribe success");

                // If the subscribed track is video.
                if (mediaType === "video") {
                    // Get `RemoteVideoTrack` in the `user` object.
                    const remoteVideoTrack = user.videoTrack;
                    // Dynamically create a container in the form of a DIV element for playing the remote video track.
                    const remotePlayerContainer = document.createElement("div");

                    remotePlayerContainer.style.width = "100%";
                    remotePlayerContainer.style.height = "335px";

                    $('#video').empty();

                    document.getElementById('video').append(remotePlayerContainer);
                    $('#wait, #audience-join').hide()
                    $('#leave').removeClass("d-none")

                    // Play the remote video track.
                    // Pass the DIV container and the SDK dynamically creates a player in the container for playing the remote video track.
                    remoteVideoTrack.play(remotePlayerContainer);

                    // Or just pass the ID of the DIV container.
                    // remoteVideoTrack.play(playerContainer.id);
                }

                // If the subscribed track is audio.
                if (mediaType === "audio") {
                    // Get `RemoteAudioTrack` in the `user` object.
                    const remoteAudioTrack = user.audioTrack;
                    // Play the audio track. No need to pass any DOM element.
                    remoteAudioTrack.play();
                }
            });

            rtc.client.on("user-unpublished", user => {
                // Get the dynamically created DIV container.
                const remotePlayerContainer = document.getElementById(user.uid);
                // Destroy the container.
                remotePlayerContainer.remove();

                alert('Live is unfortunately deprecated because of many reasons . We are sorry . check our whatsapp group for more details')

            });

            rtc.client.on('user-left', reason => {
                alert('Live is unfortunately deprecated because of many reasons . We are sorry . check our whatsapp group for more details')    

                localStorage.setItem('live-status', 'deprecated');

                window.location.reload();
            })
        }

        document.getElementById("leave").onclick = async function () {
            
            // Leave the channel.
            await rtc.client.leave();

            $('#video').empty();
            $('#audience-join').show()
            $('#leave').addClass("d-none")

            alert("Live streaming was ended")

            window.location.reload();
        }
    }

}

startBasicLiveStreaming()




$('.text-bar form').on('submit', function(e) {
    e.preventDefault();
    let msg = $('#form-message input').val(),
        messageBox = document.getElementById('conversation');

    var div = document.createElement('div'),
        comment = document.createElement('div');


    if(msg != "") {
        $.ajax({
            method: "POST",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "dashboard/messages/send",
            data: {message: msg},
            success: function() {
                console.log("message sent!")

            
                div.setAttribute('class', "messages messages--sent");

                comment.setAttribute('class', "message");
                comment.innerHTML = msg;

                div.appendChild(comment);
                messageBox.appendChild(div);

                document.querySelector('#form-message input').value = "";
                document.querySelector('.conversation').scrollTop = document.querySelector('.conversation').scrollHeight;


            }
            
        })
    }




})


