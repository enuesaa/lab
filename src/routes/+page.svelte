<script lang="ts">
	import ProjectLink from './ProjectLink.svelte'
	import type { PageData } from './$types'

	export let data: PageData
</script>

<svelte:head>
	<title>雑コード置き場 | lab.enuesaa.dev</title>
</svelte:head>

{#each data.projects as project}
	<ProjectLink href={`/prototype/${project.name}`} title={project.title} />
{/each}
