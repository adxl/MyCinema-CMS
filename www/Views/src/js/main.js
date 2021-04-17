import "/Views/node_modules/jquery/dist/jquery.min.js"

$(function () {
    $("#user-profile-button").on('click', function () {
        $("#user-profile-menu").toggleClass('hidden');
    })
})