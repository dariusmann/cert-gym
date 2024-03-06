<script>
export default {
    name: 'CategoryTree',
    props: {
        categories: {
            type: Array,
            required: true
        }
    },
    methods: {
        handleCheckboxChange(event, categoryId) {
            this.$emit('update:selected', { categoryId, isChecked: event.target.checked });
        },
        handleUpdateSelected({ categoryId, isChecked }) {
            // Emitting upwards to ensure the selected state is managed at a higher level
            this.$emit('update:selected', { categoryId, isChecked });
        }
    }
}
</script>

<template>
    <ul class="list-disc">
        <li v-for="category in categories" :key="category.id">
            {{ category.name }} {{ category.description }}
            <input type="checkbox" :value="category.id" @change="handleCheckboxChange($event, category.id)">
            <!-- Check if the category has children and recursively render them -->
            <CategoryTree v-if="category.children && category.children.length" :categories="category.children" @update:selected="handleUpdateSelected"/>
        </li>
    </ul>
</template>

