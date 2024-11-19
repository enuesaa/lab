<script lang="ts">
	import Code from './Code.svelte'

	export let content: string
</script>

<Code language="console" code={content} />
