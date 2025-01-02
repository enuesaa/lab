<script lang="ts">
	import type { PageData } from './$types'
	import PageTitle from '../prototype/[name]/PageTitle.svelte'
	import Description from '../prototype/[name]/Description.svelte'
	import PagePublishedBar from '../prototype/[name]/PagePublishedBar.svelte'
	import { createTreeViewCtl, createViewing } from '$lib/prototype/tree'
	import CodeAreaTitle from './CodeAreaTitle.svelte'
	import CodeAreaRight from './CodeAreaRight.svelte'
	import CodeAreaLeft from './CodeAreaLeft.svelte'

	createTreeViewCtl()
	createViewing()

	export let data: PageData
</script>

<svelte:head>
	<title>{data.project.title}</title>
	<meta name="description" content={`${data.project.title} | lab.enuesaa.dev`} />
</svelte:head>

<div class="container mx-auto px-1 pt-8">
	<PageTitle title={data.project.title} />
	<PagePublishedBar published={data.project.published} />
	<Description content={data.project.description} />	
	<CodeAreaTitle />
</div>

<main class="bg-[#b5b5b5] py-10">
	<section class="w-[98vw] m-auto flex gap-2 relative">
		<CodeAreaLeft project={data.project} codeFiles={data.codeFiles} />
		<CodeAreaRight units={data.project?.code?.units ?? []} />
	</section>
</main>
