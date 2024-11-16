<script lang="ts">
	import type { VariantWithTreeData } from '$lib/types/tree'
	import CodeViewer from './CodeViewer.svelte'
	import VariantProvider from './VariantProvider.svelte'

	export let variant: VariantWithTreeData
	export let showing: boolean
</script>

<VariantProvider>
	<section class={showing ? '' : 'max-h-20'}>
		<!-- <VariantTitle title={variant.title} /> -->
		<CodeViewer treeData={variant.files} firstOpen={variant.open} />
		<!-- <VariantOutput output={variant.output} /> -->
	</section>
</VariantProvider>

<style lang="postcss">
	section {
		box-shadow: 0 -0.5px 1px 1px rgba(0, 0, 0, 0.2);
		@apply px-2 md:px-7 py-1 rounded-lg bg-graywhite w-full overflow-hidden;
	}
</style>
