<script lang="ts">
	import type { TreeData } from '$lib/prototype/tree'
	import CodeTreeItemButton from './CodeTreeItemButton.svelte'

	export let treeData: TreeData[]
</script>

{#each treeData as data}
	<CodeTreeItemButton {data} />		
{/each}
