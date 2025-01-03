<script lang="ts">
	import Code from '$lib/prototype/Code.svelte'
	import UnitSep from './UnitSep.svelte'

	export let content: string
</script>

<UnitSep />
<div class="pt-2 bg-editorbg">
	<Code language="console" code={content} />
</div>
