<script lang="ts">
	import PageTitle from './PageTitle.svelte'
	import Description from './Description.svelte'
	import PagePublishedBar from './PagePublishedBar.svelte'
	import type { ProjectV2 } from '$lib/prototype/types'

	export let project: ProjectV2
</script>

<div class="container mx-auto px-1 pt-8 pb-2">
	<PageTitle title={project.title} />
	<PagePublishedBar published={project.published} />
	<Description content={project.description} />	
</div>
