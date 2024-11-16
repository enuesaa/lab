<script lang="ts">
	export let showing: boolean

	function handleClick() {
		showing = true
	}
</script>

<button on:click|preventDefault={handleClick}>表示する</button>

<style lang="postcss">
	button {
		@apply absolute top-0 bottom-0 left-0 right-0 bg-black bg-opacity-80;
		@apply block text-gray rounded-md font-semibold;
		@apply hover:text-graywhite;
	}
</style>
