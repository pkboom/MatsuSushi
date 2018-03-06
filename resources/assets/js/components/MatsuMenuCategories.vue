<template>
	<div>
		<button class="accordion font-semibold text-base" :class="{'accordion-active': isActive}" v-text="data.name" @click="show"></button>
		<div class="panel" ref="panel">
			<div v-for="menu in data.menu">
				<matsu-menu-items :data="menu" @order="ordered"></matsu-menu-items>
			</div>
		</div>
	</div>
</template>

<script>
	import MatsuMenuItems from './MatsuMenuItems.vue';

	export default {
		props: [ 'data'],

		data() {
			return {
				isActive: false,
			}
		},

		components: { MatsuMenuItems },

		methods: {
			show(event) {
				this.isActive = !this.isActive;

				this.$refs.panel.style.maxHeight =
					this.$refs.panel.style.maxHeight ?
					null : this.$refs.panel.scrollHeight + "px";
			},
			
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
    .accordion {
        background-color: #eee;
        color: #444;
        cursor: pointer;
        padding: 18px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
        transition: 0.4s;
    }

	.accordion-active,
    .accordion:hover {
        background-color: #ccc;
    }

    .accordion:after {
        content: '\02795'; /* Unicode character for "plus" sign (+) */
        font-size: 13px;
        color: #777;
        float: right;
        margin-left: 5px;
    }

    .accordion-active:after {
        content: "\2796"; /* Unicode character for "minus" sign (-) */
    }

    .panel {
        padding: 0 18px;
        background-color: white;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.2s ease-out;
    }

</style>