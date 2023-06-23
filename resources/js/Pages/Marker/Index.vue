<template>
    <div>
        <div>
            <form @submit.prevent="store" class="w-full max-w-lg pt-8">
                <div class="flex flex-wrap -mx-3 mb-6">

                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Longitude
                        </label>
                        <input v-model="longitude" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-500
                        rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                               id="grid-last-name" type="text" placeholder="00.0000000">
                        <p id="error1" class="text-red-500 text-xs italic mb-3"></p>
<!--                        31.5055721-->
<!--                        <p v-if="errors_axios.longitude" class="text-red-500 text-xs italic mb-3">{{ errors_axios.longitude }}</p>-->

                    </div>

                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="grid-first-name">Latitude</label>
                        <input v-model="latitude" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-500
                                hover:border-gray-500 rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white"
                                id="grid-first-name" type="text" placeholder="00.0000000">
                        <p id="error2" class="text-red-500 text-xs italic mb-3"></p>
<!--                        50.8050523-->
<!--                        <p v-if="this.errors_axios.latitude" class="text-red-500 text-xs italic mb-3">{{ errors.latitude }}</p>-->

                    </div>

                    <div class="w-full md:w-1/2 px-3">
                        <button class="flex-shrink-0 mt-2 bg-teal-500 hover:bg-teal-700 border-teal-500
                        hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded" type="submit">Set coordinate</button>
                    </div>
                </div>

            </form>
        </div>

<!--        <div v-if="markers.length > 0">-->
<!--            <div v-for="marker in markers">-->
<!--                Id {{ marker.id }}, Latitude: {{ marker.latitude }}, Longitude {{ marker.longitude }}<br>-->
<!--            </div>-->
<!--        </div>-->

        <div id="map" style="width: 100%; height: 500px;"></div>
        <pre id="info"></pre>
    </div>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";
import mapBoxGL from "mapbox-gl";

export default {
    name: "Index",
    layout: MainLayout,
    props: [
        'markers',
        'errors',
    ],

    mounted() {
        mapBoxGL.accessToken = 'pk.eyJ1Ijoia2VwbGVyNjcwIiwiYSI6ImNsajVxeTB3aDAxODQzZnFwZXZzY2JybncifQ._iccjG5m-lsaVxhwqx4QJQ';
        this.map = new mapBoxGL.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v12',
            center: [30.52428, 50.45056],
            zoom: 9
        });

        // const coordinates = [
        //     { lng: 31.5055721, lat: 50.8450523 },
        //     { lng: 31.5055721, lat: 50.8050523 },
        // ];
    },

    data() {
        return {
            latitude: null,
            longitude: null,
            errors_axios: null
        }
    },

    created() {
        window.Echo.channel('store_marker')
            .listen('.store_marker', res => {
                this.markers.unshift(res.marker)

                const marker = new mapBoxGL.Marker({
                    color: "#000000",
                    draggable: false,
                })
                    .setLngLat([res.marker.longitude, res.marker.latitude])
                    .addTo(this.map);

                    setTimeout(() => {
                        marker.remove();
                    }, 60000);
            })
    },

    methods: {
        store() {
            //this.$inertia.post('/markers', {latitude: this.latitude, longitude: this.longitude});
            axios.post('/markers', {latitude: this.latitude, longitude: this.longitude})
                .then(res => {

                    //this.markers.unshift(res.data);
                    //this.markers.push(res.data);

                    const marker = new mapBoxGL.Marker({
                        color: "#000000",
                        draggable: false,
                    })
                        .setLngLat([res.data.longitude, res.data.latitude])
                        .addTo(this.map);

                    setTimeout(() => {
                        marker.remove();
                    }, 60000);

                    this.latitude = null;
                    this.longitude = null;

                    document.getElementById("error1").innerText = '';
                    document.getElementById("error2").innerText = '';
                })
                .catch(error => {
                    //console.log(error.response.data.errors.latitude);
                    let error_long = error.response.data.errors.longitude;
                    let error_lat = error.response.data.errors.latitude;

                    if (typeof error_long == 'undefined') {
                        document.getElementById("error1").innerText = '';
                    }
                    else if (error_long) {
                        document.getElementById("error1").innerText = error.response.data.errors.longitude;
                    }

                    if (typeof error_lat == 'undefined') {
                        document.getElementById("error2").innerText = '';
                    }
                    else if (error_lat) {
                        document.getElementById("error2").innerText = error.response.data.errors.latitude;
                    }
                })
            ;
        }
    }
}
</script>

<style scoped>
/*#info {*/
/*    display: table;*/
/*    position: relative;*/
/*    margin: 0px auto;*/
/*    word-wrap: anywhere;*/
/*    white-space: pre-wrap;*/
/*    padding: 10px;*/
/*    border: none;*/
/*    border-radius: 13px;*/
/*    font-size: 12px;*/
/*    text-align: center;*/
/*    color: #222;*/
/*    background: #fff;*/
/*}*/
</style>
