<template>
    <v-btn
        prepend-icon="mdi-multimedia"
        variant="tonal"
        block
        color="info"
        class="btn-upload-image"
    >
        <input
            type="file"
            ref="file"
            @change="cargarImagen($event)"
            accept="image/*"
        />
        <small> Galeria</small>
    </v-btn>

    <v-dialog v-model="showModal" width="600">
        <v-card>
            <v-toolbar dark color="secondary">
                <v-btn icon dark @click="showModal = false">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
                <v-toolbar-title>Cortar imagen</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                    <v-btn
                        icon="mdi-arrow-expand-all"
                        :variant="movable ? 'flat' : 'text'"
                        @click="movable = !movable"
                    >
                    </v-btn>
                    <v-btn
                        icon="mdi-arrow-expand"
                        :variant="resizable ? 'flat' : 'text'"
                        @click="resizable = !resizable"
                    >
                    </v-btn>

                    <v-menu>
                        <template v-slot:activator="{ props }">
                            <v-btn variant="tonal" color="white" v-bind="props">
                                {{
                                    aspectRatio_options.find(
                                        (item) => item.key == _aspectRatio
                                    ).label
                                }}
                            </v-btn>
                        </template>
                        <v-list>
                            <v-list-item
                                v-for="(item, index) in aspectRatio_options"
                                :key="index"
                                :value="item.key"
                                :title="item.label"
                                @click="_aspectRatio = item.key"
                            >
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </v-toolbar-items>
            </v-toolbar>

            <cropper
                ref="cropperRef"
                class="upload-example-cropper"
                :src="image.src"
                :stencil-props="{
                    aspectRatio: _aspectRatio,
                    movable: movable,
                    resizable: resizable,
                }"
            />

            <v-card-actions dark class="justify-end">
                <v-btn
                    @click="cropAndOptimize"
                    variant="flat"
                    color="secondary"
                >
                    <small> Cortar y guardar </small>
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { ref, reactive } from "vue";
import { Cropper } from "vue-advanced-cropper";
import { loadImageHelper } from "@/helpers/uploadFile.js";
const emits = defineEmits(["onCropper"]);

const props = defineProps({
    mimeType: String,
    optimize: {
        type: Number,
        default: 0.5,
    },
    aspectRatio: {
        type: Number,
        default: 16 / 9,
    },
});

const _aspectRatio = ref(props.aspectRatio);
const movable = ref(true);
const resizable = ref(true);

const aspectRatio_options = [
    { label: "21:9", key: 21 / 9 },
    { label: "16:9", key: 16 / 9 },
    { label: "4:3", key: 4 / 3 },
    { label: "1:1", key: 1 },
    { label: "Libre", key: 0 },
];

const showModal = ref(false);
const btn_loading = ref(false);

const cropperRef = ref(null);

const image = reactive({
    src: null,
    type: null,
});

const cropAndOptimize = () => {
    const canvas = cropperRef.value.getResult().canvas;
    canvas.toBlob(
        (blob) => {
            let file = new File([blob], "imagen_crop_optimize", {
                type: blob.type,
                quality: 0.6,
            });

            console.log(file.size / 1048576);

            emits("onCropper", { file: file, blob: URL.createObjectURL(blob) });
            showModal.value = false;
        },
        image.type,
        0.6
    );
};

const cargarImagen = async (e) => {
    btn_loading.value = true;

    let res = await loadImageHelper(e);

    if (res) {
        image.src = res.src;
        image.type = res.type;
        showModal.value = true;
    } else {
        console.log("error");
    }

    console.log("fin");
    btn_loading.value = false;
};
</script>

<style lang="scss">
.btn-upload-image {
    position: relative;

    input {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        font-size: 0;
        cursor: pointer;
        opacity: 0;
    }
}
</style>
