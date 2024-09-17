<template>
    <div class="bg-gray-100">
        <div class="p-6 w-3/5 bg-white shadow-md rounded-md mx-auto mt-12">
            <div class="flex justify-center items-center">
                <h1 class="text-gray-700 font-bold text-2xl">
                    <div v-if="update">
                        Editar cliente
                    </div>
                    <div v-else>
                        Nuevo cliente
                    </div>
                </h1>
            </div>
            <form @submit.prevent="registerItem" class="mt-4">
                <div class="mb-4">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                        Nombre
                    </label>
                    <input v-model="name" type="text" class="appearance-none block w-full bg-white-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" required />
                </div>

                <div class="mb-4">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                        Apellidos
                    </label>
                    <input v-model="last_name" type="text" class="appearance-none block w-full bg-white-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" required />
                </div>

                <div class="mt-4 mb-4">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                        Correo
                    </label>
                    <input v-model="email" type="email" class="appearance-none block w-full bg-white-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" required />
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
                name      : '',
                last_name : '',
                email     : '',
                update    : false,
            }
        },
        mounted() {
            if (this.id) {
                this.update = true;
                this.loadItem();
            }
        },
        methods: {
            registerItem() {

                if (this.update) {

                    this.updateItem();

                } else {

                    this.createItem();

                }

            },
            createItem() {

                const url = '/api/client/create';

                axios.post(url, {
                    name      : this.name,
                    last_name : this.last_name,
                    email     : this.email,
                }).then(response => {

                    if (response.data.service) {
                        alert(response.data.message);
                    } else {
                        alert(response.data.message);
                    }

                    this.$router.push('/clients');

                }).catch(error => {

                    console.log(error);

                });

            },
            async loadItem() {

                const url      = '/api/client/get-item';
                const params   = { id: this.id };
                const response = await axios.get(url, { params });

                if (response.data.service) {

                    this.name      = response.data.data.name;
                    this.last_name = response.data.data.last_name;
                    this.email     = response.data.data.email;

                }

            },
            updateItem() {

                const url = '/api/client/update';

                axios.post(url, {
                    id        : this.id,
                    name      : this.name,
                    last_name : this.last_name,
                    email     : this.email,
                }).then(response => {

                    if (response.data.service) {
                        alert(response.data.message);
                    } else {
                        alert(response.data.message);
                    }

                    this.$router.push('/clients');

                }).catch(error => {

                    console.log(error);

                });

            },
            cancel() {
                this.$router.push('/clients');
            },
        }
    }

</script>
