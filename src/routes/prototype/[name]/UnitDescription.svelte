<script lang="ts">
	export let description: string
</script>

<section class="my-2 px-2 font-zenmaru text-[17px] w-full">
	<pre class="font-murecho">{description}</pre>
</section>

<style lang="postcss">
	section pre {
		letter-spacing: 0.2px;
		line-height: 1.8;
		overflow-wrap: anywhere;
		word-break: normal;
		line-break: strict;
		white-space: pre-wrap;
		font-feature-settings: 'palt';
	}
</style>
