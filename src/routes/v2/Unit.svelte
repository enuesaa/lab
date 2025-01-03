<script lang="ts">
	import type { CodeFiles, UnitV2 } from '$lib/prototype/types'
	// import CodeViewer from './CodeViewer.svelte'
	import UnitTitle from './UnitTitle.svelte'
	import UnitDescription from './UnitDescription.svelte'
	import UnitLinks from './UnitLinks.svelte'
	import UnitImage from './UnitImage.svelte'
	import UnitTerminal from './UnitTerminal.svelte'

	export let projectName: string
	export let unit: UnitV2
	export let codeFiles: CodeFiles

	const centralize = unit?.title !== undefined
</script>

{#if centralize}
	<section>
		{#if unit?.title !== undefined}
			<UnitTitle title={unit.title} />
		{/if}
		{#if unit.description !== undefined}
			<UnitDescription description={unit.description} />
		{/if}
		{#if unit.links !== undefined}
			<UnitLinks links={unit.links} />
		{/if}	
		{#if unit.image !== undefined}
			<UnitImage {projectName} image={unit.image} />
		{/if}
		{#if unit?.terminal !== undefined}
			<UnitTerminal content={unit.terminal} />
		{/if}
	</section>
{/if}

<style lang="postcss">
	section {
		@apply w-full relative mt-1 overflow-hidden;
		@apply container mx-auto pt-1 px-1 pb-7;
	}
</style>
