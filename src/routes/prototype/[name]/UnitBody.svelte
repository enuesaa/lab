<script lang="ts">
	import type { UnitWithTreeData } from '$lib/prototype/types'
	import { createTreeViewCtl, createViewing } from '$lib/prototype/tree'
	import CodeViewer from './CodeViewer.svelte'
	import UnitHider from './UnitHider.svelte'
	import UnitDescription from './UnitDescription.svelte'

	createTreeViewCtl()
	createViewing()

	export let unit: UnitWithTreeData
	export let showing: boolean
</script>

<section class={showing ? '' : 'max-h-20'}>
	{#if unit.description !== undefined}
	<UnitDescription description={unit.description} />
	{/if}

	{#if unit.filetree !== undefined}
	<CodeViewer treeData={unit.files} firstOpen={unit?.filetree?.open ?? ''} />
	{/if}

	<!-- <UnitOutput output={unit.output} /> -->

	{#if !showing}
		<UnitHider bind:showing />
	{/if}
</section>

<style lang="postcss">
	section {
		box-shadow: 0 -0.5px 1px 1px rgba(0, 0, 0, 0.2);
		@apply px-2 md:px-7 py-1 rounded-lg bg-graywhite w-full;
		@apply relative overflow-hidden;
	}
</style>
