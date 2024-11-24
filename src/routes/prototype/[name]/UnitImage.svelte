<script lang="ts">
	import type { Project } from '$lib/prototype/types'

	export let project: Project
	export let image: string
</script>

<img src={`/prototype/${project.name}/${image}`} alt={image} />

<style lang="postcss">
	img {
		@apply block mx-auto max-w-[min(100%,1000px)] mb-3;
	}
</style>
