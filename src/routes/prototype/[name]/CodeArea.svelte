<script lang="ts">
	import type { CodeUnit, UnitV2 } from '$lib/prototype/types'
	import { initCodeViewer } from '$lib/prototype/tree'
	import CodeViewer from '$lib/prototype/CodeViewer.svelte'
	import CodeAreaUnit from './CodeAreaUnit.svelte'
	import CodeAreaHead from './CodeAreaHead.svelte'

	initCodeViewer()

	export let unit: UnitV2
	let codeFiles = unit.code?.files ?? []
	let showCodeUnits = true

	let codeUnits: CodeUnit[] = unit?.code?.units ?? []
</script>

<section class="bg-gray-600 pt-1 pb-8 relative mt-9 mb-7">
	<CodeAreaHead bind:showCodeUnits {codeFiles} title={unit?.title} />

	<div class="w-[99vw] m-auto flex gap-2 max-md:gap-1">
		<div class={showCodeUnits ? 'flex-none w-[70%] max-md:w-[55%]' : 'w-full'}>
			<CodeViewer {codeFiles} firstOpen={unit.code?.open ?? ''} />
		</div>

		{#if showCodeUnits}
			<div class="flex-auto relative z-10">
				<div class="absolute -top-8 left-3 font-semibold font-zenmaru text-lg text-gray-900">メモ</div>
				{#each codeUnits as codeUnit}
					<CodeAreaUnit unit={codeUnit} {codeFiles} />
				{/each}
			</div>
		{/if}
	</div>
</section>

<style lang="postcss">
	section {
		background-image: radial-gradient(#a5a5a5 2px, transparent 2px);
		background-size: 20px 20px;
	}
</style>
