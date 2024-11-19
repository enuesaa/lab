<script lang="ts">
	import type { Unit } from '$lib/prototype/types'
	import { createTreeViewCtl, createViewing, type TreeData } from '$lib/prototype/tree'
	import CodeViewer from './CodeViewer.svelte'
	import UnitHider from './UnitHider.svelte'
	import UnitDescription from './UnitDescription.svelte'
	import UnitTerminal from './UnitTerminal.svelte'
	import UnitSep from './UnitSep.svelte'
	import Description from './Description.svelte'

	createTreeViewCtl()
	createViewing()

	export let unit: Unit
	export let files: TreeData[]
	export let showing: boolean
</script>

{#if unit.description !== undefined}
	<UnitDescription description={unit.description} />
{/if}

<section class={showing ? '' : 'max-h-20'}>
	{#if unit.open !== undefined}
		<UnitSep text="エディタ" />
		<CodeViewer treeData={files} firstOpen={unit.open} />
	{/if}

	{#if unit.console !== undefined}
		<UnitSep text="ターミナル" />
		<UnitTerminal content={unit.console} />
	{/if}

	{#if !showing}
		<UnitHider bind:showing />
	{/if}
</section>

<style lang="postcss">
	section {
		@apply rounded-lg bg-graywhite w-full;
		@apply relative overflow-hidden mt-1;
	}
</style>
