<script lang="ts">
	import type { PageData } from './$types'
	import PageTitle from '../prototype/[name]/PageTitle.svelte'
	import Description from '../prototype/[name]/Description.svelte'
	import PagePublishedBar from '../prototype/[name]/PagePublishedBar.svelte'
	import CodeViewer from './CodeViewer.svelte'
	import { createTreeViewCtl, createViewing } from '$lib/prototype/tree'
	import UnitSep from '../prototype/[name]/UnitSep.svelte'
	import UnitNav from './UnitNav.svelte'
	import BigUnitNav from './BigUnitNav.svelte'
	import UnitDescription from '../prototype/[name]/UnitDescription.svelte'
	import UnitTerminal from '../prototype/[name]/UnitTerminal.svelte'
	import Card from './Card.svelte'
	import HideButton from './HideButton.svelte'

	createTreeViewCtl()
	createViewing()

	export let data: PageData

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

	const description2 = `cmdfx.New() を見ると分かる通り、cmdfx.ICmd は clientfx.IClient へ依存している。
この依存の注入を fx がしてくれる。

cmdfx と clientfx は interface を介してやり取りしているのがポイント。
これにより例えば mock へ差し替えできる。`
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
				<UnitSep text="</>" treeData={data.files} enableDownloader />
				<CodeViewer treeData={data.files} firstOpen={'main.go'} />
			</div>
		</div>
		<div class="w-5/12 max-md:absolute max-md:w-[90vw] max-md:right-1 px-1 relative bg-[#bababa]">
			<HideButton />
			<Card>
				<UnitNav title='期待動作' />
				<UnitDescription description={description} />
				<UnitSep text="ターミナル" />
				<div class="h-[210px]">
					<UnitTerminal content={terminal} />
				</div>
			</Card>

			<Card>
				<UnitNav title='Module' />
				<UnitDescription description={'cmdfx.Module と clientfx.Module があり、両者を fx.New() でロードしている。'} />
			</Card>

			<Card>
				<UnitNav title='cmdfx.ICmd が clientfx.IClient へ依存' />
				<UnitDescription description={description2} />
			</Card>
		</div>
	</section>
</main>
