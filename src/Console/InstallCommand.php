<?php

namespace MrShaneBarron\LaravelDesign\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'laraveldesign:install
                            {--force : Overwrite existing configuration}';

    protected $description = 'Install LaravelDesign CMS package';

    public function handle(): int
    {
        $this->components->info('Installing LaravelDesign...');

        // Publish config
        $this->components->task('Publishing configuration', function () {
            $this->callSilently('vendor:publish', [
                '--tag' => 'laraveldesign-config',
                '--force' => $this->option('force'),
            ]);
        });

        // Publish migrations
        $this->components->task('Publishing migrations', function () {
            $this->callSilently('vendor:publish', [
                '--tag' => 'laraveldesign-migrations',
                '--force' => $this->option('force'),
            ]);
        });

        // Run migrations
        $this->components->task('Running migrations', function () {
            $this->callSilently('migrate');
        });

        // Create storage link if it doesn't exist
        if (!file_exists(public_path('storage'))) {
            $this->components->task('Creating storage link', function () {
                $this->callSilently('storage:link');
            });
        }

        // Create default menus
        $this->components->task('Creating default menus', function () {
            $this->createDefaultMenus();
        });

        $this->newLine();
        $this->components->info('LaravelDesign installed successfully.');
        $this->newLine();

        $this->components->bulletList([
            'Admin panel: <comment>/admin</comment>',
            'Blog: <comment>/blog</comment>',
            'Config: <comment>config/laraveldesign.php</comment>',
            'Views: <comment>php artisan vendor:publish --tag=laraveldesign-views</comment>',
        ]);

        return self::SUCCESS;
    }

    protected function createDefaultMenus(): void
    {
        $menuModel = \MrShaneBarron\LaravelDesign\Models\Menu::class;

        if (!$menuModel::where('location', 'header')->exists()) {
            $menuModel::create([
                'name' => 'Header Menu',
                'location' => 'header',
            ]);
        }

        if (!$menuModel::where('location', 'footer')->exists()) {
            $menuModel::create([
                'name' => 'Footer Menu',
                'location' => 'footer',
            ]);
        }
    }
}
