<?php

use Huy\WidgetPackage\Command\CreateWidget;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider as CoreServiceProvider;
use Illuminate\Support\Str;

class ServiceProvider extends CoreServiceProvider
{
    public function boot()
    {
        Blade::directive('widget', function ($expression){
            $expression = str_replace([' ', '\''], '', Str::headline($expression));

            return "<?php echo resolve(\"App\Http\Widgets\\$expression\")->viewWidget(); ?>";
        });

        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateWidget::class,
            ]);
        }
    }
}