<script lang="ts">
	import type { PageData } from './$types'
	import PageTitle from '../prototype/[name]/PageTitle.svelte'
	import Description from '../prototype/[name]/Description.svelte'
	import PagePublishedBar from '../prototype/[name]/PagePublishedBar.svelte'
	import CodeViewer from './CodeViewer.svelte'
	import { createTreeViewCtl, createViewing } from '$lib/prototype/tree'
	import UnitSep from '../prototype/[name]/UnitSep.svelte'
	import UnitNav from './UnitNav.svelte'
	import UnitDescription from '../prototype/[name]/UnitDescription.svelte'
	import UnitTerminal from '../prototype/[name]/UnitTerminal.svelte'

	createTreeViewCtl()
	createViewing()

	export let data: PageData

	// 期待動作
		// ソースコードのしたかな？
	// ソースコードに対するコメント
		// これは highlight チックがベスト
		// GitHub みたいに1行単位かな
	// 目次も欲しいかも

	const description = `curl ライクな CLI を作ってみる。

とは言っても GET しかできない。
curl とは似ても似つかないが、まあサンプルなので良いと思う。`

	const terminal = `$ go run . -url https://example.com/
<!doctype html>
<html>
<head>
    <title>Example Domain</title>
    
// 省略
// example.com へ HTTP GET リクエストをして、レスポンスボディを標準出力する`
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

<section class="w-[96vw] ml-[-5vw] flex gap-1 rounded-lg overflow-hidden">
	<div class="w-7/12">
		<UnitSep text="</>" treeData={data.files} enableDownloader />
		<CodeViewer treeData={data.files} firstOpen={'main.go'} />
	</div>
	<div class="w-5/12 border bg-white/60">
		<UnitNav title='期待動作' />
		<UnitDescription description={description} />
		<UnitSep text="ターミナル" />
		<UnitTerminal content={terminal} />
	</div>
</section>
