<template>
    <div class="page-login">
        <section class="logo-section">
            <h1>logo</h1>
        </section>
        <section class="form-section">
            <v-form ref="formRef" @submit.prevent="submit">
                <v-row>
                    <v-col cols="12" class="py-1">
                        <v-text-field
                            density="compact"
                            v-model="formData.login"
                            :rules="rules"
                            variant="solo"
                            flat
                            label="N° DNI"
                            rounded="lg"
                        >
                            <template v-slot:prepend-inner>
                                <v-icon
                                    size="small"
                                    icon="mdi-card-account-details-outline"
                                ></v-icon>
                            </template>
                        </v-text-field>
                    </v-col>
                    <v-col cols="12" class="py-1">
                        <v-text-field
                            density="compact"
                            variant="solo"
                            v-model="formData.password"
                            :rules="rules"
                            label="Contraseña"
                            type="password"
                            rounded="lg"
                        >
                            <template v-slot:prepend-inner>
                                <v-icon
                                    size="small"
                                    icon="mdi-fingerprint"
                                ></v-icon>
                            </template>
                        </v-text-field>
                    </v-col>

                    <v-col cols="12" class="py-1">
                        <v-btn
                            rounded="lg"
                            type="submit"
                            color="primary"
                            block
                            class="mt-2"
                        >
                            Ingresar
                        </v-btn>
                    </v-col>
                </v-row>
            </v-form>
        </section>
        <section class="footer-section">
            <h1>footer</h1>
        </section>
    </div>
</template>
<script setup>
import { ref } from "vue";
import { Link, useForm } from "@inertiajs/vue3";

const formRef = ref(null);
const formData = useForm({
    login: "",
    password: "",
});

const rules = [
    (value) => {
        if (value) return true;

        return "Obligatorio";
    },
];

const submit = () => {
    formData.post("/sign-in");
};
</script>
<style lang="scss">
.page-login {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    height: 100vh;
    width: 100vw;
    background-color: #eee;
    .form-section {
        width: 20rem;
        max-width: 90%;
    }
}

.v-field--variant-solo {
    box-shadow: none !important;
}
</style>
