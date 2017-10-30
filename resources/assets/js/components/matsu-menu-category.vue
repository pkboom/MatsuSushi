<template>
	<div class="item menuName">
		<a data-toggle="collapse" data-parent="#menuAccordion" :href="'#menuAccordion'+count" aria-expanded="false" :aria-controls="'menuAccordion'+count" :ref="'menuSubA'+count">
			{{ subcategoryitem.name }}
		</a>
		<hr>
		<div :id="'menuAccordion'+count" class="collapse" role="tabpanel" :ref="'menuSubClass'+count">
			<p class="mb-3">
				<matsu-menux v-for="(value, index) in subcategoryitem.data" :key="index" :title="value.title" :price="value.price" :descript="value.descript"  @applied="onOrderMenuCategory"></matsu-menux>
			</p>
		</div>
	</div>
</template>

<script>
export default {
	props: [ 'count', 'subcategoryitem'],

	mounted() {
		// console.log(this.$refs);

		if ( "menuSubA0" in this.$refs ) {
			// 1st item among subcategoryitems
			this.$refs.menuSubA0.setAttribute("aria-expanded", "true");
			this.$refs.menuSubClass0.setAttribute("class", "collapse show");
		}
	},

	methods: {
		onOrderMenuCategory(item) {                
			// console.log('place an order');
			
            // place an order
            this.$emit('applied', {
            	title: item.title,
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