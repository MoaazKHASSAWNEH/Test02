<?php

namespace App\Twig;

use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

class FunctionsExtension extends AbstractExtension
{
    

    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('make_link', [$this, 'make_link'],['is_safe' => ['html']]),
        ];
    }

    public function make_link($path ="",$value = "", $class="", $id = "")
    {
        // ,$id = "", $class="",$value
        // $href = "{{ path('$route_name') }}";
        //id='$id' class='$class'
        //$value
        
        return "<a href='$path' id='$id' class='$class'>$value</a>";
    }
}
