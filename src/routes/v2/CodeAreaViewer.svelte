<script lang="ts">
	import { getViewing } from '$lib/prototype/tree'
	import { onMount } from 'svelte'
	import Code from '$lib/prototype/Code.svelte'
	import CodeTree from '$lib/prototype/CodeTree.svelte'
	import UnitSep from './UnitSep.svelte'
	import type { CodeFiles } from '$lib/prototype/types'
	import CodeCopyButton from './CodeCopyButton.svelte'

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

<section class="rounded-lg overflow-hidden bg-editorbg">
	<UnitSep text="</>" />

	<div class="text-base flex">
		<ul class="flex-none pr-2 pt-2 pb-2 pl-3 border-r-editorsep border-r min-h-[800px] w-2/12 min-w-32 max-w-96 overflow-scroll">
			<CodeTree treeData={codeFiles} />
		</ul>
		<div class="overflow-scroll relative">
			{#key $viewing}
				{#if $viewing !== undefined}
					<Code language={$viewing.language} code={$viewing.code} showLineNumber={true} />
					<CodeCopyButton text={$viewing.code} />
				{/if}
			{/key}
		</div>
	</div>
</section>
