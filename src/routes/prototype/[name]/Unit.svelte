<script lang="ts">
	import UnitNav from './UnitNav.svelte'
	import UnitBody from './UnitBody.svelte'
	import type { Unit } from '$lib/prototype/types'
	import type { TreeData } from '$lib/prototype/tree'

	export let unit: Unit
	export let files: TreeData[]

	let showing: boolean = true
</script>

<UnitNav {unit} bind:showing />
<UnitBody {unit} {files} bind:showing />
