<script lang="ts">
	export let name: string
	export let title: string
	export let showing: string

	function handleClick() {
		showing = name
	}
</script>

<button on:click|preventDefault={handleClick} class={showing === name ? 'bg-graywhite' : 'bg-grayblack'}>
	{title}
</button>

<style lang="postcss">
	button {
		border: solid 2px;
		border-bottom: 0px;
		overflow: hidden;
		flex: 0 0 auto;
		@apply mt-3 mx-1 px-8 py-2 rounded-t-lg border-grayblack;
		@apply font-bold font-zenmaru text-2xl;
	}
</style>
