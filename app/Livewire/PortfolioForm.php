<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\BentoPortfolio;
use Illuminate\Support\Facades\Log;

class PortfolioForm extends Component
{
    use WithFileUploads;

    public $name;
    public $introduction;
    public $pronouns;
    public $occupation;
    public $about;
    public $twitter;
    public $instagram;
    public $facebook;
    public $threads;
    public $profilepic;
    public $image2;
    public $image3;

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'profilepic' => 'image|max:1024', // 1MB Max
            'occupation' => 'required|string|max:255',
            'pronouns' => 'string|max:255',
            'introduction' => 'string|max:1024',
            'image2' => 'image|max:1024',
            'about' => 'string|max:1024',
            'image3' => 'image|max:1024',
            'twitter' => 'string|url|max:255',
            'instagram' => 'string|url|max:255',
            'facebook' => 'string|url|max:255',
            'threads' => 'string|url|max:255',
        ]);

        try {
            $profilepicPath = $this->profilepic ? $this->profilepic->store('photos', 'public') : null;
            $image2Path = $this->image2 ? $this->image2->store('photos', 'public') : null;
            $image3Path = $this->image3 ? $this->image3->store('photos', 'public') : null;

            BentoPortfolio::create([
                'name' => $this->name,
                'introduction' => $this->introduction,
                'pronouns' => $this->pronouns,
                'occupation' => $this->occupation,
                'about' => $this->about,
                'twitter' => $this->twitter,
                'instagram' => $this->instagram,
                'facebook' => $this->facebook,
                'threads' => $this->threads,
                'profilepic' => $profilepicPath,
                'image2' => $image2Path,
                'image3' => $image3Path,
            ]);

            $this->resetForm();

            session()->flash('message', 'Documentation added successfully.');

            return redirect('/dashboard');
        } catch (\Exception $e) {
            Log::error('Error saving portfolio: ' . $e->getMessage());
            session()->flash('error', 'There was an error saving your portfolio.');
        }
    }

    public function resetForm()
    {
        $this->name = '';
        $this->introduction = '';
        $this->pronouns = '';
        $this->occupation = '';
        $this->about = '';
        $this->twitter = '';
        $this->instagram = '';
        $this->facebook = '';
        $this->threads = '';
        $this->profilepic = null;
        $this->image2 = null;
        $this->image3 = null;
    }

    public function render()
    {
        return view('livewire.portfolio-form');
    }
}
