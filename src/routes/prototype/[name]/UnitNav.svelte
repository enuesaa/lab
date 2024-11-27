<script lang="ts">
	import type { Unit } from '$lib/prototype/types'
	import { SquareChevronRight, SquareChevronDown } from 'lucide-svelte'

	export let unit: Unit
	export let showing: boolean

	function handleClick() {
		showing = !showing
	}
</script>

<button on:click|preventDefault={handleClick}>
	<span class="text-4xl">
		{#if showing}
			<SquareChevronDown class="inline" />
		{:else}
			<SquareChevronRight class="inline" />
		{/if}
	</span>
	{unit.title}
</button>

<style lang="postcss">
	button {
		@apply font-semibold text-2xl mt-6 mb-2 pl-2 font-zenmaru;
	}
</style>
