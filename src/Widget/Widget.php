<?php

namespace Huy\WidgetPackage\Widget;

use Illuminate\Support\Str;
use ReflectionClass;

abstract class Widget
{
    public function viewWidget(){
        $viewProperty = (new ReflectionClass($this))->getProperties(\ReflectionProperty::IS_PUBLIC);

        $viewData = collect($viewProperty)->flatMap(function ($property){
            return [
                $property->getName() => $property->getValue($this)
            ];
        })->toArray();

        return $this->view()->with($viewData);
    }

    public function view()
    {
        $viewName = Str::kebab(class_basename($this));

        return view("widgets.$viewName");
    }
}