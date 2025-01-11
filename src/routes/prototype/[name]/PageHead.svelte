<script lang="ts">
	import PageTitle from './PageTitle.svelte'
	import PageDescription from './PageDescription.svelte'
	import PagePublishedBar from './PagePublishedBar.svelte'
	import type { ProjectV2 } from '$lib/prototype/types'

	export let project: ProjectV2
</script>

<section>
	<PageTitle title={project.title} />
	<PagePublishedBar published={project.published} />
	<PageDescription description={project?.description ?? ''} />
</section>

<style lang="postcss">
	section {
		@apply container max-w-[1150px] mx-auto px-1 pt-8 pb-2;
	}
</style>
