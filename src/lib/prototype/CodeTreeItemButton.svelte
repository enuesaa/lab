<script lang="ts">
	import { getViewing } from '$lib/prototype/tree'
	import type { TreeData } from '$lib/prototype/tree'
	import { Check, ChevronDown, ChevronRight } from 'lucide-svelte'

	export let data: TreeData
	const hasChildren = data.children.length > 0
	let expanded = true

	const viewing = getViewing()

	function hanldeClick() {
		if (hasChildren) {
			expanded = !expanded
			return
		}
		viewing.set(data)
	}
</script>

<li class="block text-editortext pl-1">
	{#if hasChildren}
		{#if expanded}
			<button on:click|preventDefault={hanldeClick}>
				<ChevronDown class="absolute -left-[10px] w-[14px] stroke-[3px] align-baseline text-gray-500" />
				{data.title}
			</button>
		{:else}
			<button on:click|preventDefault={hanldeClick}>
				<ChevronRight class="absolute -left-[10px] w-[14px] stroke-[3px] align-baseline text-gray-500" />
				{data.title}
			</button>
		{/if}
	{:else}
		{#if $viewing?.id === data.id}
			<button on:click|preventDefault={hanldeClick} class='selected-file'>
				{data.title}
			</button>
		{:else}
			<button on:click|preventDefault={hanldeClick} class='notselected-file'>
				{data.title}
			</button>
		{/if}
	{/if}

	{#if hasChildren && expanded}
		<ul class="border-l border-gray-700 ml-2 mb-1 pl-1">
			{#each data.children as d}
				<svelte:self data={d} />
			{/each}
		</ul>
	{/if}
</li>

<style lang="postcss">
	button {
		@apply inline-block py-[1px] mt-[1px] px-1 text-left;
		@apply rounded-sm select-none relative;

		&.selected-file {
			@apply bg-editorsep/50 border-editortext/50 border-[0.5px];
			@apply underline underline-offset-[6px] decoration-gray-700;
		}
		&.notselected-file {
			@apply border-[0.5px] border-transparent;
		}
	}
</style>
