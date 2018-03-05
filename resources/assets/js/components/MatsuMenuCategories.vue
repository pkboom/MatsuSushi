<template>
	<div class="item menuName">
		<a data-toggle="collapse" data-parent="#menuAccordion" :href="'#menuAccordion'+index" aria-expanded="false" :aria-controls="'menuAccordion'+index" :ref="'menuSubA'+index">
			{{ data.name }}
		</a>
		<hr>
		<div :id="'menuAccordion'+index" class="collapse" role="tabpanel" :ref="'menuSubClass'+index">
			<p class="mb-3">
				<div v-for="menu in data.menu">
					<matsu-menu-items :data="menu" @order="ordered"></matsu-menu-items>
				</div>
			</p>
		</div>
	</div>
</template>

<script>
	import MatsuMenuItems from './MatsuMenuItems.vue';

	export default {
		props: [ 'data', 'index'],

		components: { MatsuMenuItems },

		mounted() {
			if ( "menuSubA0" in this.$refs ) {
				// 1st item among subcategoryitems
				this.$refs.menuSubA0.setAttribute("aria-expanded", "true");
				this.$refs.menuSubClass0.setAttribute("class", "collapse show");
			}
		},

		methods: {
			ordered(item) {                
				this.$emit('order', {
					name: item.name,
					price: item.price,
					quantity: 1
				});
			}
		}
	}
</script>

<style>

.menuName > a {
  font-size: 20px;
  color: #333;
  text-decoration: none;
  text-transform: uppercase;
}

.menuName > hr {
  border-color: #333;
}

</style>