<script lang="ts">
	import { getViewing } from '$lib/prototype/tree'
	import { onMount } from 'svelte'
	import Code from '$lib/prototype/Code.svelte'
	import CodeTree from '$lib/prototype/CodeTree.svelte'
	import UnitSep from './UnitSep.svelte'
	import type { CodeFiles } from '$lib/prototype/types'
	import CodeCopyButton from './CodeCopyButton.svelte'
	import CodeAreaFileTag from './CodeAreaFileTag.svelte'

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

{#key $viewing}
	<section class="rounded-lg bg-editorbg relative">
		<UnitSep text="</>" />

		<div class="text-base flex">
			<ul class="flex-none pr-2 pt-2 pb-2 pl-3 border-r-editorsep border-r min-h-[800px] w-2/12 min-w-32 max-w-96 overflow-scroll">
				<CodeTree treeData={codeFiles} />
			</ul>
			<div class="flex-auto overflow-scroll relative">
				{#if $viewing !== undefined}
					<Code language={$viewing.language} code={$viewing.code} showLineNumber={true} />
				{/if}
			</div>
		</div>

		{#if $viewing !== undefined}
			<CodeAreaFileTag filename={$viewing.id} />
			<CodeCopyButton text={$viewing.code} />
		{/if}
	</section>
{/key}
