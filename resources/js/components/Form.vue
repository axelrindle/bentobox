<script lang="ts" setup>
import { useForm } from '@tanstack/vue-form'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Button } from '@/components/ui/button'

export interface Field {
    label: string;
    name: string;
    default?: any;
    type:
        | 'text'
        | 'checkbox'
        | 'select'
        | 'radio'
        | 'date'
        | 'toggle'
        | 'number'
        | 'email'
        | 'password'
        | 'textarea'
        | 'url'
        | 'tel'
        | 'time'
        | 'color'
        | 'file';
}

const props = defineProps<{
    fields: Field[];
    onSubmit: (values: Record<string, any>) => void;
}>()

const form = useForm({
    defaultValues: props.fields.reduce((acc, field) => {
        acc[field.name] = field.default ?? ''
        return acc
    }, {} as Record<string, any>),
    onSubmit: props.onSubmit,
})

const getComponentForFieldType = (type: Field['type']) => {
    switch (type) {
        case 'text':
            return Input
        case 'email':
            return Input
        case 'password':
            return Input
        case 'number':
            return Input
        case 'url':
            return Input
        case 'tel':
            return Input
        case 'date':
            return Input
        case 'time':
            return Input
        case 'color':
            return Input
        default:
            return Input
    }
}
</script>

<template>
    <form @submit.prevent.stop="form.handleSubmit">
        <div class="flex flex-col space-y-6">
            <form.Field
                v-for="(inputField, index) in fields"
                :key="inputField.name + index"
                :name="inputField.name"
            >
                <template #default="{ field }">
                    <div>
                        <Label
                            :for="field.name"
                            class="mb-2"
                        >
                            {{ inputField.label }}
                        </Label>
                        <component
                            :is="getComponentForFieldType(inputField.type)"
                            :type="inputField.type"
                            :value="field.state.value"
                            :name="field.name"
                            @blur="field.handleBlur"
                            @input="(e: Event) => field.handleChange((e.target as HTMLInputElement).value)"
                        />
                    </div>
                </template>
            </form.Field>
        </div>
        <Button
            class="mt-6"
            type="submit"
        >
            Submit
        </Button>
    </form>
</template>
