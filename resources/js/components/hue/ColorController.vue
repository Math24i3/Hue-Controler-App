<template>
    <div class="container">
        <div v-if="fieldData.light" class="row flex">
            <div class="col-auto">
                <i class="fas fa-palette pt-2" style="font-size: 1.7em"></i>
            </div>
            <div class="col-md-2">
                <v-swatches v-model="color"
                            :swatches="swatches"
                            row-length="5"
                            shapes="circles"
                            show-border
                            popover-x="left"
                            @input="[printColor(), toggleColor()]"
                ></v-swatches>
            </div>

        </div>

    </div>
</template>

<script>
import axios from 'axios';
import VSwatches from 'vue-swatches'
import "vue-swatches/dist/vue-swatches.css"


export default {

    data() {
        return {
            fieldData: {
                light: null,
            },
            color: '#ffffff',
            swatches: ['#bf4747', '#52a752', '#3a3aa5', '#F7E9CB', '#ffffff']
        }
    },
    props: {
        lightSwitchEndpoint: {
            required: true,
            type: String
        },
    },
    computed: {
    },
    mounted() {
        this.getLightState();
    },
    methods: {
        printColor: function () {
            console.log(this.color)
        },
        toggleColor: function () {
            const color = this.color
            let data = {
                'xy': null
            }
            if (color === '#bf4747') {
                console.log('red')
                data['xy'] = [0.7, 0.28]
            } else if (color === '#52a752') {
                console.log('green')
                data['xy'] = [0.2, 0.7]
            } else if (color === '#3a3aa5') {
                console.log('blue')
                data['xy'] = [0.15, 0.05]
            } else if (color === '#ffffff') {
                console.log('white')
                data['xy'] = [0.3, 0.3]
            } else if (color === '#F7E9CB') {
                console.log('white')
                data['xy'] = [0.45, 0.41]
            }
            axios({
                method: ('post'),
                url: this.lightSwitchEndpoint.replace('_id_', '1'),
                data: data
            }).then((response) => {
                return response;
            }).catch((response) => {
                console.log(response);
                return false;
            });
        },
        getLightState: function () {
            axios.get(this.lightSwitchEndpoint.replace('_id_', '1')).then(response => {
                if (!response || !response.data) {
                    return false;
                }

                if (response.data.state) {
                    this.$set(this.$data.fieldData, 'light', response.data.state);
                }
                return true;
            }).catch((response) => {
                console.log(response);
                return false;
            });
        }
    },
    components: {
        VSwatches
    }
}
</script>
