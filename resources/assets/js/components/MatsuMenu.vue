<template>
    <div class="container menu">
		<h2>Matsu Sushi Menu</h2>
		<div id="menuAccordion" data-children=".item">
			<div v-for="(category, index) in categories" :key="index">
				<matsu-menu-categories :data="category" :index="index" @order="ordered"></matsu-menu-categories>
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
