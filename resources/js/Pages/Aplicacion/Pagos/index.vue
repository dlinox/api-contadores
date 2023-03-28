<template>
    <AppLayout>
        <v-tabs fixed-tabs v-model="tab" color="primary">
            <v-tab> Pendientes </v-tab>
            <v-tab> Aprobados </v-tab>
        </v-tabs>

        <v-window v-model="tab">
            <v-window-item>
                <v-banner
                    icon="mdi-information-outline"
                    text="Aquí se muestran el estado de todos tus registros de pago mediante depósito en cuentas del Colegio de Contadores Públicos de Puno que tienen que ser validados."
                    :stacked="false"
                >
                </v-banner>
                <v-container>
                    <section class="text-center py-3">
                        <v-btn block size="large" color="primary" rounded="lg" @click="router.get('/app/pagos/create')" >
                            Registrar pago via internet
                        </v-btn>
                    </section>

                    <section class="py-3">
                        <v-card>
                            <v-table>
                                <thead>
                                    <tr>
                                        <th class="text-left">Name</th>
                                        <th class="text-left">Calories</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="item in desserts"
                                        :key="item.name"
                                    >
                                        <td>{{ item.name }}</td>
                                        <td>{{ item.calories }}</td>
                                    </tr>
                                </tbody>
                            </v-table>
                        </v-card>
                    </section>
                </v-container>
            </v-window-item>

            <v-window-item>
                <v-banner
                    icon="mdi-information-outline"
                    text="Aquí se muestran el estado de todos tus registros de pago mediante depósito en cuentas del Colegio de Contadores Públicos de Puno validados."
                    :stacked="false"
                >
                </v-banner>
                <v-container>
                    <section class="py-3">
                        <v-card>
                            <v-card-text>
                                <v-row>
                                    <v-col>
                                        <v-select
                                            hide-details
                                            variant="outlined"
                                            clearable
                                            label="Forma Pago"
                                            :items="[
                                                'Efectivo',
                                                'POS',
                                                'Tarjeta',
                                                'Deposito',
                                            ]"
                                        ></v-select>
                                    </v-col>
                                    <v-col>
                                        <v-select
                                            hide-details
                                            variant="outlined"
                                            clearable
                                            label="Año Pago"
                                            :items="[
                                                '2020',
                                                '2021',
                                                '2022',
                                                '2023',
                                                '2024',
                                                '2025',
                                            ]"
                                        ></v-select>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                            <v-table>
                                <thead>
                                    <tr>
                                        <th class="text-left">Name</th>
                                        <th class="text-left">Calories</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="item in desserts"
                                        :key="item.name"
                                    >
                                        <td>{{ item.name }}</td>
                                        <td>{{ item.calories }}</td>
                                    </tr>
                                </tbody>
                            </v-table>
                        </v-card>
                    </section>
                </v-container>
            </v-window-item>
        </v-window>
    </AppLayout>
</template>
<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/core";
import AppLayout from "@/Layouts/AppLayout.vue";

const tab = ref(0);

const desserts = [
    {
        name: "Frozen Yogurt",
        calories: 159,
    },
    {
        name: "Ice cream sandwich",
        calories: 237,
    },
    {
        name: "Eclair",
        calories: 262,
    },
    {
        name: "Cupcake",
        calories: 305,
    },
    {
        name: "Gingerbread",
        calories: 356,
    },
    {
        name: "Jelly bean",
        calories: 375,
    },
    {
        name: "Lollipop",
        calories: 392,
    },
    {
        name: "Honeycomb",
        calories: 408,
    },
    {
        name: "Donut",
        calories: 452,
    },
    {
        name: "KitKat",
        calories: 518,
    },
];
</script>

<style lang="scss"></style>
