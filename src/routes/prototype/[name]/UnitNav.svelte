<script lang="ts">
	import { type UnitWithTreeData } from '$lib/types/tree'

	export let unit: UnitWithTreeData
	export let showing: boolean

	function handleClick() {
		showing = !showing
	}
</script>

<nav class="m-0 pl-3">
	<button class='bg-graywhite' on:click|preventDefault={handleClick}>
		{unit.title}
	</button>
</nav>

<style lang="postcss">
	nav {
		@apply flex;
		overflow: scroll;
	}
	button {
		border: solid 2px;
		border-bottom: 0px;
		overflow: hidden;
		flex: 0 0 auto;
		@apply mt-3 mx-1 px-8 py-2 rounded-t-lg border-grayblack;
		@apply font-bold font-zenmaru text-2xl;
	}
</style>
