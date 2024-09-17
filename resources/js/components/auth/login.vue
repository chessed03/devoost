<template>
    <div class="login flex justify-center items-center">
        <div class="p-6 w-2/6 bg-white shadow-md rounded-md mx-auto mt-12">
            <div class="flex justify-center items-center">
                <h1 class="text-gray-700 font-bold text-2xl">Login</h1>
            </div>

            <form @submit.prevent="handleSubmit" class="mt-4">
                <div>
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="code">Email</label>
                    <input v-model="email" type="email" class="appearance-none block w-full bg-white-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" />
                </div>

                <div class="mt-4">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="code">Password</label>
                    <input v-model="password" type="password" class="appearance-none block w-full bg-white-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" />
                </div>

                <div class="mt-6">
                    <button type="submit" class="py-2 px-4 text-center bg-blue-500 rounded-md w-full text-white hover:bg-blue-600">Iniciar sesión</button>
                </div>
            </form>

            <div class="flex justify-end mt-4">
                <router-link to="/register">
                    <button type="button" class="text-sm text-blue-500 hover:text-blue-600 underline ml-1">Registrarse</button>
                </router-link>
            </div>

        </div>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                email    : '',
                password : '',
            }
        },

        methods: {
            async handleSubmit() {
                if (this.email && this.password) {

                    try {

                        const url       = '/api/auth/sanctum/token';

                        const response  = await axios.post(url, {
                            email       : this.email,
                            password    : this.password,
                            device_name : 'browser',
                        });

                        localStorage.setItem('authToken', response.data.token);

                        this.$router.push('/home');

                    } catch (error) {

                        console.error("Hubo un error al intentar iniciar sesión", error);
                        alert('Existe un error con las credenciales.');

                    }

                } else {

                    alert("Por favor, rellena todos los campos");

                }
            }
        }
    }

</script>
