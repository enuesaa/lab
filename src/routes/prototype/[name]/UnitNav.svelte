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
	<span class="text-3xl leading-[0.8] w-7">
		{#if showing}
			<SquareChevronDown class="inline align-middle" />
		{:else}
			<SquareChevronRight class="inline align-middle" />
		{/if}
	</span>
	<span class="break-all inline-block">{unit.title}</span>
</button>

<style lang="postcss">
	button {
		@apply font-semibold text-2xl mt-7 mb-3 pl-2 font-zenmaru flex gap-[3px] text-left;
	}
</style>
