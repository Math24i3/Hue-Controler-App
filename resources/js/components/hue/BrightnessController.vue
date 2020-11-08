<template>
    <div class="container">
        <div v-if="fieldData.light" class="row flex">
            <div class="col-auto">
                <i v-if="fieldData.light.bri > 0" class="fas fa-lightbulb"></i>
                <i v-else class="far fa-lightbulb"></i>
            </div>
            <div class="col-md-2">
                <input type="range" id="custom-range-1" class="custom-range" min="0" max="5" :disabled="fetching" v-model="fieldData.brightness" @input="toggleBrightness()">
            </div>

        </div>

    </div>
</template>

<script>
import axios
    from 'axios';

export default {
    data() {
        return {
            fetching: false,
            fieldData: {
                brightness: 0,
                light: null,
            }
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
        toggleBrightness: function () {
            let bri = Number(50.8 * this.fieldData.brightness).toFixed(0);
            if (bri == 0) {
                bri = 1
            }
            let data = {
                'bri': bri
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
            this.fetching = true
            axios.get(this.lightSwitchEndpoint.replace('_id_', '1')).then(response => {
                if (!response || !response.data) {
                    return false;
                }
                if (response.data.state) {
                    this.$set(this.$data.fieldData, 'light', response.data.state);
                    this.fieldData.brightness = this.fieldData.light.bri / 50.8
                }
                return true;
            }).catch((response) => {
                console.log(response);
                return false;
            });
            this.fetching = false
        }
    },
    components: {

    }
}
</script>
