<template>
    <v-app id="inspire">
        <v-navigation-drawer v-model="drawer" width="244">
            <v-sheet color="grey-lighten-5" height="128" width="100%"></v-sheet>

            <v-list>
                <v-list-item v-for="n in 5" :key="n" :title="`Item ${n}`" link>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar class="px-3 text-white" color="#9C000C" flat height="72">
            <v-btn @click="drawer = !drawer" icon="mdi-menu">
      
            </v-btn>
            <v-spacer></v-spacer>
        </v-app-bar>

        <v-main>
            <slot></slot>
        </v-main>

        <v-bottom-navigation
            app
            mode="shift"
            grow
            color="primary"
            v-model="tap"
        >
            <v-btn
                v-for="(item, index) in menu_navigation"
                :key="index"
                :value="item.value"
                @click="goToPage(item)"
            >
                <v-icon> {{ item.icon }} </v-icon>
                <span> {{ item.name }} </span>
            </v-btn>
        </v-bottom-navigation>
    </v-app>
</template>
<script setup>
import { ref, computed } from "vue";
import { router } from "@inertiajs/core";
import { usePage } from "@inertiajs/vue3";

//const user = computed(() => usePage().props?.auth?.user);

const tap = ref(usePage().props.tap);
const drawer = ref(false);

const menu_navigation = [
    { icon: "mdi-home", value: "home", name: "Inicio", route: "/home" },
    {
        icon: "mdi-account-credit-card-outline",
        value: "pagos",
        name: "Pagos",
        route: "/pagos",
    },
    {
        icon: "mdi-file-certificate-outline",
        value: "certificados",
        name: "Certificados",
        route: "/certificados",
    },
    {
        icon: "mdi-file-multiple",
        value: "tramites",
        name: "Tramietes",
        route: "/tramites",
    },
];

const goToPage = (page) => {
    if (usePage().props.tap == page.value) {
        tap.value = page.value;
        //return;
    } else {
        router.visit(page.route);
    }
};
</script>
