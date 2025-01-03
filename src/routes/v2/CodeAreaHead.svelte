<script lang="ts">
	import { Diamond } from 'lucide-svelte'
	import CodeAreaHeadUnitHideButton from './CodeAreaHeadUnitHideButton.svelte'

	export let showCodeUnits: boolean
</script>

<section class="relative">
	<div class="container mx-auto font-semibold text-3xl font-zenmaru">
		<span class="inline-block bg-gray-700 px-5 py-3">
			<Diamond class="inline align-baseline w-[20px] fill-black stroke-black" /> コード
		</span>
	</div>
	<CodeAreaHeadUnitHideButton bind:showCodeUnits={showCodeUnits} />
</section>
