<script lang="ts">
	import { melt } from '@melt-ui/svelte'
	import { getTreeViewCtl, getViewing } from '$lib/prototype/tree'
	import type { TreeData } from '$lib/prototype/tree'

	export let data: TreeData
	const hasChildren = data.children.length > 0

	const { item } = getTreeViewCtl()
	const viewing = getViewing()

	function hanldeClick() {
		if (hasChildren) {
			return
		}
		viewing.set(data)
	}
</script>

<button
	use:melt={$item({
		id: data.id,
		hasChildren,
	})}
	on:click|preventDefault={hanldeClick}
	disabled={data.isDir}
	class={$viewing?.id === data.id ? 'bg-editorsep/50 border-editortext/50 border-[0.5px]' : ''}
>
	{data.title}
</button>

<style lang="postcss">
	button {
		@apply inline-block py-[1px] mt-[1px] px-1 text-left;
		@apply rounded-sm select-none;
	}
</style>
