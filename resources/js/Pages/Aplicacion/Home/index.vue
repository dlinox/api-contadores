<template>
    <AppLayout>
        <section class="welcome-section">
            <div class="welcome-user">
                <v-list lines="one">
                    <v-list-item
                        prepend-avatar="https://cdn.vuetifyjs.com/images/john.png"
                        :title="user.nombre"
                        subtitle="Bienvenido"
                    >
                    </v-list-item>
                </v-list>
            </div>
            <div class="welcome-data">
                <div class="data-item">
                    <span class="data-title">Aportes</span>
                    <span class="data-value"> S/. 205</span>
                </div>

                <div class="data-item">
                    <span class="data-title">Aportes</span>
                    <span class="data-value"> S/. 205</span>
                </div>
                <div class="data-item">
                    <span class="data-title">Aportes</span>
                    <span class="data-value"> S/. 205</span>
                </div>
            </div>
        </section>

        <section>
            <v-container>
                <template v-if="store.noticias.length > 0">
                    <v-carousel
                        :show-arrows="false"
                        height="400"
                        hide-delimiters
                        class="rounded-xl"
                    >
                        <v-carousel-item
                            v-for="(item, index) in store.noticias"
                            :key="index"
                            :src="item.imagen"
                            cover
                            class="rounded-xl"
                        ></v-carousel-item>
                    </v-carousel>
                </template>
                <template v-else>
                    <v-row
                        class="fill-height py-5"
                        align-content="center"
                        justify="center"
                    >
                        <v-col
                            class="text-subtitle-2 text-center text-primary pb-1"
                            cols="12"
                        >
                            Cargando Noticias
                        </v-col>

                        <v-col cols="6" class="pt-0">
                            <v-progress-linear
                                color="primary"
                                indeterminate
                                rounded
                                height="6"
                            ></v-progress-linear>
                        </v-col>
                    </v-row>
                </template>
            </v-container>
        </section>

        <section>
            <v-container>
                <v-alert
                    icon="mdi-wallet-membership"
                    text="Febrero de 2022"
                    variant="tonal"
                    type="success"
                    density="compact"
                >
                    <template v-slot:title>
                        <small>{{ user.situacion }}</small>
                    </template>
                    <template v-slot:text>
                        <small> {{ store.habil?.hasta }} </small>
                    </template>
                </v-alert>
            </v-container>
        </section>

        <section class="ma-3">
            <v-card subtitle="Pagos Prendintes" flat>
                <template v-slot:text>
                    <v-list lines="one">
                        <v-list-item
                            v-for="item in items"
                            :key="item.title"
                            :title="item.title"
                            subtitle="2022-002-05  * S/. 40"
                        >
                            <template v-slot:prepend>
                                <v-icon icon="mdi-cash-clock"></v-icon>
                            </template>
                        </v-list-item>
                    </v-list>
                </template>
            </v-card>
        </section>
    </AppLayout>
</template>
<script setup>
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { useAppStore } from "../../../store/appStore";

const props = defineProps({
    habil: Object,
});

const user = computed(() => usePage().props?.auth?.user);
const store = useAppStore();

const items = [
    {
        title: "Constancia de Halibitacion",
        value: 1,
    },
    {
        title: "Constancia de Halibitacion",
        value: 2,
    },
    {
        title: "Cutota ordinaria",
        value: 3,
    },
];

const init = async () => {
    store.getNoticias();
    store.setHabil(props.habil);
};
init();
</script>

<style lang="scss">
.welcome-section {
    width: 100%;
    background-color: $app-color1;
    min-height: 100px;
    border-end-end-radius: 1.5rem;
    border-end-start-radius: 1.5rem;
    padding: 0rem 1.5rem 1.5rem 1.5rem;

    .welcome-user {
        .v-list {
            background-color: $app-color1;
            color: white;
        }
    }

    .welcome-data {
        background-color: rgba($color: #000000, $alpha: 0.1);
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        margin-top: 1rem;
        border-radius: 1.5rem;
        .data-item {
            display: flex;
            justify-content: center;
            padding: 1rem;
            flex-wrap: wrap;
            span {
                color: white;
                width: 100%;
                text-align: center;
                &.data-title {
                    font-size: 0.8rem;
                    font-weight: 400;
                    color: #ccc;
                }
                &.data-value {
                    font-weight: 600;
                    font-size: 1.2rem;
                }
            }
        }
    }
}
</style>
