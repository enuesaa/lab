<script lang="ts">
	import type { PageData } from './$types'
	import { createTreeViewCtl, createViewing } from '$lib/prototype/tree'
	import PageMain from './PageMain.svelte'
	import CodeAreaMain from './CodeAreaMain.svelte'
	import CodeAreaHead from './CodeAreaHead.svelte'

	createTreeViewCtl()
	createViewing()

	export let data: PageData
</script>

<svelte:head>
	<title>{data.project.title}</title>
	<meta name="description" content={`${data.project.title} | lab.enuesaa.dev`} />
</svelte:head>

<PageMain project={data.project} />

<main class="bg-[#b5b5b5] pb-3">
	<CodeAreaHead />
	<CodeAreaMain project={data.project} codeFiles={data.codeFiles} />
</main>
