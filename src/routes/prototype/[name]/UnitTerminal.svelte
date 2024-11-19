<script lang="ts">
	import Code from './Code.svelte'

	export let content: string
</script>

<section class="mb-5">
	<Code language="console" code={content} />
</section>
