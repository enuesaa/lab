<script lang="ts">
	import type { PageData } from './$types'
	import PageTitle from './PageTitle.svelte'
	import Description from './Description.svelte'
	import PagePublishedBar from './PagePublishedBar.svelte'
	import Variant from './Variant.svelte'

	export let data: PageData
</script>

<svelte:head>
	<title>{data.title}</title>
</svelte:head>

<PageTitle title={data.title} />
<PagePublishedBar published={data.published} />
<Description content={data.description} />

{#each data.variants as variant}
	<Variant {variant} />
{/each}
