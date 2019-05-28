<template>
  <div>
    <locator-component @Markers="SetMarkers"></locator-component>

    Navigation points
    <span v-for="(points, type) in Markers"> 
      <strong> {{ type }} </strong>
      {<small v-for="(point, id) in points"> {{ point }} </small>}
    </span> 

    <GmapMap
        :center="{lat:Markers.start.lat, lng:Markers.start.lng}"
        :zoom="2"
        map-type-id="terrain"
        style="width: 100%; height: 300px">

        <GmapMarker
          :key="index"
          v-for="(m, index) in Markers"
          :position="m.position"
          :clickable="true"
          :draggable="true"
          @click="center=m.position"
          />

    </GmapMap>

  </div>
</template>

<script>
  export default {
    name: "Map",
    mounted () {
      //geo locate user
      //set Markers start
    },
    methods: {
      SetMarkers(input){
        this.Markers = input;
        //genorate route between markers
       }
    },
    data: function (){
      return {
        Markers: {start: {lat:0, lng:0}, end: {lat:0, lng:0}, },
      };
    }
  }
</script>