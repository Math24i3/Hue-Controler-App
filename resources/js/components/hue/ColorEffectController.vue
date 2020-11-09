<template>
    <div class="container">
        <div v-if="fieldData.light" class="row flex pt-3">
            <div class="col-auto">
                <i class="fas fa-traffic-light pt-2" style="font-size: 1.7em"></i>
            </div>
            <div class="col-md-2 pt-1">
                <button type="button" :style="buttonStyle" class="btn btn-primary border-0" @click="toggleColorEffect()">{{ (!colorEffect ? 'Start' : 'Stop ') }}</button>
            </div>

        </div>

    </div>
</template>

<script>
import axios from 'axios';

export default {

    data() {
        return {
            intervalId: null,
            fetching: false,
            testColor: 'red',
            colorEffect: false,
            colorIndex: null,
            colorCycle: [
                [0.7, 0.28],
                [0.2, 0.7],
                [0.15, 0.05]
            ],
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
        buttonStyle: function () {
            let style = {}
            if (this.colorIndex === 1 && this.colorEffect === true) {
                style = {'background-color' : '#bf4747'}
            } else if (this.colorIndex === 2 && this.colorEffect === true) {
                style = {'background-color' : '#52a752'}
            } else if (this.colorIndex === 0 && this.colorEffect === true) {
                style = {'background-color' : '#3a3aa5'}
            }
            return style
        }
    },
    mounted() {
        this.getLightState();
    },
    methods: {
        toggleColorEffect: function () {
            let t = this
            this.colorEffect = this.colorEffect === false;
            if (this.colorEffect === true) {
                t.colorIndex = 0;
                this.intervalId = setInterval(function () {
                    t.toggleColor(t.colorIndex)
                    t.colorIndex++
                    if (t.colorIndex == 3) {
                        t.colorIndex = 0;
                    }
                }, 500);
            } else {
                clearInterval(this.intervalId);
            }


        },
        toggleColor: function (colorIndex) {
            let data = {
                'xy': null
            }
            data['xy'] = this.colorCycle[colorIndex]
            if (data['xy'] != null) {
                axios({
                    method: ('post'),
                    url: this.lightSwitchEndpoint.replace('_id_', '1'),
                    data: data
                }).then((response) => {
                    if (response.status == 200) {
                    }
                    return response;
                }).catch((response) => {
                    console.log(response);
                    return false;
                });
            }

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
