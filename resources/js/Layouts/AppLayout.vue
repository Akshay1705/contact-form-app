<template>
  <div class="flex h-screen bg-gray-100 overflow-hidden">
    <!-- Sidebar Overlay (Mobile only) -->
    <div
      v-if="isSidebarOpen && !screenIsLarge"
      @click="isSidebarOpen = false"
      class="fixed inset-0 bg-black bg-opacity-40 z-40"
    ></div>

    <!-- Sidebar -->
    <aside
      class="bg-gray-800 text-white w-64 p-6 flex flex-col justify-between fixed top-0 left-0 z-50 h-full transition-transform duration-300"
      :class="{
        '-translate-x-full': !isSidebarOpen && !screenIsLarge,
        'translate-x-0': isSidebarOpen || screenIsLarge
      }"
    >
      <!-- Top Section -->
      <div>
        <div class="text-2xl font-bold mb-8">📖 Contact Book</div>
        <nav class="space-y-4">
          <Link href="/admin/messages" class="block hover:text-gray-300">📱 My Contacts</Link>
          <Link href="/contact" class="block hover:text-gray-300">➕ Add Contact</Link>
        </nav>
      </div>

      <!-- Bottom Section -->
      <div class="mt-auto border-t border-gray-700 pt-4 space-y-2">
        <div class="text-sm text-gray-300 truncate">👤 {{ user.name }}</div>
        <Link href="/profile" class="block text-sm text-gray-300 hover:text-white">⚙️ Edit Profile</Link>
        <Link
          href="/logout"
          method="post"
          as="button"
          class="block w-full text-left text-sm text-red-400 hover:text-red-600"
        >
          🔓 Logout
        </Link>
      </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col sm:ml-64 transition-all duration-300">
      <!-- Mobile Topbar -->
      <header class="sm:hidden bg-white shadow p-4 flex items-center justify-between">
        <button @click="toggleSidebar" class="text-2xl text-gray-700">☰</button>
        <h1 class="text-gray-800 font-semibold">Contact Book</h1>
      </header>

      <!-- Main slot content -->
      <main class="flex-1 p-6 overflow-y-auto">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { usePage, Link } from '@inertiajs/vue3'

const isSidebarOpen = ref(false)
const screenIsLarge = ref(window.innerWidth >= 640)
const user = usePage().props.auth.user

const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value
}

const updateScreenSize = () => {
  screenIsLarge.value = window.innerWidth >= 640
  if (screenIsLarge.value) {
    isSidebarOpen.value = false // Hide mobile sidebar on desktop
  }
}

onMounted(() => {
  window.addEventListener('resize', updateScreenSize)
})

onUnmounted(() => {
  window.removeEventListener('resize', updateScreenSize)
})
</script>
