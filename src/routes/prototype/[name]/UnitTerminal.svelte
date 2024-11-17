<script lang="ts">
	import Code from './Code.svelte'
	import type { UnitWithTreeData } from '$lib/prototype/types'

	export let terminal: UnitWithTreeData['terminal']
</script>

<section class="mb-5">
	{terminal?.description}
	<Code language="console" code={terminal?.console ?? ''} />
</section>
