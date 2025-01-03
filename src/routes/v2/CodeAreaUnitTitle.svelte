<script lang="ts">
	import { Square } from 'lucide-svelte'

	export let title: string
</script>

<div>
	<span class="leading-[0.8]">
		<Square class="inline-block w-3 align-text-bottom font-bold" style="fill: #222;" />
	</span>
	<span class="break-all inline-block">{title}</span>
</div>

<style lang="postcss">
	div {
		@apply font-semibold text-xl mt-3 mb-1 pl-2 font-zenmaru gap-[3px] text-left inline-block;
	}
</style>
