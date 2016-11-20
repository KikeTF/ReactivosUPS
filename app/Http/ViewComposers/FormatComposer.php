<?php

namespace ReactivosUPS\Http\ViewComposers;

use Illuminate\Contracts\View\View;

class FormatComposer
{
    public function compose(View $view)
    {
        $formatList = \ReactivosUPS\Format::Query()->where('estado','A')->get();
        $view->with('formatList', $formatList);
    }

}