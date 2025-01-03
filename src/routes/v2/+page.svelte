<script lang="ts">
	import type { PageData } from './$types'
	import PageTitle from './PageTitle.svelte'
	import Description from './Description.svelte'
	import PagePublishedBar from './PagePublishedBar.svelte'
	import Unit from './Unit.svelte'

	export let data: PageData
</script>

<svelte:head>
	<title>{data.project.title}</title>
	<meta name="description" content={`${data.project.title} | lab.enuesaa.dev`} />
</svelte:head>

<div class="container mx-auto px-1 pt-8 pb-2">
	<PageTitle title={data.project.title} />
	<PagePublishedBar published={data.project.published} />
	<Description content={data.project?.description ?? ''} />	
</div>

{#each data.project?.units ?? [] as unit}
	<Unit projectName={data.project?.name} {unit} />
{/each}
