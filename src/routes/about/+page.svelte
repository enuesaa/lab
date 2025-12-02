<script lang="ts">
	import PageDescription from '../prototype/[name]/PageDescription.svelte'
	import PageTitle from '../prototype/[name]/PageTitle.svelte'
	import Links from './Links.svelte'
	import Main from '../Main.svelte'

	const about = 'このサイトは個人のメモ帳です。\nちょっと調べて気づいたことをメモしてます。\n\n'
	const links = [
		{ url: 'https://enuesaa.dev/', text: 'https://enuesaa.dev' },
	]
</script>

<Main>
	<div class="container mx-auto max-w-[1150px] px-1 pt-8 pb-2">
		<PageTitle title="About" />
		<PageDescription description={about} />

		<div class="mt-6 mb-[6px] mx-auto px-3 font-semibold text-2xl font-zenmaru">
			Links
		</div>
		<Links {links} />
	</div>
</Main>
