var $j = jQuery.noConflict();

var inProgress = false;

$j(document).on('click', '#send-invite', function() {

    if (inProgress) return;

    inProgress = true;

    $j('#send-invite').removeClass('btn-action').addClass('btn-default').css('cursor', 'auto').html('<span class="fa fa-spinner fa-pulse"></span>');

    var parameters = $j('.action-row input').serialize();

    var jqxhr = $j.post('/users/friends/requests/send', parameters, function(data) {

        if (data.code == 200) {

            $j('#send-invite').removeClass('btn-default').addClass('btn-action-3').css('cursor', 'pointer').attr('title', 'Cancel friend request');
            $j('#send-invite').html('<span class="fa fa-times"></span>&nbsp;<span class="fa fa-user"></span>').attr('id', 'cancel-invite');
            $j('.action-row .note').hide();
            $j('#relationship-id').val(data.newRelationship);
            inProgress = false;

        } else {

            alert(data.message);
            $j('#send-invite').switchClass('btn-default', 'btn-action').html('<span class="fa fa-plus"></span>&nbsp;<span class="fa fa-user"></span>').css('cursor', 'pointer');
            inProgress = false;

        }

    })
    .fail(function() {

        alert('Apologies, we could not connect to our server. Please try again later.');
        $j('#send-invite').switchClass('btn-default', 'btn-action').html('<span class="fa fa-plus"></span>&nbsp;<span class="fa fa-user"></span>').css('cursor', 'pointer');
        inProgress = false;

    })

});

$j(document).on('click', '#cancel-invite', function() {

    if (inProgress) return;

    inProgress = true;

    $j('#cancel-invite').removeClass('btn-action-3').addClass('btn-default').css('cursor', 'auto').html('<span class="fa fa-spinner fa-pulse"></span>');

    var parameters = 'id=' + $j('#relationship-id').val();

    var jqxhr = $j.post('/users/friends/requests/cancel', parameters, function(data) {

        if (data.code == 200) {

            $j('#cancel-invite').removeClass('btn-default').addClass('btn-action').css('cursor', 'pointer').attr('title', 'Add to friends');
            $j('#cancel-invite').html('<span class="fa fa-plus"></span>&nbsp;<span class="fa fa-user"></span>').attr('id', 'send-invite');
            inProgress = false;

        } else {

            alert(data.message);
            $j('#cancel-invite').switchClass('btn-default', 'btn-action-3').html('<span class="fa fa-times"></span>&nbsp;<span class="fa fa-user"></span>').css('cursor', 'pointer');
            inProgress = false;

        }

    })

    .fail(function() {

        alert('Apologies, we could not connect to our server. Please try again later.');
        $j('#cancel-invite').switchClass('btn-default', 'btn-action-3').html('<span class="fa fa-times"></span>&nbsp;<span class="fa fa-user"></span>').css('cursor', 'pointer');
        inProgress = false;

    })

});

$j(document).on('click', '#accept-invite', function() {

    if (inProgress) return false;

    inProgress = true;

    $j('#accept-invite').removeClass('btn-action-2').addClass('btn-default').css('cursor', 'auto').html('<span class="fa fa-spinner fa-pulse"></span>');

    var parameters = 'id=' + $j('#relationship-id').val();

    var jqxhr = $j.post('/users/friends/requests/accept', parameters, function(data) {

        if (data.code == 200) {

            $j('#accept-invite').switchClass('btn-action', 'btn-default').attr('title', 'Remove from friends');
            $j('#accept-invite').html('<span class="fa fa-minus"></span>&nbsp;<span class="fa fa-user"></span>').css('cursor', 'pointer').attr('id', 'remove-friend');
            inProgress = false;

        } else {

            alert(data.message);
            $j('#accept-invite').switchClass('btn-default', 'btn-action').html('<span class="fa fa-check"></span>&nbsp;<span class="fa fa-user"></span>').css('cursor', 'pointer');
            inProgress = false;

        }

    })
    .fail(function() {

        alert('Apologies, we could not connect to our server. Please try again later.');
        $j('#accept-invite').switchClass('btn-default', 'btn-action').html('<span class="fa fa-check"></span>&nbsp;<span class="fa fa-user"></span>').css('cursor', 'pointer');
        inProgress = false;

    })

});

$j(document).on('click', '#remove-friend', function() {

    if (inProgress) return false;

    if (!confirm('Are you sure you want to remove this person from your friends’ list?')) {
        return false;
    }

    inProgress = true;

    $j('#remove-friend').css('cursor', 'auto').html('<span class="fa fa-spinner fa-pulse"></span>');

    var parameters = 'id=' + $j('#relationship-id').val();

    var jqxhr = $j.post('/users/friends/remove', parameters, function(data) {

        if (data.code == 200) {

            $j('#remove-friend').switchClass('btn-default', 'btn-action').attr('title', 'Add to friends');
            $j('#remove-friend').html('<span class="fa fa-plus"></span>&nbsp;<span class="fa fa-user"></span>').attr('id', 'send-invite');
            $j('.action-row .note').show();
            inProgress = false;

        } else {

            alert(data.message);
            $j('#remove-friend').html('<span class="fa fa-minus"></span>&nbsp;<span class="fa fa-user"></span>').css('cursor', 'pointer');
            inProgress = false;

        }

    })
        .fail(function() {

            alert('Apologies, we could not connect to our server. Please try again later.');
            $j('#remove-friend').html('<span class="fa fa-minus"></span>&nbsp;<span class="fa fa-user"></span>').css('cursor', 'pointer');
            inProgress = false;

        })

});

$j('#messageDialog').on('shown.bs.modal', function() {

    $j('#messageDialog .message').val('').focus();

})

$j(document).on('click', '#messageDialog .action-send', function() {

    if (inProgress) return false;

    var message = $j('#messageDialog .message').val();
    $j('#messageDialog .message-alert').hide();

    if (message == '') {
        $j('#messageDialog .message').addClass('invalid');
        return false;
    } else {
        $j('#messageDialog .response .message').removeClass('invalid');
    }

    var dataString = '_token=' + $j('#_token').val() + '&id=' + $j('#url').val() + '&message=' + encodeURIComponent(message);
    var messageInfo = '';
    inProgress = true;
    $j('#messageDialog .action-send').removeClass('btn-action-2').addClass('btn-default').html('<span>Sending...</span>');

    var jqxhr = $j.post('/users/messages/new', dataString , function(response) {

        if (response.code == 200) {

            $j('#messageDialog .action-send').removeClass('btn-default').addClass('btn-action-2').html('<span class="fa fa-comments-o"></span>&nbsp;<span>Open conversation</span>').wrap('<a href="/members-area/messages"></a>').removeClass('action-send').addClass('action-conversation');
            $j('#messageDialog .message-alert').removeClass('alert-danger').addClass('alert-success').html('Message sent!').show();
            $j('.user-profile .message-button').data('toggle', '').html('<span class="fa fa-comments-o"></span>&nbsp;<span>Open conversation</span>').wrap('<a href="/members-area/messages"></a>');

            inProgress = false;

        } else {

            $j('#messageDialog .message-alert').removeClass('alert-success').addClass('alert-danger').html(response.message).show();
            $j('#messageDialog .action-send').removeClass('btn-default').addClass('btn-action-2').html('<span>Send</span>');
            inProgress = false;

        }

    })
    .fail(function() {

        $j('#messageDialog .message-alert').removeClass('alert-success').addClass('alert-danger').html('Could not connect to server. Please try again later.').show();
        $j('#messageDialog .action-send').removeClass('btn-default').addClass('btn-action-2').html('<span>Send</span>');
        inProgress = false;

    })

});

$j('#facebook-share-link').click(function(e) {

    var pageFull = window.location.pathname;
    var page = pageFull.substr(pageFull.lastIndexOf('/') + 1);

    e.preventDefault();

    FB.ui({
            method: 'share',
            href: window.location.href.toLowerCase(),
        },
        function (response) {
        }
    );

});
