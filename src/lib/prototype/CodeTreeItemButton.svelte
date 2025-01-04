<script lang="ts">
	import { getViewing } from '$lib/prototype/tree'
	import type { TreeData } from '$lib/prototype/tree'
	import { ChevronDown, ChevronRight } from 'lucide-svelte'

	export let treeData: TreeData
	const hasChildren = treeData.children.length > 0
	let expanded = true

	const viewing = getViewing()

	function hanldeClick() {
		if (hasChildren) {
			expanded = !expanded
			return
		}
		viewing.set(treeData)
	}
</script>

<li class="block text-editortext">
	{#if hasChildren}
		{#if expanded}
			<button on:click|preventDefault={hanldeClick}>
				<ChevronDown class="absolute left-[-7px] w-[14px] stroke-[3px] align-baseline text-gray-500" />
				<span class="ml-[2px]">{treeData.title}</span>
			</button>
		{:else}
			<button on:click|preventDefault={hanldeClick}>
				<ChevronRight class="absolute left-[-7px] w-[14px] stroke-[3px] align-baseline text-gray-500" />
				<span class="ml-[2px]">{treeData.title}</span>
			</button>
		{/if}
	{:else}
		{#if $viewing?.id === treeData.id}
			<button on:click|preventDefault={hanldeClick} class='selected-file'>
				{treeData.title}
			</button>
		{:else}
			<button on:click|preventDefault={hanldeClick} class='notselected-file'>
				{treeData.title}
			</button>
		{/if}
	{/if}

	{#if hasChildren && expanded}
		<ul class="border-l border-gray-700 ml-[6px] mb-1 pl-[6px]">
			{#each treeData.children as d}
				<svelte:self treeData={d} />
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
