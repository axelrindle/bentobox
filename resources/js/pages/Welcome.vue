<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import { dashboard, login, register } from '@/routes'
import AppLogoIcon from '@/components/AppLogoIcon.vue'
import { Button } from '@/components/ui/button'

withDefaults(
    defineProps<{
        canRegister: boolean;
    }>(),
    {
        canRegister: true,
    },
)
</script>

<template>
    <Head title="Welcome to BentoBox" />
    <div class="w-full h-svh bg-sidebar flex flex-col items-center justify-center space-y-12">
        <AppLogoIcon class="text-6xl" />
        <nav class="flex items-center gap-4">
            <Button v-if="$page.props.auth.user">
                <Link

                    :href="dashboard()"
                >
                    Dashboard
                </Link>
            </Button>
            <template v-else>
                <Button>
                     <Link
                        :href="login()"
                    >
                        Log in
                    </Link>
                </Button>
            </template>
        </nav>
    </div>
</template>
