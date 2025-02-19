<script lang="ts">
	type Link = {
		url: string
		text: string
		key?: string
	}
	export let links: Link[]
</script>

<ul class="block py-1 px-10 my-4 w-full">
	{#each links as link}
		<li class="font-zenmaru text-lg font-normal">
			{#if link.key !== null}
				{link.key}:
			{/if}
			<a href={link.url} target="_blank">{link.text}</a>
		</li>
	{/each}
</ul>

<style lang="postcss">
	ul {
		list-style-type: square;
	}
	li {
		letter-spacing: 0.1px;
		line-height: 1.8;
		overflow-wrap: anywhere;
		word-break: normal;
		line-break: strict;
		white-space: pre-wrap;
		font-feature-settings: 'palt';
	}
	a {
		text-decoration: underline;
	}
</style>
