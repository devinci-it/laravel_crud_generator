<?php

namespace Devinci\LaravelUtils\Command;

use Illuminate\Console\Command;
use Devinci\LaravelUtils\StubsManager;
class SetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repository:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup repository controllers for Laravel Utils package';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Your setup logic here
        StubsManager::moveStubsToProjectRoot();
        StubsManager::createRepositoryDir();

        return 0;
    }
}
