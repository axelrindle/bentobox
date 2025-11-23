import configActDefault from '@actcoding/eslint-config/default'
import configVue from 'eslint-plugin-vue'

/** @type {import('eslint').Linter.Config[]} */
export default [
    {
        name: 'app/files',
        files: [
            'resources/js/**/*',
        ],
    },
    {
        name: 'app/ignores',
        ignores: [
            'vendor',
            'node_modules',
            'public',
            'bootstrap/ssr',
            'tailwind.config.js',
            'resources/js/actions/*',
            'resources/js/routes/*',
            'resources/js/wayfinder/*',
            'resources/js/components/ui/*',
        ],
    },
    ...configActDefault,
    ...configVue.configs['flat/recommended'],
    {
        name: 'app/vue/ts',
        files: ['resources/js/**/*.vue'],
        languageOptions: {
            parserOptions: {
                parser: '@typescript-eslint/parser',
                ecmaFeatures: {
                    jsx: true,
                },
            },
        },
    },
    {
        name: 'app/rules',
        rules: {
            '@typescript-eslint/no-explicit-any': 'off',

            'vue/multi-word-component-names': 'off',
            'vue/html-indent': ['error', 4],
            'vue/require-default-prop ': 'off',
        },
    },
]

