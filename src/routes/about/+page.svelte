<script lang="ts">
	import Description from '../prototype/[name]/Description.svelte'
	import PageTitle from '../prototype/[name]/PageTitle.svelte'
	import Links from '../prototype/[name]/Links.svelte'

	let about = 'このサイトは個人のメモ帳です。\n'
	about += 'ちょっと調べて気づいたことをメモしてます。\n\n'

	let links = [{href: 'https://enuesaa.dev/', text: 'nua', key: '運営者'}]
</script>

<PageTitle title='About' />
<Description content={about} />

<Links {links} />
