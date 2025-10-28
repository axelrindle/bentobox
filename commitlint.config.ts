import { execSync } from 'node:child_process'
import type { UserConfig } from '@commitlint/types'

function isDefaultBranch() {
    const ref = execSync('git rev-parse --abbrev-ref HEAD', {
        cwd: __dirname,
    }).toString('utf-8').trim()

    return ref === 'main'
}

export default {
    extends: ['@commitlint/config-conventional'],
    rules: {
        'ticket-reference': [
            1,
            'always',
        ],
    },
    plugins: [
        {
            rules: {
                'ticket-reference': async ({ subject }) => {
                    if (isDefaultBranch()) {
                        return [true]
                    }

                    return [
                        !!subject && /(?:\s\()(([A-Z0-9-]+)|(#\d+))(?:\))$/g.test(subject),
                        'The commit message should include a bracketed ticket or pull-request reference at the very end: (`(#1337)` or `(TICKET-1337)` for example)',
                    ]
                },
            },
        },
    ],
} satisfies UserConfig
