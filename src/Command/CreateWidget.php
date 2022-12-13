<?php
namespace huynguyen206\WidgetPackage\Command;

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
        $content = File::get(base_path('vendors/widget'));
        if (!is_dir(app_path('Http/Widgets/'))) {
            // dir doesn't exist, make it
            mkdir(app_path('Http/Widgets/') , 0777, true);
        }

        if (!is_dir(resource_path("views/widgets/"))) {
            // dir doesn't exist, make it
            mkdir(resource_path("views/widgets/") , 0777, true);
        }

        File::put(app_path("Http/Widgets/$widgetName.php"),str_replace(['{{WidgetName}}', '{{ViewName}}'], [$widgetName, $viewName], $content));
        File::put(resource_path("views/widgets/$viewName.blade.php"), '<div> </div>');
        $this->info("$widgetName was created successfully!");

        return 0;
    }
}