<template>
    <div class="container">
        <div v-if="fieldData.light" class="row flex pt-3">
            <div class="col-auto">
                <i v-if="fieldData.light.on" class="fas fa-lightbulb"></i>
                <i v-else class="far fa-lightbulb"></i>


            </div>
            <div class="col-md-2">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="customSwitches" v-model="fieldData.light.on" @input="toggleLight()" :disabled="fetching">
                    <label class="custom-control-label" for="customSwitches">{{ ( fieldData.light.on ? 'Bulb is on' : 'Bulb is off')}}</label>
                </div>
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
        toggleLight: function () {
            this.fetching  = true
            let data = {
                'on': !this.fieldData.light.on
            }
            axios({
                method: ('post'),
                url: this.lightSwitchEndpoint.replace('_id_', '1'),
                data: data
            }).then((response) => {
                if (response.status == 200) {
                    this.fetching  = false
                }
                return response;
            }).catch((response) => {
                this.fetching  = false
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

    }
}
</script>
