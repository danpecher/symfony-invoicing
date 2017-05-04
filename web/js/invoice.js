document.addEventListener("DOMContentLoaded", function (event) {
    Vue.component('invoice-items', {
        props: ['initialItems'],
        template: `<div class="invoice-items-container section">
            <div v-for="(item, index) in items" class="columns">
                <select v-model="item.unit" :name="'invoice_form[items][' + index + '][unit]'">
                    <option value="ks">ks</option>
                    <option value="kg">kg</option>
                </select>
                <input :name="'invoice_form[items][' + index + '][quantity]'" v-model="item.quantity" type="text" class="column" placeholder="Počet">
                <input :name="'invoice_form[items][' + index + '][title]'" v-model="item.title" type="text" class="column" placeholder="Název">
                <input :name="'invoice_form[items][' + index + '][pricePerUnitCents]'" v-model="item.pricePerUnitCents" type="text" class="column" placeholder="Cena">
                <a href="" @click.prevent="removeItem(index)"><i class="fa fa-trash"></i></a>
            </div>
            <a @click.prevent="addItem" href="" class="button is-success is-small">Přidat položku</a>
        </div>`,
        data: function () {
            let defaultItem = {unit: 'ks', title: '', quantity: 1, pricePerUnitCents: 0};
            return {
                items: this.initialItems.length < 1 ? [defaultItem] : this.initialItems
            }
        },
        methods: {
            addItem: function () {
                this.items.push({});
            },
            removeItem: function (index) {
                this.items.splice(index, 1);
                this.items = this.items;
            }
        }
    });

    new Vue({
        el: '.invoice-items',
    });
});