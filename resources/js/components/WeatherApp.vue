<template>
    <div class="text-white mb-8">
        <div class="places-input text-gary-800">
            <input type="search" id="address" class="form-control" placeholder="Where are we going?" />

            <p>Selected: <strong id="address-value">none</strong></p>
        </div>
        <div class="weather-container font-sans w-128 max-w-lg rounded-lg overflow-hidden bg-gray-900 shadow-lg
        mt-4">
            <div class="current-weather flex items-center justify-between px-6 py-8">
                <div class="flex items-center">
                    <div>
                        <div class="text-6xl font-semibold ">{{ currentTemperature.actual }}°C</div>
                        <div>Feels like {{ currentTemperature.feels }}°C</div>
                        <div class="font-semibold">{{ currentTemperature.summary }}</div>
                        <div>{{ location.name }}</div>
                    </div>
                </div>
                <div><canvas ref="iconCurrent" id="iconCurrent" width="128" height="128"></canvas></div>
            </div> <!-- end current-container -->
            <div class="future-weather text-sm bg-gray-800 px-6 py-8 overflow-hidden">
                <div v-for="(item, index) in daily"
                     :key="item.date"
                     class="flex items-center"
                     :class="{ 'mt-4' : index > 0 , 'font-semibold' : index == 0 }"

                     v-if="index < 5"
                >
                    <div class="w-1/6 text-lg text-gray-200">
                        {{ toDayOfWeek(item.date)  }}</div>
                    <div class="w-4/6 px-4 flex items-center">
                        <div><canvas :id="`icon${index+1}`" :data-icon="toKebabCase(item.day.condition.text)"
                        width="24" height="24"></canvas></div>
                        <div class="ml-3">{{ item.day.condition.text }}</div>
                    </div>
                    <div class="w-1/6 text-right">
                        <div>{{ Math.round(item.day.maxtemp_c) }}°C</div>
                        <div>{{ Math.round(item.day.mintemp_c) }}°C</div>
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

            var placesAutocomplete = places({
                appId: '1W2YBYGWDO',
                apiKey: '61fb33d4ad49e4b0d4a3a33a4cece0fc',
                container: document.querySelector('#address')
            }).configure({
                type: 'city',
                aroundLatLngViaIP: false
            });

            var $address = document.querySelector('#address-value')
            placesAutocomplete.on('change', function(e) {
                $address.textContent = e.suggestion.value

                this.location.name = `${e.suggestion.name}, ${e.suggestion.country}`
                this.location.lat = e.suggestion.latlng.lat
                this.location.lng = e.suggestion.latlng.lng


            });

            placesAutocomplete.on('clear', function() {
                $address.textContent = 'none';
            });

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

                this.$nextTick(() =>{
                    skycons.add('icon1', document.getElementById('icon1').getAttribute(('data-icon'))+'-day')
                    skycons.add('icon2', document.getElementById('icon2').getAttribute(('data-icon'))+'-day')
                    skycons.add('icon3', document.getElementById('icon3').getAttribute(('data-icon'))+'-day')

                    skycons.play()
                })

            })
            },
            toKebabCase(stringToConvert){
                return stringToConvert.split(' ').join('-')
            },
            toDayOfWeek(dateString){

                const days = ['SUN','MON','TUE','WED','THU','FRI','SAT']
                var d = new Date(dateString);


                return days[d.getDay()]
            }
        }
    }
</script>
