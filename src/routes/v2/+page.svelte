<script lang="ts">
	import type { PageData } from './$types'
	import PageTitle from '../prototype/[name]/PageTitle.svelte'
	import Description from '../prototype/[name]/Description.svelte'
	import PagePublishedBar from '../prototype/[name]/PagePublishedBar.svelte'
	import CodeViewer from './CodeViewer.svelte'
	import { createTreeViewCtl, createViewing } from '$lib/prototype/tree'
	import UnitSep from '../prototype/[name]/UnitSep.svelte'
	import BigUnitNav from './BigUnitNav.svelte'
	import Unit from './Unit.svelte'
	import HideButton from './HideButton.svelte'

	createTreeViewCtl()
	createViewing()

	export let data: PageData
</script>

<svelte:head>
	<title>{data.project.title}</title>
	<meta name="description" content={`${data.project.title} | lab.enuesaa.dev`} />
</svelte:head>

<div class="container mx-auto px-1 py-8">
	<PageTitle title={data.project.title} />
	<PagePublishedBar published={data.project.published} />
	<Description content={data.project.description} />	
</div>

<main class="bg-[#bababa]">
	<BigUnitNav title='コード' />
	<section class="w-[98vw] m-auto flex gap-2">
		<div class="w-7/12">
			<div class="rounded-lg overflow-hidden">
				<UnitSep text="</>" treeData={data.codeFiles} enableDownloader />
				<CodeViewer treeData={data.codeFiles} firstOpen={data.project.code?.open ?? ''} />
			</div>
		</div>
		<div class="w-5/12 max-md:absolute max-md:w-[90vw] max-md:right-1 px-1 relative bg-[#bababa]">
			<HideButton />
			{#each data.project?.code?.units ?? [] as unit}
				<Unit {unit} />
			{/each}
		</div>
	</section>
</main>
