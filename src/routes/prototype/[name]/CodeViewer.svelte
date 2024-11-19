<script lang="ts">
	import { getTreeViewCtl, getViewing } from '$lib/prototype/tree'
	import type { TreeData } from '$lib/prototype/tree'
	import { onMount } from 'svelte'
	import Code from './Code.svelte'
	import CodeTree from './CodeTree.svelte'

	export let treeData: TreeData[]
	export let firstOpen: string

	const { tree } = getTreeViewCtl()
	const viewing = getViewing()
	onMount(() => {
		for (const data of treeData) {
			if (data.id === firstOpen) {
				viewing.set(data)
				break
			}
		}
	})
</script>

<section>
	<ul class="flex-none pr-2 pt-2 pb-2 border-r-editorsep border-r" {...$tree}>
		<CodeTree {treeData} />
	</ul>
	<div class="flex-auto">
		{#key $viewing}
			{#if $viewing !== undefined}
				<Code language={$viewing.language} code={$viewing.code} />
			{/if}
		{/key}
	</div>
</section>

<style lang="postcss">
	section {
		@apply bg-editorbg text-editortext text-base;
		@apply flex overflow-y-scroll min-h-12;
	}
</style>
