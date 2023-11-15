$(document).ready(function() {
    $('button').click(function() {
        var requestId = $(this).data('id');
        var action = $(this).data('action');
        var button = $(this);
        $.ajax({
            type: 'POST',
            url: 'acceptORreject.php',
            data: { request_id: requestId, action: action },
            success: function(response) {
                if (response.success) {
                    if (action == 'Accept') {
                        button.closest('form').html('<p>New friend!</p>');
                    } else {
                        button.closest('form').html('<p>Rejected...</p>');
					}
                } else {
                    alert('Something went wrong');
				}
			}
        });
    });
});