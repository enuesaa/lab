<script lang="ts">
	import type { TreeData } from '$lib/prototype/tree'
	import UnitSepDownloader from './UnitSepDownloader.svelte'

	export let text: string
	export let treeData: TreeData[] = []
	export let enableDownloader: boolean = false
</script>

<div>
	{text}

	{#if enableDownloader}
		<UnitSepDownloader {treeData} />
	{/if}
</div>

<style lang="postcss">
	div {
		@apply w-full px-2 pt-1 pb-[2px] font-medium text-sm bg-editorsep text-gray;
		@apply border-t-[0.5px] border-b-[0.5px] border-editortext/50 text-center;
		@apply relative;
	}
</style>
