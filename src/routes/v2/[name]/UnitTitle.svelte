<script lang="ts">
	import { Diamond } from 'lucide-svelte'

	export let title: string
</script>

<div class="container mx-auto font-semibold text-3xl font-zenmaru">
	<span class="inline-block px-5 py-4">
		<Diamond class="inline align-baseline w-[20px] fill-black stroke-black" /> {title}
	</span>
</div>
