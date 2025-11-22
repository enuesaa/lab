<?php

use App\Models\Memo;
use Livewire\Component;
use Livewire\Attributes\Computed;

new class extends Component
{
    #[Computed]
    public function memos()
    {
        return Memo::all();
    }
};
?>

<ul class="mt-6 space-y-3">
    @foreach ($this->memos as $memo)
        <li>{{ $memo->title }}</li>
    @endforeach
</ul>
