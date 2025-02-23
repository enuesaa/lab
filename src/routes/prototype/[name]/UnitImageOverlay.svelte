<script lang="ts">
	import { createDialog, melt } from '@melt-ui/svelte'
	import { MoveDiagonal, X as CloseIcon } from 'lucide-svelte'
	import type { MouseEventHandler } from 'svelte/elements'

	export let projectName: string
	export let image: string

	const {
		elements: { trigger, overlay, portalled, close, content },
		states: { open },
	} = createDialog()

	let imgRef: HTMLImageElement
	let scale = 1
	let originX = 50
	let originY = 50
	const handleZoom = () => {
		scale = scale === 1 ? 1.3 : 1
	}
	const handleMouseMove: MouseEventHandler<HTMLDivElement> = (e) => {
		const rect = e.currentTarget.getBoundingClientRect()
		originX = ((e.clientX - rect.left) / rect.width) * 100
		originY = ((e.clientY - rect.top) / rect.height) * 100
	}
	$: {
		if (imgRef !== undefined && imgRef !== null) {
			imgRef.style.transformOrigin = `${originX}% ${originY}%`
			imgRef.style.transform = `scale(${scale})`
			imgRef.style.cursor = scale === 1 ? 'zoom-in' : 'zoom-out'
		}
	}
</script>

<button use:melt={$trigger} class="absolute top-1 right-1 text-gray-700">
	<MoveDiagonal />
</button>

{#if $open}
	<div use:melt={$portalled}>
		<div use:melt={$overlay} class="fixed inset-0 bg-gray-900/90 fade"></div>

		<!-- svelte-ignore a11y_no_noninteractive_element_interactions -->
		<img
			use:melt={$content}
			src={`/prototype/${projectName}/${image}`}
			alt={image}
			class="fixed z-20 block w-10/12 inset-0 m-auto max-w-[1500px] fade outline-none"
			bind:this={imgRef}
			on:mousemove={handleMouseMove}
			on:click={handleZoom}
		/>

		<button use:melt={$close} class="fixed text-gray top-1 right-1">
			<CloseIcon class="w-8 h-8" />
		</button>
	</div>
{/if}

<style lang="postcss">
	.fade {
		animation: fade 0.3s ease forwards;
	}
	@keyframes fade {
		0% {
			opacity: 0;
		}
		100% {
			opacity: 1;
		}
	}
</style>
