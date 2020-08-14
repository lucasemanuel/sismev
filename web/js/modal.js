$('body').on('click', '.btn-modal', function (e) {
    $('#modal').modal('show')
        .find('#content-modal')
        .load($(this).attr('value'));
    }
);