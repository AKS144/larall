<template>
  <div class="container">
    <h2>Resturants</h2>
    <div id="map" style="width: 500px; height: 500px">
      <gmap-map
        :center="mapCenter"
        :zoom="7"
        style="width: 100%; height: 320px"
        @click="handleMapClick"
      >
        <gmap-info-window
          :options="infoWindowOptions"
          :position="infoWindowPosition"
          :opened="infoWindowOpened"
          @closeclick="handleInfoWindowClose"
        >
          <div class="info-window">
            <h2 v-text="activeResturant.name"></h2>
            <h5 v-text="'Hours: ' + activeResturant.hours"></h5>
            <p v-text="activeResturant.address"></p>
            <p
              v-text="activeResturant.city + ', ' + activeResturant.state"
            ></p>
          </div>
        </gmap-info-window>
        <gmap-marker
          v-for="r in resturants"
          :key="r.id"
          :position="getPosition(r)"
          :clickable="true"
          :draggable="false"
          @click="handleMarkerClicked(r)"
        >
        </gmap-marker>
      </gmap-map>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      resturants: [],
      infoWindowOptions: {
        pixelOffset: {
          width: 0,
          height: -35,
        },
      },
      activeResturant: {},
      infoWindowOpened: false,
    };
  },

  created() {
    axios
      .get("/api/resturants")
      .then((response) => {
        this.resturants = response.data;
      })
      .catch((error) =>
        console.error(error)
      ); /*
    axios
      .get("/api/restaurants")
      .then((response) => (this.restaurants = response.data))
      .catch((error) => console.error(error));*/
  },

  methods: {
    getPosition(r) {
      return {
        lat: parseFloat(r.latitude),
        lng: parseFloat(r.longitude),
      };
    },

    handleMarkerClicked(r) {
      this.activeResturant = r;
      this.infoWindowOpened = true;
    },
    handleInfoWindowClose() {
      this.activeResturant = {};
      this.infoWindowOpened = false;
    },
    handleMapClick(e) {
      this.resturants.push({
        name: "Placeholder",
        hours: "00:00am-00:00pm",
        city: "Vasco",
        state: "Goa",
        latitude: e.latLng.lat(),
        longitude: e.latLng.lng(),
      });
    },
  },

  computed: {
    mapCenter() {
      if (!this.resturants.length) {
        return {
          lat: +10,
          lng: +10,
        };
      }
      //for each of the resturant avialable
      //calculate center point for all of them
      //calculate median point
      //get boundind box and zoom level based on largest/smallest
      return {
        lat: parseFloat(this.resturants[0].latitude),
        lng: parseFloat(this.resturants[0].longitude),
      };
    },

    infoWindowPosition() {
      return {
        lat: parseFloat(this.activeResturant.latitude),
        lng: parseFloat(this.activeResturant.longitude),
      };
    },
  },
};
</script>

