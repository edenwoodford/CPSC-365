$(document).ready(function () {
    $('#addFriendButton').click(function () {
        var user1 = $(this).data('friend1');
        var user2 = $(this).data('friend2');
        $.post("friendRequest.php", { friend1: user1, friend2: user2 })
        .done(function (response) {
            try {
                var data = JSON.parse(response);
                if(data.success) {
                    alert('Friend request sent');
                } else {
                    alert('Failed to send friend request');
                }
            } catch (e) {
                alert('failed to respond');
            }
        });
    });
});
