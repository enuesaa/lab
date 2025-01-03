<script lang="ts">
	import { Square } from 'lucide-svelte'

	export let title: string
</script>

<div>
	<span class="leading-[0.8] w-4">
		<Square class="inline-block w-3 pt-3 align-bottom font-bold" style="fill: #222;" />
	</span>
	<span class="break-all inline-block">{title}</span>
</div>

<style lang="postcss">
	div {
		@apply font-semibold text-xl mt-3 mb-2 px-2 font-zenmaru gap-[3px] text-left flex;
	}
</style>
