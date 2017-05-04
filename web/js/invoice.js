document.addEventListener("DOMContentLoaded", function (event) {
    const defaultItem = {unit: 'ks', title: '', quantity: 1, pricePerUnitCents: 0};

    Vue.component('invoice-items', {
        props: ['initialItems'],
        template: `<div class="invoice-items-container">
            <div v-for="(item, index) in items" class="invoice-item-row">
                <input :name="'invoice_form[items][' + index + '][quantity]'" v-model="item.quantity" type="number" class="input unit-input" placeholder="Počet">
                <span class="select">
                    <select v-model="item.unit" :name="'invoice_form[items][' + index + '][unit]'">
                        <option value="ks">ks</option>
                        <option value="kg">kg</option>
                    </select>
                </span>
                <input :name="'invoice_form[items][' + index + '][title]'" v-model="item.title" type="text" class="input" placeholder="Název">
                <input :name="'invoice_form[items][' + index + '][pricePerUnitCents]'" v-model="item.pricePerUnitCents" type="text" class="input price-input" placeholder="Cena">
                <a href="" @click.prevent="removeItem(index)" class="button is-small is-danger"><i class="fa fa-trash"></i></a>
            </div>
            <div class="invoice-add-item">
                <a @click.prevent="addItem" href="" class="button is-success is-small">
                    <span class="icon is-small">
                           <i class="fa fa-plus"></i> 
                    </span>
                    <span>Přidat položku</span>
                </a>
            </div>
            <div class="invoice-summary">
                <div class="invoice-total">Celkem <strong>{{ total }} {{ currency }}</strong></div>
            </div>
        </div>`,
        data: function () {
            return {
                items: this.initialItems.length < 1 ? [Object.assign({}, defaultItem)] : this.initialItems,
                currency: '',
            }
        },
        computed: {
            total: function (vm) {
                return vm.items.reduce((acc, item) => acc + item.pricePerUnitCents * item.quantity, 0);
            }
        },
        methods: {
            addItem: function () {
                this.items.push(Object.assign({}, defaultItem));
            },
            removeItem: function (index) {
                this.items.splice(index, 1);
            }
        },
        mounted: function () {
            const $currencyInput = document.querySelector('#invoice_form_currency');
            this.currency = $currencyInput.value;
            $currencyInput.addEventListener('change', (e) => {
                this.currency = e.target.value;
            });
        }
    });

    new Vue({
        el: '.invoice-items',
    });
});