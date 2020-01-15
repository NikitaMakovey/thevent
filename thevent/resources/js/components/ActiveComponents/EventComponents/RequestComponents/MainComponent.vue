<template>
    <v-row>
        <v-spacer></v-spacer>
        <v-col cols="11" lg="9" class="pa-0 ma-0">
            <v-card
                class="py-0"
            >
                <v-col
                    cols="12 py-0"
                >
                    <p class="request-title">Заявка на организацию</p>
                </v-col>
            </v-card>
            <v-card
                class="my-2 pa-0"
            >
                <v-col
                    cols="12"
                    class="stepper-container"
                >
                    <stepper-component></stepper-component>
                </v-col>
            </v-card>
        </v-col>
        <v-spacer></v-spacer>
    </v-row>
</template>

<script>
    import StepperComponent from "./StepperComponent";

    export default {
        components: {
            'stepper-component' : StepperComponent
        }
    }
</script>

<style scoped>
    .stepper-container {
        padding: 0 !important;
    }
    * {
        text-decoration: none !important;
    }
    .request-title {
        font-size: 3rem;
    }
    @media screen and (max-width: 700px) {
        .request-title {
            font-size: 1rem;
        }
    }
    @media screen and (min-width: 2000px) {
        .request-title {
            font-size: 4rem;
        }
    }
</style>
