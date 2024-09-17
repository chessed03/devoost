<template>
    <div class="bg-gray-100">
        <div class="p-6 w-3/5 bg-white shadow-md rounded-md mx-auto mt-12">
            <div class="flex justify-center items-center">
                <h1 class="text-gray-700 font-bold text-2xl">
                    <div v-if="update">
                        Editar producto
                    </div>
                    <div v-else>
                        Nuevo producto
                    </div>
                </h1>
            </div>
            <form @submit.prevent="registerItem" class="mt-4">
                <div class="mb-4">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                        Código
                    </label>
                    <input
                        :disabled="update"
                        v-model="code"
                        type="text"
                        @input="onlyNumbers"
                        class="appearance-none block w-full bg-white-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white"
                        required
                    />
                    <span class="text-sm font-bold">* Se espera 8 dígitos</span>
                </div>

                <div class="mt-4 mb-4">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                        Descripción
                    </label>
                    <input v-model="description" type="text" class="appearance-none block w-full bg-white-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" required />
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
                code        : '',
                description : '',
                update      : false,
            }
        },
        mounted() {
            if (this.id) {
                this.update = true;
                this.loadItem();
            }
        },
        methods: {
            onlyNumbers() {
                let regulatedInput = this.code.replace(/[^0-9]/g, '');
                this.code          = regulatedInput.slice(0, 8);
            },
            registerItem() {

                let validateCode = this.code.length;

                if (validateCode === 8 ) {

                    if (this.update) {

                        this.updateItem();

                    } else {

                        this.createItem();

                    }

                } else {
                    alert('El código debe ser de 8 digitos.')
                }

            },
            createItem() {

                const url = '/api/product/create';

                axios.post(url, {
                    code        : this.code,
                    description : this.description,
                }).then(response => {

                    if (response.data.service) {
                        alert(response.data.message);
                    } else {
                        alert(response.data.message);
                    }

                    this.$router.push('/products');

                }).catch(error => {

                    console.log(error);

                });

            },
            async loadItem() {

                const url      = '/api/product/get-item';
                const params   = { id: this.id };
                const response = await axios.get(url, { params });

                if (response.data.service) {

                    this.code        = response.data.data.code;
                    this.description = response.data.data.description;

                }

            },
            updateItem() {

                const url = '/api/product/update';

                axios.post(url, {
                    id          : this.id,
                    code        : this.code,
                    description : this.description,
                }).then(response => {

                    if (response.data.service) {
                        alert(response.data.message);
                    } else {
                        alert(response.data.message);
                    }

                    this.$router.push('/products');

                }).catch(error => {

                    console.log(error);

                });

            },
            cancel() {
                this.$router.push('/products');
            },
        }
    }

</script>
