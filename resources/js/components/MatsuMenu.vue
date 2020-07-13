<template>
    <div class="container">
		<div class="w-2/3 mx-auto">
			<h2 class="mt-8 py-8 px-2 font-bold">Matsu Sushi Menu</h2>
			<div v-for="(category, index) in categories" :key="index">
				<matsu-menu-categories :data="category" @order="ordered"></matsu-menu-categories>
			</div>
		</div>
    </div>
</template>

<script>
    import MatsuMenuCategories from './MatsuMenuCategories.vue';

	export default {
        data() {
            return {
                categories: '',
            }
		},
		
		components: {MatsuMenuCategories},

        created() {
			axios.get('/menu/categories')
				.then(({data}) => this.categories = data);
        },
        
		methods: {
			ordered(order) {
				Orders.place(order);
				
				// update cart badges
				document.getElementById("cart-badge").textContent = Orders.count();

				flash(order.name + ' ordered.');
			}
		}
    }
</script>
