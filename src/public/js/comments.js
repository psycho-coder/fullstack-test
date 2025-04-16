$(function () {
    $('[data-action="send-comment"]').on('click', function(e) {
        e.preventDefault();

        let form = $('[data-form="comment_form"]');
        $('[data-alert]')
            .hide()
            .removeClass('alert-danger')
            .removeClass('alert-success')
            .html('');

        if ($('#email-form', $(form))[0].value.length === 0) {
            alertStyled('Email is empty', 'danger');
            return;
        }

        if ($('#text-form', $(form))[0].value.length === 0) {
            alertStyled('Text is empty', 'danger');
            return;
        }

        if (!/.+?@.+\..+/.test($('#email-form', $(form))[0].value)) {
            alertStyled('Email is incorrect', 'danger');
            return;
        }

        $.ajax({
            url: form.prop('action'),
            dataType: 'JSON',
            method: 'POST',
            data: form.serialize()
        })
        .done(function (response) {
            if (response.success === false) {
                alertStyled(response.message, 'danger');
            } else {
                alertStyled(response.message, 'success');

                let form = $('[data-template="comment"]').clone();
                form.removeAttr('data-template');
                form.find('.card-title').html(response.comment.name);
                form.find('.card-subtitle').html(response.comment.date);
                form.find('.card-text').html(response.comment.text);
                form.find('form').prop('action', response.url_to_remove);
                form.find('form, input[type="hidden"]').prop('value', response.hash)
                $('.cards').prepend(form);
                form.show();

                $('#email-form').val(null);
                $('#date-form').val(null);
                $('#text-form').val(null);
            }
        })
        .fail(function () {
            alertStyled('Internal error', 'danger');
        });
    });

    $('html,body').on('click', '[data-action="remove-comment"]', function (e) {
        e.preventDefault();
        let form = $(this).parent();

        $.ajax({
            url: form.prop('action'),
            dataType: 'JSON',
            method: 'POST',
            data: form.serialize()
        })
            .done(function (response) {
                if (!response.success) {
                    alertStyled('Error. Comment has no removed', 'danger');
                } else {
                    alertStyled('Comment has been removed', 'success');
                    $('[data-comment-id="' + response.id + '"]').hide('fast').remove();
                }
            })
            .fail(function () {
                alertStyled('Internal error', 'danger');
            });

        e.stopPropagation();
    });

    $('[data-action="order"]').on('click', function(e) {
        e.preventDefault();
        ordering.order = buttonSortToggle($(this).data('order'));
        $(this).data('order', ordering.order)
        sort(ordering);
    });

    $('[data-action="field"]').on('click', function (e) {
        e.preventDefault();
        $('[data-toggle="dropdown"]').html($(this).data('order'));
        ordering.sort = $(this).data('order');
        sort(ordering);
    });
})

function sort(fields) {
    let search = window.location.search.split('?');

    if (search.length > 1) {
        let url = search[1].split('&').map(function (value) {
            return value.split('=');
        });

        if (url.length === 1) {
            url.push(['sort', fields.sort]);
            url.push(['order', fields.order]);
        }

        url.forEach(function (value, index, array) {
            if ('page' !== value[0]) {
                switch (value[0]) {
                    case 'sort':
                        value[1] = fields.sort;
                        break;
                    case 'order':
                        value[1] = fields.order;
                        break;
                }
            }
        });

        window.location = window.location.pathname + '?' + url.map(function (value) {return value.join('=')}).join('&');
    } else {
        let url = [];
        url.push(['sort', fields.sort]);
        url.push(['order', fields.order]);
        window.location = window.location.pathname + '?' + url.map(function (value) {return value.join('=')}).join('&');
    }
}

function buttonSortToggle(order) {
    let button = $('span.oi');
    switch (order) {
        case 'asc':
            button.removeClass('oi-arrow-bottom').addClass('oi-arrow-top');
            return 'desc';
        case 'desc':
            button.removeClass('oi-arrow-top').addClass('oi-arrow-bottom');
            return 'asc';
    }
}

function alertStyled(text, status) {
    $('[data-alert]').addClass('alert-' + status).html(text).show('fast');
    setTimeout(function () {
        $('[data-alert]')
            .hide('fast')
            .removeClass('alert-danger')
            .removeClass('alert-success')
            .html('');
    }, 2000);
}