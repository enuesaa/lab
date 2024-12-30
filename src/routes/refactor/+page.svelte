<script lang="ts">
	import type { PageData } from './$types'
	import PageTitle from '../prototype/[name]/PageTitle.svelte'
	import Description from '../prototype/[name]/Description.svelte'
	import PagePublishedBar from '../prototype/[name]/PagePublishedBar.svelte'
	import CodeViewer from '../prototype/[name]/CodeViewer.svelte'
	import { createTreeViewCtl, createViewing } from '$lib/prototype/tree'
	import UnitSep from '../prototype/[name]/UnitSep.svelte'

	createTreeViewCtl()
	createViewing()

	export let data: PageData
</script>

<svelte:head>
	<title>{data.project.title}</title>
	<meta name="description" content={`${data.project.title} | lab.enuesaa.dev`} />
</svelte:head>

<PageTitle title={data.project.title} />
<PagePublishedBar published={data.project.published} />
<Description content={data.project.description} />

<UnitSep text="</>" treeData={data.files} enableDownloader />
<CodeViewer treeData={data.files} firstOpen={'main.go'} />
