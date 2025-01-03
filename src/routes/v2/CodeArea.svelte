<script lang="ts">
	import type { CodeFiles, ProjectV2, UnitV2 } from '$lib/prototype/types'
	import UnitSep from '../prototype/[name]/UnitSep.svelte'
	import CodeViewer from './CodeViewer.svelte'
	import CodeAreaUnit from './CodeAreaUnit.svelte'
	import CodeAreaHead from './CodeAreaHead.svelte'

	export let project: ProjectV2
	export let codeFiles: CodeFiles
	let showCodeUnits = true

	let units: UnitV2[] = []
	$: units = project?.code?.units ?? []
</script>

<CodeAreaHead bind:showCodeUnits={showCodeUnits} />

<section class="w-[98vw] m-auto flex gap-2">
	<div class={showCodeUnits ? 'w-7/12 max-md:w-full' : 'w-full'}>
		<div class="rounded-lg overflow-hidden">
			<UnitSep text="</>" treeData={codeFiles} enableDownloader />
			<CodeViewer treeData={codeFiles} firstOpen={project.code?.open ?? ''} />
		</div>
	</div>

	{#if showCodeUnits}
		<div class="w-5/12 max-md:absolute max-md:w-[90vw] max-md:right-1 px-1 relative mt-[-15px]">
			{#each units as unit}
				<CodeAreaUnit {unit} />
			{/each}
		</div>
	{/if}
</section>
