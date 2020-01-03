<!-- screens/LoginScreen.vue -->

<template>
  <view class="container">
    <text>Please login</text>
    <button title="Submit" @press="authenticate"></button>
  </view>
</template>

<script>
export default {
  props: {
    navigation: {
      type: Object
    }
  },
  methods: {
    authenticate() {
      this.navigation.navigate("Home");
    }
  }
}
</script>