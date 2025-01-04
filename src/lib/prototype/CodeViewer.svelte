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

<section class="rounded-lg bg-editorbg relative">
	<CodeSep />

	<PaneGroup direction="horizontal" class="text-base flex">
		<Pane defaultSize={20} class="flex-none pr-2 pt-2 pb-2 pl-3 border-r-editorsep border-r min-h-[800px] min-w-32 max-w-96 overflow-scroll">
			{#each codeFiles as treeData}
				<CodeTreeItemButton data={treeData} />
			{/each}
		</Pane>
		<PaneResizer class="w-[1px] bg-gray-600/80 relative">
			<Dot class="absolute top-1/3 left-[-10px] bg-editorbg text-editortext overflow-visible z-10 w-5" />
		</PaneResizer>
		<Pane class="flex-auto relative overflow-scroll">
			{#if $viewing !== undefined}
				<Code language={$viewing.language} code={$viewing.code} showLineNumber={true} />
			{/if}
		</Pane>
	</PaneGroup>

	{#if $viewing !== undefined}
		<CodeAreaFileTag filename={$viewing.title} />
		<CodeCopyButton text={$viewing.code} />
	{/if}
</section>
