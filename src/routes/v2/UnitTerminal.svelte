<script lang="ts">
	import Code from '$lib/prototype/Code.svelte'
	import UnitSep from './UnitSep.svelte'

	export let content: string
</script>

<div>
	<UnitSep />
	<Code language="console" code={content} />
</div>
