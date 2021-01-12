<template>
  <div class="w-full h-full p-1 lg:p-4">
    <inertia-link
      class="text-indigo-500 text-xs underline"
      :href="$route('admin.dashboard')"
    >
      Go to dashboard
    </inertia-link>
    <div class="grid gap-2 grid-cols-7 mt-4 text-sm">
      <div
        v-for="day in daysOfWeek"
        :key="day"
        class="bg-matsu-blue-50 p-4 rounded"
      >
        {{ day }}
      </div>
      <div
        v-for="(tips, date) in dates"
        :key="date"
        class="relative bg-matsu-blue-50 p-4 rounded space-y-2"
      >
        <div v-if="today === date" class="text-red-500 font-bold">
          {{ date }}
        </div>
        <div v-else class="text-gray-500">
          {{ date }}
        </div>
        <div v-if="tips.tip" class="space-y-2">
          <div>Total Tip: ${{ tips.tip }}</div>
          <div>Restaurant: ${{ tips.restaurantTip }}</div>
          <div>Delivery: ${{ tips.deliveryTip }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    dates: Object,
    today: String,
  },
  data() {
    return {
      daysOfWeek: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
    }
  },
}
</script>
