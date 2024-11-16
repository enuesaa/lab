<script lang="ts">
	import UnitNav from './UnitNav.svelte'
	import UnitBody from './UnitBody.svelte'
	import type { UnitWithTreeData } from '$lib/tree'

	export let unit: UnitWithTreeData

	let showing: boolean = true
</script>

<UnitNav {unit} bind:showing={showing} />
<UnitBody {unit} bind:showing={showing} />
