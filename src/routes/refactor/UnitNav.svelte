<script lang="ts">
	import { SquareChevronDown } from 'lucide-svelte'

	export let title: string
</script>

<div>
	<span class="text-2xl leading-[0.8] w-7">
		<SquareChevronDown class="inline align-middle" />
	</span>
	<span class="break-all inline-block">{title}</span>
</div>

<style lang="postcss">
	div {
		@apply font-semibold text-2xl mt-2 mb-1 pl-2 font-zenmaru gap-[3px] text-left inline-block;
	}
</style>
