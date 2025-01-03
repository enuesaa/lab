<script lang="ts">
	import type { CodeFiles, CodeUnit } from '$lib/prototype/types'
	import CodeAreaUnitTitle from './CodeAreaUnitTitle.svelte'
	import CodeAreaUnitDescription from './CodeAreaUnitDescription.svelte'
	import UnitTerminal from './UnitTerminal.svelte'
	import CodeAreaUnitOpenFileButton from './CodeAreaUnitOpenFileButton.svelte'

	export let codeFiles: CodeFiles
	export let unit: CodeUnit
</script>

<div class="mb-3 bg-gray rounded-xl overflow-hidden shadow-2xlu border-[0.2px] border-gray-700 text-gray-900 px-1 py-[2px]">
	{#if unit.title !== undefined}
		<CodeAreaUnitTitle title={unit.title} />
	{/if}
	{#if unit.description !== undefined}
		<CodeAreaUnitDescription description={unit.description} />
	{/if}
	{#if unit.terminal !== undefined}
		<UnitTerminal content={unit.terminal} />
	{/if}
	{#if unit.filename !== undefined}
		<CodeAreaUnitOpenFileButton filename={unit.filename} codeFiles={codeFiles} />
	{/if}
</div>
