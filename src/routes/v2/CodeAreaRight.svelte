<script lang="ts">
	import type { UnitV2 } from '$lib/prototype/types'
	import HideButton from './HideButton.svelte'
	import Unit from './Unit.svelte'

	export let units: UnitV2[]

	let show = true
</script>

<HideButton bind:show={show} />

{#if show}
	<div class="w-5/12 max-md:absolute max-md:w-[90vw] max-md:right-1 px-1 relative bg-gray shadow-lg rounded-lg">
		{#each units as unit}
			<Unit {unit} />
		{/each}
	</div>
{/if}
