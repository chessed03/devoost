<template>
    <div>
        <header v-if="isLoggedIn">
            <top-bar></top-bar>
        </header>
        <header v-if="!isLoggedIn">
            <top-menu></top-menu>
        </header>
        <main>
            <router-view></router-view>
        </main>
    </div>
</template>

<script>

    import TopBar from "./components/menu/topBar.vue";
    import TopMenu from "./components/menu/topMenu.vue";

    export default {
        components: {
            TopBar,
            TopMenu
        },
        data: () => ({
            isLoggedIn: !!localStorage.getItem('authToken')
        }),
        watch: {
            '$route': function () {
                this.checkAuth();
            }
        },
        methods: {
            checkAuth() {
                this.isLoggedIn = !!localStorage.getItem('authToken');
            },
        },
    };

</script>
