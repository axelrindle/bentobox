<script setup lang="ts">
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'

const model = defineModel({
    type: [String, Number, Object],
})

type Option = {
    id: string | number
    label: string
}

interface SelectProps {
    options: Option[];
}

defineProps<SelectProps>()
</script>

<template>
    <div class="max-w-80 min-w-52">
        <Select v-model="model">
            <SelectTrigger>
                <SelectValue placeholder="Select a place" />
            </SelectTrigger>
            <SelectContent class="w-full lg:w-80">
                <SelectGroup>
                    <SelectLabel>Places</SelectLabel>
                    <SelectItem
                        v-for="option in options"
                        :key="option.id"
                        :value="option.id"
                    >
                        {{ option.label }}
                    </SelectItem>
                </SelectGroup>
            </SelectContent>
        </Select>
    </div>
</template>
