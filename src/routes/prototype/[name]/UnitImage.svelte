<script lang="ts">
	export let projectName: string
	export let image: string

	let showOverlay = false
	let zoomLevel: '100'|'150' = '100'

	const zoomLevelStyleMap = {
		'100': 'scale-90 block mb-3',
		'150': 'scale-150 block mb-3',
	}

	function hanldeEnableOverlay() {
		showOverlay = true
	}
	function hanldeDisableOverlay() {
		showOverlay = false
	}
	function handleZoom() {
		if (zoomLevel === '100') {
			zoomLevel = '150'
		} else {
			zoomLevel = '100'
		}
	}
</script>

<!-- svelte-ignore a11y_no_noninteractive_element_interactions -->
<!-- svelte-ignore a11y_click_events_have_key_events -->
<img
	src={`/prototype/${projectName}/${image}`}
	alt={image}
	on:click|preventDefault={hanldeEnableOverlay}
	class="block mx-auto max-w-[min(100%,1150px)] mb-3"
/>

{#if showOverlay}
	<!-- svelte-ignore a11y_no_static_element_interactions -->
	<div on:dblclick={handleZoom}>
		<button on:click|preventDefault={hanldeDisableOverlay} class="text-gray absolute top-0 right-0">
			close
		</button>
		<img
			src={`/prototype/${projectName}/${image}`}
			alt={image}
			class={zoomLevelStyleMap[zoomLevel]}
			style="transition: transform 0.3s ease-in-out"
		/>
	</div>
{/if}

<style lang="postcss">
	div {
		@apply fixed top-0 bottom-0 left-0 right-0 bg-black z-20 w-full flex justify-center overflow-scroll;
	}
</style>
