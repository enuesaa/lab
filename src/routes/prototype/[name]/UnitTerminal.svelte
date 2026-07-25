<script lang="ts">
	import Code from '$lib/prototype/Code.svelte'

	export let content: string
</script>

<div class="overflow-x-auto">
	<div class="p-4 bg-editorbg rounded-lg w-fit min-w-[50%]">
		<Code language="console" code={content} />
	</div>
</div>
