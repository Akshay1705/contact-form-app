<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String
})
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100 p-6">
    <div class="max-w-3xl w-full bg-white rounded-lg shadow p-8 text-center">
      <h1 class="text-4xl font-bold text-gray-800 mb-4">📱 Welcome to MyContacts</h1>

      <div class="flex justify-center space-x-4">
        <Link
          v-if="canLogin"
          href="/login"
          class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded"
        >
          Login
        </Link>

        <Link
          v-if="canRegister"
          href="/register"
          class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded"
        >
          Register
        </Link>
      </div>
    </div>
  </div>
</template>
