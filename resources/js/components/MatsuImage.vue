<template>
    <div class="house-image-wrapper" @click="removed">
        <img 
            :src="'/storage/thumbs/'+image.filename" 
            width="200px" 
            class="house-image"
            >
        <p class="delete-icon">x</p>
    </div>
</template>

<script>
    export default {
        props: ['data'],

        data() {
            return {
                image: this.data,
                id: this.data.id,
            }
        },
        
        methods: {
            removed() {
                this.$emit('remove');

                axios.delete(`/upload/${this.id}`);
            }
        }
    }
</script>

<style>

.house-image-wrapper {
    position: relative;
    z-index: 0;
    margin: .5rem;
}

.house-image-wrapper:hover {
    z-index: 100;
}

.house-image {
    transition: transform 0.2s;
}

.house-image-wrapper:hover .house-image {
    transform: scale(1.2, 1.2);
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.3);
    opacity: .7;
}

.delete-icon {
    display: none;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    font-size: 3rem;
    color:rgba(29, 29, 29, 0.493);
}

.house-image-wrapper:hover .delete-icon {
    display: block;
}

</style>
