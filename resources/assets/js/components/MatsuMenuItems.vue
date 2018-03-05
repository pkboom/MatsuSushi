<template>
	<div style="margin-bottom: 1rem;">
		<div class="row">
			<div class="col menu-title" style="font-weight: bold" v-text="data.name">
			</div>
			<div class="col menu-price" align="right">
				<a href="javascript:void(0)" class="order-button" @click="ordered" v-text="data.price"></a>
			</div>
		</div>
		<div class="row">
			<div class="col menu-description" v-text="descriptToLowerCase">
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: ['data'],

	methods: {
		ordered() {                
            this.$emit('order', {
            	name: this.data.name,
				price: this.data.price,
				quantity: 1
            });
        }
    },

    computed: {
    	descriptToLowerCase() {
    		let lowerCaseDescript = this.data.descript.toLowerCase();    			
    		return lowerCaseDescript.replace('california', 'California');
    	}
    }
}
</script>

<style>
.menu-title {
	text-transform: uppercase;
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