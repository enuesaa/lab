<script lang="ts">
	import { getViewing } from '$lib/prototype/tree'
	import { onMount } from 'svelte'
	import Code from '$lib/prototype/Code.svelte'
	import CodeSep from './CodeSep.svelte'
	import type { CodeFiles } from '$lib/prototype/types'
	import CodeCopyButton from './CodeCopyButton.svelte'
	import CodeAreaFileTag from './CodeFileTag.svelte'
	import CodeTreeItemButton from './CodeTreeItemButton.svelte'
	import { PaneGroup, Pane, PaneResizer } from 'paneforge'
	import { Dot } from 'lucide-svelte'

	export let codeFiles: CodeFiles
	export let firstOpen: string

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

<section class="rounded-lg bg-editorbg relative text-base">
	<CodeSep />

	<!-- PanelGroup で overflow: hidden がデフォルトで付与されるので上書きしている -->
	<PaneGroup direction="horizontal" style="overflow: visible">
		<Pane defaultSize={15} class="p-2 pl-4 min-h-[800px] min-w-32 max-w-80">
			{#each codeFiles as treeData}
				<CodeTreeItemButton {treeData} />
			{/each}
		</Pane>
		<PaneResizer class="w-[1px] bg-gray-600/80 relative">
			<Dot class="absolute top-48 left-[-10px] bg-editorbg text-editortext overflow-visible z-10 w-5" />
			{#key $viewing}
				{#if $viewing !== undefined}
					<CodeAreaFileTag filename={$viewing.title} />
				{/if}
			{/key}
		</PaneResizer>
		<Pane style="overflow: scroll">
			{#key $viewing}
				{#if $viewing !== undefined}
					<Code language={$viewing.language} code={$viewing.code} showLineNumber={true} />
				{/if}
			{/key}
		</Pane>
	</PaneGroup>

	{#key $viewing}
		{#if $viewing !== undefined}
			<CodeCopyButton text={$viewing.code} />
		{/if}
	{/key}
</section>
