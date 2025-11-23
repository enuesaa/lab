<script lang="ts">
	import type { UnitV2 } from '$lib/prototype/types'
	import UnitTitle from './UnitTitle.svelte'
	import UnitDescription from './UnitDescription.svelte'
	import UnitLinks from './UnitLinks.svelte'
	import UnitImage from './UnitImage.svelte'
	import UnitTerminal from './UnitTerminal.svelte'
	import CodeArea from './CodeArea.svelte'
	import UnitInline from './UnitInline.svelte'
	import UnitCap from './UnitCap.svelte'

	export let projectName: string
	export let unit: UnitV2

	const isNormalContent = unit?.code === undefined
</script>

{#if isNormalContent}
	<section class="w-full relative overflow-hidden container max-w-[1150px] mx-auto px-1 pt-2 pb-2">
		{#if unit?.cap !== undefined}
			<UnitCap text={unit.cap} />
		{/if}
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
		{#if unit?.inline !== undefined}
			<UnitInline inline={unit.inline} />
		{/if}
	</section>
{:else}
	<CodeArea {unit} />
{/if}
