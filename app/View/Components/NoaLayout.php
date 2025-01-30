<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NoaLayout extends Component
{
    public string $metaTitle;
    public string $metaDescription;

    public function __construct(
        string $metaTitle = 'Default title',
        string $metaDescription = 'Default description'
    ) {
        $this->metaTitle = $metaTitle;
        $this->metaDescription = $metaDescription;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.noa-layout');
    }
}

