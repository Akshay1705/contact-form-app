<template>
    <div class="max-w-xl mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-4">Contact Us</h1>

        <form @submit.prevent="submit" class="space-y-4">
            <div>
                <label class="block">Name</label>
                <input v-model="form.name" type="text" class="w-full border rounded p-2" />
                <p v-if="form.errors.name" class="text-red-500">{{ form.errors.name }}</p>
            </div>

            <div>
                <label class="block">Email</label>
                <input v-model="form.email" type="email" class="w-full border rounded p-2" />
                <p v-if="form.errors.email" class="text-red-500">{{ form.errors.email }}</p>
            </div>

            <div>
                <label class="block">Message</label>
                <textarea v-model="form.message" class="w-full border rounded p-2"></textarea>
                <p v-if="form.errors.message" class="text-red-500">{{ form.errors.message }}</p>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Send</button>

            <p v-if="$page.props.flash.success" class="text-green-600 mt-2">
                {{ $page.props.flash.success }}
            </p>
        </form>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({ layout: AppLayout })

const form = useForm({
    name: '',
    email: '',
    message: ''
})

const submit = () => {
    form.post('/contact')
}
</script>
  
