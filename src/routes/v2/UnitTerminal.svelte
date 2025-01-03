<script lang="ts">
	import Code from '../prototype/[name]/Code.svelte'
	import UnitSep from './UnitSep.svelte'

	export let content: string
</script>

<div>
	<UnitSep />
	<Code language="console" code={content} />
</div>
