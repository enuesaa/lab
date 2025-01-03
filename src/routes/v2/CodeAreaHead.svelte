<script lang="ts">
	import { Diamond } from 'lucide-svelte'
	import CodeAreaHeadUnitHideButton from './CodeAreaHeadUnitHideButton.svelte'

	export let showCodeUnits: boolean
</script>

<section class="relative">
	<div>
		<Diamond class="inline align-baseline w-[20px] fill-[#000000]" /> コード
	</div>
	<CodeAreaHeadUnitHideButton bind:showCodeUnits={showCodeUnits} />
</section>

<style lang="postcss">
	div {
		@apply container mx-auto py-3 px-5 font-semibold text-3xl font-zenmaru;
	}
</style>
