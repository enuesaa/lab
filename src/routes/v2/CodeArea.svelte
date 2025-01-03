<script lang="ts">
	import type { CodeFiles, ProjectV2, UnitV2 } from '$lib/prototype/types'
	import { createTreeViewCtl, createViewing } from '$lib/prototype/tree'
	import CodeAreaViewer from './CodeAreaViewer.svelte'
	import CodeAreaUnit from './CodeAreaUnit.svelte'
	import CodeAreaHead from './CodeAreaHead.svelte'
	import CodeAreaOverlay from './CodeAreaOverlay.svelte'

	createTreeViewCtl()
	createViewing()

	export let project: ProjectV2
	export let codeFiles: CodeFiles
	let showCodeUnits = true

	let units: UnitV2[] = []
	$: units = project?.code?.units ?? []
</script>

<section class="bg-gray-600 pb-3 relative">
	<CodeAreaHead bind:showCodeUnits={showCodeUnits} {codeFiles} />

	<div class="w-[98vw] m-auto flex gap-2">
		<div class={showCodeUnits ? 'w-7/12 max-md:w-full' : 'w-full'}>
			<CodeAreaViewer {codeFiles} firstOpen={project.code?.open ?? ''} />
		</div>

		{#if showCodeUnits}
			<div class="w-5/12 max-md:absolute max-md:w-[90vw] max-md:right-1 px-1 relative mt-[-15px] z-10">
				{#each units as unit}
					<CodeAreaUnit {unit} />
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
	}
</style>
