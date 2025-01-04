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

{#if hasChildren}
	{#if expanded}
		<button on:click|preventDefault={hanldeClick}>
			<ChevronDown class="absolute left-[-6px] w-[14px] stroke-[3px] align-baseline text-editortext/80" />
			<span class="ml-[5px]">{treeData.title}</span>
		</button>
	{:else}
		<button on:click|preventDefault={hanldeClick} class="">
			<ChevronRight class="absolute left-[-5px] w-[14px] stroke-[3px] align-baseline text-editortext/80" />
			<span class="ml-[5px]">{treeData.title}</span>
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
	<div class="border-l border-gray-700 ml-2 mt-[1px] mb-[6px] pl-2">
		{#each treeData.children as d}
			<svelte:self treeData={d} />
		{/each}
	</div>
{/if}

<style lang="postcss">
	button {
		@apply block ml-1 px-1 my-[1px] text-left text-editortext;
		@apply rounded-sm select-none relative;

		&.selected-file {
			@apply bg-editorsep/50 border-editortext/50 border-[0.5px];
			@apply underline underline-offset-[5px] decoration-gray-700;
		}
		&.notselected-file {
			@apply border-[0.5px] border-transparent;
		}
	}
</style>
