<script lang="ts">
	import { getTreeViewCtl, getViewing } from '$lib/prototype/tree'
	import { onMount } from 'svelte'
	import Code from '$lib/prototype/Code.svelte'
	import CodeTree from '$lib/prototype/CodeTree.svelte'
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

<section class="rounded-lg overflow-hidden bg-editorbg">
	<UnitSep text="</>" />

	<div class="text-base flex">
		<ul class="flex-none pr-2 pt-2 pb-2 border-r-editorsep border-r min-h-[800px]" {...$tree}>
			<CodeTree treeData={codeFiles} />
		</ul>
		<div class="flex-auto overflow-scroll">
			{#key $viewing}
				{#if $viewing !== undefined}
					<Code language={$viewing.language} code={$viewing.code} showLineNumber={true} />
				{/if}
			{/key}
		</div>
	</div>
</section>
