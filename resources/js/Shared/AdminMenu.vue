<template>
  <div class="font-heading font-semibold">
    <div class="mb-4">
      <menu-item
        name="Home"
        url="admin/dashboard"
        :link="$route('admin.dashboard')"
        icon="dashboard"
      />
    </div>
    <div class="mb-4">
      <menu-item
        name="Reservations"
        url="admin/reservations*"
        :link="$route('admin.reservations')"
        icon="calendar"
      />
    </div>
    <div class="mb-4">
      <menu-item
        name="Transactions"
        url="admin/transactions*"
        :link="$route('admin.transactions')"
        icon="credit"
      />
    </div>
    <div class="mb-4">
      <menu-item
        name="Categories"
        url="admin/categories*"
        :link="$route('admin.categories')"
        icon="apple"
      />
    </div>
    <div class="mb-4">
      <menu-item
        name="Items"
        url="admin/items*"
        :link="$route('admin.items')"
        icon="coffee"
      />
    </div>
    <div class="mb-4">
      <menu-item
        name="Images"
        url="admin/images*"
        :link="$route('admin.images')"
        icon="document"
      />
    </div>
    <div class="mb-4">
      <menu-item
        name="Tips"
        url="admin/tips"
        :link="$route('admin.tips')"
        icon="quiz"
      />
    </div>
    <div class="mb-4">
      <menu-item
        name="Promotion"
        url="admin/promotion"
        :link="$route('admin.promotion')"
        icon="book"
      />
    </div>
    <div class="mb-4">
      <menu-item
        name="Settings"
        url="admin/settings"
        :link="$route('admin.settings')"
        icon="add"
      />
    </div>
  </div>
</template>
