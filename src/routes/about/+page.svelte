<script lang="ts">
	import PageDescription from '../prototype/[name]/PageDescription.svelte'
	import PageTitle from '../prototype/[name]/PageTitle.svelte'
	import Links from './Links.svelte'
	import Main from '../Main.svelte'

	const about = 'このサイトは個人のメモ帳です。\nちょっと調べて気づいたことをメモしてます。\n\n'
	const links = [{ url: 'https://enuesaa.dev/', text: 'nua', key: '運営者' }]
</script>

<Main>
	<div class="container mx-auto px-1 pt-8 pb-2">
		<PageTitle title="About" />
		<PageDescription description={about} />
		
		<Links {links} />
	</div>
</Main>
