<script lang="ts">
	import type { UnitV2 } from '$lib/prototype/types'
	import UnitSep from '../prototype/[name]/UnitSep.svelte'
	import UnitNav from './UnitNav.svelte'
	import UnitDescription from '../prototype/[name]/UnitDescription.svelte'
	import UnitTerminal from '../prototype/[name]/UnitTerminal.svelte'

	export let unit: UnitV2
</script>

<div class="mb-2">
	{#if unit.title !== undefined}
		<UnitNav title={unit.title} />
	{/if}
	{#if unit.description !== undefined}
		<UnitDescription description={unit.description} />
	{/if}
	{#if unit.terminal !== undefined}
		<UnitSep text="ターミナル" />
		<div class="h-[210px]">
			<UnitTerminal content={unit.terminal} />
		</div>
	{/if}

	<slot />
</div>
