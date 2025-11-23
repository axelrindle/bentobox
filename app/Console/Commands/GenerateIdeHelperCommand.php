<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Override;

class GenerateIdeHelperCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ide-helper:composite';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Composite command which detects whether composer is running in dev mode.';

    /**
     * {@inheritdoc}
     */
    #[Override]
    public function isHidden(): bool
    {
        return env('COMPOSER_DEV_MODE', '1') == '0';
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        if ($this->isHidden()) {
            return;
        }

        // $this->call('ide-helper:generate');
        $this->call('ide-helper:models', ['-R', '-M']);
    }
}
