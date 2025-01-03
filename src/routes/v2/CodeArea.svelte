<script lang="ts">
	import type { CodeUnit, UnitV2 } from '$lib/prototype/types'
	import { createTreeViewCtl, createViewing } from '$lib/prototype/tree'
	import CodeAreaViewer from './CodeAreaViewer.svelte'
	import CodeAreaUnit from './CodeAreaUnit.svelte'
	import CodeAreaHead from './CodeAreaHead.svelte'
	import CodeAreaOverlay from './CodeAreaOverlay.svelte'

	createTreeViewCtl()
	createViewing()

	export let unit: UnitV2
	let codeFiles = unit.code?.files ?? []
	let showCodeUnits = true

	let codeUnits: CodeUnit[] = unit?.code?.units ?? []
</script>

<section>
	<CodeAreaHead bind:showCodeUnits={showCodeUnits} {codeFiles} />

	<div class="w-[98vw] m-auto flex gap-2">
		<div class={showCodeUnits ? 'flex-none w-8/12 max-md:w-full' : 'w-full'}>
			<CodeAreaViewer {codeFiles} firstOpen={unit.code?.open ?? ''} />
		</div>

		{#if showCodeUnits}
			<div class="overflow-hidden max-md:absolute max-md:w-[80vw] max-md:right-1 px-1 relative mt-[-15px] z-10">
				{#each codeUnits as codeUnit}
					<CodeAreaUnit unit={codeUnit} {codeFiles} />
				{/each}
			</div>
		{/if}
	</div>

	{#if showCodeUnits}
		<CodeAreaOverlay bind:showCodeUnits={showCodeUnits} />
	{/if}
</section>

<style lang="postcss">
	section {
		background-image: radial-gradient(#a5a5a5 2px, transparent 2px);
		background-size: 20px 20px;
		@apply bg-gray-600 pb-3 relative;
		@apply mt-2 mb-7;
	}
</style>
