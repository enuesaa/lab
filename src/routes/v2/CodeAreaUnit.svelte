<script lang="ts">
	import type { UnitV2 } from '$lib/prototype/types'
	import CodeAreaUnitTitle from './CodeAreaUnitTitle.svelte'
	import UnitDescription from './UnitDescription.svelte'
	import UnitTerminal from './UnitTerminal.svelte'

	export let unit: UnitV2
</script>

<div class="mb-3 bg-gray rounded-lg overflow-hidden shadow-2xlu border-[0.2px] border-gray-700">
	{#if unit.title !== undefined}
		<CodeAreaUnitTitle title={unit.title} />
	{/if}
	{#if unit.description !== undefined}
		<UnitDescription description={unit.description} />
	{/if}
	{#if unit.terminal !== undefined}
		<UnitTerminal content={unit.terminal} />
	{/if}
</div>
