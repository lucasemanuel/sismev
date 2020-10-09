Vue.component('order_items', {
    props: ['id', 'index', 'name', 'amount', 'unit_price', 'total'],
    template: '\
    <tr>\
        <td>{{ index+1 }}</td>\
        <td>{{ name }}</td>\
        <td>{{ unit_price }}</td>\
        <td>{{ amount }}</td>\
        <td>{{ total }}</td>\
        <td>\
            <a href="#" class="text-muted" v-on:click="app.popItem(index)">\
                <i class="fas fa-trash"></i>\
            </a>\
        </td>\
    </tr>\
    ',
});