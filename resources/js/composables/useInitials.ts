export function getInitials(fullName?: string): string {
    if (!fullName) return ''

    return fullName.trim().split(' ')
        .map(s => s.trim())
        .filter(s => s.length > 0)
        .map(s => s.charAt(0).toUpperCase() + s.substring(1))
        .join(' ')
}

export function useInitials() {
    return { getInitials }
}
