window.addEventListener('show-form', event => {
    $('#addForm').modal('show');
});

window.addEventListener('show-suspendModal', event => {
    $('#suspendModal').modal('show');
});

window.addEventListener('show-deleteModal', event => {
    $('#deleteModal').modal('show');
});

window.addEventListener('show-profileModal', event => {
    $('#profileModal').modal('show');
});

window.addEventListener('show-deposit-modal', event => {
    $('#popalert').modal('show');
});


window.addEventListener('load', function() {
    document.getElementById('pre-loader').style.display = 'none';
});

window.addEventListener('close-modal', event => {
    $('#' + event.detail.modalid).modal('hide');
});


window.addEventListener('open-modal', event => {
    $('#' + event.detail.modalid).modal('show');
});


window.addEventListener('show-change-photo-form', event => {
    $('#uploadtab').css('display', 'block');
});

window.addEventListener('toggleclass', event => {
    const cardfront = document.getElementById('cardfront');
    cardfront.classList.add('fadeOut');
    const cardback = document.getElementById('cardback');
    cardback.classList.remove('d-none');
});


/*window.livewire.on('toggleclass', () => {
    const cardfront = document.getElementById('cardfront');
    cardfront.classList.add('fadeOut');
    console.log(cardfront);
    const cardback = document.getElementById('cardback');
    cardback.classList.remove('d-none');
}); */


function copy(selector) {
    TopScroll = window.pageYOffset || document.documentElement.scrollTop;
    LeftScroll = window.pageXOffset || document.documentElement.scrollLeft;

    var $temp = $("<div>");
    $("body").append($temp);
    $temp.attr("contenteditable", true)
        .html($(selector).html()).select()
        .on("focus", function() { document.execCommand('selectAll', false, null); })
        .focus();
    document.execCommand("copy");
    $temp.remove();
    toastr.success('Copied', 'Success!');
    window.scrollTo(LeftScroll, TopScroll);
}




$(function() {
    toastr.options = { "progressBar": true, "timeOut": "4000", }

    window.addEventListener('hide-form', event => {
        $('#addForm').modal('hide');
        toastr.success(event.detail.message, 'Success!');
    });

    window.addEventListener('notify-modal', event => {
        toastr.success(event.detail.message, 'Success!');
    });

    window.addEventListener('hide-suspendModal', event => {
        $('#suspendModal').modal('hide');
        toastr.success(event.detail.message, 'Success!');

    });
    window.addEventListener('modal-hide', event => {
        if (event.detail.status == true) {
            toastr.success(event.detail.message, 'Success!');
            $('#' + event.detail.modalid).modal('hide');
        } else {
            toastr.warning(event.detail.message, 'Failed!');
        }
    });


    if ($('.prevent-default').length) {
        $('.prevent-default').click(function(event) {
            event.stopPropagation();
        });
    }

    window.livewire.on('goBack', () => {
        window.history.back();
    });


    if ($('.goback').length) {
        document.querySelector(".goback").addEventListener("click", () => { window.history.back(); });
    }

    window.addEventListener('form-response-profile-update', event => {
        toastr.success(event.detail.message, 'Success!');
        document.querySelector('.profile-name').innerHTML = event.detail.profile_name;
        document.querySelector('.profile-name-sidebar').innerHTML = event.detail.profile_name;
    });

    window.addEventListener('form-response-photo-update', event => {
        toastr.success(event.detail.message, 'Success!');
        $('#uploadtab').css('display', 'none');
        document.querySelector('.profile-photo').src = event.detail.photo_url;
        document.querySelector('.profile-photo-sidebar').src = event.detail.photo_url;
    });

    window.addEventListener('form-response-password', event => {
        if (event.detail.status == true) {
            toastr.success(event.detail.message, 'Success!');
        } else {
            toastr.warning(event.detail.message, 'Failed!');
        }
    });

    $('#showpassword').click(function() {
        var passwordInput = $('#pw');
        var confirmPasswordInput = $('#psw');

        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            confirmPasswordInput.attr('type', 'text');
        } else {
            passwordInput.attr('type', 'password');
            confirmPasswordInput.attr('type', 'password');
        }
    });

});



$(document).ready(function() {
    const modeCheckbox = $('#mode');
    const currentModeSpan = $('#current-mode');

    const isDarkMode = localStorage.getItem('isDarkMode') === 'true';
    if (isDarkMode) {
        $('body').toggleClass('dark-mode');
        $('nav').toggleClass('navbar-dark navbar-light');
        $('aside').toggleClass('sidebar-light-primary sidebar-dark-primary');
        $('aside nav').toggleClass('navbar-dark navbar-light');
        modeCheckbox.prop('checked', true);
        currentModeSpan.text('Night');
    } else {
        currentModeSpan.text('Day');
    }
    modeCheckbox.on('change', function() {
        $('body').toggleClass('dark-mode');
        $('nav').toggleClass('navbar-dark navbar-light');
        $('aside').toggleClass('sidebar-light-primary sidebar-dark-primary');
        $('aside nav').toggleClass('navbar-dark navbar-light');

        localStorage.setItem('isDarkMode', $(this).is(':checked'));
        currentModeSpan.text($(this).is(':checked') ? 'Night' : 'Day');
    });

});


function time_remain(dbDatetime, d = 'default') {

    let milliseconds;
    if (typeof dbDatetime === 'string') {

        milliseconds = new Date(dbDatetime).getTime();
    } else {

        milliseconds = dbDatetime;
    }

    const countDownTimer = milliseconds;
    let interval;

    return {
        countDown: milliseconds - Date.now(),
        countDownTimer,
        intervalID: null,
        init() {
            if (!this.intervalID) {
                this.intervalID = setInterval(() => {
                    this.countDown = this.countDownTimer - new Date().getTime();
                }, 1000);
            }
        },
        getTime() {
            if (this.countDown < 0) {
                this.clearTimer();
            }
            return this.countDown;
        },
        formatTime(num) {
            const seconds = Math.floor(num / 1000) % 60;
            const minutes = Math.floor(num / (1000 * 60)) % 60;
            const hours = Math.floor(num / (1000 * 60 * 60)) % 24;
            const days = Math.floor(num / (1000 * 60 * 60 * 24));

            if (d === 'minutes') {

                return `${minutes}m ${seconds}s`;
            } else {

                return `${days}d ${hours}h ${minutes}m ${seconds}s`;
            }
        },
        clearTimer() {
            clearInterval(this.intervalID);
        }
    };
}