<!-- components/timesheet.vue -->

<template>
    <view class="timesheet-container">
        <text>Id: {{ timesheet.id }}</text>
        <text>Employee id: {{ timesheet.employeeId }}</text>
    </view>
</template>

<script>
export default {
  props: {
    timesheet: {
      Type: Object
    }
  }
};
</script>

<style>
.timesheet-container {
  flex: 1;
  margin-bottom: 30;
}
</style>