<script lang="ts">
	import { NotepadText, SquareX } from 'lucide-svelte'

	export let showCodeUnits: boolean

	function handleClick() {
		showCodeUnits = !showCodeUnits
	}
</script>

{#if showCodeUnits}
	<button on:click|preventDefault={handleClick}>
		<SquareX class="inline align-bottom stroke-2 w-[22px]" /> Hide
	</button>
{:else}
	<button on:click|preventDefault={handleClick}>
		<NotepadText class="inline align-bottom stroke-2 w-[22px]" /> Notes
	</button>
{/if}

<style lang="postcss">
	button {
		@apply inline-block font-semibold text-lg my-2 font-zenmaru;
		@apply absolute right-9 top-[12px] rounded-xl px-[10px] pt-[1px] pb-[3.5px] bg-gray shadow-2xl;
		@apply z-10;
		@apply hover:bg-gray-500 hover:border-[0.2px] hover:border-gray-700;
	}
</style>
