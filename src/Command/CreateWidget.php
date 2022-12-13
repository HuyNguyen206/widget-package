<?php
namespace Huy\WidgetPackage\Command;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CreateWidget extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:widget {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to create custom widget';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $widgetName = $this->argument('name');
        $viewName = Str::kebab($widgetName);
        $content = File::get(base_path('stubs/widget'));
        File::put(app_path("Http/Widgets/$widgetName.php"),str_replace(['{{WidgetName}}', '{{ViewName}}'], [$widgetName, $viewName], $content));
        File::put(resource_path("views/widgets/$viewName.blade.php"), '<div> </div>');
        $this->info("$widgetName was created successfully!");

        return 0;
    }
}