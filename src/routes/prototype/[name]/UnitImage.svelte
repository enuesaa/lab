<script lang="ts">
	import { parseAttrs } from '$lib/prototype/attrs'
	import UnitImageOverlay from './UnitImageOverlay.svelte'

	export let projectName: string
	export let image: string

	const { content: filename, attrs } = parseAttrs(image)
</script>

<div class="mb-3 relative" style={attrs?.size === 'min' ? 'max-width: min(100%,800px)' : 'max-width: min(100%,1150px)'}>
	<img src={`/prototype/${projectName}/${filename}`} alt={filename} />
	<UnitImageOverlay {projectName} image={filename} />
</div>
