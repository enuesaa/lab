<script lang="ts">
	import Code from './Code.svelte'

	export let output: string
</script>

<section class="mb-5">
	<h4 class="font-bold font-zenmaru text-3xl">実行結果</h4>
	<Code language="console" code={output} />
</section>
