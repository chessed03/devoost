<template>

    <div class="bg-gray-100">
        <div class="p-6 w-3/5 bg-white shadow-md rounded-md mx-auto mt-12">
            <div class="flex justify-center items-center">
                <h1 class="text-gray-700 font-bold text-2xl">Algoritmia</h1>
            </div>

            <div class="mt-4">
                <br>
                <hr>
                <br>
                [ INSTRUCCIONES ] <br>
                * Campo Número a evaluar: un solo dígito.<br>
                * Campo Número de base: Lista de números separados por coma (,). Ejemplo: 1,4,5,7,2 <br>
                * Campo Número: Veces que se realizará la consulta con el número a evaluar.<br>
                * Campo Listado númerico: Lista de números separados por un espacio, de menor a mayor. Ejemplo: 7 8 9 15 27<br>
                <br>
                <hr>
                <br>
                <form @submit.prevent="validate" class="mt-4">
                    <div>
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Número a evaluar:</label>
                        <input v-model="number_evaluate" type="number" required class="appearance-none block w-full bg-white-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white">
                    </div>

                    <div>
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Números de base:</label>
                        <input v-model="number_base" required @keypress="validateInput($event, 'base')" class="appearance-none block w-full bg-white-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white">
                    </div>

                    <div>
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Número:</label>
                        <input v-model="number_query" type="number" required class="appearance-none block w-full bg-white-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white">
                    </div>

                    <div>
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Listado númerico:</label>
                        <input v-model="number_list" @keypress="validateInput($event, 'list')" required class="appearance-none block w-full bg-white-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white">
                    </div>

                    <div class="flex mt-6 space-x-4">
                        <button type="button" class="py-2 px-4 text-center bg-red-500 rounded-md w-full text-white hover:bg-red-600">Limpiar</button>
                        <button type="submit" class="py-2 px-4 text-center bg-blue-500 rounded-md w-full text-white hover:bg-blue-600">Evaluar</button>
                    </div>
                </form>
            </div>

            <div class="mt-4">
                <br>
                <hr>
                <br>
                [ RESULTADO ] <br>
                <br>
                <hr>

            </div>

        </div>
    </div>

</template>

<script>

export default {
    data() {
        return {
            number_evaluate : null,
            number_base     : '',
            number_query    : null,
            number_list     : '',
        };
    },
    methods: {
        validateInput(event, type) {

            let charCode = (event.which) ? event.which : event.keyCode;
            let condition;

            if (type === 'base') {

                condition = (charCode >= 48 && charCode <= 57) || charCode == 44;

            } else if (type === 'list') {

                condition = (charCode >= 48 && charCode <= 57) || charCode == 32;

            }

            if (!condition) {
                event.preventDefault();
            }

        },
        validate() {
            console.log(this.number_base, this.number_list);
            const url = '/api/iyata/algoritmia';

            axios.post(url, {
                number_evaluate : this.number_evaluate,
                number_base     : this.number_base,
                number_query    : this.number_query,
                number_list     : this.number_list,
            }).then(response => {

                console.log(response);


            }).catch(error => {

                console.log(error);

            });

        },
    },

}

</script>
