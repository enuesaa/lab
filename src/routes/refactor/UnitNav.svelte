<script lang="ts">
	import { SquareChevronDown } from 'lucide-svelte'

	export let title: string
</script>

<button>
	<span class="text-3xl leading-[0.8] w-7">
		<SquareChevronDown class="inline align-middle" />
	</span>
	<span class="break-all inline-block">{title}</span>
</button>

<style lang="postcss">
	button {
		@apply font-semibold text-2xl mt-7 mb-3 pl-2 font-zenmaru flex gap-[3px] text-left;
	}
</style>
