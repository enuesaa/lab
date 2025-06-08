<script lang="ts">
	import { Diamond } from 'lucide-svelte'

	export let title: string

	let symbol: string|undefined = undefined
	let display = title

	const match = title.match(/^symbol\(([^)]+)\)\s+(.+)$/)
	if (match !== null && match.length > 0) {
		symbol = match[1]
		display = match[2]
	}
</script>

<div class="mt-6 mb-[6px] mx-auto px-3 font-semibold text-2xl font-zenmaru">
	{#if symbol === undefined}
		<Diamond class="inline-block align-bottom w-[14px] fill-gray-1000 stroke-gray-1000 pb-[4px] mr-[6px]" />	
	{:else}
		<span class="font-bold text-[1.6rem]">{symbol}</span>
	{/if}
	{display}
</div>
