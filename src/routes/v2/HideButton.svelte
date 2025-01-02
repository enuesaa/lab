<script lang="ts">
	import { PanelRightClose, NotepadText } from 'lucide-svelte'

	export let show: boolean

	function handleClick() {
		show = !show
	}
</script>

{#if show}
	<button on:click|preventDefault={handleClick}>
		<PanelRightClose class="inline align-bottom stroke-2" /> Hide
	</button>
{:else}
	<button on:click|preventDefault={handleClick}>
		<NotepadText class="inline align-bottom stroke-2" /> Open
	</button>
{/if}

<style lang="postcss">
	button {
		@apply inline-block font-semibold text-lg my-2 font-zenmaru;
		@apply absolute right-[10px] top-[-59px] rounded-xl px-[10px] pt-[1px] pb-[2px] bg-gray shadow-xl;
	}
</style>
