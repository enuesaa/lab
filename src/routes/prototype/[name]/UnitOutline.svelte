<script lang="ts">
	import type { UnitV2 } from '$lib/prototype/types'

	export let unit: UnitV2
</script>

<nav class="my-6 flex justify-center">
	<div class="w-fit min-w-[260px]">
		<p class="text-xs text-gray-500 mb-3 tracking-wider">目次</p>
		<ol class="flex flex-col list-none m-0 p-0">
			{#each unit.outline ?? [] as item}
				<li class="border-t border-gray-400 last:border-b">
					<a href="#{item.as}" class="flex items-center gap-3 py-2.5 text-base text-gray-800 no-underline hover:text-black hover:underline transition-colors duration-100">
						{item.title}
					</a>
				</li>
			{/each}
		</ol>
	</div>
</nav>