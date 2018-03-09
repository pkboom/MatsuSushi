<template>
    <div class="flex items-center py-2">
        <div v-if="editing" class="w-1/2 mr-2">
            <input type="text" v-model="name" @keyup.enter="edited" class="w-full appearance-none bg-white text-black border-2 py-2 px-2 rounded">
        </div>
        <a :href="'/menu/categories/'+category.name" v-else v-text="name" class="text-grey-darkest hover:font-semibold hover:text-black mr-2"></a>

        <button class="bg-orange-light text-white py-1 px-2 rounded mr-3" @click="edited">Edit</button>

        <button type="submit" @click="deleted">Delete</button>
    </div>
</template>

<script>
    export default {
        props: ['category'],

        data() {
            return {
                name: this.category.name,
                editing: false,
            }
        },

        watch: {
            category() {
                this.name = this.category.name
            },
        },

        methods: {
            edited() {
                if (this.editing) {
                    axios.patch(location.pathname + '/' + this.category.id, {
                        name: this.name,
                    })
                    .then(() => flash('Updated!'))
                    .catch(error => {
                        flash(error.response.data.errors.name[0], 'danger');
                            
                        this.editing = !this.editing;
                    });
                }

                this.editing = !this.editing;
            },

            deleted() {
                axios.delete(location.pathname + '/' + this.category.id)
                .then(() => {
                    flash('Deleted!');

                    this.$emit('delete');
                });
            }

        }
    }
</script>

<style>
    
</style>