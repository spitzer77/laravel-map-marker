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
<!--                        <p v-if="errors_axios.longitude" class="text-red-500 text-xs italic mb-3">{{ errors_axios.longitude }}</p>-->
                    </div>

                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="grid-first-name">Latitude</label>
                        <input v-model="latitude" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-500
                                hover:border-gray-500 rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white"
                                id="grid-first-name" type="text" placeholder="00.0000000">
                        <p id="error2" class="text-red-500 text-xs italic mb-3"></p>
<!--                        <p v-if="this.errors_axios.latitude" class="text-red-500 text-xs italic mb-3">{{ errors.latitude }}</p>-->
                    </div>

                    <div class="w-full md:w-3/4 px-3">
                        <button class="flex-shrink-0 mt-2 bg-teal-500 hover:bg-teal-700 border-teal-500
                        hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded" type="submit">Set coordinate</button>
                        <span class="ml-3 text-black-600" id="time"></span>
                    </div>
                </div>
            </form>
        </div>

        <div id="map" style="width: 100%; height: 500px;"></div>
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
    },

    data() {
        return {
            latitude: null,
            longitude: null,
            interval: 60000, // interval for marker
            //errors_axios: null
        }
    },

    created() {
        window.Echo.channel('store_marker')
            .listen('.store_marker', res => {
                //this.markers.unshift(res.marker)
                this.countDown(this.getInterval(), 'time');
                this.setMarker(res.marker);
            })
    },

    methods: {
        getInterval(){
            //return 60000; // millisecond
            return this.interval; // millisecond
        },
        countDown(interval, elementId)
        {
            const addMilliseconds = (date, milliseconds) => {
                const result = new Date(date);
                result.setMilliseconds(result.getMilliseconds() + milliseconds);
                return result;
            };

            const countDownDate = addMilliseconds(new Date(), interval);

            let x = setInterval(function() {
                let now = new Date().getTime();
                let distance = countDownDate - now;

                let days = Math.floor(distance / (1000 * 60 * 60 * 24));
                let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                if (document.getElementById(elementId)) {
                    document.getElementById(elementId).innerHTML =
                        'Time to show: ' +
                        days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

                    if (distance < 0) {
                        clearInterval(x);
                        //document.getElementById("time").innerHTML = "EXPIRED";
                        document.getElementById(elementId).innerHTML = "";
                    }

                    if (distance < 10000) document.getElementById(elementId).className = 'ml-3 text-red-600';
                }
            }, 1000);
        },
        setMarker(res){
            const marker = new mapBoxGL.Marker({
                color: "#000000",
                draggable: false,
            })
                //.setLngLat([res.data.longitude, res.data.latitude])
                .setLngLat([res.longitude, res.latitude])
                .addTo(this.map);

            setTimeout(() => {
                marker.remove();
            }, this.getInterval());
        },
        store() {
            //this.$inertia.post('/markers', {latitude: this.latitude, longitude: this.longitude});
            axios.post('/markers', {latitude: this.latitude, longitude: this.longitude})
                .then(res => {

                    // for display list of data with current form data, unused in this release
                    //this.markers.unshift(res.data);
                    //this.markers.push(res.data);

                    this.countDown(this.getInterval(), 'time');
                    this.setMarker(res.data);

                    this.latitude = null;
                    this.longitude = null;
                })
                .catch(error => {
                    document.getElementById("time").innerHTML = "";
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
                });
        }
    }
}
</script>

<style scoped>
</style>
