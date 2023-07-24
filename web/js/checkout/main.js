const app = new Vue({
    el: '.checkout-index',
    data: {
        items: [],
        totalPaid: 0,
        saleId: '',
        products: [],
        totalOrder: 0
    },
    mounted() {
        this.saleId = document.querySelector('#pay-sale_id').value;
        this.load();
    },
    methods: {
        updateSale() {
            $('form#w2').yiiActiveForm('validate', true);

            const form = document.querySelector('form#w2');
            const formData = new FormData(form);

            axios.post('/api/sale/update', formData)
                .then(({ data }) => {
                    if (data) {
                        const { title, message, status } = data;

                        if (title && message) {
                            const cls = status === 200 ? 'success' : 'warning';

                            $(document).Toasts('create', {
                                title: `${title}!`,
                                body: message,
                                autohide: true,
                                delay: 5000,
                                class: [`bg-${cls}`, 'fix-toast']
                            });
                        }
                    }
                })
                .catch(({ response }) => {
                    const { name, message } = response.data;
                    showToast(name, message);
                });
        },
        pushPay() {
            $('form#w1').yiiActiveForm('validate', true);

            const form = document.querySelector('form#w1');
            const formData = new FormData(form);

            axios.post('/api/pay/create', formData)
                .then(({ data }) => {
                    this.items.push(data.pay);
                    this.totalPaid = data.total;
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
            axios.delete('/api/pay/delete', { params: { id } })
                .then(({ data }) => {
                    this.totalPaid = data.total;
                    this.items.splice(index, 1);
                })
                .catch(({ response }) => {
                    const { name, message } = response.data;
                    showToast(name, message);
                });
        },
        load() {
            axios.get('/api/sale/', { params: { id: this.saleId } })
                .then(({ data }) => {
                    this.items = data.pays;
                    this.totalPaid = data.total;
                    this.products = data.order.orderItems;
                    this.totalOrder = data.order.total_value;
                })
                .catch(({ response }) => {
                    const { name, message } = response.data;
                    showToast(name, message);
                });
        },
    }
});

Vue.component('payment_items', {
    props: ['id', 'index', 'name', 'installments', 'value'],
    template: '\
    <tr>\
        <td>{{ index+1 }}</td>\
        <td>{{ name }}</td>\
        <td>{{ installments }}</td>\
        <td>{{ value }}</td>\
        <td>\
            <a href="#" class="text-muted" v-on:click="app.popItem(index)">\
                <i class="fas fa-trash"></i>\
            </a>\
        </td>\
    </tr>\
    ',
})

function showToast(title, message = '') {
    $(document).Toasts('create', {
        title: title,
        body: message,
        autohide: true,
        delay: 5000,
        class: ['bg-warning', 'fix-toast']
    });
}

$('form').on('submit', e => false);