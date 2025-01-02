<script lang="ts">
	import { Code } from 'lucide-svelte'

	export let title: string
</script>

<div>
	<span class="text-3xl leading-[0.8] w-7">
		<Code class="inline align-middle" />
	</span>
	<span class="break-all inline-block">{title}</span>
</div>

<style lang="postcss">
	div {
		@apply font-semibold text-2xl mt-3 mb-4 pl-10 font-zenmaru gap-[3px] text-left inline-block;
	}
</style>
