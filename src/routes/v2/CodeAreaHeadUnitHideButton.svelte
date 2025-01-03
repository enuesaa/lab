<script lang="ts">
	import { PanelRightClose, NotepadText } from 'lucide-svelte'

	export let showCodeUnits: boolean

	function handleClick() {
		showCodeUnits = !showCodeUnits
	}
</script>

{#if showCodeUnits}
	<button on:click|preventDefault={handleClick}>
		<PanelRightClose class="inline align-bottom stroke-2 w-[24px]" /> Hide
	</button>
{:else}
	<button on:click|preventDefault={handleClick}>
		<NotepadText class="inline align-bottom stroke-2 w-[24px]" /> Notes
	</button>
{/if}

<style lang="postcss">
	button {
		@apply inline-block font-semibold text-lg my-2 font-zenmaru;
		@apply absolute right-9 top-[1px] rounded-xl px-[10px] pt-[1px] pb-[2px] bg-gray shadow-2xl;
		@apply z-10;
		@apply hover:bg-gray-500 hover:border-[0.2px] hover:border-gray-700;
	}
</style>
