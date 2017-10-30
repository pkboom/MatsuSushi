<template>
	<div class="add-to-cart-wrapper">
		<slot></slot> Added to Cart			
	</div>
</template>

<script>
export default {
}
</script>

<style>

.add-to-cart-wrapper {
	position: fixed;
	top: 2rem;
	z-index: 9999;
	line-height: 1.5rem;
	background-color: rgba(244, 66, 66, 0.9);
	border-radius: 4px !important;
	background-clip: padding-box !important;
	border: 0 !important;
	color: white !important;
	margin: auto;
	padding: .5rem 2rem;
	text-decoration: none !important;	
	left: 50%;
	transform: translateX(-50%);
}


</style>