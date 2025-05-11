<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Toast extends Component
{
    public $message;
    public $type;
    public $duration;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($message = '', $type = 'success', $duration = 3000)
    {
        $this->message = $message;
        $this->type = $type; // success, error, info, warning
        $this->duration = $duration;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.toast');
    }
}