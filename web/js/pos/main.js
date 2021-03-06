const app = new Vue({
    el: '.pos-index',
    data: {
        items: [],
        total: 0,
        orderId: '',
    },
    mounted() {
        this.orderId = document.querySelector('#orderitem-order_id').value;
        this.load();
    },
    methods: {
        pushItem() {
            $('form').yiiActiveForm('validate', true);

            const form = document.querySelector('form');
            const formData = new FormData(form);
            
            axios.post('/api/order-item/create', formData)
                .then(({ data }) => {
                    this.items.push(data.orderItem);
                    this.total = data.total;
                    const $form = $('form');
                    $form.get(0).reset();
                })
                .catch(({ response }) => {
                    const { name, message } = response.data;
                    showToast(name, message);
                });
        },
        popItem(index) {
            const id = this.items[index].id;
            axios.delete('/api/order-item/delete', { params: { id } })
                .then(({ data }) => {
                    this.total = data.total;
                    this.items.splice(index, 1);
                })
                .catch(({ response }) => {
                    const { name, message } = response.data;
                    showToast(name, message);
                });
        },
        load() {
            axios.get('/api/order/index', { params: { id: this.orderId } })
                .then(({ data }) => {
                    this.items = data.orderItems;
                    this.total = data.total_value;
                })
                .catch(({ response }) => {
                    const { name, message } = response.data;
                    showToast(name, message);
                });
        },
    }
});

function showToast(title, message = '') {
    $(document).Toasts('create', {
        title: title,
        body: message,
        autohide: true,
        delay: 5000,
        class: ['bg-warning', 'fix-toast']
    });
}

function setPrice(value) {
    $('#orderitem-default_price-disp').inputmask("setvalue", value);
    $('#orderitem-unit_price-disp').inputmask("setvalue", value);
    $('#orderitem-unit_price-disp').focus();
}

$('form').on('submit', e => false);