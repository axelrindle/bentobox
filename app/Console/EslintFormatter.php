<?php

namespace App\Console;

use Illuminate\Support\Facades\Process;
use Spatie\TypeScriptTransformer\Formatters\Formatter;

class EslintFormatter implements Formatter
{
    public function format(string $file): void
    {
        Process::command(['bunx', 'eslint', '--fix', $file])
            ->path(base_path())
            ->run()
            ->throw();
    }
}
