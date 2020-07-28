<template>
  <admin-layout title="Reservations">
    <div class="mb-8">
      <breadcrumb name="Reservations" />
    </div>
    <div class="mb-6 flex justify-between items-center">
      <search-filter
        v-model="form.search"
        class="w-full max-w-lg mr-4"
        :filter-show="false"
        @reset="reset"
      />
      <inertia-link class="btn" :href="$route('admin.reservations.create')">
        <span>Create</span>
        <span class="hidden md:inline">Reservation</span>
      </inertia-link>
    </div>
    <div class="bg-white rounded shadow overflow-x-auto">
      <table class="w-full">
        <tr>
          <th class="text-left px-6 pt-6 pb-4 font-bold whitespace-no-wrap">
            Name
          </th>
          <th class="text-left px-6 pt-6 pb-4 font-bold whitespace-no-wrap">
            Phone
          </th>
          <th class="text-left px-6 pt-6 pb-4 font-bold whitespace-no-wrap">
            People
          </th>
          <th class="text-left px-6 pt-6 pb-4 font-bold whitespace-no-wrap">
            Reserved At
          </th>
          <th
            class="text-left px-6 pt-6 pb-4 font-bold whitespace-no-wrap"
            colspan="2"
          >
            Created At
          </th>
        </tr>
        <tr
          v-for="reservation in reservations.data"
          :key="reservation.id"
          class="hover:bg-gray-100 focus:bg-gray-100 cursor-pointer"
          @click="
            $inertia.visit($route('admin.reservations.edit', reservation.id))
          "
        >
          <td class="border-t px-6 py-4 whitespace-no-wrap">
            {{ reservation.name }}
          </td>
          <td class="border-t px-6 py-4 whitespace-no-wrap">
            {{ reservation.phone }}
          </td>
          <td class="border-t px-6 py-4 whitespace-no-wrap">
            {{ reservation.people }}
          </td>
          <td class="border-t px-6 py-4 whitespace-no-wrap">
            {{ reservation.reserved_at }}
          </td>
          <td class="border-t px-6 py-4 whitespace-no-wrap">
            {{ reservation.created_at }}
          </td>
          <td class="border-t px-4 align-middle w-min">
            <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
          </td>
        </tr>
        <tr v-if="reservations.data.length === 0">
          <td class="border-t px-6 py-4" colspan="6">No reservations found.</td>
        </tr>
      </table>
    </div>
    <pagination :links="reservations.links" />
  </admin-layout>
</template>

<script>
export default {
  props: {
    filters: Object,
    reservations: Object,
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
          'admin.reservations',
          Object.keys(query).length ? query : { remember: 'forget' }
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
