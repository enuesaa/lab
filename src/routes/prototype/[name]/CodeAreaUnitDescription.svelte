<script lang="ts">
	export let description: string
</script>

<section class="my-2 px-3 w-full max-md:my-1 max-md:px-1">
	<pre class="font-murecho text-gray-800 text-[15px]">{description}</pre>
</section>

<style lang="postcss">
	section pre {
		letter-spacing: 0.2px;
		line-height: 1.6;
		overflow-wrap: anywhere;
		word-break: normal;
		line-break: strict;
		white-space: pre-wrap;
		font-feature-settings: 'palt';
	}
</style>
