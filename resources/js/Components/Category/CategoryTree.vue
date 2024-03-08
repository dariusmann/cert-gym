<script>
export default {
    name: 'CategoryTree',
    props: {
        categories: {
            type: Array,
            required: true
        },
        level: {
            type: Number,
            required: true
        }
    },
    data: function (data) {
        return {}
    },
    methods: {
        handleCheckboxChange(event, categoryId) {
            this.$emit('update:selected', {categoryId, isChecked: event.target.checked});
        },
        handleUpdateSelected({categoryId, isChecked}) {
            // Emitting upwards to ensure the selected state is managed at a higher level
            this.$emit('update:selected', {categoryId, isChecked});
        }
    },
    computed: {
        classesUl: function () {
            return {
                'ml-5 mt-2': this.level === 2,
            }
        },
        classesHeading: function () {
            return {
                'text-2xl mt-4': this.level === 1,
            }
        },
    }
}
</script>

<template>
    <ul :class="classesUl">
        <li v-for="category in categories" :key="category.id">
            <div class="flex items-center text-bold">
                <span :class="classesHeading">{{ category.name }}</span>
                <input v-if="level > 1"
                        type="checkbox"
                       class="checkbox ml-2 checkbox-secondary"
                       :value="category.id"
                       @change="handleCheckboxChange($event, category.id)">
            </div>

            <div>
                <p>{{ category.description }}</p>
            </div>


            <!-- Check if the category has children and recursively render them -->
            <CategoryTree
                v-if="category.children && category.children.length"
                :categories="category.children"
                @update:selected="handleUpdateSelected"
                :level="level + 1"/>
        </li>
    </ul>
</template>

