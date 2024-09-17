<template>
    <div class="flex justify-center mt-4">
        <nav class="bg-blue-500 p-2 shadow-md w-3/5 rounded">
            <ul class="flex justify-around text-white">
                <li class="hover:bg-blue-700 p-2 rounded">
                    <router-link to="/home" class="no-underline text-white hover:text-gray-200">Inicio</router-link>
                </li>
                <li class="hover:bg-blue-700 p-2 rounded">
                    <router-link to="/clients" class="no-underline text-white hover:text-gray-200">Clientes</router-link>
                </li>
                <li class="hover:bg-blue-700 p-2 rounded">
                    <router-link to="/products" class="no-underline text-white hover:text-gray-200">Productos</router-link>
                </li>
                <li class="hover:bg-blue-700 p-2 rounded">
                    <router-link to="/prices" class="no-underline text-white hover:text-gray-200">Precios</router-link>
                </li>
                <li class="hover:bg-blue-700 p-2 rounded">
                    <router-link to="/orders" class="no-underline text-white hover:text-gray-200">Ordenes</router-link>
                </li>
                <li class="hover:bg-blue-700 p-2 rounded">
                    <a href="#" @click="logout" class="no-underline text-white hover:text-gray-200">Salir</a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
    export default {
        data: () => ({}),
        methods: {
            logout(event) {
                event.preventDefault();

                axios.defaults.headers.common['Authorization']  = `Bearer ${localStorage.getItem('authToken')}`;
                const url                                       = '/api/auth/logout';

                axios.post(url)
                    .then(() => {
                        localStorage.removeItem('authToken');
                        this.isLoggedIn = false;
                        this.$router.push('/login');
                    })
                    .catch(error => {
                        console.error('Ocurrio un error', error);
                    });
            },
        },
    };

</script>
