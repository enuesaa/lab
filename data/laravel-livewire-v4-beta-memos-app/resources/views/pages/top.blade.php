<?php

use App\Models\Memo;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;

new #[Title('top')] class extends Component
{
    #[Computed]
    public function memos()
    {
        return Memo::latest('updated_at')->get();
    }
};
?>

<div>
    <livewire:pagetop title="Top">
        <a href="/memo/create" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md bg-sky-600 text-white text-sm hover:bg-sky-700">
            New Memo
        </a>
    </livewire:pagetop>

    <ul class="mt-6 space-y-3">
        @foreach ($this->memos as $memo)
            <li>
                <a href="/memos/{{ $memo->id }}" class="block bg-white rounded-lg border border-slate-100 p-4 hover:shadow-sm">
                    <h3 class="font-medium text-slate-900">{{ $memo->title }}</h3>
                    <p class="mt-1 text-sm text-slate-600 truncate">{{ $memo->content }}</p>
                </a>
            </li>
        @endforeach
    </ul>
</div>
