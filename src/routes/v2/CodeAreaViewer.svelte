<script lang="ts">
	import { getTreeViewCtl, getViewing } from '$lib/prototype/tree'
	import { onMount } from 'svelte'
	import Code from '../prototype/[name]/Code.svelte'
	import CodeTree from '../prototype/[name]/CodeTree.svelte'
	import UnitSep from './UnitSep.svelte'
	import type { CodeFiles } from '$lib/prototype/types'

	export let codeFiles: CodeFiles
	export let firstOpen: string

	const { tree } = getTreeViewCtl()
	const viewing = getViewing()
	onMount(() => {
		for (const data of codeFiles) {
			if (data.id === firstOpen) {
				viewing.set(data)
				break
			}
		}
	})
</script>

<section class="rounded-lg overflow-hidden">
	<UnitSep text="</>" />

	<div class="bg-editorbg text-editortext text-base flex">
		<ul class="flex-none pr-2 pt-2 pb-2 border-r-editorsep border-r" {...$tree}>
			<CodeTree treeData={codeFiles} />
		</ul>
		<div class="flex-auto">
			{#key $viewing}
				{#if $viewing !== undefined}
					<Code language={$viewing.language} code={$viewing.code} />
				{/if}
			{/key}
		</div>
	</div>
</section>
