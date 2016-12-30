<?php

namespace ReactivosUPS\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use ReactivosUPS\Format;

class FormatComposer
{
    public function compose(View $view)
    {
        $formatList = Format::Query()->where('estado','A')->get();
        $view->with('formatList', $formatList);
    }

}