<script lang="ts">
	import { Code } from 'lucide-svelte'
</script>

<div>
	<Code class="inline align-baseline stroke-[3px]" /> コード
</div>

<style lang="postcss">
	div {
		@apply inline-block font-semibold text-3xl font-zenmaru mb-[-30px] mt-5;
		@apply bg-[#b5b5b5] py-3 px-5 rounded-xl;
	}
</style>
