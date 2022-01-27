<template>
    <div class="text-white mb-8">
        <div class="places-input text-gary-800">
            <input type="text" class="w-full">
        </div>
        <div class="weather-container font-sans w-128 max-w-lg rounded-lg overflow-hidden bg-gray-900 shadow-lg
        mt-4">
            <div class="current-weather flex items-center justify-between px-6 py-8">
                <div class="flex items-center">
                    <div>
                        <div class="text-6xl font-semibold ">{{ currentTemperature.actual }}°C</div>
                        <div>Feels like {{ currentTemperature.feels }}°C</div>
                    </div>
                    <div class="mx-5">
                        <div class="font-semibold">{{ currentTemperature.summary }}</div>
                        <div>{{ location.name }}</div>
                    </div>
                </div>
                <div><canvas ref="iconCurrent" id="iconCurrent" width="128" height="128"></canvas></div>
            </div> <!-- end current-container -->
            <div class="future-weather text-sm bg-gray-800 px-6 py-8 overflow-hidden">
                <div v-for="item in daily"
                     :key="item.date"
                     class="flex items-center"

                >
                    <div class="w-1/6 text-lg text-gray-200">
                        {{
                        new Date( item.date + 'T00:00:00.000Z').toLocaleString('en-us', {  weekday: 'long' }) }}</div>
                    <div class="w-4/6 px-4 flex items-center">
                        <div>icon</div>
                        <div class="ml-3">Cloudy with a...</div>
                    </div>
                    <div class="w-1/6 text-right">
                        <div>5°C</div>
                        <div>-2°C</div>
                    </div>
                </div>

            </div> <!-- end future-container -->
        </div> <!-- end weather-container -->
    </div>
</template>

<script>
    export default {
        mounted() {
             this.fetchData()
        },
        data(){
            return{
                currentTemperature:{
                    actual:'',
                    feels: '',
                    summary: '',
                    icon: '',
                },
                daily: [],
                location: {
                    name : 'North Vancouver, Canada',
                    lat : 49.316666,
                    lng : -123.066666,
                }
            }
        },
        methods: {
            fetchData(){
                var skycons = new Skycons({'color': 'white'});
                fetch(`/api/weather?lat=${this.location.lat}&lng=${this.location.lng}`)

            .then(response => response.json())
            .then(data => {
                console.log(data);
                this.currentTemperature.actual = Math.round(data.current.temp_c)
                this.currentTemperature.feels = Math.round(data.current.feelslike_c)
                this.currentTemperature.summary = data.current.condition.text
                this.currentTemperature.icon = this.toKebabCase(data.current.condition.text)
                //console.log.()
                this.daily = data.forecast.forecastday

                if(data.current.is_day == 1){
                    skycons.add("iconCurrent", this.currentTemperature.summary+'-day');
                    skycons.play()
                }else{
                    skycons.add("iconCurrent", this.currentTemperature.summary+'-night');
                    skycons.play()
                }

            })
            },
            toKebabCase(stringToConvert){
                return stringToConvert.split(' ').join('-')
            }
        }
    }
</script>
