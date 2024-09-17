<template>

    <div class="bg-gray-100">
        <div class="p-6 w-3/5 bg-white shadow-md rounded-md mx-auto mt-12">
            <div class="flex justify-center items-center">
                <h1 class="text-gray-700 font-bold text-2xl">Ordenes</h1>
            </div>

            <div class="flex justify-between mt-4">
                <h2 class="text-lg font-bold text-gray-700">Listado de ordenes</h2>
                <router-link to="/orders/create">
                    <button type="button" class="py-2 px-4 text-center bg-blue-500 rounded-md text-white hover:bg-blue-600">Nueva orden</button>
                </router-link>
            </div>

            <div class="mt-4">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Número
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Cliente
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="item in items" :key="items.id">
                        <td class="px-6 py-4 whitespace-no-wrap">
                            {{ item.id }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap">
                            {{ item.client.name }} {{ item.client.last_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                            <router-link :to="`/orders/update/${ item.id }`" class="text-indigo-600 hover:text-indigo-900">
                                Editar
                            </router-link>
                            &nbsp;&nbsp;
                            <a @click="deleteItem(`${ item.id }`)" href="#" class="text-red-600 hover:text-red-900">
                                Eliminar
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</template>


<script>

export default {
    data() {
        return {
            items: [],
        }
    },
    created() {
        this.getItems();
    },
    methods: {
        async getItems() {

            const url      = '/api/order/get-items';
            const response = await axios.get(url);

            if (response.data.service) {
                this.items  = response.data.data;
            }

        },
        deleteItem(id) {

            const url = '/api/order/disable';

            axios.post(url, {
                id : id,
            }).then(response => {

                if (response.data.service) {
                    alert(response.data.message);
                } else {
                    alert(response.data.message);
                }

                this.items = [];
                this.getItems();

            }).catch(error => {

                console.log(error);

            });

        }
    },
}

</script>
