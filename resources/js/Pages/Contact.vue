<template>
    <div class="max-w-xl mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-4 ">➕ Add Contact</h1>

        <form @submit.prevent="submit" class="space-y-4">
            <div>
                <label class="block">Name</label>
                <input v-model="form.name" 
                type="text" 
                placeholder="Enter your name"
                class="w-full border rounded p-2" />
                <p v-if="form.errors.name" class="text-red-500">{{ form.errors.name }}</p>
            </div>

            <div>
                <label class="block">Email</label>
                <input v-model="form.email" 
                type="email" 
                placeholder="Enter your email"
                class="w-full border rounded p-2" />
                <p v-if="form.errors.email" class="text-red-500">{{ form.errors.email }}</p>
            </div>

            <div>
                <label>Phone Number</label>
                <input v-model="form.phone_number" 
                type="tel" 
                maxlength="10" 
                minlength="10" 
                pattern="[0-9]{10}" 
                placeholder="Enter 10-digit number" 
                class="w-full border rounded p-2" />
                <div class="text-red-500 text-sm" v-if="form.errors.phone_number">{{ form.errors.phone_number }}</div>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">+ Add</button>
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
  phone_number: '',
})

const submit = () => {
    form.post('/contact')
}
</script>
  
