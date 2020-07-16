<template>
  <admin-layout title="Transaction">
    <div class="mb-8">
      <breadcrumb
        :previous-url="$route('admin.transactions')"
        previous-name="Transaction"
        :name="transaction.name"
      />
    </div>
    <div class="bg-white max-w-2xl overflow-hidden rounded shadow">
      <div class="p-8 rounded space-y-4">
        <div>Stripe Id: {{ transaction.stripe_id }}</div>
        <div>Name: {{ transaction.name }}</div>
        <div>Email: {{ transaction.email }}</div>
        <div>Phone: {{ transaction.phone }}</div>
        <div>Address: {{ transaction.address }}</div>
        <div>Subtotal: $ {{ transaction.subtotal }}</div>
        <div>Tip: $ {{ transaction.tip }}</div>
        <div>Total: $ {{ transaction.total }}</div>
        <div>Message: {{ transaction.message }}</div>
        <div>Status: {{ transaction.status }}</div>
        <div>Created at: {{ transaction.created_at }}</div>
      </div>
    </div>
  </admin-layout>
</template>

<script>
export default {
  props: {
    transaction: Object,
  },
  data() {
    return {
      sending: false,
    }
  },
  methods: {},
}
</script>
