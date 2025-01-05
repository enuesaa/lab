<script lang="ts">
	export let links: { title: string; url: string }[]
</script>

<div class="pl-10 mb-3">
	{#each links as link}
		<a href={link.url} class="underline list-item" target="_blank">{link.title}</a>
	{/each}
</div>
