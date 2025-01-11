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
</svelte:head>

<Main>
	<PageHead project={data.project} />

	{#each data.project?.units ?? [] as unit}
		<Unit projectName={data.project?.name} {unit} />
	{/each}
</Main>
