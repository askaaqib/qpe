var $j = jQuery.noConflict();

var inProgress = false;
var SendingInfo = false;
var ResultsResent = false;
var Subscribed = false;

var friendsSectionOffset = 0;
var invitesSectionOffset = 0;

var activeQuestionID = 0;
var questionSet = 1;
var ownQuestionSet = 1;
var answerSet = 1;
var answerCount = 0;
var noAnswers = true;

var customFilter = false;
var defaultStoryOffset = 10;
var customStoryOffset = 1;

var Stage2 = false;

$j(document).on('click', '.members-area .top-switches .switch', function () {

    var selectedSection = $j(this).data('section');

    if (!inProgress) {
        inProgress = true;
        $j(this).find('.switch-icon').html('<span class="fa fa-spinner fa-pulse"></span>');
        window.location.href = '/members-area/' + selectedSection;
    }

});

$j('#send-dialog #request-form').submit(function (e) {

    e.preventDefault();

    if (inProgress) return;

    if (!Stage2) {
        $j('#send-dialog .alert').hide();
        $j('#send-dialog #email').removeClass('invalid');

        inProgress = true;

        $j('#send-dialog .action-send').prop('disabled', true);

        var parameters = $j('#request-form').serialize();

        var jqxhr = $j.post('/users/profile/create', parameters, function (response) {
            if (response.code == 200) {
                Stage2 = true;

                $j('#send-dialog .action-send').hide();
                $j('#send-dialog .action-close').data('done', 1);

                if ($j('#send-dialog #newsletter').prop('checked')) {
                    $j('#send-dialog #confirmation-message').html('<p>Please do not forget to confirm your subscription by clicking the link in the e-mail.</p>');
                }

                $j('#send-dialog .step-1').hide();

                var personalLink = response.inviteCode;
                $j('#send-dialog #friend-link').val('https://www.16personalities.com/free-personality-test/' + personalLink);
                $j('#send-dialog #twitter-custom-link').attr('href', 'https://twitter.com/share?url=https://www.16personalities.com/free-personality-test/' + personalLink + "&text=I%20am%20'The%20" + $j('#nice-type-field').val() + "'%20(" + $j('#nice-type-code').val() + ').%20What%20is%20your%20type?&via=16Personalities&hashtags=16Personalities');
                $j('#send-dialog #facebook-custom-link').attr('href', 'https://www.facebook.com/sharer/sharer.php?u=https://www.16personalities.com/free-personality-test/' + personalLink);
                $j('#send-dialog #google-custom-link').attr('href', 'https://plus.google.com/share?url=https://www.16personalities.com/free-personality-test/' + personalLink);
                $j('#send-dialog #pinterest-custom-link').attr('href', '//pinterest.com/pin/create/link/?url=https%3A%2F%2Fwww.16personalities.com%2Ffree-personality-test%2F' + personalLink + '&media=https%3A%2F%2Fwww.16personalities.com%2Fimages%2Flogo_main.png&description=Pin%20It!');
                $j('#send-dialog .step-2').show();

            } else {

                $j('#send-dialog #email').addClass('invalid');
                $j('#send-dialog .alert').html(response.message).show();
                $j('#send-dialog .action-send').prop('disabled', false);
                inProgress = false;

            }
        })
        .fail(function () {

            $j('#send-dialog .alert').html('Could not connect to server - please try again.').show();
            $j('#send-dialog .action-send').prop('disabled', false);
            inProgress = false;

        })

    }

});

$j('#send-dialog .action-close').click(function () {
    if ($j(this).data('done') == 1) window.location.reload();
});

$j(document).on('click', '#members-area-forgot-button', function (e) {

    e.preventDefault();
    if (inProgress) return;

    $j('#forgot-email').css('border', '1px solid #E1E1E1');

    if ($j('#forgot-email').val() == '') {
        $j('#forgot-email').css('border', '1px solid #7F3300');
        return false;
    }

    inProgress = true;

    $j('#members-area-forgot-button').removeClass('btn-action').addClass('btn-default');
    $j('#members-area-forgot-button').css('cursor', 'auto');
    $j('#members-area-forgot-button').html('<span>Please wait...</span>');

    $j('#forgot-password').submit();

});

$j(document).on('click', '#members-area-reset-button', function (e) {

    e.preventDefault();
    if (inProgress) return;

    $j('#password, #password2').css('border', '1px solid #E1E1E1');

    if ($j('#password').val() == '') {
        $j('#password').css('border', '1px solid #7F3300');
        return false;
    }

    if ($j('#password2').val() == '') {
        $j('#password2').css('border', '1px solid #7F3300');
        return false;
    }

    inProgress = true;

    $j('#members-area-reset-button').removeClass('btn-action').addClass('btn-default');
    $j('#members-area-reset-button').css('cursor', 'auto');
    $j('#members-area-reset-button').html('<span>Please wait...</span>');

    $j('#reset-password').submit();

});

$j('.members-area .section.preferences #password-submit').click(function () {

    if (inProgress) return;

    var validationError = false;
    inProgress = true;

    $j('#old-password, #new-password-1, #new-password-2').removeClass('invalid');
    $j('#password-alert').hide();

    var oldPassword = $j('#old-password').val();
    var newPassword1 = $j('#new-password-1').val();
    var newPassword2 = $j('#new-password-2').val();

    if (oldPassword == '') {
        $j('#old-password').addClass('invalid');
        validationError = true;
    }

    if (newPassword1 == '') {
        $j('#new-password-1').addClass('invalid');
        validationError = true;
    }

    if (newPassword2 == '') {
        $j('#new-password-2').addClass('invalid');
        validationError = true;
    }

    if (!validationError && newPassword1.length < 8) {
        $j('#new-password-1').addClass('invalid');
        $j('#password-alert').html('Your new password is too short. Please pick one that is at least 8 symbols long.');
        $j('#password-alert').show();
        validationError = true;
    }

    if (!validationError && newPassword1 != newPassword2) {
        $j('#new-password-2').addClass('invalid');
        $j('#password-alert').html('Passwords do not match.');
        $j('#password-alert').show();
        validationError = true;
    }

    if (validationError) {
        inProgress = false;
        return false;
    }

    $j('#password-submit').removeClass('btn-action-2').addClass('btn-default').css('cursor', 'auto').html('<span class="fa fa-spinner fa-pulse"></span>');

    var parameters = $j('#password-form').serialize();

    var jqxhr = $j.post('/users/profile/change-password', parameters, function (data) {

        if (data.code == 200) {

            $j('#password-submit').switchClass('btn-default', 'btn-action-2').css('cursor', 'pointer').html('<span>Update password</span>');
            $j('#password-alert').removeClass('alert-danger').addClass('alert-success');
            $j('#password-alert').html('Your password has been changed.').show();
            inProgress = false;

        } else {

            $j('#password-submit').switchClass('btn-default', 'btn-action-2').css('cursor', 'pointer').html('<span>Update password</span>');
            $j('#password-alert').html(data.message).show();
            inProgress = false;

        }

    })
        .fail(function () {

            $j('#question-alert').html('');
            $j('#password-submit').switchClass('btn-default', 'btn-action-2').css('cursor', 'pointer').html('<span>Update password</span>');
            $j('#password-alert').html('Cannot connect to server - please try again later.').show();
            inProgress = false;

        })

});

$j('#friend-link').click(function () {
    $j(this).select();
});

$j(document).on('click', '.members-area-tabs a[href="#community"]', function () {

    $j('#community #answers-list').hide();
    $j('#community #answers-list #answer-alert').hide();
    $j('#community #questions-list').show();

});

$j(document).on('click', '#save-question', function (e) {

    e.preventDefault();

    if (SendingInfo) return false;

    SendingInfo = true;

    $j('#save-question').removeClass('btn-action').addClass('btn-default');
    $j('#save-question').css('cursor', 'default');
    $j('#save-question').html('<span>Please wait...</span>');

    var parameters = $j('#question-form').serialize();

    var jqxhr = $j.post('/questions/new', parameters, function (data) {

        SendingInfo = false;
        $j('#save-question').css('cursor', 'pointer');

        if (data === 'OK') {

            $j('#save-question').removeClass('btn-default').addClass('btn-green');
            $j('#save-question').html('<span>Question saved!</span>');
            location.reload(true);

        } else if (data === 'TOKEN') {

            $j('#question-alert').html('Cannot connect to server - please try again later.');
            $j('#question-alert').removeClass('hidden');
            $j('#save-question').removeClass('btn-default').addClass('btn-action');
            $j('#save-question').html('<span>Save</span>');

        } else if (data === 'LOGIN') {

            $j('#question-alert').html('Please log in before posting a question.');
            $j('#question-alert').removeClass('hidden');
            $j('#save-question').removeClass('btn-default').addClass('btn-action');
            $j('#save-question').html('<span>Save</span>');
            location.reload(true);

        } else if (data === 'MISSING') {

            $j('#question-alert').html('Please specify the question title and the question itself.');
            $j('#question-alert').removeClass('hidden');
            $j('#save-question').removeClass('btn-default').addClass('btn-action');
            $j('#save-question').html('<span>Save</span>');

        } else if (data === 'MISSINGTYPE') {

            $j('#question-alert').html('Please select at least one personality type.');
            $j('#question-alert').removeClass('hidden');
            $j('#save-question').removeClass('btn-default').addClass('btn-action');
            $j('#save-question').html('<span>Save</span>');

        } else if (data === 'MISSINGVARIANT') {

            $j('#question-alert').html('Please select at least one type variant.');
            $j('#question-alert').removeClass('hidden');
            $j('#save-question').removeClass('btn-default').addClass('btn-action');
            $j('#save-question').html('<span>Save</span>');

        } else {

            $j('#question-alert').html('Cannot connect to server - please try again later.');
            $j('#question-alert').removeClass('hidden');
            $j('#save-question').removeClass('btn-default').addClass('btn-action');
            $j('#save-question').html('<span>Save</span>');

        }

    })

        .fail(function () {

            SendingInfo = false;
            $j('#question-alert').html('Cannot connect to server - please try again later.');
            $j('#question-alert').removeClass('hidden');
            $j('#save-question').css('cursor', 'pointer');
            $j('#save-question').removeClass('btn-default').addClass('btn-action');
            $j('#save-question').html('<span>Save</span>');

        })

});

$j(document).on('click', '#modify-question', function (e) {

    e.preventDefault();

    if (SendingInfo) return false;

    SendingInfo = true;

    $j('#modify-question').removeClass('btn-action').addClass('btn-default');
    $j('#modify-question').css('cursor', 'default');
    $j('#modify-question').html('<span>Please wait...</span>');

    var parameters = $j('#question-modify-form').serialize();

    var jqxhr = $j.post('/questions/update', parameters, function (data) {

        SendingInfo = false;
        $j('#modify-question').css('cursor', 'pointer');

        if (data.code == 200) {

            var newTitle = $j('#question-modify-form #question-modify-title').val();
            $j('#answers-list .question-title').html(newTitle);
            $j('#questions-list .community-own-questions-wrapper .question-item .question-link[data-id="' + activeQuestionID + '"]').html(newTitle);

            var newBody = $j('#question-modify-form #question-modify-body').val();
            newBody = newBody.replace(/(?:\r\n|\r|\n)/g, '<br />');

            $j('#answers-list .question-content').html(newBody);
            $j('#question-modify-dialog').modal('hide');
            $j('#modify-question').removeClass('btn-default').addClass('btn-action');
            $j('#modify-question').html('<span>Update</span>');

        } else {

            $j('#question-modify-alert').html(data.message);
            $j('#question-modify-alert').removeClass('hidden');
            $j('#modify-question').removeClass('btn-default').addClass('btn-action');
            $j('#modify-question').html('<span>Update</span>');

        }

    })

        .fail(function () {

            SendingInfo = false;
            $j('#question-modify-alert').html('Cannot connect to server - please try again later.');
            $j('#question-modify-alert').removeClass('hidden');
            $j('#modify-question').css('cursor', 'pointer');
            $j('#modify-question').removeClass('btn-default').addClass('btn-action');
            $j('#modify-question').html('<span>Update</span>');

        })

});

$j(document).on('click', '#delete-account-link', function () {

    if (!confirm('Are you sure you want to delete your profile? This is irreversible.')) {
        return false;
    }

});

$j('.members-area .section.preferences .resend-results-button').click(function () {

    if (inProgress || ResultsResent) return false;

    inProgress = true;
    $j('.resend-results-button').switchClass('btn-action-2', 'btn-default').html('<span class="fa fa-spinner fa-pulse"></span>&nbsp;<span>Just a moment...</span>');

    var jqxhr = $j.get('/users/profile/resend', function (data) {

        inProgress = false;
        if (data.code == 200) {
            ResultsResent = true;
            $j('.resend-results-button').switchClass('btn-default', 'btn-action-2').html('<span class="fa fa-check"></span>&nbsp;<span>Sent!</span>');
        } else {
            alert(data.message);
            $j('.resend-results-button').switchClass('btn-default', 'btn-action-2').html('<span>Resend results</span>');
        }

    })
        .fail(function () {

            inProgress = false;
            alert('Sorry, we could not resend your results at this time. Please try again later.');
            $j('.resend-results-button').switchClass('btn-default', 'btn-action-2').html('<span>Resend results</span>');

        })

});

$j('.members-area .section.preferences #subscribe-user').click(function () {

    if (inProgress || Subscribed) return;

    inProgress = true;

    $j('#subscribe-user').removeClass('btn-action-2').addClass('btn-default').css('cursor', 'auto').html('<span class="fa fa-spinner fa-pulse"></span>');

    var jqxhr = $j.get('/users/profile/subscribe', function (data) {

        if (data.code == 200) {

            $j('#subscribe-user').switchClass('btn-default', 'btn-green').html('<span class="fa fa-check"></span>&nbsp;<span>Subscribed</span>');

            $j('#newsletter').hide();
            $j('.subscribe-note').hide();
            $j('.subscribe-note-2').hide();
            alert('Subscribed! Please do not forget to confirm your subscription by clicking the link in the e-mail.');
            inProgress = false;
            Subscribed = true;

        } else {

            alert('Apologies, we could not subscribe you at this time. Please try again later.');
            $j('#subscribe-user').removeClass('btn-default').addClass('btn-action-2');
            $j('#subscribe-user').css('cursor', 'pointer');
            $j('#subscribe-user').html('<span>Subscribe</span>');
            inProgress = false;

        }

    })
        .fail(function () {

            alert('Apologies, we could not subscribe you at this time. Please try again later.');
            $j('#subscribe-user').removeClass('btn-default').addClass('btn-action-2');
            $j('#subscribe-user').css('cursor', 'pointer');
            $j('#subscribe-user').html('<span>Subscribe</span>');
            inProgress = false;

        })

});

$j('.members-area .section.preferences #visibility-switch-private').click(function () {

    if (inProgress || $j(this).hasClass('active')) return false;

    if (!confirm('This will also cancel any pending friend requests. Are you sure you want to proceed?')) {
        return false;
    }

    $j('#visibility-switch-private .label-title').html('<span class="fa fa-spinner fa-pulse"></span>');

    var parameters = 'visible=0&_token=' + $j('#_token').val();

    var jqxhr = $j.post('/users/profile/set-visibility', parameters, function (data) {

        if (data.code == 200) {

            $j('#visibility-switch-private .label-title').html('Private');
            $j('.link-info.public').hide();
            $j('.link-info.private').show();
            $j('.invite-list-wrapper').html('No requests found.');
            $j('.answer-name').html('Posting anonymously. To choose your name, make your profile public in the Preferences tab.');

            $j('#profile-menu .primary-wrapper').html('<span class="fa fa-exclamation-triangle"></span>&nbsp;Your profile is currently private. <a href="/members-area">Make it public</a> to get a profile link and connect with your friends.');

            inProgress = false;

        } else {

            alert('Apologies, we could not update your profile at this time. Please try again later.');
            $j('#visibility-switch-private .label-title').html('Private');
            $j('#visibility-switch-public').button('toggle');
            inProgress = false;

        }

    })
        .fail(function () {

            alert('Apologies, we could not update your profile at this time. Please try again later.');
            $j('#visibility-switch-private .label-title').html('Private');
            $j('#visibility-switch-public').button('toggle');
            inProgress = false;

        })

});

$j('.members-area .section.preferences #visibility-switch-public').click(function () {

    if (inProgress || $j(this).hasClass('active')) return false;

    $j('#visibility-switch-public .label-title').html('<span class="fa fa-spinner fa-pulse"></span>');

    var parameters = 'visible=1&_token=' + $j('#_token').val();

    var jqxhr = $j.post('/users/profile/set-visibility', parameters, function (data) {

        if (data.code == 200) {

            $j('#visibility-switch-public .label-title').html('Public');
            $j('#profile-name').val(data.name);
            $j('#profile-link').val('https://www.16personalities.com/profiles/' + data.url);

            $j('#twitter-profile-link').attr('href', 'https://twitter.com/share?url=https://www.16personalities.com/profiles/' + data.url + '&text=This%20is%20my%20%2316Personalities%20profile.%20Share%20yours!&via=16Personalities&hashtags=16Personalities');
            $j('#facebook-profile-link').attr('href', 'https://www.facebook.com/sharer/sharer.php?u=https://www.16personalities.com/profiles/' + data.url);
            $j('#google-profile-link').attr('href', 'https://plus.google.com/share?url=https://www.16personalities.com/profiles/' + data.url);
            $j('#pinterest-profile-link').attr('href', '//pinterest.com/pin/create/link/?url=https%3A%2F%2Fwww.16personalities.com%2Fprofiles%2F' + data.url + '&media=https%3A%2F%2F16personalities.com%2Fimages%2Ftypes%2F' + $j('#type').val() + '.png&description=Pin%20It!');

            $j('.link-info.private').hide();
            $j('.link-info.public').show();
            $j('.answer-name').html('Posting as <strong>' + data.name + '</strong>. You can change your name in the Preferences tab.');

            $j('#profile-menu .primary-wrapper').html('<div>Here is a link to your profile – share it with friends!</div><input readonly class="profile-link" value="https://www.16personalities.com/profiles/' + data.url + '">');

            inProgress = false;

        } else {

            alert('Apologies, we could not update your profile at this time. Please try again later.');
            $j('#visibility-switch-public .label-title').html('Public');
            $j('#visibility-switch-private').button('toggle');
            inProgress = false;

        }

    })
        .fail(function () {

            alert('Apologies, we could not update your profile at this time. Please try again later.');
            $j('#visibility-switch-public .label-title').html('Public');
            $j('#visibility-switch-private').button('toggle');
            inProgress = false;

        })

});

$j('.members-area .section.preferences .gender-switches .switch').click(function () {

    if (inProgress) return false;
    var thisTransfer = $j(this);
    var gender = $j(thisTransfer).data('gender');
    var parameters = '_token=' + $j('#_token').val() + '&gender=' + gender;
    inProgress = true;

    var jqxhr = $j.post('/users/profile/set-gender', parameters, function (data) {

        if (data.code === 200) {
            inProgress = false;
        } else {
            alert(data.message);
            inProgress = false;
        }

    })
        .fail(function () {

            alert('Apologies, we could not update your profile at this time. Please try again later.');
            inProgress = false;

        })

});

$j('.members-area .section.preferences .notification-switches .switch').click(function () {

    if (inProgress) return false;
    var thisTransfer = $j(this);
    var notifications = $j(thisTransfer).data('notifications');
    var parameters = 'notifications=' + notifications;
    inProgress = true;

    var jqxhr = $j.post('/users/profile/set-notifications', parameters, function (data) {

        inProgress = false;
        if (data.code != 200) {
            alert(data.message);
        }

    })
    .fail(function () {

        alert('Apologies, we could not update your profile at this time. Please try again later.');
        inProgress = false;

    })

});

$j('.members-area .section.preferences #name-change').click(function () {

    if (inProgress) return false;

    var newName = $j('#profile-name').val();
    if (newName == '') {
        $j('#profile-name').addClass('invalid');
        return false;
    }

    $j('#profile-name').removeClass('invalid');

    $j('#name-change').switchClass('btn-action-2', 'btn-default', 0).html('<span class="fa fa-spinner fa-pulse"></span>&nbsp;<span>Just a sec...</span>');

    var parameters = 'name=' + newName + '&_token=' + $j('#_token').val();

    var jqxhr = $j.post('/users/profile/set-name', parameters, function (data) {

        if (data.code == 200) {

            $j('#name-change').switchClass('btn-default', 'btn-green', 0);
            $j('#name-change').html('<span class="fa fa-check"></span>&nbsp;<span>Changed!</span>');
            $j('.main-headline .name').html(newName);
            $j('.welcome-name').html(newName);
            $j('#friend-invitetext').val('I took this personality test – try it yourself and let’s compare our results! It’s free and only takes 10 minutes. Thanks! /' + newName);
            $j('.answer-name').html('Posting as <strong>' + newName + '</strong>. You can change your name in the Preferences tab.');
            inProgress = false;

        } else {

            alert(data.message);
            $j('#name-change').switchClass('btn-default', 'btn-action-2', 0);
            $j('#name-change').html('<span>Set name</span>');
            inProgress = false;

        }

    })
        .fail(function () {

            alert('Apologies, we could not update your profile at this time. Please try again later.');
            $j('#name-change').switchClass('btn-default', 'btn-action-2', 0).html('<span>Set name</span>');
            inProgress = false;

        })

});

$j('.members-area .section.preferences #email-change').click(function () {

    if (inProgress) return false;

    var newEmail = $j('#profile-email').val();
    if (newEmail == '') {
        $j('#profile-email').addClass('invalid');
        return false;
    }

    $j('#profile-email').removeClass('invalid');

    $j('#email-change').switchClass('btn-action-2', 'btn-default', 0).html('<span class="fa fa-spinner fa-pulse"></span>&nbsp;<span>Just a sec...</span>');

    var parameters = 'email=' + newEmail;

    var jqxhr = $j.post('/users/profile/set-email', parameters, function (data) {

        inProgress = false;

        if (data.code == 200) {

            $j('#email-change').switchClass('btn-default', 'btn-green', 0);
            $j('#email-change').html('<span class="fa fa-check"></span>&nbsp;<span>Changed!</span>');

        } else {

            alert(data.message);
            $j('#email-change').switchClass('btn-default', 'btn-action-2', 0).html('Save');

        }

    })
    .fail(function () {

        alert('Apologies, we could not update your profile at this time. Please try again later.');
        $j('#email-change').switchClass('btn-default', 'btn-action-2', 0).html('Save');
        inProgress = false;

    })

});

$j('.members-area .section.tests .mini-test #mini-test-form').submit(function (e) {

    if (inProgress) e.preventDefault();

    inProgress = true;
    $j('#mini-test-form .see-results').removeClass('btn-action').addClass('btn-default').html('<span class="fa fa-spinner fa-pulse"></span>&nbsp;<span>Please wait...</span>');

});

$j('#profile-name').keyup(function (e) {

    if ($j('#name-change').hasClass('btn-green')) {
        $j('#name-change').html('<span>Set name</span>').switchClass('btn-green', 'btn-action-2');
    }

    if (e.which == 13) {
        e.preventDefault();
        $j('#name-change').trigger('click');
    }

});

$j('#profile-link').click(function () {
    $j(this).select();
});

$j('#friend-sendinvites').click(function () {

    if (inProgress) return false;

    $j('#friend-emails').removeClass('invalid');
    $j('.compare-section .friend-invites .friend-invitealert').hide();

    var emails = $j.trim($j('#friend-emails').val());
    if (emails == '') {

        $j('#friend-emails').addClass('invalid');
        return false;

    }

    inProgress = true;

    $j('#friend-sendinvites').removeClass('btn-action').addClass('btn-default');
    $j('#friend-sendinvites').html('<span class="fa fa-spinner fa-pulse"></span>&nbsp;<span>Sending...</span>');

    var parameters = '_token=' + $j('#_token').val() + '&emails=' + emails + '&text=' + $j('#friend-invitetext').val();

    var jqxhr = $j.post('/users/friends/requests/send-emails', parameters, function (data) {

        if (data.code == 200) {

            var data = data.payload;

            $j('.compare-section .friend-invites .friend-invitealert').html('Invites sent!').removeClass('alert-danger').addClass('alert-success').show();
            $j('#friend-sendinvites').removeClass('btn-default').addClass('btn-action');
            $j('#friend-sendinvites').html('<span>Send invites</span>');
            inProgress = false;

        } else {

            $j('.compare-section .friend-invites .friend-invitealert').html(data.message).removeClass('alert-success').addClass('alert-danger').show();
            $j('#friend-sendinvites').removeClass('btn-default').addClass('btn-action');
            $j('#friend-sendinvites').html('<span>Send invites</span>');
            inProgress = false;

        }

    })
        .fail(function () {

            $j('.compare-section .friend-invites .friend-invitealert').html('Apologies, we could not send invites at this time. Please try again later.').removeClass('alert-success').addClass('alert-danger').show();
            $j('#friend-sendinvites').removeClass('btn-default').addClass('btn-action');
            $j('#friend-sendinvites').html('<span>Send invites</span>');
            inProgress = false;

        })

});

$j('.friend-invite .request-accept').click(function () {

    if (inProgress) return false;

    var id = $j(this).data('id');
    var processed = $j(this).data('processed');
    if (processed == 1) return false;

    $j(this).removeClass('btn-action').addClass('btn-default').css('cursor', 'auto').html('<span class="fa fa-spinner fa-pulse"></span>');

    var thisTransfer = $j(this);
    var parameters = 'id=' + id + '&_token=' + $j('#_token').val();

    var jqxhr = $j.post('/users/friends/requests/accept', parameters, function (data) {

        if (data.code == 200) {

            $j(thisTransfer).css('width', 'auto').switchClass('btn-default', 'btn-action-3');
            $j(thisTransfer).next().hide();
            $j(thisTransfer).data('processed', 1).html('<span class="fa fa-check"></span>&nbsp;<span>Accepted</span>');
            inProgress = false;

        } else {

            alert(data.message);
            $j(thisTransfer).switchClass('btn-default', 'btn-action-2').html('<span>Accept</span>');
            inProgress = false;

        }

    })
        .fail(function () {

            alert('Apologies, we could not connect to our server. Please try again later.');
            $j(thisTransfer).switchClass('btn-default', 'btn-action-2').html('<span>Accept</span>');
            inProgress = false;

        })

});

$j('.friend-invite .request-reject').click(function () {

    if (inProgress) return false;

    var id = $j(this).data('id');
    var processed = $j(this).data('processed');
    if (processed == 1) return false;

    $j(this).removeClass('btn-action').addClass('btn-default').css('cursor', 'auto').html('<span class="fa fa-spinner fa-pulse"></span>');

    var thisTransfer = $j(this);
    var parameters = 'id=' + id + '&_token=' + $j('#_token').val();

    var jqxhr = $j.post('/users/friends/requests/reject', parameters, function (data) {

        if (data.code == 200) {

            $j(thisTransfer).css('width', 'auto').switchClass('btn-default', 'btn-action-3');
            $j(thisTransfer).prev().hide();
            $j(thisTransfer).data('processed', 1).html('<span class="fa fa-times"></span>&nbsp;<span>Rejected</span>');
            inProgress = false;

        } else {

            alert(data.message);
            $j(thisTransfer).removeClass('btn-default').addClass('btn-action').html('<span>Reject</span>');
            inProgress = false;

        }

    })
        .fail(function () {

            alert('Apologies, we could not connect to our server. Please try again later.');
            $j(thisTransfer).removeClass('btn-default').addClass('btn-action').html('<span>Reject</span>');
            inProgress = false;

        })

});

$j('.friend-invite .request-cancel').click(function () {

    if (inProgress) return false;

    var id = $j(this).data('id');
    var processed = $j(this).data('processed');
    if (processed == 1) return false;

    $j(this).removeClass('btn-action').addClass('btn-default').css('cursor', 'auto').html('<span class="fa fa-spinner fa-pulse"></span>');

    var thisTransfer = $j(this);
    var parameters = 'id=' + id + '&_token=' + $j('#_token').val();

    var jqxhr = $j.post('/users/friends/requests/cancel', parameters, function (data) {

        if (data.code == 200) {

            $j(thisTransfer).css('width', 'auto').switchClass('btn-default', 'btn-action-3').data('processed', 1).html('<span class="fa fa-times"></span>&nbsp;<span>Cancelled</span>');
            inProgress = false;

        } else {

            alert(data.message);
            $j(thisTransfer).removeClass('btn-default').addClass('btn-action').html('<span>Cancel</span>');
            inProgress = false;

        }

    })
        .fail(function () {

            alert('Apologies, we could not connect to our server. Please try again later.');
            $j(thisTransfer).removeClass('btn-default').addClass('btn-action').html('<span>Cancel</span>');
            inProgress = false;

        })

});

$j(document).on('click', '.friend-remove-toggle', function () {

    var recountedItems = 0;

    if (inProgress) return false;

    if (!confirm('Are you sure you want to remove this person from your friends’ list?')) {
        return false;
    }

    inProgress = true;

    var parameters = 'id=' + $j(this).data('id') + '&_token=' + $j('#_token').val();
    var thisTransfer = $j(this).parent();

    var jqxhr = $j.post('/users/friends/remove', parameters, function (data) {

        if (data.code == 200) {

            $j(thisTransfer).hide('drop', {direction: 'up'}, function () {

                $j(thisTransfer).remove();

                $j('.friend-result').each(function (i, e) {

                    recountedItems++;
                    $j(this).attr('data-id', recountedItems);

                });

                $j('.friend-result').filter(function () {
                    return (parseInt($j(this).attr('data-id')) > friendsSectionOffset && parseInt($j(this).attr('data-id')) <= friendsSectionOffset + 4);
                }).show('drop', {direction: 'down'});

                maxFriends--;

                if (maxFriends <= friendsSectionOffset + 4) {
                    $j('.friends-list-section-wrapper').css('min-height', 'auto');
                    $j('.friend-list-load').hide();
                }

                inProgress = false;

            });

        } else {

            alert(data.message);
            inProgress = false;

        }

    })
        .fail(function () {

            alert('Apologies, we could not connect to our server. Please try again later.');
            inProgress = false;

        })

});

$j(document).on('submit', '.friend-search #search-form', function () {

    $j('.friend-search #search-form .search-button').removeClass('btn-action-2').addClass('btn-default').html('<span>Please wait...</span>');

});

$j(document).on('submit', '#name-form', function () {

    if (inProgress) return false;

    var name = $j('#name-form #name').val();

    if (name == '') {
        $j('#name-form #name').addClass('invalid');
        return false;
    } else {
        $j('#name-form #name').removeClass('invalid');
    }

    $j('#name-form .action-continue').html('<span class="fa fa-spinner fa-pulse"></span>&nbsp;Continue&nbsp;<span class="fa fa-caret-right"></span>').prop('disabled', true);

    inProgress = true;

    var parameters = 'name=' + name + '&age=' + $j('#name-form #age').val() + '&gender=' + $j('#name-form #gender').val();

    var jqxhr = $j.post('/users/profile/set-name', parameters, function (response) {

        inProgress = false;
        if (response.code == 200) {
            window.location.reload(true);
        } else {

            alert(response.message);
            $j('#name-form .action-continue').html('Continue&nbsp;<span class="fa fa-caret-right"></span>').prop('disabled', false);

        }

    })
        .fail(function () {

            inProgress = false;
            $j('#name-form .action-continue').html('Continue&nbsp;<span class="fa fa-caret-right"></span>').prop('disabled', false);
            alert('Sorry, we could not connect to our server. Please try again later.');

        })

});

$j(document).on('click', '.members-area .section.discussions .question-view .show-reply', function () {

    $j('.reply-wrapper').slideToggle(300);

});

$j(document).on('click', '.members-area .section.discussions .question-view .watch-thread-button', function () {
    var $button = $j(this);
    var watched = parseInt($button.attr('data-watching'));
    var id = $button.data('id');
    if (watched) {
        $j.post('/members-area/questions/api/unwatch/' + id, {}, function (response) {
            if (response.code == 200) {
                $button.attr('data-watching', 0);
            }
        });
    } else {
        $j.post('/members-area/questions/api/watch/' + id, {}, function (response) {
            if (response.code == 200) {
                $button.attr('data-watching', 1);
            }
        });
    }
});

$j(document).on('click', '.members-area .section.discussions .question-view .reply-wrapper .emoji', function () {
    $j('.reply-wrapper textarea').val($j('.reply-wrapper textarea').val() + $j(this).data('emoji'));
});

$j(document).on('click', '.members-area .section.discussions .question-view .body-edit-wrapper .emoji', function () {

    var $editedPost = $j(this).closest('.body-edit-wrapper').find('textarea');
    $editedPost.val($editedPost.val() + $j(this).data('emoji'));
});

$j(document).on('click', '.members-area .section.discussions .question-view .upvote-button', function () {

    if (inProgress) return false;
    inProgress = true;

    var thisTransfer = $j(this);

    var votableId = $j(thisTransfer).data('votable-id');
    var removingVote = $j(thisTransfer).hasClass('upvoted');
    var oldScore = $j(thisTransfer).prev('.score').data('score');

    inProgress = true;

    var jqxhr = $j.post('/voting/answer/' + votableId, function (response) {

        inProgress = false;
        if (response.code == 200) {

            if (removingVote) {

                $j(thisTransfer).removeClass('upvoted');
                if (oldScore == 1) {
                    $j(thisTransfer).prev('.score').data('score', 0).html('0').removeClass('visible');
                } else {
                    var newScore = oldScore - 1;
                    $j(thisTransfer).prev('.score').data('score', newScore).html('+' + newScore);
                }

            } else {

                $j(thisTransfer).addClass('upvoted');
                var newScore = oldScore + 1;
                $j(thisTransfer).prev('.score').data('score', newScore).html('+' + newScore).addClass('visible');

            }

        } else {
            alert(response.message);
        }

    })
        .fail(function () {
            inProgress = false;
            alert('Could not connect to server. Please try again later.');
        })

});

$j(document).on('click', '.members-area .section.discussions .question-view .quote-button', function () {

    var id = $j(this).data('quote-id');

    $j.get('/members-area/questions/api/answer-body/' + id + '/quote', function (response) {

        if (response.code == 200) {
            var quote = response.body;
            var author = response.author;

            $j('.reply-wrapper .answer').html('[quote=' + author + ']' + quote + '[/quote]' + "\n");

            $j('html,body').animate({scrollTop: 500}, 500);
            $j('.reply-wrapper').show(300);
            $j('.reply-wrapper .answer').focus();
            $j('.reply-wrapper #quotedID').val(id);
        } else {
            alert(response.message);
        }
    });
});

$j(document).on('click', '.members-area .section.discussions .question-view .edit-answer-button', function () {
    var $button = $j(this);
    var $container = $button.closest('.answer-item');
    var $textarea = $container.find('textarea');

    var id = $container.data('id');
    $button.html('<span class="fa fa-spinner fa-spin"></span>');

    $j.get('/members-area/questions/api/answer-body/' + id + '/raw', function (response) {

        $button.html('<span class="fa fa-edit"></span>');

        if (response.code == 200) {

            $container.addClass('edit-mode');
            $textarea.html(response.body);

        } else {
            alert(response.message);
        }
    });
});

$j(document).on('click', '.members-area .section.discussions .question-view .cancel-button', function () {
    $j(this).closest('.answer-item').removeClass('edit-mode');
});

$j(document).on('click', '.members-area .section.discussions .question-view .save-button', function () {
    var $button = $j(this);
    var $container = $button.closest('.answer-item');
    var $textarea = $container.find('textarea');
    var id = $container.data('id');
    $button.html('Wait...').prop('disabled', true);
    $j.post('/members-area/questions/api/answer-body/' + id, {body: $textarea.val()}, function (response) {

        $button.html('Save').prop('disabled', false);

        if (response.code == 200) {

            $container.find('.answer .answer-content').html(response.body);
            $container.removeClass('edit-mode');

        } else {
            alert(response.message);
        }

    });
});

$j(document).on('click', '.members-area .section.discussions .question-new .check-all', function (e) {

    e.preventDefault();
    $j('.type-selection input').prop('checked', 'checked');

});

$j(document).on('submit', '.members-area .section.discussions .question-view #answer-form', function (e) {

    if (inProgress) return false;

    if ($j('.answer').val() == '') {
        $j('.answer').addClass('invalid');
        e.preventDefault();
        return false;
    }

    inProgress = true;

    $j('.answer').removeClass('invalid');
    $j('#publish-answer').removeClass('btn-action').addClass('btn-default').html('<span>Please wait...</span>');

});

$j(document).on('click', '.members-area .section.discussions .question-new .question-publish', function (e) {

    e.preventDefault();
    if (inProgress) return false;

    var validationFailed = false;
    if ($j('.category').val() == '') {
        $j('.category').addClass('invalid');
        validationFailed = true;
    }
    if ($j('.title').val() == '') {
        $j('.title').addClass('invalid');
        validationFailed = true;
    }
    if ($j('.body').val() == '') {
        $j('.body').addClass('invalid');
        validationFailed = true;
    }

    if (validationFailed) {
        return false;
    }

    inProgress = true;
    $j('.title, .body').removeClass('invalid');
    $j('.question-publish').removeClass('btn-action').addClass('btn-default').html('<span>Please wait...</span>');

    $j('#new-question-form').submit();

});

$j(document).on('click', '.members-area .section.discussions .question-view .question-delete', function () {

    if (!confirm('Are you sure you want to delete your thread? This is irreversible.')) {
        return false;
    } else {
        $j('#delete-form').submit();
    }

});

$j(document).on('click', '.members-area .section.academy .knowledge .articles .filters-show', function (e) {

    e.preventDefault();
    $j('.article-filters').slideToggle(300);
    if ($j('.filters-show span:nth-of-type(2)').hasClass('fa-caret-down')) {
        $j('.filters-show span:nth-of-type(2)').removeClass('fa-caret-down').addClass('fa-caret-up');
    } else {
        $j('.filters-show span:nth-of-type(2)').removeClass('fa-caret-up').addClass('fa-caret-down');
    }

});

$j(document).on('change', '.members-area .section.academy .knowledge .articles .type-list', function () {

    var category = $j(this).val();
    if (category == '') return false;

    $j(this).prop('disabled', true);

    var dataString = 'category=' + category;
    window.location.href = '/members-area/academy/knowledge/articles/?' + dataString;

});

$j(document).on('click', '.members-area .section.academy .knowledge .articles .search-button-term', function () {

    var searchTerm = $j('.search-term').val();
    if (searchTerm == '') return false;

    $j('.search-button-term').switchClass('btn-action-2', 'btn-default').html('<span class="fa fa-spinner fa-spin"></span>');
    var dataString = 'term=' + searchTerm;
    window.location.href = '/members-area/academy/knowledge/articles/?' + dataString;

});

// Messages

$j(document).on('click', '.section.messages .conversation', function () {

    if (inProgress) return false;

    var conversationID = $j(this).data('id');
    var conversationKey = $j(this).data('key');
    var partner = $j(this).find('.author-name').html();
    var parameters = 'conversation=' + conversationID;
    inProgress = true;

    var jqxhr = $j.get('/users/messages/fetch', parameters, function (data) {

        if (data.code == 200) {

            $j('#conversationDialog .messages').html('');
            var ownModifier = '';
            var messageInfo = '';

            $j.each(data.messages, function (index, item) {

                if (item.ownMessage) {
                    ownModifier = ' own';
                } else {
                    ownModifier = '';
                }

                messageInfo = '<div class="item row' + ownModifier + '"><div class="message-wrapper"><div class="body">' + item.body + '</div>';

                if (data.otherProfile['available'] && !item.ownMessage) {
                    messageInfo += '<div class="author-info"><a href="/profiles/' + data.otherProfile['link'] + '">' + item.author + '</a>, ' + item.date + '</div></div></div>';
                } else {
                    messageInfo += '<div class="author-info">' + item.author + ', ' + item.date + '</div></div></div>';
                }

                $j('#conversationDialog .messages').prepend(messageInfo);

            });

            if (data.moreThan10) {
                $j('.section.messages #conversationDialog .load-more').show();
            } else {
                $j('.section.messages #conversationDialog .load-more').hide();
            }

            window.pusher = new Pusher('c884ed537c3c56d04692', {
                encrypted: true
            });

            window.pusher.connection.bind('connected', function() {
                $j('#conversationDialog .connection-status').switchClass('disconnected', 'connected', 0).html('<span class="fa fa-circle"></span> Connected');
            });

            var channel = window.pusher.subscribe(conversationKey);
            channel.bind('newMessage', function(data) {
                addNewMessage(data);
            });

            $j('#conversationDialog .conversation-partner').html(partner);

            $j('#conversationDialog').data('conversation', conversationID);
            $j('#conversationDialog').data('conversationKey', conversationKey);

            $j('#conversationDialog .response .message').val('').removeClass('invalid');
            $j('#conversationDialog .message-alert').hide();
            $j('.section.messages #conversationDialog .load-more').data('offset', 10);
            $j('#conversationDialog').modal('show');

            inProgress = false;

        } else {

            alert(data.message);
            inProgress = false;

        }

    })
        .fail(function () {

            inProgress = false;
            alert('Could not connect to server. Please try again later.');

        })

});

function addNewMessage(data) {

    if (data.authorKey != $j('#conversationDialog').data('userkey')) {

        var messageInfo = '<div class="item row"><div class="message-wrapper"><div class="body">' + data.message + '</div><div class="author-info">' + data.author + ', just now</div></div></div>';
        $j.post('/users/messages/mark-conversation-read', 'id=' + $j('#conversationDialog').data('conversation'));

        $j('#conversationDialog .messages').append(messageInfo);
        $j('#conversationDialog .message-list').animate({
                scrollTop: $j('#conversationDialog .message-list')[0].scrollHeight
            },
            1000,
            'easeOutQuint'
        );

    }



}

$j('.section.messages #conversationDialog').on('shown.bs.modal', function () {

    $j('#conversationDialog .message-list').animate({
            scrollTop: $j('#conversationDialog .message-list')[0].scrollHeight
        },
        1000,
        'easeOutQuint'
    );
    $j('#conversationDialog .response .message').focus();

})

$j('.section.messages #conversationDialog').on('hide.bs.modal', function () {

    var conversationKey = $j('#conversationDialog').data('conversationKey');
    window.pusher.unsubscribe(conversationKey);

})

$j(document).on('click', '.section.messages #conversationDialog .load-more', function () {

    if (inProgress) return false;

    var conversationID = $j('#conversationDialog').data('conversation');
    var offset = $j('.section.messages #conversationDialog .load-more').data('offset');
    var parameters = 'conversation=' + conversationID + '&offset=' + offset;
    inProgress = true;

    var jqxhr = $j.get('/users/messages/fetch', parameters, function (data) {

        if (data.code == 200) {

            var ownModifier = '';
            var messageInfo = '';

            if (data.messages.length == 0) {

                $j('.section.messages #conversationDialog .load-more').hide();

            } else {

                $j.each(data.messages, function (index, item) {

                    if (item.ownMessage) {
                        ownModifier = ' own';
                    } else {
                        ownModifier = '';
                    }

                    messageInfo = '<div class="item row' + ownModifier + '"><div class="message-wrapper"><div class="body">' + item.body + '</div>';

                    if (data.profileAvailable && !item.ownMessage) {
                        messageInfo += '<div class="author-info"><a href="/profiles/' + data.profileLink + '">' + item.author + '</a>, ' + item.date + '</div></div></div>';
                    } else {
                        messageInfo += '<div class="author-info">' + item.author + ', ' + item.date + '</div></div></div>';
                    }

                    $j('#conversationDialog .messages').prepend(messageInfo);

                });

            }

            if (data.messages.length < 10) {
                $j('.section.messages #conversationDialog .load-more').hide();
            }

            $j('.section.messages #conversationDialog .load-more').data('offset', offset + 10)

            inProgress = false;

        } else {

            alert(data.message);
            inProgress = false;

        }

    })
        .fail(function () {

            inProgress = false;
            alert('Could not connect to server. Please try again later.');

        })

});

$j(document).on('click', '.section.messages #conversationDialog .action-send', function () {

    if (inProgress) return false;

    var message = $j('.section.messages #conversationDialog .response .message').val();
    $j('#conversationDialog .message-alert').hide();

    if (message == '') {
        $j('.section.messages #conversationDialog .response .message').addClass('invalid');
        return false;
    } else {
        $j('.section.messages #conversationDialog .response .message').removeClass('invalid');
    }

    var conversationID = $j('#conversationDialog').data('conversation');

    var parameters = '_token=' + $j('#_token').val() + '&conversation=' + conversationID + '&message=' + encodeURIComponent(message);
    inProgress = true;
    $j('.section.messages #conversationDialog .action-send').removeClass('btn-action-2').addClass('btn-default').html('<span>Sending...</span>');

    var jqxhr = $j.post('/users/messages/new-conv', parameters, function (data) {

        inProgress = false;

        if (data.code == 200) {

            $j('.conversation[data-id="' + conversationID + '"] .excerpt .body').removeClass('unread').html(data.excerpt);
            $j('.conversation[data-id="' + conversationID + '"] .excerpt .time').html('Last activity: just now');
            $j('#conversationDialog .action-send').removeClass('btn-default').addClass('btn-action-2').html('<span>Send</span>');
            $j('#conversationDialog .response .message').val('').focus();

            var messageInfo = '<div class="item row own"><div class="message-wrapper"><div class="body">' + data.message + '</div><div class="author-info">You, just now</div></div></div>';
            $j('#conversationDialog .messages').append(messageInfo);
            $j('#conversationDialog .message-list').animate({
                    scrollTop: $j('#conversationDialog .message-list')[0].scrollHeight
                },
                1000,
                'easeOutQuint'
            );

        } else {

            $j('#conversationDialog .message-alert').removeClass('alert-success').addClass('alert-danger').html(data.message).css('display', 'inline-block');
            $j('.section.messages #conversationDialog .action-send').removeClass('btn-default').addClass('btn-action-2').html('<span>Send</span>');

        }

    })
    .fail(function () {

        $j('#conversationDialog .message-alert').removeClass('alert-success').addClass('alert-danger').html('Could not connect to server. Please try again later.').css('display', 'inline-block');
        $j('.section.messages #conversationDialog .action-send').removeClass('btn-default').addClass('btn-action-2').html('<span>Send</span>');
        inProgress = false;

    })

});

function count($this) {
    var current = parseInt($this.html(), 10);
    if (current < $this.data('count')) {
        $this.html(++current + '%');
        setTimeout(function () {
            count($this)
        }, 35);
    }
}

$j('span.score-percentage').each(function () {
    $j(this).data('count', parseInt($j(this).data('count'), 10));
    $j(this).html('0%');
    count($j(this));
});