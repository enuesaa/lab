<script lang="ts">
	export let description: string
</script>

<section>
	<pre>{description}</pre>
</section>

<style lang="postcss">
	section {
		@apply mt-1 mb-2 px-3 w-full;
	}
	section pre {
		letter-spacing: 0.2px;
		line-height: 1.6;
		overflow-wrap: anywhere;
		word-break: normal;
		line-break: strict;
		white-space: pre-wrap;
		font-feature-settings: 'palt';
		@apply font-murecho text-gray-800;
	}
</style>
