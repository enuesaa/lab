<script lang="ts">
	export let links: {title: string; url:string}[]
</script>

<div class="pl-10">
	{#each links as link}
		<a href={link.url} class="underline list-item">{link.title}</a>
	{/each}
</div>
