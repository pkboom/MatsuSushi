<template>
  <admin-layout title="Transactions">
    <div class="mb-8">
      <breadcrumb name="Transactions" />
    </div>
    <div class="mb-6 flex justify-between items-center">
      <search-filter
        v-model="form.search"
        class="w-full max-w-lg mr-4"
        :filter-show="false"
        @reset="reset"
      />
    </div>
    <div class="bg-white rounded shadow overflow-x-auto">
      <table class="w-full">
        <tr>
          <th class="text-left px-6 pt-6 pb-4 font-bold whitespace-no-wrap">
            Id
          </th>
          <th class="text-left px-6 pt-6 pb-4 font-bold whitespace-no-wrap">
            Name
          </th>
          <th class="text-left px-6 pt-6 pb-4 font-bold whitespace-no-wrap">
            Total
          </th>
          <th class="text-left px-6 pt-6 pb-4 font-bold whitespace-no-wrap">
            Tip
          </th>
          <th class="text-left px-6 pt-6 pb-4 font-bold whitespace-no-wrap">
            Delivery Tip
          </th>
          <th class="text-left px-6 pt-6 pb-4 font-bold whitespace-no-wrap">
            Type
          </th>
          <th class="text-left px-6 pt-6 pb-4 font-bold whitespace-no-wrap">
            Status
          </th>
          <th
            class="text-left px-6 pt-6 pb-4 font-bold whitespace-no-wrap"
            colspan="2"
          >
            Created At
          </th>
        </tr>
        <tr
          v-for="transaction in transactions.data"
          :key="transaction.id"
          class="hover:bg-gray-100 focus:bg-gray-100 cursor-pointer"
          @click="
            $inertia.visit($route('admin.transactions.show', transaction.id))
          "
        >
          <td class="border-t px-6 py-4 whitespace-no-wrap">
            {{ transaction.id }}
          </td>
          <td class="border-t px-6 py-4 whitespace-no-wrap">
            {{ transaction.name }}
          </td>
          <td class="border-t px-6 py-4 whitespace-no-wrap">
            $ {{ transaction.total }}
          </td>
          <td class="border-t px-6 py-4 whitespace-no-wrap">
            {{
              transaction.status === status.succeeded
                ? '$' + transaction.tip
                : ''
            }}
          </td>
          <td class="border-t px-6 py-4 whitespace-no-wrap">
            {{
              transaction.status === status.succeeded &&
              transaction.type === type.delivery
                ? '$' + transaction.delivery_tip
                : ''
            }}
          </td>
          <td class="border-t px-6 py-4 whitespace-no-wrap">
            {{ transaction.type }}
          </td>
          <td class="border-t px-6 py-4 whitespace-no-wrap">
            {{ transaction.status }}
          </td>
          <td class="border-t px-6 py-4 whitespace-no-wrap">
            {{ transaction.formattedCreatedAt }}
          </td>
          <td class="border-t px-4 align-middle w-min">
            <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
          </td>
        </tr>
        <tr v-if="transactions.data.length === 0">
          <td class="border-t px-6 py-4" colspan="7">No transactions found.</td>
        </tr>
      </table>
    </div>
    <pagination :links="transactions.links" />
  </admin-layout>
</template>

<script>
export default {
  props: {
    filters: Object,
    transactions: Object,
    status: Object,
    type: Object,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
      },
    }
  },
  watch: {
    form: {
      handler: _.throttle(function() {
        let query = _.pickBy(this.form)

        let url = this.$route(
          'admin.transactions',
          Object.keys(query).length ? query : { remember: 'forget' },
        )
        this.$inertia.replace(url)
      }, 300),
      deep: true,
    },
  },
  methods: {
    reset() {
      this.form = _.mapValues(this.form, () => null)
    },
  },
}
</script>
