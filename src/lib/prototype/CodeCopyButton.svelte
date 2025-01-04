<script lang="ts">
	import { createTooltip, melt } from '@melt-ui/svelte'
	import { fade } from 'svelte/transition'
	import { CopyIcon, CheckIcon } from 'lucide-svelte'

	export let text: string

	const {
		elements: { trigger, content, arrow },
		states: { open },
	} = createTooltip({
		positioning: {
			placement: 'top',
		},
		openDelay: 0,
		closeOnPointerDown: false,
	})

	let checked: boolean = false

	async function copy() {
		await globalThis.navigator.clipboard.writeText(text)
		checked = true
		setTimeout(() => (checked = false), 3000)
	}
</script>

<button type="button" class="absolute right-4 top-9 text-gray-600" use:melt={$trigger} on:click|preventDefault={copy}>
	{#if checked}
		<CheckIcon class="w-4" />
	{:else}
		<CopyIcon class="w-4" />
	{/if}
</button>

{#if $open}
	<div use:melt={$content} transition:fade={{ duration: 100 }} class="z-10 bg-gray-600 px-1 text-sm font-semibold">
		<div use:melt={$arrow}></div>
		Copy
	</div>
{/if}
