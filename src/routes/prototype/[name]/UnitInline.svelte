<script lang="ts">
	import Code from '$lib/prototype/Code.svelte'
	import type { UnitV2 } from '$lib/prototype/types'
	import UnitTerminalHead from './UnitTerminalHead.svelte'

	export let inline: UnitV2['inline']
</script>

<UnitTerminalHead />
<div class="p-2 mb-2 bg-editorbg rounded-b-lg">
	<Code language={inline?.file?.language ?? ''} code={inline?.file?.code ?? ''} />
</div>
