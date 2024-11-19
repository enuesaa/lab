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
		@apply font-semibold text-2xl mt-4 mb-2 pl-2 font-zenmaru;
	}
</style>

<!-- 
<nav class="m-0 pl-3">
	<button class="bg-graywhite" on:click|preventDefault={handleClick}>
		{unit.title}
	</button>
</nav>

<style lang="postcss">
	nav {
		@apply flex;
		overflow: scroll;
	}
	button {
		overflow: hidden;
		flex: 0 0 auto;
		@apply mt-3 mx-1 px-6 py-2 rounded-t-lg border-editorbg/50 border-2 border-b-0;
		@apply font-bold text-xl;
		@apply bg-white/30 text-editorbg/80;
	}
</style> -->
