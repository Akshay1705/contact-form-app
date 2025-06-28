<template>
  <div class="max-w-6xl mx-auto mt-10 px-4">
    <h1 class="text-2xl font-bold mb-6">📥 My Contacts</h1>

    <!-- Search + Export -->
    <div class="mb-4 flex flex-col sm:flex-row sm:items-center gap-2">
      <input
        v-model="search"
        @keyup.enter="applySearch"
        type="text"
        placeholder="Search by name, email or phone..."
        class="flex-1 border p-2 rounded w-full"
      />
      <div class="flex gap-2">
        <button
          @click="applySearch"
          class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
        >
          Search
        </button>
        <a
          :href="route('contacts.export')"
          class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 whitespace-nowrap"
        >
          ⬇️ Export CSV
        </a>
      </div>
    </div>

    <!-- Flash messages -->
    <div
      v-if="deletion"
      class="mb-4 rounded-lg bg-red-100 border border-red-400 text-red-800 px-4 py-3"
    >
      <strong class="font-bold">Deleted:</strong> <span>{{ flash.success }}</span>
    </div>
    <div
      v-if="success"
      class="mb-4 rounded-lg bg-green-100 border border-green-400 text-green-800 px-4 py-3"
    >
      <strong class="font-bold">Success:</strong> <span>{{ flash.success }}</span>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto w-full bg-white shadow border rounded">
      <table class="min-w-full text-sm divide-y divide-gray-200">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="px-4 py-3 text-center font-semibold">Name</th>
            <th class="px-4 py-3 text-center font-semibold">Email</th>
            <th class="px-4 py-3 text-center font-semibold">Phone</th>
            <th class="px-4 py-3 text-center font-semibold">Submitted At</th>
            <th class="px-4 py-3 text-center font-semibold">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          <tr v-for="msg in messages.data" :key="msg.id">
            <!-- Name -->
            <td class="text-center px-4 py-2">
              <template v-if="editingId === msg.id">
                <input v-model="editedContact.name" class="border p-1 rounded w-full" />
              </template>
              <template v-else>{{ msg.name }}</template>
            </td>

            <!-- Email -->
            <td class="text-center px-4 py-2">
              <template v-if="editingId === msg.id">
                <input v-model="editedContact.email" class="border p-1 rounded w-full" />
              </template>
              <template v-else>{{ msg.email }}</template>
            </td>

            <!-- Phone -->
            <td class="text-center px-4 py-2">
              <template v-if="editingId === msg.id">
                <input v-model="editedContact.phone_number" class="border p-1 rounded w-full" />
              </template>
              <template v-else>{{ msg.phone_number }}</template>
            </td>

            <!-- Date -->
            <td class="text-center px-4 py-2 text-gray-500">
              {{ new Date(msg.created_at).toLocaleString() }}
            </td>

            <!-- Actions -->
            <td class="text-center px-4 py-2">
              <template v-if="editingId === msg.id">
                <button @click="updateContact(msg.id)" class="text-green-600 hover:underline">Save</button>
                <button @click="cancelEdit" class="ml-2 text-gray-500 hover:underline">Cancel</button>
              </template>
              <template v-else>
                <button @click="enableEdit(msg)" class="text-blue-600 hover:underline">✏️ Edit</button>
                <button @click="deleteMessage(msg.id)" class="ml-2 text-red-600 hover:underline">🗑️ Delete</button>
              </template>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex flex-wrap justify-center gap-2 text-sm">
      <button
        v-for="link in messages.links"
        :key="link.label"
        :disabled="!link.url"
        @click="link.url && router.visit(link.url)"
        v-html="link.label"
        :class="[
          'px-3 py-1 rounded',
          link.active ? 'bg-blue-500 text-white' : 'bg-white text-gray-700 border',
          !link.url && 'opacity-50 cursor-not-allowed'
        ]"
      />
    </div>
  </div>
</template>

  
  <script setup>
  import AppLayout from '@/Layouts/AppLayout.vue'
  import { router, usePage } from '@inertiajs/vue3'
  import { ref, watch, computed } from 'vue'
  
  defineOptions({ layout: AppLayout })
  const page = usePage()
  const props = defineProps(['messages', 'filters'])
  
  const search = ref(props.filters.search || '')
  const flash = computed(() => page.props.flash)
  
  const editingId = ref(null)
  const editedContact = ref({})
  const deletion = ref(false)
  const success = ref(false)
  
  watch(
    () => flash.value.success,
    (msg) => {
      if (!msg) return
      if (msg.toLowerCase().includes('deleted')) {
        deletion.value = true
        setTimeout(() => (deletion.value = false), 3000)
      } else {
        success.value = true
        setTimeout(() => (success.value = false), 4000)
      }
    },
    { immediate: true }
  )
  
  function enableEdit(msg) {
    editingId.value = msg.id
    editedContact.value = { ...msg }
  }
  function cancelEdit() {
    editingId.value = null
    editedContact.value = {}
  }
  function updateContact(id) {
    router.put(`/admin/messages/${id}`, editedContact.value, {
      onSuccess: () => {
        editingId.value = null
      },
    })
  }
  function deleteMessage(id) {
    if (confirm('Are you sure you want to delete this message?')) {
      router.delete(`/admin/messages/${id}`)
    }
  }
  function applySearch() {
    router.get('/admin/messages', { search: search.value }, { preserveState: true })
  }
  </script>
  