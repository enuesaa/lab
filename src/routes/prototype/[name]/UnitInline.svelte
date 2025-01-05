<script lang="ts">
	import Code from '$lib/prototype/Code.svelte'
	import type { UnitV2 } from '$lib/prototype/types'
	import UnitSep from './UnitSep.svelte'

	export let inline: UnitV2['inline']
</script>

<UnitSep />
<div class="p-2 mb-2 bg-editorbg rounded-b-lg">
	<Code language={inline?.file?.language ?? ''} code={inline?.file?.code ?? ''} />
</div>
