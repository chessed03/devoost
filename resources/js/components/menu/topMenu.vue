<template>
    <div class="flex justify-center mt-4">
        <nav class="bg-blue-500 p-2 shadow-md w-3/5 rounded">
            <ul class="flex justify-around text-white">
                <li class="hover:bg-blue-700 p-2 rounded">
                    <router-link to="/algoritmia" class="no-underline text-white hover:text-gray-200">Prueba algoritmia</router-link>
                </li>
                <li class="hover:bg-blue-700 p-2 rounded">
                    <router-link to="/test" class="no-underline text-white hover:text-gray-200">Prueba vue</router-link>
                </li>
                <li class="hover:bg-blue-700 p-2 rounded">
                    <router-link to="/login" class="no-underline text-white hover:text-gray-200">Login</router-link>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
export default {};

</script>
