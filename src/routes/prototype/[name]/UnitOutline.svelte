<script lang="ts">
	import type { Outline } from '$lib/prototype/types'

	export let outline: Outline
</script>

<nav class="my-9 m-3 w-fit min-w-[260px] border border-blackgray/80 rounded-xl p-5 font-zenmaru text-blackgray/85 bg-graywhite">
	<div class="text-2xl mb-3 font-medium">{outline?.title ?? '目次'}</div>
	<ol class="flex flex-col list-none m-0 p-0">
		{#each outline.items ?? [] as item}
			<li>
				<a href="#{item.as}" class="flex items-center gap-1 p-2 rounded-xl text-lg no-underline font-medium hover:bg-gray">
					{item.title}
				</a>
			</li>
		{/each}
	</ol>
</nav>
