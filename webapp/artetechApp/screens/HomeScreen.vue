<!-- screens/HomeScreen.vue -->

<template>
  <view class="container">
    <text>This is the App Details screen</text>
    <button title="Go to Detail screen" @press="goToDetailsScreen"></button>
    <text>Id: {{ timesheet.id }}</text>
    <text>Employee id: {{ timesheet.employeeId }}</text>
    <text>Rate id: {{ timesheet.rateId }}</text>
    <text>Customer id: {{ timesheet.customerId }}</text>
  </view>
</template>

<script>
import axios from 'axios';
export default {
    data() {
    return {
      timesheet: []
    }
  },


  created() {
    axios.get('http://172.17.3.45:8000/api/timesheets/1')
    .then(response => {
         this.timesheet = response.data
    })
    .catch(error => {
      console.log(error);
    })
    },
  // Declare `navigation` as a prop
  props: {
    navigation: {
      type: Object
    }
  },
  methods: {
    goToDetailsScreen() {
      this.navigation.navigate("Details");
    }
  }
}
</script>