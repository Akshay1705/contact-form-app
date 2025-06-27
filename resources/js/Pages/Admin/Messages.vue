<template>
    <div class="max-w-4xl mx-auto mt-10">
      <h1 class="text-2xl font-bold mb-6">📥 Contact Messages</h1>
        
        <!-- Shown after delete -->
        <div
        v-if="deletion"
        class="mb-4 rounded-lg bg-red-100 border border-red-400 text-red-800 px-4 py-3"
        >
        <strong class="font-bold">Deleted:</strong>
        <span>{{ page.props.flash.success }}</span>
        </div>

        <!-- Shown after addition -->
        <div
        v-if="addition"
        class="mb-4 rounded-lg bg-green-100 border border-green-400 text-green-800 px-4 py-3"
        >
        <strong class="font-bold">Added:</strong>
        <span>{{ page.props.flash.success }}</span>
        </div>

      <table class="min-w-full bg-white border border-gray-200 shadow">
        <thead class="bg-gray-100 text-sm text-gray-700">
            <tr>
                <th class="px-4 py-3 text-center font-semibold">Name</th>
                <th class="px-4 py-3 text-center font-semibold">Email</th>
                <th class="px-4 py-3 text-center font-semibold">Phone</th>
                <th class="px-4 py-3 text-center font-semibold">Submitted At</th>
                <th class="px-4 py-3 text-center font-semibold">Actions</th>
            </tr>
        </thead>

        <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="msg in messages" :key="msg.id">
                <td class="px-6 py-4 text-center text-sm">{{ msg.name }}</td>
                <td class="px-6 py-4 text-center text-sm">{{ msg.email }}</td>
                <td class="px-6 py-4 text-center text-sm">{{ msg.phone_number }}</td>
                <td class="px-6 py-4 text-center text-sm text-gray-500">
                {{ formatDate(msg.created_at) }}
                </td>
                <td class="px-6 py-4 text-center text-sm">
                <button
                    @click="deleteMessage(msg.id)"
                    class="text-red-600 hover:underline"
                >
                    Delete
                </button>
                </td>
            </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script setup>
  import AppLayout from '@/Layouts/AppLayout.vue'
  import { router, usePage } from '@inertiajs/vue3'
  import { ref, watch } from 'vue'
  
  defineOptions({ layout: AppLayout })
  defineProps(['messages'])
  
  const page = usePage()
  
  const deletion = ref(false)
const addition = ref(false)

watch(
    () => page.props.flash.success,
    (msg) => {
        if (!msg) return

        if (msg.toLowerCase().includes('deleted')) {
        deletion.value = true
        setTimeout(() => (deletion.value = false), 3000)
        } else if (msg.toLowerCase().includes('added') || msg.toLowerCase().includes('created')) {
        addition.value = true
        setTimeout(() => (addition.value = false), 8000)
        }
    },
    { immediate: true }
)
  
  function formatDate(date) {
    return new Date(date).toLocaleString()
  }
  
  function deleteMessage(id) {
    if (confirm('Are you sure you want to delete this message?')) {
      router.delete(`/admin/messages/${id}`)
    }
  }
  </script>
  
  