<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import { Badge } from '@/components/ui/badge'
import { Button } from '@/components/ui/button'
import AuthBase from '@/layouts/AuthLayout.vue'
import oidc from '@/routes/oidc'
import login from '@/routes/login'

defineProps<{
    status?: string;
    canResetPassword: boolean;
    usedOidc?: boolean;
}>()
</script>

<template>
    <AuthBase
        title="Log in to your account"
        description="Enter your email and password below to log in"
    >
        <Head title="Log in" />

        <div
            v-if="status"
            class="mb-4 text-center text-sm font-medium text-green-600"
        >
            {{ status }}
        </div>

        <section>
            <div class="relative">
                <Button
                    as="a"
                    :variant="usedOidc ? 'default' : 'outline'"
                    class="w-full"
                    :tabindex="5"
                    :href="oidc.login.url()"
                >
                    Login with OpenID Connect
                </Button>
                <Badge
                    v-if="usedOidc === true"
                    class="absolute -top-2 -right-2"
                    variant="secondary"
                >
                    Last used
                </Badge>
            </div>
        </section>

        <div class="relative flex my-3 items-center">
            <div class="flex-grow border-t border-gray-400" />
            <span class="flex-shrink mx-4 text-gray-400 italic uppercase">or</span>
            <div class="flex-grow border-t border-gray-400" />
        </div>

        <section>
            <div class="relative">
                <Button
                    as="a"
                    :variant="usedOidc ? 'outline' : 'default'"
                    class="w-full"
                    :tabindex="5"
                    :href="login.email.url()"
                >
                    Login with email
                </Button>
                <Badge
                    v-if="usedOidc === false"
                    class="absolute -top-2 -right-2"
                    variant="secondary"
                >
                    Last used
                </Badge>
            </div>
        </section>
    </AuthBase>
</template>
