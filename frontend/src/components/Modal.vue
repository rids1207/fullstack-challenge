<template>
    <div class="modal" v-if="show">
        <div class="modal-content">
            <button class="close" @click="$emit('close')">x</button>
            <div class="modal-header">
                <h1>Weather Details of {{ user.name }}</h1>

            </div>
            <div class="modal-body">
                <div class="main-weather-section">
                    <h3>Weather</h3>
                    <ul>
                        <li>Main: {{ JSON.parse(user.user_weather.weather_data).weather[0].main }}</li>
                        <li>Description: {{ JSON.parse(user.user_weather.weather_data).weather[0].description }}</li>
                        <li>Base: {{ JSON.parse(user.user_weather.weather_data).base }}</li>

                        <li>Main: {{ JSON.parse(user.user_weather.weather_data).main.temp }}&#8451</li>
                        <li>Feels Like: {{ JSON.parse(user.user_weather.weather_data).main.feels_like }}</li>
                        <li>Temp Min: {{ JSON.parse(user.user_weather.weather_data).main.temp_min }}&#8451</li>
                        <li>Temp Max: {{ JSON.parse(user.user_weather.weather_data).main.temp_max }}&#8451</li>
                        <li>Pressure: {{ JSON.parse(user.user_weather.weather_data).main.pressure }}</li>
                    </ul>
                </div>

                <div class="main-weather-section">
                    <h3>Wind</h3>
                    <ul>
                        <li>wind speed: {{ JSON.parse(user.user_weather.weather_data).wind.speed }}</li>
                        <li>wind deg: {{ JSON.parse(user.user_weather.weather_data).wind.deg }}</li>
                    </ul>
                </div>

                <div class="main-weather-section">
                    <h3>Clouds</h3>
                    <ul>
                        <li>All: {{ JSON.parse(user.user_weather.weather_data).clouds.all }}</li>
                    </ul>
                </div>

                <div class="main-weather-section">
                    <h3>Sys</h3>
                    <ul>
                        <li>Country: {{ JSON.parse(user.user_weather.weather_data).sys.country }}</li>
                        <li>Sunrise: {{ formatTime(JSON.parse(user.user_weather.weather_data).sys.sunrise) }}</li>
                        <li>Sunset: {{ formatTime(JSON.parse(user.user_weather.weather_data).sys.sunset) }}</li>

                        <li>Timezone : {{ JSON.parse(user.user_weather.weather_data).timezone }}</li>
                        <li>Name : {{ JSON.parse(user.user_weather.weather_data).name }}</li>
                        <li>Cod : {{ JSON.parse(user.user_weather.weather_data).cod }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
  
<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
    name: 'Modal',
    props: {
        show: {
            type: Boolean,
            required: true,
        },
        user: {
            type: Object,
            required: true,
        }
    },
    methods: {
        formatTime(timestamp) {
            const date = new Date(timestamp * 1000);
            const hours = date.getHours();
            const minutes = "0" + date.getMinutes();
            const seconds = "0" + date.getSeconds();
            let period = hours >= 12 ? "PM" : "AM";
            let hours12 = hours % 12 || 12;
            let formattedHours = ("0" + hours12).slice(-2);
            return formattedHours + ":" + minutes.substr(-2) + ":" + seconds.substr(-2) + " " + period;
        },
        getDateInTimezone(timestamp, timezoneOffset) {
            const timestampInMilliseconds = timestamp * 1000; // Convert seconds to milliseconds
            const timezoneOffsetInMilliseconds = timezoneOffset * 60 * 1000; // Convert minutes to milliseconds
            const date = new Date(timestampInMilliseconds + timezoneOffsetInMilliseconds);
            return date;
        }

    },
});
</script>
  
<style>
/* Modal container */
.main-weather-section {
    float: left;
    width: 100%;
}

.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0, 0, 0);
    background-color: rgba(0, 0, 0, 0.4);
}

/* Modal content */
.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    min-height: 500px;
}

ul {
    width: 100%;
}

ul li {
    width: 25%;
    float: left;
    list-style: none;
}

/* Close button */
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;

}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
</style>