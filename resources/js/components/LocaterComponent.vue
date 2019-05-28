<template>
    <div>
        <div class="card-body container">
            <form @submit="formSubmit">
                <input type="text" class="" v-model="postcodeSearch">
                <button class="btn btn-success">Search</button>
            </form>
            <h1>
                <strong>{{postcode}}</strong> 
                <small>
                    {{distance}}
                    <br />
                    {{lat}} {{lng}}
                </small> 
            </h1>
        </div>
        <div class="row container"> 
            <div class="col-4" v-for="(times, day) in opening_times"> 
                <strong> {{ day }} </strong>
                <br />
                <small class="col-6" v-for="(time, id) in times"> {{ time }} </small>
            </div> 
        </div>
    </div>
</template>

<script>
    export default {
        name: "Locater",
        mounted() {},
        data: function (){
            return {
                postcodeSearch:'BB7 3AZ',//get from config()
                output: '',
                opening_times: '',
                lat: '',
                lng: '',
                postcode: '',
                distance: '',
            };
        },
        methods: {
            formSubmit(e) {
                e.preventDefault();
                let currentObj = this;
                axios.get('/api/GetNearestLocation', {//get from route()
                    params: {
                        postcode: this.postcodeSearch,
                    }
                })
                .then(function (response) {
                    let data = response.data.data;

                    currentObj.postcode = data.postcode;
                    currentObj.distance = data.distance;
                    currentObj.lat = data.end.lat;
                    currentObj.lng = data.end.lng;
                    currentObj.opening_times = data.opening_times;
                    currentObj.$emit('Markers', {start: data.start,  end: data.end } );
                })
                .catch(function (error) {
                    currentObj.output = error;
                });

            }
        }
    }
</script>

