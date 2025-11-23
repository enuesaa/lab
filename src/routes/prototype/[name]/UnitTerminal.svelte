<script lang="ts">
	import Code from '$lib/prototype/Code.svelte'
	import UnitTerminalHead from './UnitTerminalHead.svelte'

	export let content: string
</script>

<UnitTerminalHead />
<div class="py-2 pl-2 pb-1 bg-editorbg rounded-b-lg">
	<Code language="console" code={content} />
</div>
