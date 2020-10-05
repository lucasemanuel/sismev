const app = new Vue({
    el: '.pos-index',
    data: {
        listOrderItems: [],
        total: 0,
    },
    methods: {
        pushItem() {
            const form = document.querySelector('form');
            const formData = new FormData(form);
            axios.post('/api/order-item/create', formData)
                .then(({ data }) => {
                    console.log(data);
                })
                .catch(({ response }) => {
                    showToast(response.data.name, response.data.message)
                });
        }
    }
});

function showToast(title, message = '') {
    $(document).Toasts('create', {
        title: title,
        body: message,
        autohide: true,
        delay: 4000,
        class: ['bg-warning', 'fix-toast']
    });
}

function setPrice(value) {
    $('#product-unit_price-disp').inputmask("setvalue", value);
    $('#orderItem-unit_price-disp').inputmask("setvalue", value);
    $('#orderItem-unit_price-disp').focus();
}