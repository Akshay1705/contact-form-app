<template>
    <div class="max-w-4xl mx-auto mt-10">
      <h1 class="text-2xl font-bold mb-6">📥 Contact Messages</h1>

      <div
            v-if="showFlash"
            class="mb-4 rounded-lg bg-red-100 border border-red-400 text-red-800 px-4 py-3"
            role="alert"
        >
            <strong class="font-bold">Success:</strong>
            <span class="block sm:inline">{{ $page.props.flash.success }}</span>
        </div>
  
      <table class="min-w-full bg-white border border-gray-200 shadow">
        <thead>
          <tr class="bg-gray-100 text-left text-sm font-semibold">
            <th class="px-4 py-2">Name</th>
            <th class="px-4 py-2">Email</th>
            <th class="px-4 py-2">Message</th>
            <th class="px-4 py-2">Submitted At</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="msg in messages" :key="msg.id">
                <td class="px-6 py-4 text-sm">{{ msg.name }}</td>
                <td class="px-6 py-4 text-sm">{{ msg.email }}</td>
                <td class="px-6 py-4 text-sm">{{ msg.message }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">
                {{ formatDate(msg.created_at) }}
                </td>
                <td class="px-6 py-4 text-sm">
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
  const showFlash = ref(false)
  
  watch(
    () => page.props.flash.success,
    (newVal) => {
      if (newVal) {
        showFlash.value = true
        setTimeout(() => {
          showFlash.value = false
        }, 3000)
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
  
  