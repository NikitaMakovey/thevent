<template>
    <v-row>
        <v-spacer></v-spacer>
        <v-col cols="10" class="pa-0 ma-0">
            <v-card>
                <v-col
                    align-self="start"
                    class="pa-0"
                    cols="12"
                >
                    <v-avatar
                        class="profile"
                        color="grey"
                        size="164"
                        tile
                    >
                        <v-img :src="USER_INFO.image"></v-img>
                    </v-avatar>
                </v-col>
                <v-col class="px-3 py-0">
                    <v-list-item
                        color="#000000"
                        class="px-0"
                    >
                        <v-list-item-content>
                            <v-list-item-title>
                                <span class="title">
                                    {{ USER_INFO.second_name }} {{ USER_INFO.first_name }} {{ USER_INFO.third_name }}
                                </span>
                                <v-btn text icon class="title"
                                       :to="{ name: 'edit.info', params: { id: this.$store.getters.ID } }"
                                >
                                    <v-icon class="title">mdi-fountain-pen-tip</v-icon>
                                </v-btn>
                            </v-list-item-title>
                            <v-list-item-subtitle
                            >
                                На платформе с {{ $moment(USER_INFO.created_at).format("LL") }}
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                </v-col>
            </v-card>
            <v-card
                class="my-2"
            >
                <v-col
                    cols="12"
                >
                    <div>
                        <p class="information-text">Информация</p>
                    </div>
                    <v-divider></v-divider>
                    <v-simple-table>
                        <template v-slot:default>
                            <tbody>
                            <tr>
                                <td>Электронная почта</td>
                                <td>{{ USER_INFO.email === null ? "-" : USER_INFO.email }}</td>
                            </tr>
                            <tr>
                                <td>Дата рождения</td>
                                <td>
                                    {{
                                    USER_INFO.birth_date === null ?
                                    "-" : $moment(USER_INFO.birth_date).format('LL')
                                    }}
                                </td>
                            </tr>
                            <tr>
                                <td>Специализация</td>
                                <td>{{ USER_INFO.specialization === null ? "-" : USER_INFO.specialization }}</td>
                            </tr>
                            <tr>
                                <td>Био</td>
                                <td>{{ USER_INFO.info === null ? "-" : USER_INFO.info }}</td>
                            </tr>
                            </tbody>
                        </template>
                    </v-simple-table>
                </v-col>
            </v-card>
            <v-card
                class="my-2"
                v-if="USER_EVENTS.length > 0"
            >
                <v-col
                    cols="12"
                >
                    <div>
                        <p class="information-text">Участие в мероприятиях</p>
                    </div>
                    <event-list-component :events="USER_EVENTS"></event-list-component>
                </v-col>
            </v-card>
            <v-card
                class="my-2"
                v-if="USER_SKILLS.length > 0"
            >
                <v-col
                    cols="12"
                >
                    <div>
                        <p class="information-text">Навыки</p>
                    </div>
                    <v-divider></v-divider>
                    <div id="chartdiv" ref="chartdiv"></div>
                </v-col>
            </v-card>
        </v-col>
        <v-spacer></v-spacer>
    </v-row>
</template>

<script>
    import {mapGetters} from 'vuex';
    import EventListComponent from "../ActiveComponents/UserComponents/EventListComponent";

    import * as am4core from "@amcharts/amcharts4/core";
    import * as am4charts from "@amcharts/amcharts4/charts";
    import kelly from "@amcharts/amcharts4/themes/kelly";
    import am4themes_animated from "@amcharts/amcharts4/themes/animated"

    am4core.useTheme(kelly);
    am4core.useTheme(am4themes_animated);

    export default {
        components: {
            'event-list-component' : EventListComponent
        },
        mounted() {
            this.$store.dispatch('GET_USER', { id: this.$store.getters.ID })
                .then((skills) => {
                    let iconPath =
                        "M53.5,476c0,14,6.833,21,20.5,21s20.5-7,20.5-21V287h21v189c0," +
                        "14,6.834,21,20.5,21 c13.667,0,20.5-7,20.5-21V154h10v116c0,7.334," +
                        "2.5,12.667,7.5,16s10.167,3.333,15.5,0s8-8.667,8-16V145c0-13.334-4.5-" +
                        "23.667-13.5-31 s-21.5-11-37.5-11h-82c-15.333,0-27.833,3.333-37.5,10s-" +
                        "14.5,17-14.5,31v133c0,6,2.667,10.333,8,13s10.5,2.667,15.5,0s7.5-7,7.5-13 " +
                        "V154h10V476 M61.5,42.5c0,11.667,4.167,21.667,12.5,30S92.333,85,104,85s21.667-" +
                        "4.167,30-12.5S146.5,54,146.5,42 c0-11.335-4.167-21.168-12.5-29.5C125.667,4.167," +
                        "115.667,0,104,0S82.333,4.167,74,12.5S61.5,30.833,61.5,42.5z";



                    let chart = am4core.create(this.$refs.chartdiv, am4charts.SlicedChart);
                    chart.hiddenState.properties.opacity = 0;

                    chart.data = skills;

                    let series = chart.series.push(new am4charts.PictorialStackedSeries());
                    series.dataFields.value = "skill_factor";
                    series.dataFields.category = "name";
                    series.alignLabels = true;

                    series.maskSprite.path = iconPath;
                    series.ticks.template.locationX = 1;
                    series.ticks.template.locationY = 0.5;

                    series.labelsContainer.width = 300;

                    chart.legend = new am4charts.Legend();
                    chart.legend.position = "left";
                    chart.legend.valign = "bottom";
                });
        },
        computed: {
            ...mapGetters(['USER_INFO', 'USER_EVENTS', 'USER_SKILLS'])
        }
    }
</script>

<style scoped>
    .information-text {
        font-size: 2rem;
    }
    #chartdiv {
        width: 100%;
        height: 500px;
    }
</style>
