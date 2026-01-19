<script setup lang="ts">
import { computed, watch, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { CircleCheck, CircleX, AlertTriangle, Info } from 'lucide-vue-next';

const page = usePage();
const visible = ref(false);
const type = ref<'success' | 'error' | 'warning' | 'info'>('success');
const message = ref('');

watch(() => page.props.flash, (flash: any) => {
    if (flash.success) {
        show('success', flash.success);
    } else if (flash.error) {
        show('error', flash.error);
    } else if (flash.warning) {
        show('warning', flash.warning);
    } else if (flash.info) {
        show('info', flash.info);
    }
}, { deep: true });

function show(t: 'success' | 'error' | 'warning' | 'info', msg: string) {
    type.value = t;
    message.value = msg;
    visible.value = true;

    setTimeout(() => {
        visible.value = false;
    }, 5000);
}

const variant = computed(() => {
    switch (type.value) {
        case 'error': return 'destructive';
        default: return 'default'; // Alert component might rely on 'default' or 'destructive' mainly, we can style others with classes
    }
});

const icon = computed(() => {
    switch (type.value) {
        case 'success': return CircleCheck;
        case 'error': return CircleX;
        case 'warning': return AlertTriangle;
        case 'info': return Info;
    }
});

const alertClass = computed(() => {
    switch (type.value) {
        case 'success': return 'bg-green-100 border-green-500 text-green-700 dark:bg-green-900/20 dark:text-green-400';
        case 'warning': return 'bg-yellow-100 border-yellow-500 text-yellow-700 dark:bg-yellow-900/20 dark:text-yellow-400';
        case 'info': return 'bg-blue-100 border-blue-500 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400';
        default: return ''; // Error handles itself with variant='destructive' usually, or we can override
    }
});
</script>

<template>
    <div v-if="visible"
        class="fixed top-4 right-4 z-50 w-full max-w-sm animate-in slide-in-from-right-full fade-in duration-300">
        <Alert :variant="variant" :class="[variant !== 'destructive' ? alertClass : '']">
            <component :is="icon" class="h-4 w-4" />
            <AlertTitle class="capitalize">{{ type }}</AlertTitle>
            <AlertDescription>
                {{ message }}
            </AlertDescription>
        </Alert>
    </div>
</template>
