<template>
	<div style="margin-bottom: 1rem;">
		<div class="row">
			<div class="col menu-title" style="font-weight: bold">
				{{ this.name }}
			</div>
			<div class="col menu-price" align="right">
				<a href="javascript:void(0)" class="order-button" @click="onOrderMenux">{{ this.price }}</a>
			</div>
		</div>
		<div class="row">
			<div class="col menu-description">
				{{ descriptToLowerCase }}
			</div>
		</div>
	</div>		
</template>

<script>
export default {
	props: [ 'name', 'price', 'descript' ],

	methods: {
		onOrderMenux() {                
			console.log(this.name);
			
            // place an order
            this.$emit('applied', {
            	name: this.name,
            	price: this.price,
            });
        }
    },

    computed: {
    	descriptToLowerCase() {
    		let lowerCaseDescript = this.descript.toLowerCase();    			
    		lowerCaseDescript = lowerCaseDescript.replace('california', 'California');
    		return lowerCaseDescript;
    	}
    }
}
</script>

<style>

.menu-title {
	text-transform: uppercase;
}

.menu-description {
	/*text-transform: lowercase;*/
}

.order-button {
	border-radius: 4px !important;
	background-clip: padding-box !important;
	border: 1px solid #cecece !important;
	color: black !important;
	padding: .3rem .5rem;
	text-decoration: none !important;
}

</style>