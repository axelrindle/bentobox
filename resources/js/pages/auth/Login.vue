<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3'
import { LoaderCircle } from 'lucide-vue-next'
import { useLocalStorage } from '@vueuse/core'
import InputError from '@/components/InputError.vue'
import TextLink from '@/components/TextLink.vue'
import { Button } from '@/components/ui/button'
import { Checkbox } from '@/components/ui/checkbox'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import AuthBase from '@/layouts/AuthLayout.vue'
import { store } from '@/routes/login'
import { request } from '@/routes/password'
import { login as oidcLogin } from '@/routes/oidc'
import { Badge } from '@/components/ui/badge'

defineProps<{
    status?: string;
    canResetPassword: boolean;
    canRegister: boolean;
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

        <Form
            v-slot="{ errors, processing }"
            v-bind="store.form()"
            :reset-on-success="['password']"
            class="flex flex-col gap-6"
        >
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="email">Email address</Label>
                    <Input
                        id="email"
                        type="email"
                        name="email"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="email"
                        placeholder="email@example.com"
                    />
                    <InputError :message="errors.email" />
                </div>

                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="password">Password</Label>
                        <TextLink
                            v-if="canResetPassword"
                            :href="request()"
                            class="text-sm"
                            :tabindex="5"
                        >
                            Forgot password?
                        </TextLink>
                    </div>
                    <Input
                        id="password"
                        type="password"
                        name="password"
                        required
                        :tabindex="2"
                        autocomplete="current-password"
                        placeholder="Password"
                    />
                    <InputError :message="errors.password" />
                </div>

                <div class="flex items-center justify-between">
                    <Label
                        for="remember"
                        class="flex items-center space-x-3"
                    >
                        <Checkbox
                            id="remember"
                            name="remember"
                            :tabindex="3"
                        />
                        <span>Remember me</span>
                    </Label>
                </div>

                <div class="relative mt-4">
                    <Button
                        type="submit"
                        class="w-full"
                        :tabindex="4"
                        :disabled="processing"
                        data-test="login-button"
                        :variant="usedOidc ? 'outline' : 'default'"
                    >
                        <LoaderCircle
                            v-if="processing"
                            class="h-4 w-4 animate-spin"
                        />
                        <span>Log in</span>
                    </Button>
                    <Badge
                        v-if="usedOidc === false"
                        class="absolute -top-2 -right-2"
                        variant="secondary"
                    >
                        Last used
                    </Badge>
                </div>
            </div>

            <div class="relative flex py-5 items-center">
                <div class="flex-grow border-t border-gray-400" />
                <span class="flex-shrink mx-4 text-gray-400 italic uppercase">or</span>
                <div class="flex-grow border-t border-gray-400" />
            </div>

            <div
                class="text-center text-sm text-muted-foreground"
            >
                <div class="relative">
                    <Button
                        as="a"
                        :variant="usedOidc ? 'default' : 'outline'"
                        class="w-full"
                        :tabindex="5"
                        :href="oidcLogin.url()"
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
            </div>
        </Form>
    </AuthBase>
</template>
