<script setup lang="ts">
import type { HTMLAttributes } from "vue"
import { cn } from '@/lib/utils'
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button'
import { register } from '@/routes';
import { store } from '@/routes/login';
import { request } from '@/routes/password';
import { Checkbox } from '@/components/ui/checkbox';
import { Spinner } from '@/components/ui/spinner';
import { Form, } from '@inertiajs/vue3';
import {
    Field,
    FieldDescription,
    FieldGroup,
    FieldLabel,
    FieldSeparator,
} from '@/components/ui/field'
import { Input } from '@/components/ui/input'

const props = defineProps<{
    class?: HTMLAttributes["class"];
    status?: string;
    canResetPassword: boolean;
    canRegister: boolean;
}>()
</script>

<template>

    <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
        {{ status }}
    </div>
    <Form v-bind="store.form()" :reset-on-success="['password']" v-slot="{ errors, processing }"
        :class="cn('flex flex-col gap-6', props.class)">
        <FieldGroup>
            <div class="flex flex-col items-center gap-1 text-center">
                <h1 class="text-2xl font-bold">
                    Inicie sessão na sua conta
                </h1>
                <p class="text-muted-foreground text-sm text-balance">
                    Digite seu email e senha abaixo para entrar
                </p>
            </div>
            <Field>
                <FieldLabel for="email">
                    Email
                </FieldLabel>
                <Input id="email" type="email" name="email" placeholder="email@exemplo.com" required autofocus :tabindex="1"
                    autocomplete="email" />
                <InputError :message="errors.email" />
            </Field>
            <Field>
                <div class="flex items-center">
                    <FieldLabel for="password">
                        Senha
                    </FieldLabel>
                    <TextLink v-if="canResetPassword" :href="request()"
                        class="ml-auto text-sm underline-offset-4 hover:underline" :tabindex="5">
                        Esqueceu a senha?
                    </TextLink>
                </div>
                <Input id="password" type="password" name="password" required :tabindex="2" autocomplete="current-password"
                    placeholder="Sua senha" />
                <InputError :message="errors.password" />
            </Field>

            <Field>
                <label class="inline-flex items-center space-x-2">
                     <Checkbox id="remember" name="remember"
                        class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary-600" :tabindex="3" />
                    <span class="text-sm text-gray-600">Lembrar-me</span>
                </label>
            </Field>
            <Field>
                <Button type="submit" :tabindex="4" :disabled="processing" data-test="login-button">
                    <Spinner v-if="processing" />
                    Entrar
                </Button>
            </Field>
            <FieldSeparator>Ou Continue com</FieldSeparator>
            <Field>
                <Button variant="outline" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path
                            d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"
                            fill="currentColor" />
                    </svg>
                    Login com o GitHub
                </Button>
                <FieldDescription class="text-center" v-if="canRegister">
                    Não tem uma conta?
                    <TextLink :href="register()" :tabindex="5">Registre-se</TextLink>
                </FieldDescription>
            </Field>
        </FieldGroup>
    </form>
</template>
