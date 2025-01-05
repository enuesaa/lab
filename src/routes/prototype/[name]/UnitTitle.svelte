<script lang="ts">
	import { Diamond } from 'lucide-svelte'

	export let title: string
</script>

<div class="mt-4 mb-[6px] mx-auto px-3 font-semibold text-2xl font-zenmaru">
	<Diamond class="inline-block align-bottom w-[14px] fill-gray-1000 stroke-gray-1000 pb-[4px] mr-[6px]" />{title}
</div>
