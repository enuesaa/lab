<script lang="ts">
	export let links: { title: string; url: string }[]
</script>

<ul class="pl-10 mt-2 mb-3 list-disc">
	{#each links as link}
		<li>
			<a href={link.url} class="underline" target="_blank">{link.title}</a>
		</li>
	{/each}
</ul>
