<?php
 
use App\Models\Memo;
use Livewire\Attributes\Title;
use Livewire\Component;
 
new #[Title('memo')] class extends Component
{
    public Memo $memo;
 
    public function mount($id) 
    {
        $this->memo = Memo::findOrFail($id);
    }

    public function delete()
    {
        $this->memo->deleteOrFail();

        return redirect()->to('/');
    }
};
?>

<div>
    <livewire:pagetop title="{{ $memo->title }}">
        <div class="flex justify-end gap-2">
            <button wire:click="delete" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md text-sm bg-transparent text-slate-700 hover:bg-slate-50">
                Delete
            </button>
            <a href="/memos/{{ $memo->id }}/update" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md bg-sky-600 text-white text-sm hover:bg-sky-700">
                Update
            </a>
        </div>
    </livewire:pagetop>

    <div class="text-sm text-slate-500 mb-3">
        Created {{ $memo->created_at->diffForHumans() }}
    </div>

    <div class="bg-white rounded-lg border border-slate-100 p-6 prose prose-slate max-w-none">
        {{ $memo->content }}
    </div>
</div>
