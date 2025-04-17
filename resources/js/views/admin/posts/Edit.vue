<template>
    <div class="card">
        <DataTable :value="products" tableStyle="min-width: 50rem">
            <template #header>
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <span class="text-xl font-bold">Products</span>
                    <Button icon="pi pi-refresh" rounded raised />
                </div>
            </template>
            <Column field="DNI" sortable header="DNI"></Column>
            <Column field="player" sortable header="Jugador">
                <template #body="slotProps">
                    {{ formatCurrency(slotProps.data.price) }}
                </template>
            </Column>
            <Column field="income" sortable header="Importe"></Column>
            <Column field="phone" sortable header="Telefono">
                <template #body="slotProps">
                    <Rating :modelValue="slotProps.data.rating" readonly />
                </template>
            </Column>
            <Column header="Status">
                <template #body="slotProps">
                    <Tag :value="slotProps.data.inventoryStatus" :severity="getSeverity(slotProps.data)" />
                </template>
            </Column>
            <template #footer> In total there are {{ products ? products.length : 0 }} products. </template>
        </DataTable>
    </div>
</template>
<script setup>
    import { onMounted, reactive, watchEffect } from "vue";
    import { useRoute } from "vue-router";
    import useCategories from "@/composables/categories";
    import usePosts from "@/composables/posts";
    import { useForm, useField, defineRule } from "vee-validate";
    import { required, min } from "@/validation/rules"
    import DropZone from "@/components/DropZone.vue";
    defineRule('required', required)
    defineRule('min', min);

    // Define a validation schema
    const schema = {
        title: 'required|min:5',
        content: 'required|min:50',
        categories: 'required'
    }
    // Create a form context with the validation schema
    const { validate, errors, resetForm } = useForm({ validationSchema: schema })
    // Define actual fields for validation
    const { value: title } = useField('title', null, { initialValue: '' });
    const { value: content } = useField('content', null, { initialValue: '' });
    const { value: categories } = useField('categories', null, { initialValue: '', label: 'category' });
    const { categoryList, getCategoryList } = useCategories()
    const { post: postData, getPost, updatePost, validationErrors, isLoading } = usePosts()
    const post = reactive({
        title,
        content,
        categories,
        thumbnail: ''
    })
    const route = useRoute()
    function submitForm() {
        validate().then(form => { if (form.valid) updatePost(post) })
    }
    onMounted(() => {
        getPost(route.params.id)
        getCategoryList()
    })

    // https://vuejs.org/api/reactivity-core.html#watcheffect
    watchEffect(() => {
        post.id = postData.value.id
        post.title = postData.value.title
        post.content = postData.value.content
        post.thumbnail = postData.value.original_image
        post.categories = postData.value.categories
    })
</script>
