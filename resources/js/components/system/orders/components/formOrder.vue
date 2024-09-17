<template>
    <div class="bg-gray-100">
        <div class="p-6 w-3/5 bg-white shadow-md rounded-md mx-auto mt-12">
            <div class="flex justify-center items-center">
                <h1 class="text-gray-700 font-bold text-2xl">
                    <div v-if="update">
                        Editar orden
                    </div>
                    <div v-else>
                        Nueva orden
                    </div>
                </h1>
            </div>
            <form @submit.prevent="registerItem" class="mt-4">
                <div class="flex mb-4">
                    <div class="w-2/3 pr-2">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                            Cliente
                        </label>
                        <select
                            :disabled="update"
                            v-model="client_id"
                            class="appearance-none block w-full bg-white-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white"
                            required
                        >
                            <option value="" disabled selected>Selecciona una opción</option>
                            <option v-for="client in clients" :key="client.id" :value="client.id">
                                {{ client.name }} {{ client.last_name }}
                            </option>
                        </select>
                    </div>
                    <div class="w-1/3 pl-2">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                            Fecha
                        </label>
                        <input v-model="order_date" type="text" class="appearance-none block w-full bg-white-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" readonly />
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                        Código
                    </label>
                    <input v-model="code" type="text" @input="searchProduct" class="appearance-none block w-full bg-white-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" />
                    <span class="text-sm font-bold">* Se espera 8 dígitos</span>
                </div>
                <div class="mt-4">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Cantidad
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Producto
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Precio
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Total
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="product in Object.values(products)" :key="product.id">
                                <td class="px-6 py-4 whitespace-no-wrap">
                                    {{ product.quantity }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap">
                                    {{ product.description }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-right">
                                    {{ product.price }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-right">
                                    {{ product.total }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                                    <a @click="deleteItem(`${ product.id }`)" href="#" class="text-red-600 hover:text-red-900">
                                        Eliminar
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-right font-bold">
                                <h2 class="text-3xl">Total General:</h2>
                            </td>
                            <td class="px-6 py-4 font-bold text-right">
                                <h2 class="text-3xl">{{ getTotal() }}</h2>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="button" @click="cancel" class="py-2 px-4 text-center bg-red-500 rounded-md text-white hover:bg-red-600">Cancelar</button>
                    <button type="submit" class="py-2 px-4 text-center bg-blue-500 rounded-md text-white hover:bg-blue-600 ml-4">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>


    export default {
        props: ["id"],
        data() {
            return {
                clients    : [],
                client_id  : '',
                order_date : new Date().toISOString().split('T')[0],
                products   : [],
                update     : false,
            }
        },
        mounted() {
            this.loadClients();
            this.loadProducts();
            if (this.id) {
                this.update = true;
                this.loadItem();
            }
        },
        methods: {
            async loadClients() {

                const url      = '/api/client/get-items';
                const response = await axios.get(url);

                if (response.data.service) {
                    this.clients = response.data.data;
                }

            },
            async loadItem() {

                const url      = '/api/order/get-item';
                const params   = {id: this.id};
                const response = await axios.get(url, {params});

                if (response.data.service) {

                    this.client_id  = response.data.data.client_id;
                    let rawDate     = new Date(response.data.data.created_at);
                    this.order_date = rawDate.getFullYear()+'-'+('0' + (rawDate.getMonth()+1)).slice(-2)+'-'+('0' + rawDate.getDate()).slice(-2);

                }

            },
            async loadProducts() {

                const url      = '/api/order-detail/get-order-items';
                const params   = {id: this.id};
                const response = await axios.get(url, {params});

                if (response.data.service) {
                    let items = response.data.data;

                    items.forEach(product => {

                        this.products.push({
                            id          : product.product.code,
                            product_id  : product.product.id,
                            quantity    : product.quantity,
                            description : product.product.description,
                            price       : Number(product.product.product_price.price),
                            total       : Number(product.product.product_price.price * product.quantity).toFixed(2)
                        });

                    });

                }

            },
            async searchProduct() {

                this.onlyNumbers();

                let product_code = this.code;

                if (product_code.length === 8) {

                    const url      = '/api/product/get-item-code';
                    const params   = { product_code: product_code };
                    const response = await axios.get(url, { params });

                    if (response.data.service) {

                        const product      = response.data.data;
                        const productIndex = this.products.findIndex(prod => prod.id === product_code);

                        if (productIndex !== -1) {

                            this.products[productIndex].quantity += 1;
                            this.products[productIndex].total    = (this.products[productIndex].quantity * this.products[productIndex].price).toFixed(2);

                        } else {

                            this.products.push({
                                id          : product_code,
                                product_id  : product.product.id,
                                quantity    : 1,
                                description : product.product.description,
                                price       : Number(product.price),
                                total       : Number(product.price).toFixed(2)
                            });

                        }
                    }

                    this.code = '';
                }

            },
            deleteItem(id) {
                const index = this.products.findIndex(product => product.id === id);
                if (index !== -1) {
                    this.products.splice(index,1);
                }
            },
            getTotal() {
                let total = Object.values(this.products).reduce((total, product) => total + Number(product.total), 0);
                return total.toFixed(2);
            },
            onlyNumbers() {

                let regulatedInput = this.code.replace(/[^0-9]/g, '');
                this.code          = regulatedInput.slice(0, 8);

            },
            registerItem() {

                if (this.update) {

                    this.updateItem();

                } else {

                    this.createItem();

                }

            },
            createItem() {

                let productsSelected = this.products.map(product => {
                    return {
                        product_id : product.product_id,
                        quantity   : product.quantity
                    };
                });

                const url = '/api/order/create';

                axios.post(url, {
                    client_id : this.client_id,
                    products  : productsSelected,
                }).then(response => {

                    if (response.data.service) {
                        alert(response.data.message);
                    } else {
                        alert(response.data.message);
                    }

                    this.$router.push('/orders');

                }).catch(error => {

                    console.log(error);

                });

            },
            updateItem() {

                let productsSelected = this.products.map(product => {
                    return {
                        product_id : product.product_id,
                        quantity   : product.quantity
                    };
                });

                const url = '/api/order/update';

                axios.post(url, {
                    id        : this.id,
                    client_id : this.client_id,
                    products  : productsSelected,
                }).then(response => {

                    if (response.data.service) {
                        alert(response.data.message);
                    } else {
                        alert(response.data.message);
                    }

                    this.$router.push('/orders');

                }).catch(error => {

                    console.log(error);

                });

            },
            cancel() {
                this.$router.push('/orders');
            },
        }
    }

</script>
