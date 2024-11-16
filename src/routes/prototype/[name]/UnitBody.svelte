<script lang="ts">
	import type { UnitWithTreeData } from '$lib/types/tree'
	import CodeViewer from './CodeViewer.svelte'
	import UnitProvider from './UnitProvider.svelte'

	export let unit: UnitWithTreeData
	export let showing: boolean
</script>

<UnitProvider>
	<section class={showing ? '' : 'max-h-20'}>
		<!-- <UnitTitle title={unit.title} /> -->
		<CodeViewer treeData={unit.files} firstOpen={unit.open} />
		<!-- <UnitOutput output={unit.output} /> -->
	</section>
</UnitProvider>

<style lang="postcss">
	section {
		box-shadow: 0 -0.5px 1px 1px rgba(0, 0, 0, 0.2);
		@apply px-2 md:px-7 py-1 rounded-lg bg-graywhite w-full overflow-hidden;
	}
</style>
