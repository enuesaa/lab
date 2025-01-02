<script lang="ts">
	import { SquareChevronDown } from 'lucide-svelte'
	export let title = ''

	export let right: boolean = false
	let position = right ? 'relative ml-[85%]' : ''
</script>

<div class={position}>
	<span class="text-3xl leading-[0.8] w-7">
		<SquareChevronDown class="inline align-middle" />
	</span>
	<span>{title}</span>
</div>

<style lang="postcss">
	div {
		@apply font-semibold text-2xl my-2 pl-1 font-zenmaru flex gap-[3px];
	}
</style>
