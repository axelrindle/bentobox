import { useBrowserLocation } from '@vueuse/core'
import { computed } from 'vue'

export function useCurrentPath() {
    const location = useBrowserLocation()
    return computed(() => location.value.pathname ?? '')
}
