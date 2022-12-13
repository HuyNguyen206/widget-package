<?php
namespace huynguyen206\WidgetPackage\Provider;

use huynguyen206\WidgetPackage\Command\CreateWidget;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider as CoreServiceProvider;
use Illuminate\Support\Str;

class ServiceProvider extends CoreServiceProvider
{
    public function boot()
    {
        $this->registerDirective();

        $this->registerCommand();

        $this->publishAssets();
    }

    /**
     * @return void
     */
    public function publishAssets()
    {
        $this->publishes([
            __DIR__ . '/../stubs/widget' => base_path('stubs/widget')
        ], 'widget-asset');

        $this->publishes([
            __DIR__ . '/../Widget/Widget.php' => base_path('App\Http\Widgets\Widget.php')
        ], 'widget-asset');
    }

    /**
     * @return void
     */
    public function registerCommand()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateWidget::class,
            ]);
        }
    }

    /**
     * @return void
     */
    public function registerDirective()
    {
        Blade::directive('widget', function ($expression) {
            $expression = str_replace([' ', '\''], '', Str::headline($expression));

            return "<?php echo resolve(\"App\Http\Widgets\\$expression\")->viewWidget(); ?>";
        });
    }
}