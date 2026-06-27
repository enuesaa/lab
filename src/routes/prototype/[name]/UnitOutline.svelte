<script lang="ts">
	import type { UnitV2 } from '$lib/prototype/types'

	export let unit: UnitV2
</script>

<nav class="m-6 w-fit min-w-[260px] border rounded-xl p-5 font-zenmaru">
	<div class="text-2xl mb-3 font-medium">目次</div>
	<ol class="flex flex-col list-none m-0 p-0">
		{#each unit.outline ?? [] as item}
			<li>
				<a href="#{item.as}" class="flex items-center gap-1 py-2 text-xl no-underline hover:font-medium">
					{item.title}
				</a>
			</li>
		{/each}
	</ol>
</nav>
