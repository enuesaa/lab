<script lang="ts">
	import { PanelRightClose } from 'lucide-svelte'

	export let show: boolean

	function handleClick() {
		show = !show
	}
</script>

<button on:click|preventDefault={handleClick}>
	<PanelRightClose class="inline align-bottom stroke-2" /> hide
</button>

<style lang="postcss">
	button {
		@apply inline-block font-semibold text-lg my-2 font-zenmaru;
		@apply absolute right-[10px] top-[-42px] rounded-md px-2 py-[1px] bg-gray;
	}
</style>
