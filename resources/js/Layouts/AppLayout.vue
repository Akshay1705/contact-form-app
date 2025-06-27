<script setup>
import { Link } from '@inertiajs/vue3'
</script>
<template>
    <div>
        <header class="bg-gray-800 text-white p-4">
            <nav class="max-w-7xl mx-auto flex justify-between">
                <div class="text-lg font-bold">MyApp</div>
                <div>
                    <Link href="/admin/messages" class="px-3">Home</Link>
                    <Link href="/contact" class="px-3">Add Contact</Link>
                </div>
            </nav>
        </header>

        <main class="max-w-4xl mx-auto mt-6">
            <slot />
        </main>
    </div>
</template>

