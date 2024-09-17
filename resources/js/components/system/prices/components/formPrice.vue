<template>
    <div class="bg-gray-100">
        <div class="p-6 w-3/5 bg-white shadow-md rounded-md mx-auto mt-12">
            <div class="flex justify-center items-center">
                <h1 class="text-gray-700 font-bold text-2xl">
                    <div v-if="update">
                        Editar precio
                    </div>
                    <div v-else>
                        Nuevo precio
                    </div>
                </h1>
            </div>
            <form @submit.prevent="registerItem" class="mt-4">
                <div class="mb-4">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                        Producto
                    </label>
                    <select
                        :disabled="update"
                        v-model="product_id"
                        class="appearance-none block w-full bg-white-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white"
                        required
                    >
                        <option value="" disabled selected>Selecciona una opción</option>
                        <option v-for="product in products" :key="product.id" :value="product.id">
                            {{ product.description }}
                        </option>
                    </select>
                </div>

                <div class="mt-4 mb-4">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                        Precio
                    </label>
                    <input v-model="price" type="text" @input="onlyNumbers" class="appearance-none block w-full bg-white-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" required />
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
                products   : [],
                product_id : '',
                price      : '',
                update     : false,
            }
        },
        mounted() {
            this.loadProducts();

            if (this.id) {
                this.update = true;
                this.loadItem();
            }
        },
        methods: {
            async loadProducts() {

                const url      = '/api/product/get-items';
                const response = await axios.get(url);

                if (response.data.service) {
                    this.products  = response.data.data;
                }

            },
            onlyNumbers() {
                let regulatedInput = this.price.replace(/[^0-9]/g, '');
                this.price         = regulatedInput.slice(0, 8);
            },
            registerItem() {

                if (this.update) {

                    this.updateItem();

                } else {

                    this.createItem();

                }

            },
            createItem() {

                const url = '/api/price/create';

                axios.post(url, {
                    product_id : this.product_id,
                    price      : this.price,
                }).then(response => {

                    if (response.data.service) {
                        alert(response.data.message);
                    } else {
                        alert(response.data.message);
                    }

                    this.$router.push('/prices');

                }).catch(error => {

                    console.log(error);

                });

            },
            async loadItem() {

                const url      = '/api/price/get-item';
                const params   = { id: this.id };
                const response = await axios.get(url, { params });

                if (response.data.service) {

                    this.product_id = response.data.data.product_id;
                    this.price      = response.data.data.price;

                }

            },
            updateItem() {

                const url = '/api/price/update';

                axios.post(url, {
                    id         : this.id,
                    product_id : this.product_id,
                    price      : this.price,
                }).then(response => {

                    if (response.data.service) {
                        alert(response.data.message);
                    } else {
                        alert(response.data.message);
                    }

                    this.$router.push('/prices');

                }).catch(error => {

                    console.log(error);

                });

            },
            cancel() {
                this.$router.push('/prices');
            },
        }
    }

</script>
