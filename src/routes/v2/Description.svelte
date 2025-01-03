<script lang="ts">
	export let content: string
</script>

<section>
	<pre>{content}</pre>
</section>

<style lang="postcss">
	section {
		@apply py-3 px-2 mt-4 font-zenmaru text-[17px] w-full;
	}
	section pre {
		letter-spacing: 0.2px;
		line-height: 1.8;
		overflow-wrap: anywhere;
		word-break: normal;
		line-break: strict;
		white-space: pre-wrap;
		font-feature-settings: 'palt';
		@apply font-murecho;
	}
</style>
