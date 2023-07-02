import $ from 'jquery';

$(function() {
    class AddToCartModal {
        constructor() {
            this.closeBtn = $('.js-add-to-cart-modal-close');
        }

        init() {
            this.closeBtn.on('click', function () {
               $('.js-add-to-cart-modal').addClass('hidden');
            });
        }
    }

    const addToCartModal = new AddToCartModal();

    addToCartModal.init();


});
