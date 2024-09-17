<template>

    <div class="bg-gray-100">
        <div class="p-6 w-3/5 bg-white shadow-md rounded-md mx-auto mt-12">
            <div class="flex justify-center items-center">
                <h1 class="text-gray-700 font-bold text-2xl">Vue</h1>
            </div>

            <div class="mt-4">
                <br>
                <hr>
                <br>
                [ INSTRUCCIONES ] <br>
                * Click en obtener el recurso que provee la api.<br>
                * Para borrar el conternido dar click en limpiar.<br>
                * Consumiento un API desde https://github.com/public-apis/public-apis.
                <br>
                <hr>
                <br>
                <div>
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">API:</label>
                    <input type="text" class="appearance-none block w-full bg-white-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" disabled value="https://baconipsum.com/api/?type=all-meat&paras=2&start-with-lorem=1">
                </div>
                <div class="flex mt-6 space-x-4">
                    <button type="button" @click="clearInputs()" class="py-2 px-4 text-center bg-red-500 rounded-md w-full text-white hover:bg-red-600">Limpiar</button>
                    <button type="button" @click="getStartwithLorem()" class="py-2 px-4 text-center bg-blue-500 rounded-md w-full text-white hover:bg-blue-600">Obtener texto Lorem</button>
                </div>
                <br>
                <div v-if="get_start_with_lorem && get_start_with_lorem.length" class="mt-4 p-4 bg-green-100 rounded">
                    <div v-for="(item, index) in get_start_with_lorem" :key="index" class="mt-2">
                        {{ item }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>

export default {
    data() {
        return {
            get_start_with_lorem : [],
        };
    },
    methods: {
        clearInputs() {

            this.get_start_with_lorem = [];

        },
        getStartwithLorem() {

            const url = 'https://baconipsum.com/api/?type=all-meat&paras=2&start-with-lorem=1';

            axios.get(url, {
                headers: {
                    'X-Requested-With': null
                }
            }).then(response => {

                this.get_start_with_lorem = response.data;

            }).catch(error => {
                console.log(error);
            });

        },
    },
}

</script>
