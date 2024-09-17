import { createRouter, createWebHistory } from "vue-router";

import FormProduct from "./components/system/products/components/formProduct.vue";
import FormClient from "./components/system/clients/components/formClient.vue";
import FormPrice from "./components/system/prices/components/formPrice.vue";
import FormOrder from "./components/system/orders/components/formOrder.vue";
import Algoritmia from "./components/system/algoritmia/algoritmia.vue";
import Products from "./components/system/products/products.vue";
import Clients from "./components/system/clients/clients.vue";
import Prices from "./components/system/prices/prices.vue";
import Orders from "./components/system/orders/orders.vue";
import Register from "./components/auth/register.vue";
import Test from "./components/system/test/test.vue";
import Login from "./components/auth/login.vue";
import Home from "./components/system/home.vue";

const routes = [
    {
        path        : '/algoritmia',
        component   : Algoritmia,
    },
    {
        path        : '/test',
        component   : Test,
    },
    {
        path        : '/login',
        component   : Login,
        alias       : '/'
    },
    {
        path        : '/register',
        component   : Register,
    },
    {
        path        : '/login',
        component   : Login,
        alias       : '/'
    },
    {
        path        : '/register',
        component   : Register,
    },
    {
        path        : "/home",
        name        : 'home',
        component   : Home,
        meta        : {
            requiresAuth: true
        }
    },
    {
        path        : "/clients",
        name        : 'clients',
        component   : Clients,
        meta        : {
            requiresAuth: true
        }
    },
    {
        path        : "/clients/create",
        name        : 'CreateClient',
        component   : FormClient,
        meta        : {
            requiresAuth: true
        }
    },
    {
        path        : "/clients/update/:id",
        name        : 'UpdateClient',
        component   : FormClient,
        props       : true,
        meta        : {
            requiresAuth: true
        }
    },
    {
        path        : "/products",
        name        : 'products',
        component   : Products,
        meta        : {
            requiresAuth: true
        }
    },
    {
        path        : "/products/create",
        name        : 'CreateProduct',
        component   : FormProduct,
        meta        : {
            requiresAuth: true
        }
    },
    {
        path        : "/products/update/:id",
        name        : 'UpdateProduct',
        component   : FormProduct,
        props       : true,
        meta        : {
            requiresAuth: true
        }
    },
    {
        path        : "/prices",
        name        : 'prices',
        component   : Prices,
        meta        : {
            requiresAuth: true
        }
    },
    {
        path        : "/prices/create",
        name        : 'CreatePrices',
        component   : FormPrice,
        meta        : {
            requiresAuth: true
        }
    },
    {
        path        : "/prices/update/:id",
        name        : 'UpdatePrices',
        component   : FormPrice,
        props       : true,
        meta        : {
            requiresAuth: true
        }
    },
    {
        path        : "/orders",
        name        : 'orders',
        component   : Orders,
        meta        : {
            requiresAuth: true
        }
    },
    {
        path        : "/orders/create",
        name        : 'CreateOrders',
        component   : FormOrder,
        meta        : {
            requiresAuth: true
        }
    },
    {
        path        : "/orders/update/:id",
        name        : 'UpdateOrders',
        component   : FormOrder,
        props       : true,
        meta        : {
            requiresAuth: true
        }
    },
];

const history = createWebHistory();

const router = createRouter({
    history,
    routes,
});

router.beforeEach((to, from, next) => {

    if(to.matched.some(record => record.meta.requiresAuth) && !localStorage.getItem('authToken')) {
        next({
            path    : '/',
            query   : { redirect: to.fullPath }
        });
    } else {
        next();
    }

});

export default router;
