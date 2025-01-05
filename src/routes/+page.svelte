<script lang="ts">
	import ProjectLink from './ProjectLink.svelte'
	import Main from './Main.svelte'
	import type { PageData } from './$types'

	export let data: PageData
</script>

<svelte:head>
	<title>雑コード置き場 | lab.enuesaa.dev</title>
</svelte:head>

<Main>
	<div class="container mx-auto px-1 pt-8 pb-2">
		{#each data.projects as project}
			<ProjectLink project={project} />
		{/each}
	</div>
</Main>
