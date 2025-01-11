<script lang="ts">
	import { createDialog, melt } from '@melt-ui/svelte'
	import { MoveDiagonal, X } from 'lucide-svelte'
	import { fade } from 'svelte/transition'

	export let projectName: string
	export let image: string

	// let zoomLevel: '100'|'150' = '100'
	// const zoomLevelStyleMap = {
	// 	'100': 'scale-90',
	// 	'150': 'scale-150',
	// }
	// function handleZoom() {
	// 	if (zoomLevel === '100') {
	// 		zoomLevel = '150'
	// 	} else {
	// 		zoomLevel = '100'
	// 	}
	// }
	const {
		elements: { trigger, overlay, portalled, close, content },
		states: { open },
	} = createDialog({ })
</script>

<button use:melt={$trigger} class="absolute top-1 right-1 text-gray-700">
	<MoveDiagonal />
</button>

{#if $open}
	<div use:melt={$portalled}>
		<div use:melt={$overlay}
			class="fixed inset-0 bg-gray-900/90"
			transition:fade={{ duration: 70 }}
		></div>
		<img use:melt={$content}
			src={`/prototype/${projectName}/${image}`}
			alt={image}
			transition:fade={{ duration: 70 }}
		/>
		<button use:melt={$close} class="fixed text-gray top-1 right-1">
			<X class="w-8 h-8" />
		</button>
	</div>
{/if}

<style lang="postcss">
	img {
		@apply block w-full max-w-[1500px];
		@apply fixed left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 z-20;
	}
</style>
