import { defineStore } from "pinia";

export const useAppStore = defineStore("app", {
    state: () => ({
        noticias: [],
        pagosPendientes: [],
        pagosAprobados: [],
        certificaods: [],
        tramites: [],
        counter: 0,
        habil: null
    }),
    actions: {
        increment() {
            this.counter++;
        },

        async getNoticias() {
            if (this.noticias.length == 0) {
                try {
                    let res = await fetch(
                        "https://ccppuno.org.pe/wp-json/api-lnx/v1/get-noticias"
                    );

                    let json = await res.json();
                    this.noticias = json.noticias;
                } catch (error) {
                    console.error(error);
                    // let the form component display the error
                    return error;
                }
            }
        },

        setHabil(habil){
          
          this.habil = habil;
        }
    },
});
