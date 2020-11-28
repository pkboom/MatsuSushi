<template>
  <front-layout title="Thank you">
    <div
      class="my-8 p-8 max-w-2xl w-full mx-auto space-y-4 rounded bg-matsu-blue-50 shadow-lg"
    >
      <div class="text-xl border-b-2 border-gray-400 py-2">
        Thank you!
      </div>
      <div class="space-y-4">
        <div>
          <span class="text-gray-500">Order number:</span>
          {{ transaction.id }}
        </div>
        <div><span class="text-gray-500">Items:</span></div>
        <div class="space-y-4">
          <div v-for="(item, key) in groupItems()" :key="key" class="space-y-2">
            <div>
              {{ item.item.name }}
              <span v-if="item.count > 1" class="ml-2">
                &times; {{ item.count }}
              </span>
            </div>
            <div class="hidden sm:block text-gray-400 text-sm">
              {{ item.item.description }}
            </div>
          </div>
        </div>
      </div>
      <div class="space-y-4 border-t-2">
        <div class="pt-4 leading-5">
          &#10003; You will receive an email receipt shortly. If you have any
          questions, call us at
          <a
            href="tel:7057609484"
            class="whitespace-no-wrap underline text-matsu-blue-600 font-bold"
          >
            705-760-9484
          </a>
          .
        </div>
      </div>
    </div>
  </front-layout>
</template>

<script>
export default {
  props: {
    transaction: Object,
  },
  mounted() {
    localStorage.removeItem('items')

    this.$page.countInCart = 0
  },
  methods: {
    groupItems() {
      return Object.values(
        _.groupBy(this.transaction.items, item => item.name + item.description),
      )
        .map(group => ({
          count: group.length,
          item: group[0],
        }))
        .sort((a, b) => a.item.name.localeCompare(b.item.name))
    },
  },
}
</script>
