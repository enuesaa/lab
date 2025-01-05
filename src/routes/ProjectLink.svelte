<script lang="ts">
	import type { ProjectV2 } from '$lib/prototype/types'

	export let project: ProjectV2
</script>

<div>
	<a href={`/prototype/${project.name}`}>{project.title}</a>
	<span>{project.published}</span>	
</div>

<style lang="postcss">
	div {
		@apply inline-block h-48 my-3 mx-1 sm:mx-2 align-middle w-[47%];
		@apply relative;
	}

	a {
		border: solid 1px rgba(0, 0, 0, 0.2);
		box-shadow: 0 1px 1px rgba(255, 255, 255, 0.2);
		white-space: pre-wrap;
		@apply flex justify-center items-center;
		@apply w-full h-full font-zenmaru font-semibold rounded-lg;
		@apply p-3 sm:p-5 text-lg sm:text-xl;
		@apply hover:bg-grayblacker;
		@apply overflow-hidden;
	}

	span {
		letter-spacing: 1px;
		@apply absolute bottom-0 right-0 px-2;
		@apply text-right text-base font-semibold font-zenmaru text-gray-800/80;
	}
</style>
