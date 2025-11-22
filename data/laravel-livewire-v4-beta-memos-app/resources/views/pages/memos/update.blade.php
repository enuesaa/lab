<?php

use App\Models\Memo;
use Livewire\Component;
use Livewire\Attributes\Validate;

new class extends Component
{
    public Memo $memo;
 
    #[Validate('required|max:100', message: 'Please provide a title')]
    public $title = '';
 
    #[Validate('required')]
    public $content = '';
 
    public function mount($id) 
    {
        $this->memo = Memo::findOrFail($id);
        $this->title = $this->memo->title;
        $this->content = $this->memo->content;
    }

    public function save()
    {
        $this->memo->update($this->validate());

        return redirect()->to('/');
    }
};
?>

<div>
    <livewire:pagetop title="Update" />

    <form wire:submit="save" class="space-y-3 mt-6">
        <label>
            Title
            <input type="text" wire:model="title" class="mt-1 block w-full rounded-md border px-3 py-2 text-sm">
            @error('title') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </label>
        <label>
            Content
            <textarea wire:model="content" rows="5" class="mt-1 block w-full rounded-md border px-3 py-2 text-sm"></textarea>
            @error('content') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </label>
        <div class="flex justify-end gap-2">
            <a href="/memos/{{ $memo->id }}" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md text-sm bg-transparent text-slate-700 hover:bg-slate-50">
                Cancel
            </a>
            <button type="submit" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md bg-sky-600 text-white text-sm hover:bg-sky-700">
                Save
            </button>
        </div>
    </form>
</div>
