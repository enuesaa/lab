<script lang="ts">
	import type { Project, Unit } from '$lib/prototype/types'
	import { createTreeViewCtl, createViewing, type TreeData } from '$lib/prototype/tree'
	import CodeViewer from './CodeViewer.svelte'
	import UnitHider from './UnitHider.svelte'
	import UnitDescription from './UnitDescription.svelte'
	import UnitLinks from './UnitLinks.svelte'
	import UnitImage from './UnitImage.svelte'
	import UnitTerminal from './UnitTerminal.svelte'
	import UnitSep from './UnitSep.svelte'

	createTreeViewCtl()
	createViewing()

	export let project: Project
	export let unit: Unit
	export let files: TreeData[]
	export let showing: boolean
</script>

<section class={showing ? '' : 'max-h-20'}>
	{#if unit.description !== undefined}
		<UnitDescription description={unit.description} />
	{/if}

	{#if unit.links !== undefined}
		<UnitLinks links={unit.links} />
	{/if}

	{#if unit.image !== undefined}
		<UnitImage {project} image={unit.image} />
	{/if}

	<div class="rounded-lg overflow-hidden mt-1">
		{#if unit.open !== undefined}
			<UnitSep text="</>" treeData={files} enableDownloader />
			<CodeViewer treeData={files} firstOpen={unit.open} />
		{/if}

		{#if unit.console !== undefined}
			<UnitSep text="ターミナル" />
			<UnitTerminal content={unit.console} />
		{/if}
	</div>

	{#if !showing}
		<UnitHider bind:showing />
	{/if}
</section>

<style lang="postcss">
	section {
		@apply w-full relative mt-1 overflow-hidden;
	}
</style>
