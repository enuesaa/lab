<script lang="ts">
	import Code from '$lib/prototype/Code.svelte'
	import UnitSep from './UnitSep.svelte'

	export let content: string
</script>

<UnitSep />
<div class="py-2 pl-2 pb-1 bg-editorbg rounded-b-lg">
	<Code language="console" code={content} />
</div>
