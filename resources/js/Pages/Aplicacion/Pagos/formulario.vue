<template>
    <v-app id="inspire">
        <v-app-bar
            class="py-2 text-white"
            color="secondary"
            density="prominent"
        >
            <template v-slot:prepend>
                <v-btn @click="router.get('/app/pagos')" icon="mdi-arrow-left">
                </v-btn>
            </template>

            <template v-slot:title>
                <v-list lines="one" bg-color="secondary">
                    <v-list-item class="pl-0">
                        <v-list-item-subtitle class="text-h6 py-1">
                            Total S/. 00.00
                        </v-list-item-subtitle>
                        <v-list-item-title class="text-h6 mt-3">
                            ñlñ
                        </v-list-item-title>
                    </v-list-item>
                </v-list>
            </template>
        </v-app-bar>

        <v-main>
            <v-container class="my-4">
                <v-row>
                    <v-col cols="8">
                        <v-autocomplete
                            variant="outlined"
                            label="Concepto"
                            :items="[
                                'California',
                                'Colorado',
                                'Florida',
                                'Georgia',
                                'Texas',
                                'Wyoming',
                            ]"
                            hide-details
                        ></v-autocomplete>
                    </v-col>
                    <v-col cols="4">
                        <v-select
                            variant="outlined"
                            label="Cantidad"
                            :items="[
                                1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14,
                                15, 16,
                            ]"
                            hide-details
                        ></v-select>
                    </v-col>
                    <v-col cols="12">
                        <hr />
                        <div class="text-caption">
                            Voucher de depósito (png, jpg)
                        </div>
                    </v-col>
                    <v-col cols="6">
                        <v-text-field
                            hide-details
                            variant="outlined"
                            label="N° de Operacion"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="6">
                        <DatePikerComponent v-model="date">
                            <v-text-field
                                hide-details
                                variant="outlined"
                                v-model="date"
                                readonly
                                label="Fecha"
                                append-inner-icon="mdi-calendar-range"
                            />
                        </DatePikerComponent>
                    </v-col>

                    <v-col cols="12">
                        <v-text-field
                            hide-details
                            variant="outlined"
                            label="Importe"
                        ></v-text-field>
                    </v-col>

                    <v-col cols="6">
                        <v-btn
                            variant="tonal"
                            block
                            prepend-icon="mdi-camera"
                            @click="dialogCamara = !dialogCamara"
                        >
                            <small> Camara </small>
                        </v-btn>
                    </v-col>

                    <v-col cols="6">
                        <CropCompressImageComponent
                            :aspectRatio="1"
                            @onCropper="img_blob = $event.blob"
                        />
                    </v-col>

                    <v-col v-if="img_blob" cols="12">
                        <v-img
                            class="bg-black"
                            width="100%"
                            :aspect-ratio="1"
                            :src="img_blob"
                        ></v-img>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>

        <v-dialog
            v-model="dialogCamara"
            fullscreen
            :scrim="false"
            transition="dialog-bottom-transition"
        >
            <v-card color="#000">
                <Camera
                    ref="camera"
                    :resolution="{ width: 300, height: 400 }"
                ></Camera>

                <v-card-actions dark class="justify-space-around mb-5">
                    <v-btn
                        @click="dialogCamara = false"
                        icon="mdi-close"
                        variant="tonal"
                        color="white"
                    ></v-btn>

                    <v-btn
                        icon="mdi-camera-iris"
                        color="primary"
                        variant="tonal"
                        size="x-large"
                        @click="snapshot"
                    ></v-btn>

                    <v-btn
                        icon="mdi-sync"
                        variant="tonal"
                        color="white"
                    ></v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-footer app elevation="10">
            <v-row class="mb-1">
                <v-col>
                    <v-btn rounded="lg" size="large" color="error" block>
                        <small> cancelar</small>
                    </v-btn>
                </v-col>
                <v-col>
                    <v-btn rounded="lg" size="large" color="secondary" block>
                        <small> guardar</small>
                    </v-btn>
                </v-col>
            </v-row>
        </v-footer>
    </v-app>
</template>
<script setup>
import { ref, computed } from "vue";
import { router } from "@inertiajs/core";
import { usePage } from "@inertiajs/vue3";
import DatePikerComponent from "@/components/DatePikerComponent.vue";
import Camera from "simple-vue-camera";
import CropCompressImageComponent from "../../../components/CropCompressImageComponent.vue";

const camera = ref(null);

const date = ref(null);
const dialog = ref(false);
const dialogCamara = ref(false);

const img_blob = ref(null);

const snapshot = async () => {
    const blob = await camera.value?.snapshot();
    const url = URL.createObjectURL(blob);

    let file = new File([blob], "imagen_crop_optimize", {
        type: blob.type,
        quality: 0.5,
    });

    img_blob.value = url;
    dialog.value = false;

    dialogCamara.value = false;
};
</script>
