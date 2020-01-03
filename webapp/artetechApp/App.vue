<!--
<script>
import axios from 'axios';

export default {
  data() {
    return {
      timesheets: []
    }
  },


  created() {
    axios.get('http://172.17.3.45:8000/api/timesheets/1')
    .then(response => {
         this.timesheets = response.data
    })
    .catch(error => {
      console.log(error);
    })
    }
}
</script>

<template>
  <view class="container">
    <text></text>
    <text>{{ timesheets }}</text>
  </view>
</template>
-->


<template>
  <app-navigator></app-navigator>
</template>

<script>
import {
  createAppContainer,
  createStackNavigator,
} from "vue-native-router";

import HomeScreen from "./screens/HomeScreen.vue";
import DetailsScreen from "./screens/DetailsScreen.vue";
import LoginScreen from "./screens/LoginScreen.vue";

const StackNavigator = createStackNavigator(
  {
    Home: HomeScreen,
    Details: DetailsScreen,
    Login: LoginScreen,
  },
  {
    initialRouteName: 'Login',
  }
);

const AppNavigator = createAppContainer(StackNavigator);

export default {
  components: { AppNavigator },
}
</script>

<style>
.container {
  background-color: white;
  align-items: center;
  justify-content: center;
  flex: 1;
}
.text-color-primary {
  color: blue;
}
</style>
