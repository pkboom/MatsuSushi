<template>
  <admin-layout :title="transaction.name">
    <div class="mb-8">
      <breadcrumb
        :previous-url="$route('admin.transactions')"
        previous-name="Transactions"
        :name="transaction.name"
      />
    </div>
    <div class="bg-white max-w-2xl overflow-hidden rounded shadow">
      <div class="p-8 rounded space-y-4">
        <div>
          <span class="text-gray-500">Status:</span>
          {{ transaction.status }}
        </div>
        <div>
          <span class="text-gray-500">Order number:</span>
          {{ transaction.id }}
        </div>
        <div>
          <span class="text-gray-500">Stripe Id:</span>
          {{ transaction.stripe_id }}
        </div>
        <div>
          <span class="text-gray-500">Name:</span>
          {{ transaction.name }}
        </div>
        <div>
          <span class="text-gray-500">Phone:</span>
          {{ transaction.phone }}
        </div>
        <div v-if="transaction.takeout_time">
          <span class="text-gray-500">Takeout time:</span>
          {{ transaction.takeout_time }}
        </div>
        <div v-if="transaction.address">
          <span class="text-gray-500">Address:</span>
          {{ transaction.address }}
        </div>
        <div>
          <span class="text-gray-500">Subtotal:</span>
          $ {{ transaction.subtotal }}
        </div>
        <div>
          <span class="text-gray-500">Tip:</span>
          $ {{ transaction.tip }}
        </div>
        <div>
          <span class="text-gray-500">Total:</span>
          $ {{ transaction.total }}
        </div>
        <div>
          <span class="text-gray-500">Created at:</span>
          {{ transaction.formattedCreatedAt }}
        </div>
        <div>
          <span class="text-gray-500">Message:</span>
          {{ transaction.message }}
        </div>
        <div><span class="text-gray-500">Items:</span></div>
        <div class="space-y-3">
          <div
            v-for="(item, key) in transaction.items"
            :key="'item' + key"
            class="space-y-1"
          >
            <div>{{ item.name }}</div>
            <div class="text-gray-400 text-sm">{{ item.description }}</div>
          </div>
        </div>
      </div>
      <div
        v-if="transaction.name === 'Keunbae Park'"
        class="px-8 py-4 bg-gray-100 border-t border-gray-100 flex justify-end items-center space-x-6"
      >
        <div>
          <button
            class="text-blue-600 underline"
            tabindex="-1"
            type="button"
            @click="update(status.succeeded)"
          >
            Succeeded
          </button>
        </div>
        <div>
          <button
            class="text-blue-600 underline"
            tabindex="-1"
            type="button"
            @click="update(status.inprocess)"
          >
            In Process
          </button>
        </div>
        <div>
          <button
            class="text-blue-600 underline"
            tabindex="-1"
            type="button"
            @click="update(status.failed)"
          >
            Failed
          </button>
        </div>
        <div>
          <button
            class="text-blue-600 underline"
            tabindex="-1"
            type="button"
            @click="destroy()"
          >
            Delete
          </button>
        </div>
      </div>
    </div>
  </admin-layout>
</template>

<script>
export default {
  props: {
    transaction: Object,
    status: Object,
  },
  methods: {
    update(status) {
      this.$inertia.put(
        this.$route('admin.transactions.update', this.transaction.id),
        { status },
      )
    },
    destroy() {
      this.$inertia.delete(
        this.$route('admin.transactions.destroy', this.transaction.id),
      )
    },
  },
}
</script>
