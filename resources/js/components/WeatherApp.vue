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
                        <div class="text-6xl font-semibold ">8°C</div>
                        <div>Feels like 900000°C</div>
                    </div>
                    <div class="mx-5">
                        <div class="font-semibold">Cloudy</div>
                        <div>Vancouver, Canada</div>
                    </div>
                </div>
                <div>Icon</div>
            </div> <!-- end current-container -->
            <div class="future-weather text-sm bg-gray-800 px-6 py-8 overflow-hidden">
                <div class="flex items-center">
                    <div class="w-1/6 text-lg text-gray-200">MON</div>
                    <div class="w-4/6 px-4 flex items-center">
                        <div>icon</div>
                        <div class="ml-3">Cloudy with a...</div>
                    </div>
                    <div class="w-1/6 text-right">
                        <div>5°C</div>
                        <div>-2°C</div>
                    </div>
                </div>
                <div class="flex items-center mt-8">
                    <div class="w-1/6 text-lg text-gray-200">TUE</div>
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
            console.log('Component mounted.')
        }
    }
</script>
