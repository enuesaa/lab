<script lang="ts">
	// see https://github.com/metonym/svelte-highlight/issues/246
	import highlightjs from 'highlight.js/lib/common'
	import 'highlight.js/styles/github-dark-dimmed.min.css'
	import CodeLine from './CodeLine.svelte'

	export let language: string
	export let code: string
	export let showLineNumber = false

	const lines = code.split('\n')
	const useAuto = highlightjs.getLanguage(language) === undefined
</script>

{#if showLineNumber}
	<table>
		<tbody>
			{#each lines as line, i}
				<tr>
					<td class="text-gray-600 opacity-65 min-w-5 text-base text-center">{i+1}</td>
					<td><CodeLine code={line} {language} auto={useAuto} /></td>
				</tr>
			{/each}
		</tbody>
	</table>
{:else}
	<CodeLine {code} {language} auto={useAuto} />
{/if}

<style lang="postcss">
	tbody {
		@apply py-2 block bg-editorbg text-editortext pl-3;
	}
	td {
		@apply p-0;
	}
</style>
