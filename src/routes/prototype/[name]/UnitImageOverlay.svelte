<script lang="ts">
	import { Dialog } from 'melt/builders'
	import { MoveDiagonal, X as CloseIcon } from 'lucide-svelte'
	import type { MouseEventHandler } from 'svelte/elements'

	export let projectName: string
	export let image: string

	const dialog = new Dialog()

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

<button {...dialog.trigger} class="absolute top-1 right-1 text-gray-700">
	<MoveDiagonal />
</button>

<div {...dialog.overlay} class="fixed inset-0 w-full h-full bg-gray-900/90 z-10"></div>

<dialog {...dialog.content} class="fixed inset-0 m-auto w-10/12 max-w-[1500px] h-fit p-0 bg-transparent overflow-visible outline-none z-20">
	<!-- svelte-ignore a11y_no_noninteractive_element_interactions -->
	<img
		src={`/prototype/${projectName}/${image}`}
		alt={image}
		class="block w-full"
		bind:this={imgRef}
		on:mousemove={handleMouseMove}
		on:click={handleZoom}
	/>
	<button on:click={() => (dialog.open = false)} class="fixed text-gray top-1 right-1">
		<CloseIcon class="w-8 h-8" />
	</button>
</dialog>

<style lang="postcss">
	@reference "#app.css";

	img {
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
	dialog::backdrop {
		background: transparent;
	}
</style>
