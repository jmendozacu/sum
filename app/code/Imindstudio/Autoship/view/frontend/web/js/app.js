require(['jquery'], function($) {
    $(function() {
        var ui = {
                name: '[name="customer-name"]',
                token: '[name="form_key"]',
                action: '[data-action]',
                detail: '[data-detail]',
                submit: '[data-submit]',
                rating: '[data-rating]:checked',
                reviewId: '[data-review-id]',
                messageText: '[data-message-content] div',
                errorMessages: '.mage-error',
                messageContent: '[data-message-content]',
                reviewContainer: '[data-review-container]',
                messageContainer: '.page .messages',
                detailErrorMessage: '#review-detail-field-error',
                ratingErrorMessage: '#review-rating-field-error'
            },
            init = function() {
                $(ui.errorMessages).hide();
                $(ui.messageContainer).hide();
            },
            showMessage = function(container, cssClass, message) {
                container.find(ui.messageText).text(message);
                container.find(ui.messageContent).addClass(cssClass);
                container.show();
            },
            showErrorMessage = function(container, message) {
                showMessage(container, 'message-error error', message);
            },
            showSuccessMessage = function(container, message) {
                showMessage(container, 'message-success success', message);
            };

        init();
        $(ui.submit).click(function() {
            var error = false,
                token = $(ui.token).val(),
                name = $(ui.name).val().split(' ')[0],
                reviewContainer = $(this).closest(ui.reviewContainer),
                messageContainer = reviewContainer.find(ui.messageContainer),
                button = reviewContainer.find(ui.submit),
                rating = reviewContainer.find(ui.rating).val(),
                detail = reviewContainer.find(ui.detail).val(),
                action = reviewContainer.find(ui.action).val(),
                reviewId = reviewContainer.find(ui.reviewId).val();

            if(!token && !name && !action) {
                error = true;
            }
            if(!rating) {
                error = true;
                reviewContainer.find(ui.ratingErrorMessage).show();
            }
            if(!detail) {
                error = true;
                reviewContainer.find(ui.detailErrorMessage).show();
                reviewContainer.find(ui.detail).addClass('mage-error');
            }
            if(!error) {
                button.text('Processing...');
                $.post(action, {
                    'title': ' ',/* non-breaking space: alt + 0160 */
                    'detail': detail,
                    'nickname': name,
                    'form_key': token,
                    'ratings[4]': rating,
                    'review_id': reviewId,
                    'validate_rating': ''
                }).done(function(data) {
                    if(data.indexOf('You submitted your review for moderation.') >= 0) {
                        showSuccessMessage(messageContainer, 'You submitted your review for moderation.');
                        button.text('Submitted');
                        button.prop('disabled', true);
                        reviewContainer.find(ui.detail).replaceWith('<p>' + detail + '</p>');
                    } else {
                        showErrorMessage(messageContainer, 'Something went wrong.');
                    }
                }).fail(function() {
                    showErrorMessage(messageContainer, 'Something went wrong.');
                });
            } else {
                showErrorMessage(messageContainer, 'Something went wrong.');
            }
        });
    });
});