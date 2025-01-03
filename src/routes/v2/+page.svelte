<script lang="ts">
	import type { PageData } from './$types'
	import PageMain from './PageMain.svelte'
	import CodeArea from './CodeArea.svelte'

	export let data: PageData
</script>

<svelte:head>
	<title>{data.project.title}</title>
	<meta name="description" content={`${data.project.title} | lab.enuesaa.dev`} />
</svelte:head>

<PageMain project={data.project} />
<CodeArea project={data.project} codeFiles={data.codeFiles} />
