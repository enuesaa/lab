<script lang="ts">
	import type { PageData } from './$types'
	import { createTreeViewCtl, createViewing } from '$lib/prototype/tree'
	import PageMain from './PageMain.svelte'
	import CodeArea from './CodeArea.svelte'

	createTreeViewCtl()
	createViewing()

	export let data: PageData
</script>

<svelte:head>
	<title>{data.project.title}</title>
	<meta name="description" content={`${data.project.title} | lab.enuesaa.dev`} />
</svelte:head>

<PageMain project={data.project} />

<CodeArea project={data.project} codeFiles={data.codeFiles} />
