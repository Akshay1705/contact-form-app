<template>
    <div>
        <header class="bg-gray-800 text-white p-4">
            <nav class="max-w-7xl mx-auto flex justify-between">
                <div class="text-lg font-bold">MyApp</div>
                <div>
                    <inertia-link href="/" class="px-3">Home</inertia-link>
                    <inertia-link href="/contact" class="px-3">Contact</inertia-link>
                </div>
            </nav>
        </header>

        <main class="max-w-4xl mx-auto mt-6">
            <slot />
        </main>
    </div>
</template>
  
