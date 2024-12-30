<script lang="ts">
	import type { PageData } from './$types'
	import PageTitle from '../prototype/[name]/PageTitle.svelte'
	import Description from '../prototype/[name]/Description.svelte'
	import PagePublishedBar from '../prototype/[name]/PagePublishedBar.svelte'
	import CodeViewer from './CodeViewer.svelte'
	import { createTreeViewCtl, createViewing } from '$lib/prototype/tree'
	import UnitSep from '../prototype/[name]/UnitSep.svelte'
	import UnitNav from './UnitNav.svelte'

	createTreeViewCtl()
	createViewing()

	export let data: PageData

	// 期待動作
		// ソースコードのしたかな？
	// ソースコードに対するコメント
		// これは highlight チックがベスト
		// GitHub みたいに1行単位かな
	// 目次も欲しいかも
</script>

<svelte:head>
	<title>{data.project.title}</title>
	<meta name="description" content={`${data.project.title} | lab.enuesaa.dev`} />
</svelte:head>

<PageTitle title={data.project.title} />
<PagePublishedBar published={data.project.published} />
<Description content={data.project.description} />

<UnitNav title='コード全体' />
<UnitNav title='期待動作' />

<section class="w-[95vw] ml-[-5vw] rounded-lg overflow-hidden">
	<UnitSep text="</>" treeData={data.files} enableDownloader />
	<CodeViewer treeData={data.files} firstOpen={'main.go'} />
</section>
