<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PrintBtn extends Component
{
	protected $type;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type = 'table')
    {
     	$this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.print-btn');
    }
}
