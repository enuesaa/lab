<script lang="ts">
	import type { PageData } from './$types'
	import Unit from './Unit.svelte'
	import Main from '../../Main.svelte'
	import PageHead from './PageHead.svelte'

	export let data: PageData
</script>

<svelte:head>
	<title>{data.project.title}</title>
	<meta name="description" content={`${data.project.title} | lab.enuesaa.dev`} />
	<link rel="alternate" type="text/markdown" href={`https://lab.enuesaa.dev/prototype/${data.project.name}.md`} />
</svelte:head>

<Main>
	<PageHead project={data.project} />

	{#each data.project?.units ?? [] as unit}
		<Unit projectName={data.project?.name} {unit} />
	{/each}

	<div class="container max-w-[1150px] mx-auto px-3 pt-6 pb-6 text-sm text-right">
		<a href={`/prototype/${data.project.name}.md`} class="hover:underline">View as Markdown</a>
	</div>
</Main>
