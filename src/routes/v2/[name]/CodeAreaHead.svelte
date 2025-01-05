<script lang="ts">
	import { Diamond } from 'lucide-svelte'
	import CodeAreaHeadUnitHideButton from './CodeAreaHeadUnitHideButton.svelte'
	import CodeAreaDownloadButton from './CodeAreaDownloadButton.svelte'
	import type { CodeFiles } from '$lib/prototype/types'

	export let title: string|undefined = 'コード'
	export let showCodeUnits: boolean
	export let codeFiles: CodeFiles
</script>

<section class="relative">
	<div class="container max-w-[1150px] mx-auto font-semibold text-3xl font-zenmaru">
		<span class="inline-block bg-gray-600 pl-5 pr-2 py-3">
			<Diamond class="inline align-baseline w-[20px] fill-black stroke-black" /> {title}
		</span>
		<CodeAreaDownloadButton {codeFiles} />
	</div>
	<CodeAreaHeadUnitHideButton bind:showCodeUnits={showCodeUnits} />
</section>
