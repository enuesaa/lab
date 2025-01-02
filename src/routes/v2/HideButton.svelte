<script lang="ts">
	import { PanelRightClose } from 'lucide-svelte'
</script>

<div class="absolute right-[10px] top-[-45px] rounded-lg py-[1px] px-2 hover:bg-gray">
	<span class="text-xl leading-1 w-6">
		<PanelRightClose class="inline-block align-bottom" />
	</span>
	<span>hide</span>
</div>

<style lang="postcss">
	div {
		@apply font-semibold text-lg my-2 pl-1 font-zenmaru flex gap-[5px];
	}
</style>
