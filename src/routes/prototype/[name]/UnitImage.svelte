<script lang="ts">
	import UnitImageOverlay from './UnitImageOverlay.svelte'

	export let projectName: string
	export let image: string
</script>

<div class="mx-auto max-w-[min(100%,1150px)] mb-3 relative">
	<img src={`/prototype/${projectName}/${image}`} alt={image} />
	<UnitImageOverlay {projectName} {image} />
</div>
