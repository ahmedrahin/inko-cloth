<?php

namespace App\Http\Livewire\Content;

use Livewire\Component;
use App\Models\HomeSlider;
use App\Models\BannerContent;

class BannerConter extends Component
{
    public $slider_id;
    public $title;
    public $description;
    public $link;

    protected $rules = [
        'title' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'link' => 'nullable|string',
    ];

    protected $listeners = [
        'open_add_modal' => 'openAddModal',
    ];

    public function openModal($id)
    {
        $this->slider_id = $id;

        dd($this->slider_id = $id);

        $content = BannerContent::where('home_slider_id', $id)->first();

        if ($content) {
            $this->title = $content->title;
            $this->description = $content->description;
            $this->link = $content->link;
        } else {
            $this->title = '';
            $this->description = '';
            $this->link = '';
        }
    }

    public function submit()
    {
        $this->validate();

        BannerContent::updateOrCreate(
            ['home_slider_id' => $this->slider_id],
            [
                'title' => $this->title,
                'description' => $this->description,
                'link' => $this->link
            ]
        );

        session()->flash('success', 'Banner content updated!');
        $this->dispatchBrowserEvent('modal-close');
    }

    public function openAddModal()
    {
       $this->reset(['description','title', 'link']);
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        $sliders = HomeSlider::all();
        return view('livewire.content.banner-conter', compact('sliders'));
    }
}
