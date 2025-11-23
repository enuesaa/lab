<script lang="ts">
	import { parseAttrs } from '$lib/prototype/attrs'
	import { Diamond, Square } from 'lucide-svelte'

	export let title: string
	const {
		content: display,
		attrs: { symbol },
	} = parseAttrs(title)
</script>

<div class="mt-6 mb-[6px] mx-auto px-3 font-semibold text-2xl font-zenmaru">
	{#if symbol === undefined}
		<Diamond class="inline-block align-bottom w-[14px] fill-editorbg stroke-editorbg pb-[4px] mr-1" />
	{:else}
		<span class="font-bold align-text-bottom text-[1.6rem]">{symbol}</span>
	{/if}
	{display}
</div>
