<template>
    <div class="register flex justify-center items-center">
        <div class="p-6 w-2/6 bg-white shadow-md rounded-md mx-auto mt-12">
            <div class="flex justify-center items-center">
                <h1 class="text-gray-700 font-bold text-2xl">Registro</h1>
            </div>
            <form @submit.prevent="registerUser" class="mt-4">
                <div>
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Nombre:</label>
                    <input v-model="name" type="text" required class="appearance-none block w-full bg-white-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white">
                </div>
                <div class="mt-4">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Email:</label>
                    <input v-model="email" type="email" required class="appearance-none block w-full bg-white-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white">
                </div>
                <div class="mt-4">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Contraseña:</label>
                    <input v-model="password" type="password" required class="appearance-none block w-full bg-white-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white">
                </div>
                <div class="mt-4">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Confirmar Contraseña:</label>
                    <input v-model="confirmPassword" type="password" required class="appearance-none block w-full bg-white-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white">
                </div>
                <div class="mt-6">
                    <button type="submit" class="py-2 px-4 text-center bg-blue-500 rounded-md w-full text-white hover:bg-blue-600">Registrar</button>
                </div>
            </form>
            <div class="flex justify-end mt-4">
                <router-link to="/login">
                    <button type="button" class="text-sm text-blue-500 hover:text-blue-600 underline ml-1">Iniciar sesión</button>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            name            : '',
            email           : '',
            password        : '',
            confirmPassword : ''
        }
    },
    methods: {
        registerUser() {

            if (this.password !== this.confirmPassword) {
                alert("La contraseña y la confirmación de la contraseña no coinciden!");
                return;
            }

            const url = '/api/user/register';

            axios.post(url, {
                name                  : this.name,
                email                 : this.email,
                password              : this.password,
                password_confirmation : this.confirmPassword,
            }).then(response => {

                console.log(response)

                this.$router.push('/login');

            }).catch(error => {

                console.log(error);

            });

        }
    }
}

</script>
